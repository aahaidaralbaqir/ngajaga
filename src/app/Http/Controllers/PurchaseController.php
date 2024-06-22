<?php

namespace App\Http\Controllers;

use App\Constant\Constant;
use App\Repositories\PurchaseRepository;
use App\Util\Common;
use App\Util\Response;
use Error;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    public function index() {
        $user_query = [
            'status' => [Constant::PURCHASE_ORDER_WAITING, Constant::PURCHASE_ORDER_COMPLETED]
        ];
        $purchase_orders = PurchaseController::transformPurchaseOrders(PurchaseRepository::getPurchaseOrders($user_query));
        $data['purchase_orders'] = $purchase_orders;
        $data['user'] = parent::getUser();
        $data['total_row'] = count($purchase_orders);
        return view('admin.purchase.index', $data);
    }

    public function createPurchaseOrder(Request $request) {
        DB::beginTransaction();
        try {
            $user_input = $request->only('purchase_number', 'purchase_date', 'supplier_id', 'items', 'created_by');

            $validator = Validator::make($user_input, $this->ruleValidations());
            if ($validator->fails()) {
                return response()
                    ->json([
                        'success' => FALSE,
                        'errors' => $validator->errors()
                    ], 400);
            }

            $purchase_order_record = $this->getPurchaseOrderByNumber($user_input['purchase_number']);
            if ($purchase_order_record) {
                Session::flash('error', 'No.Pembelian telah digunakan'); 
                return response()
                    ->json([
                        'success' => FALSE,
                        'error_message' => 'No.Pembelian telah digunakan silahkan ganti dengan yang lain'
                    ], 400);
            }


            $create_purchase_order_inputs = $request->only('purchase_number', 'purchase_date', 'supplier_id', 'created_by');
            foreach ($create_purchase_order_inputs as $field => $value) {
                if ($field == 'purchase_date')
                    $create_purchase_order_inputs[$field] = strtotime($value);
            }
            $create_purchase_order_inputs['status'] = Constant::PURCHASE_ORDER_WAITING;
            $purchase_order_id = PurchaseRepository::createPurchaseOrder($create_purchase_order_inputs);
            $order_items = $user_input['items'];
            foreach ($order_items as $index => $order_item) 
            {
                $order_item['purchase_order_id'] = $purchase_order_id;
                $order_item['total_price'] = intval($order_item['price']) * intval($order_item['qty']);
                $order_item['received_qty'] = 0;
                $order_item['received_price'] = 0;
                $order_items[$index] = $order_item;
            }
            PurchaseRepository::createPurchaseOrderItem($order_items);
            Session::flash('success', 'Pemesanan stok berhasil dibuat'); 
            DB::commit();
            return response()
                ->json([
                    'status' => TRUE,
                    'message' => 'Pemesanan stok berhasil dibuat'
                ], 200);
        } catch (Error $error) {
            DB::rollBack();
            return response()
            ->json([
                'status' => false,
                'message' => $error->getMessage()
            ], 200);
        }
        
    }

    public function createPurchaseForm() {
        $data['page_title'] = 'Produk apa yang akan kamu beli ?';
        $data['target_route'] = 'purchase.create';
        $data['user'] = parent::getUser();
        $data['item'] = NULL;
        $data['latest_purchase_order_id'] = PurchaseRepository::getLatestPurchaseOrder();
        return view('admin.purchase.form', $data);
    }

    public function editPurchaseOrder(Request $request) {
        DB::beginTransaction();
        try {
            $purchase_order_id = $request->input('purchase_order_id');
            $purchase_order_record = PurchaseRepository::getPurchaseOrderById($purchase_order_id);
            if (!$purchase_order_record) {
                return response()
                    ->json([
                        'status' => TRUE,
                        'message' => 'Data tidak ditemukan '
                    ], 404); 
            }
            
            $user_input = $request->only('purchase_number', 'purchase_date', 'supplier_id', 'items', 'created_by', 'id');
            $validator = Validator::make($user_input, $this->ruleValidations());
            if ($validator->fails()) {
                return response()
                    ->json([
                        'success' => FALSE,
                        'errors' => $validator->errors()
                    ], 400);
            }

            if ($purchase_order_record->purchase_number != $user_input['purchase_number'])
            {
                $order_by_number = $this->getPurchaseOrderByNumber($user_input['purchase_number']);
                if ($order_by_number) {
                    Session::flash('error', 'No.Pembelian telah digunakan'); 
                    return response()
                        ->json([
                            'success' => FALSE,
                            'error_message' => 'No.Pembelian telah digunakan silahkan ganti dengan yang lain'
                        ], 400);
                }
            }

            $update_purchase_order_inputs = $request->only('purchase_date', 'supplier_id', 'created_by');
            foreach ($update_purchase_order_inputs as $field => $value) {
                if ($field == 'purchase_date')
                    $update_purchase_order_inputs   [$field] = strtotime($value);
            }
            PurchaseRepository::updatePurchaseOrder($purchase_order_id, $update_purchase_order_inputs);
            $order_items = $user_input['items'];
            foreach ($order_items as $index => $order_item) 
            {
                if (array_key_exists('id', $order_item) && $order_item['id'] !== 0) {
                    $order_item_id = $order_item['id'];
                    $order_item['total_price'] = intval($order_item['price']) * intval($order_item['qty']);
                    $order_item['received_qty'] = 0;
                    $order_item['received_price'] = 0;
                    unset($order_item['id']);
                    PurchaseRepository::updatePurchaseOrderItem($order_item_id, $order_item);
                    continue;
                }
                $order_item['purchase_order_id'] = $purchase_order_id;
                PurchaseRepository::createPurchaseOrderItem($order_item);
            }
            DB::commit();
            Session::flash('success', 'Pemesanan stok berhasil dirubah'); 
            return response()
                ->json([
                    'status' => TRUE,
                    'message' => 'Pemesanan stok berhasil diubah'
                ], 200);
        } catch (Error $error) {
            DB::rollBack();
            return response()
            ->json([
                'status' => false,
                'message' => $error->getMessage()
            ], 200);
        }
    }

    public function cancelPurchaseOrder(Request $request, $purchaseOrderId)
    {
        $purchase_order_record = PurchaseRepository::getPurchaseOrderById($purchaseOrderId);
        if (!$purchase_order_record) {
            return Response::backWithError('Data pemesanan stok tidak ditemuakn');
        }

        if ($purchase_order_record->status == Constant::PURCHASE_ORDER_COMPLETED) {
            return Response::backWithError('Data pemesanan yang berstatus selesai tidak bisa dibatalkan');
        }

        $updated_purchase_param = [
            'status' => Constant::PURCHASE_ORDER_VOID
        ];
        PurchaseRepository::updatePurchaseOrder($purchaseOrderId, $updated_purchase_param);
        return Response::redirectWithSuccess('purchase.index', 'Data pemesanan berhasil dibatalkan');
    }

    public function editPurchaseForm(Request $request, $purchaseOrderId) {
        $purchase_order_record = PurchaseRepository::getPurchaseOrderById($purchaseOrderId);
        if (!$purchase_order_record) {
            return Response::backWithError('Pembelian stok tidak ditemukan');
        }
        return view('admin.purchase.form')
            ->with('page_title', 'Informasi pembelian stok apa yang akan dirubah ?')
            ->with('latest_purchase_order_id', NULL)
            ->with('user', parent::getUser())
            ->with('item', $purchase_order_record);
    }

    private function getPurchaseOrders() {
        
    }

    public static function transformPurchaseOrders(Collection $purchase_orders): Collection {
        foreach ($purchase_orders as $index => $purchase_order) {
            $purchase_order_status = Common::getPurchaseOrderStatuses();
            $item = new \stdClass();
            $item->id = $purchase_order->id;
            $item->purchase_date = Common::formatTime($purchase_order->purchase_date);
            $item->purchase_name = $purchase_order->supplier_name;
            $item->purchase_number = $purchase_order->purchase_number;
            $item->supplier_name = $purchase_order->supplier_name;
            $item->created_by_name = $purchase_order->created_by_name;
            $item->status = $purchase_order->status; 
            $item->status_name = $purchase_order_status[$purchase_order->status];
            $item->purchase_invoice_id = $purchase_order->purchase_invoice_id;
            $purchase_orders[$index] = $item;
        }
        return $purchase_orders;
    }

    private function getPurchaseOrderByNumber($purchase_number) {
        return DB::table('purchase_orders')
            ->where('purchase_number', $purchase_number)
            ->first();
    }

    private function getPurchaseOrderById($purchase_order_id) {
        return DB::table('purchase_orders')
            ->where('id', $purchase_order_id)
            ->first();
    }

    private static function ruleValidations() {
        return [
            'purchase_number' => 'required',
            'purchase_date' => 'required|date_format:Y-m-d',
            'supplier_id' => 'required|integer|exists:suppliers,id',
            'items.*' => 'required|array|min:1',
            'items.*.price' => 'required|integer|min:1',
            'items.*.product_id' => 'required|integer|exists:products,id',
            'items.*.qty' => 'required|integer|min:1',
            'items.*.unit' => 'required|integer|min:1',
        ];
    }

    public static function getUnit(Request $request) {
        $product_id = $request->query('productId');
        $current_units = Common::getUnits();
        if ($product_id) {
            $product_mapping = DB::table('price_mapping')
                ->where('product_id', $product_id)
                ->get();
            $unit_ids = array_map(function ($item) {
                return $item->unit_id;
            }, $product_mapping->toArray());
            $current_units = array_filter($current_units, function ($item) use ($unit_ids) {
                return in_array($item, $unit_ids);
            }, ARRAY_FILTER_USE_KEY);
        }
        return response()->json(array (
            'status' => true,
            'units' => $current_units
        ), 200);
    }

    public function getProduct(Request $request) {
        $product_records = DB::table('products')
            ->select(['products.id', 'products.name'])
            ->get();
        $product_ids = array_map(function ($item) {
            return $item->id;
        }, $product_records->toArray());

        $price_mapping = DB::table('price_mapping')
            ->whereIn('product_id', $product_ids)
            ->get();

        $grouped_price_mapping = [];
        foreach ($price_mapping as $pm) {
            if (array_key_exists($pm->product_id, $grouped_price_mapping)) {
                $grouped_price_mapping[$pm->product_id][] = $pm->unit; 
            } else {
                $grouped_price_mapping[$pm->product_id] = [$pm->unit];
            }
        }

        for ($s = 0; $s < count($product_records); $s++)  {
            $product_record = $product_records[$s];
            $product_record->units = Common::getUnitByIds(array_keys(Common::getUnits()));
            if (array_key_exists($product_record->id, $grouped_price_mapping)) {
                $product_record->units =  Common::getUnitByIds($grouped_price_mapping[$product_record->id]);
            }
            $product_records[$s] = $product_record;
        }
        return response()->json(array (
            'status' => true,
            'products' => $product_records
        ), 200);
    }

    public function getSupplier(Request $request) {
        $supplier_records = PurchaseRepository::getSuppliers();
        return response()->json(array (
            'status' => true,
            'suppliers' => $supplier_records
        ), 200);
    }

    public function getPurchaseOrderDetail(Request $request, $purchaseOrderId) 
    {
        $purchase_order_record = PurchaseRepository::getPurchaseOrderById($purchaseOrderId);
        if (!$purchase_order_record)
        {
            return response()
                ->json([
                    'status' => false,
                    'error_message' => 'Data pemesanan stok tidak ditemukan'
                ], 404);
        }

        $purchase_order_item_records = PurchaseRepository::getPurchaseOrderItemByPurchaseOrderId($purchase_order_record->id);
        $purchase_order_record->items = [];
        if ($purchase_order_item_records) 
        {
            $purchase_order_record->items = $purchase_order_item_records;
        }

        return response()
            ->json([
                'status' => TRUE,
                'purchase_order' => $purchase_order_record
            ], 200);
    }

    public function printPurchase(Request $request, $purchaseOrderId)
    {
        $purchase_record = PurchaseRepository::getPurchaseOrderById($purchaseOrderId);
        if (!$purchase_record) {
            return Response::backWithError('Data pemesanan tidak ditemukan');
        }
        $purchase_record->order_items = PurchaseRepository::getPurchaserOrderItemDetailByPurchaseOrderId($purchaseOrderId);
        $data =  ['item' => $purchase_record, 'user' => parent::getUser()];
        $pdf = Pdf::loadView('admin.purchase.print', $data);
        $file_name = 'Pemesanan Stok - ' . $purchase_record->purchase_number . '.pdf';
        return $pdf->download($file_name);
    }
}
