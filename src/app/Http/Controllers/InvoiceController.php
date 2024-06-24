<?php

namespace App\Http\Controllers;

use App\Constant\Constant;
use App\Repositories\AccountRepository;
use App\Repositories\InvoiceRepository;
use App\Repositories\ProductRepository;
use App\Repositories\PurchaseRepository;
use App\Util\Response;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{

    public function getInvoices(Request $request)
    {
        $invoice_records = InvoiceRepository::getInvoices();
        return view('admin.invoice.index')
            ->with('total_row', count($invoice_records))
            ->with('invoices', $invoice_records)
            ->with('user', parent::getUser());
    }

    public function createInvoiceForm(Request $request)
    {
        $latest_invoice_id = InvoiceRepository::getLatestInvoiceId();
        $invoice_code = $this->generateInvoiceCode($latest_invoice_id);

        $purchase_number = $request->query('purchaseNumber');
        $purchase_order_record = NULL;
        if ($purchase_number) {
            $purchase_order_record = PurchaseRepository::getPurchaseOrderByNumber($purchase_number);
            $purchase_order_record->items = [];
            if (!$purchase_order_record)  return Response::backWithError('Data pemesanan stok tidak ditemukan');
            $order_items = PurchaseRepository::getPurchaserOrderItemDetailByPurchaseOrderId($purchase_order_record->id);
            $purchase_order_record->items = $order_items;
        }


        $purchase_order_records = PurchaseRepository::getPendingPurchaseOrders();
        $account_records = AccountRepository::getAccountsWithBalance();

        return view('admin.invoice.form')
            ->with('item', NULL)
            ->with('user', parent::getUser())
            ->with('page_title', 'Buat penerimaan stok')
            ->with('purchase_order', $purchase_order_record)
            ->with('purchase_orders', $purchase_order_records)
            ->with('accounts', $account_records)
            ->with('target_route', 'invoice.create')
            ->with('invoice_code', $invoice_code);
    }

    public function createInvoice(Request $request)
    {
        DB::beginTransaction();
        try  {
            $user_input_field_rules = [
                'purchase_number'   => 'required|exists:purchase_orders,purchase_number',
                'invoice_code'      => 'required',
                'received_date'     => 'required|date_format:Y-m-d',
                'account_id'        => 'required|exists:accounts,id',
                'purchase_order_id' => 'required',
                'description'       => 'present'
            ];

            $user_input = $request->only('invoice_code', 'received_date', 'account_id', 'purchase_order_id', 'description', 'purchase_number');
            $validator = Validator::make($user_input, $user_input_field_rules);
            if ($validator->fails())
                return Response::backWithErrors($validator);

            $create_purchase_invoice_input = [];
            $order_item_inputs = [];
            foreach ($request->all() as $field => $value)
            {
                if (in_array($field, ['invoice_code', 'purchase_order_id', 'received_date', 'account_id', 'description']))
                    $create_purchase_invoice_input[$field] = $value;

                if (is_array($value))
                    for ($idx = 0; $idx < count($value); $idx++) 
                        $order_item_inputs[$idx][$field] = $value[$idx];
            }

            $payment_total = 0;
            foreach ($order_item_inputs as $order_item) 
            {
                $payment_total += $order_item['received_price'] * $order_item['received_qty'];
                $updated_order_invoice_param = [
                    'received_price'    => $order_item['received_price'],        
                    'received_qty'      => $order_item['received_qty']];
                PurchaseRepository::updatePurchaseOrderItem($order_item['purchase_order_item_id'], $updated_order_invoice_param);
            }

            $current_account_balance = AccountRepository::getAccountBalance($create_purchase_invoice_input['account_id']);
            if ($current_account_balance < $payment_total) {
                return Response::backWithError('Saldo dari akun tersebut tidak valid silahkan gunakan akun yang lain');
            }

            

            $create_invoice_param = [
                'invoice_code'      => $user_input['invoice_code'],
                'account_id'        => $user_input['account_id'],
                'received_date'     => strtotime($user_input['received_date']),
                'purchase_order_id' => $user_input['purchase_order_id'],
                'payment_total'     => $payment_total,
                'description'       => $user_input['description']];
            
            $updated_invoice_param = [
                'status'    => Constant::PURCHASE_ORDER_COMPLETED
            ];
            PurchaseRepository::updatePurchaseOrder($user_input['purchase_order_id'], $updated_invoice_param);
            $invoice_id = InvoiceRepository::createInvoice($create_invoice_param);

            $create_cashflow_param = [
                'account_id'    => $create_purchase_invoice_input['account_id'],
                'amount'        => $payment_total * -1,
                'created_by'    => $this->getUserId(),
                'description'   => 'Pembelian untuk invoice ' . $create_purchase_invoice_input['invoice_code'],
                'identifier'    => $invoice_id
            ];

            AccountRepository::createCashflow($create_cashflow_param);

            foreach ($order_item_inputs as $order_item)
            {
                $price_mapping_record = ProductRepository::getPriceMappingDetail($order_item['product_id'], $order_item['unit']);
                $create_stock_param = [
                    'product_id'    => $order_item['product_id'],
                    'qty'           => $order_item['received_qty'] * $price_mapping_record->conversion,
                    'identifier'    => $invoice_id      
                ];
                ProductRepository::createStock($create_stock_param);
            }
            DB::commit();
            return Response::redirectWithSuccess('invoice.index', 'Invoice berhasil diterbitkan');
        } catch (Exception $error) {
            DB::rollback();
            return Response::backWithError('Invoice gagal diterbitkan ' . $error->getMessage());
        }
    }

    public function editInvoiceForm(Request $request, $invoiceId)
    {
        $invoice_record = InvoiceRepository::getInvoiceById($invoiceId);
        if (!$invoice_record) {
            return Response::backWithError('Data invoice tidak ditemukan');
        }

        $purchase_order_record = PurchaseRepository::getPurchaseOrderById($invoice_record->purchase_order_id);
        $purchase_order_record->items = PurchaseRepository::getPurchaserOrderItemDetailByPurchaseOrderId($purchase_order_record->id);
        $account_records = AccountRepository::getAccountsWithBalance();

        $purchase_order_records = PurchaseRepository::getPendingPurchaseOrders();

        return view('admin.invoice.form')
            ->with('item', $invoice_record)
            ->with('user', parent::getUser())
            ->with('page_title', 'Ubah penerimaan stok')
            ->with('purchase_order', $purchase_order_record)
            ->with('purchase_orders', $purchase_order_records)
            ->with('accounts', $account_records)
            ->with('target_route', 'invoice.edit');
    }

    public function editInvoice(Request $request)
    {
        DB::beginTransaction();
        try  {
            $invoice_id = $request->input('id');
            $invoice_record = InvoiceRepository::getInvoiceById($invoice_id);
            if (!$invoice_record) {
                return Response::backWithError('Data invoice tidak ditemukan');
            }

            $user_input_field_rules = [
                'received_date'     => 'required|date_format:Y-m-d',
                'account_id'        => 'required|exists:accounts,id',
                'description'       => 'present'
            ];

            $user_input = $request->only('received_date', 'account_id', 'description');
            $validator = Validator::make($user_input, $user_input_field_rules);
            if ($validator->fails())
                return Response::backWithErrors($validator);

            $update_purchase_invoice_input = [];
            $order_item_inputs = [];
            foreach ($request->all() as $field => $value)
            {
                if (in_array($field, ['received_date', 'account_id', 'description']))
                {
                    if ($field == 'received_date') 
                        $value = strtotime($value);
                    $update_purchase_invoice_input[$field] = $value;
                }

                if (is_array($value))
                    for ($idx = 0; $idx < count($value); $idx++) 
                        $order_item_inputs[$idx][$field] = $value[$idx];
            }

            $payment_total = 0;
            foreach ($order_item_inputs as $order_item) 
            {
                $payment_total += $order_item['received_price'] * $order_item['received_qty'];
                $updated_order_invoice_param = [
                    'received_price'    => $order_item['received_price'],        
                    'received_qty'      => $order_item['received_qty']];
                PurchaseRepository::updatePurchaseOrderItem($order_item['purchase_order_item_id'], $updated_order_invoice_param);
            }
            $update_purchase_invoice_input['payment_total'] = $payment_total;

            # delete previous cashflow activity
            AccountRepository::deleteCashflowByPurchaseInvoiceId($invoice_id);

            $current_account_balance = AccountRepository::getAccountBalance($update_purchase_invoice_input['account_id']);
            if ($current_account_balance < $payment_total) {
                return Response::backWithError('Saldo dari akun tersebut tidak valid silahkan gunakan akun yang lain');
            }

             $create_cashflow_param = [
                'account_id'    => $update_purchase_invoice_input['account_id'],
                'amount'        => $payment_total * -1,
                'created_by'    => $this->getUserId(),
                'description'   => 'Pembelian untuk invoice ' . $invoice_record->invoice_code,
                'identifier'    => $invoice_id
            ];

            AccountRepository::createCashflow($create_cashflow_param);

            InvoiceRepository::editInvoice($invoice_id, $update_purchase_invoice_input);

            # remove previous stock in
            ProductRepository::deleteStockByPurchaseInvoiceId($invoice_id);

            foreach ($order_item_inputs as $order_item)
            {
                $price_mapping_record = ProductRepository::getPriceMappingDetail($order_item['product_id'], $order_item['unit']);
                $create_stock_param = [
                    'product_id'    => $order_item['product_id'],
                    'qty'           => $order_item['received_qty'] * $price_mapping_record->conversion,
                    'identifier'    => $invoice_id      
                ];
                ProductRepository::createStock($create_stock_param);
            }
            DB::commit();
            return Response::redirectWithSuccess('invoice.index', 'Invoice berhasil dirubah');
        } catch (Exception $error) {
            DB::rollback();
            return Response::backWithError('Invoice gagal diterbitkan ' . $error->getMessage());
        }
    }

    private function generateInvoiceCode($latest_invoice_id)
    {
        return sprintf('INV/%s/%d', date('Ymd', time()), $latest_invoice_id);    
    }
}
