<?php

namespace App\Http\Controllers;

use App\Constant\Constant;
use App\Util\Common;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PurchaseController extends Controller
{
    public function index() {
        $purchase_orders = PurchaseController::transformPurchaseOrders($this->getPurchaseOrders());
        $data['purchase_orders'] = $purchase_orders;
        $data['total_row'] = count($purchase_orders);
        return view('admin.purchase.index', $data);
    }

    public function createPurchaseOrder(Request $request) {
        $user_input = $request->only('purchase_number', 'purchase_date', 'supplier_id');
        $validator = Validator::make($user_input, $this->ruleValidations());
        if ($validator->fails()) {
            return redirect()
                ->route('purchase.create.form')
                ->withErrors($validator)
                ->withInput();
        }

        $purchase_order_record = $this->getPurchaseOrderByNumber($user_input);
        if ($purchase_order_record) {
            return redirect()
                ->route('purchase.create.form')
                ->withErrors(['purchase_number' => 'No.Pembelian telah digunakan'])
                ->withInput();
        }

        $user_input['status'] = Constant::PURCHASE_ORDER_DRAFT;
        $user_input['created_by'] = $this->getUserId();
        DB::table('purchase_orders')->insert($user_input);
        return redirect()
            ->route('purchase.index')
            ->with(['success' => 'Pembelian stok berhasil dibuat']);
    }

    public function createPurchaseForm() {
        $data['page_title'] = 'Produk apa yang akan kamu beli ?';
        $data['target_route'] = 'purchase.create';
        $data['item'] = NULL;
        $product_records = ProductController::getProducts();
        $data['suppliers'] = SupplierController::getSuppliers();
        $data['products'] = $product_records;
        $data['units'] = Common::getUnits();
        return view('admin.purchase.form', $data);
    }

    public function editPurchaseOrder(Request $request) {
        $purchase_order_id = $request->input('id');
        $purchase_order_record = $this->getPurchaseOrderById($purchase_order_id);
        if (!$purchase_order_record) {
            return redirect()
                ->route('purchase.index')
                ->with(['error' => 'Pembelian stok tidak ditemukan']);
        }

        $user_input = $request->only('purchase_number', 'purchase_date', 'supplier_id');
        $validator = Validator::make($user_input, $this->ruleValidations());
        if ($validator->fails()) {
            return redirect()
                ->route('purchase.edit.form')
                ->withErrors($validator)
                ->withInput(); 
        }

        DB::table('purchase_orders')->where('id', $purchase_order_id)->update($user_input);
        return redirect()
            ->route('purchase.index')
            ->with(['success' => 'Pembelian stok berhasil diubah']);
    }

    public function editPurchaseOrderForm(Request $request, $purchaseOrderId) {
        $purchase_order_record = $this->getPurchaseOrderById($purchaseOrderId);
        if (!$purchase_order_record) {
            return redirect()
                ->route('purchase.index')
                ->with(['error' => 'Pembelian stok tidak ditemukan']);
        }
        $data['page_title'] = 'Informasi pembelian stok apa yang akan dirubah ?';
        $data['target_route'] = 'purchase.edit';
        $data['item'] = $purchase_order_record;
        return view('admin.purchase.form', $data);
    }

    private function getPurchaseOrders() {
        return DB::table('purchase_orders')
            ->select(['purchase_orders.id', 'purchase_orders.purchase_date', DB::raw('suppliers.name AS supplier_name'), DB::raw('users.name AS created_by_name'), 'purchase_orders.status'])
            ->leftJoin('suppliers', function ($join) {
                $join->on('suppliers.id', '=', 'purchase_orders.supplier_id');
            })
            ->leftJoin('users', function ($join) {
                $join->on('users.id', '=', 'purchase_orders.created_by');
            })
            ->get();
    }

    public static function transformPurchaseOrders(Collection $purchase_orders): Collection {
        foreach ($purchase_orders as $index => $purchase_order) {
            $purchase_order_status = Common::getPurchaseOrderStatuses();
            $item = new \stdClass();
            $item->id = $purchase_order->id;
            $item->purchase_date = Common::formatTime($purchase_order->purchase_date);
            $item->purchase_name = $purchase_order->supplier_name;
            $item->created_by_name = $purchase_order->created_by_name;
            $item->status = $purchase_order_status[$purchase_order->status];
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
            'purchase_date' => 'required',
            'supplier_id' => 'required'
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
        return response()->json(array (
            'status' => true,
            'products' => $product_records
        ), 200);
    }

    public function getSupplier(Request $request) {
        $supplier_records = DB::table('suppliers')
            ->get();
        return response()->json(array (
            'status' => true,
            'suppliers' => $supplier_records
        ), 200);
    }
}
