<?php

namespace App\Http\Controllers;

use App\Constant\Constant;
use App\Exports\TransactionExport;
use App\Repositories\AccountRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\ProductRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\UserRepository;
use App\Util\Common;
use App\Util\Response;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class TransactionController extends Controller
{
    public function getTransactions(Request $request)
    {
        $transaction_records = TransactionRepository::getTransactions($request->all());
        $customers = CustomerRepository::getCustomers();
        $accounts = AccountRepository::getAccountsWithBalance();
        $users = UserRepository::getUsers();
        $today_transaction_summary = TransactionRepository::getTodayTransactionSummary();
        return view('admin.transaction.index')
            ->with('transactions', $transaction_records)
            ->with('customers', $customers)
            ->with('accounts', $accounts)
            ->with('users', $users)
            ->with('today_summary', $today_transaction_summary)
            ->with('has_filter', $request->query->count() > 0)
            ->with('user', parent::getUser());
    }

    public function createTransactionForm(Request $request) 
    {
        $category = $request->query('cat');
        $user_input_params = $request->all();
        $category_records = ProductRepository::getCategories();
        $product_records = ProductRepository::getDetailProducts($user_input_params);
        $product_ids = [];
        foreach ($product_records as $product_record) {
            $product_ids[] = $product_record->id;
        }
        $product_unit_records = ProductRepository::getProductUnitByProductIds($product_ids);
        foreach ($product_records as $idx => $product_record) {
            $product_record->units = $product_unit_records[$product_record->id];
            $product_records[$idx] = $product_record;
        }
        $order_data = session()->get(Constant::OrderDataSessionKey);
        $order_data = $order_data ? $order_data : [];
        $account_records = AccountRepository::getAccountsWithBalance();
        $selected_account = session()->get(Constant::OrderSelectedAccountKey);
        $customer_records = CustomerRepository::getCustomers();
        return view('admin.transaction.create')
            ->with('categories', $category_records)
            ->with('selected_category', $category)
            ->with('products', $product_records)
            ->with('orders', $order_data)
            ->with('accounts', $account_records)
            ->with('customers', $customer_records)
            ->with('customer_info', false)
            ->with('selected_account', $selected_account)
            ->with('user', parent::getUser());
    }

    public function customer(Request $request) {
        $category = $request->query('cat');
        $user_input_params = $request->all();
        $category_records = ProductRepository::getCategories();
        $product_records = ProductRepository::getDetailProducts($user_input_params);
        $product_ids = [];
        foreach ($product_records as $product_record) {
            $product_ids[] = $product_record->id;
        }
        $product_unit_records = ProductRepository::getProductUnitByProductIds($product_ids);
        foreach ($product_records as $idx => $product_record) {
            $product_record->units = $product_unit_records[$product_record->id];
            $product_records[$idx] = $product_record;
        }
        $order_data = session()->get(Constant::OrderDataSessionKey);
        $order_data = $order_data ? $order_data : [];
        $account_records = AccountRepository::getAccountsWithBalance();
        $selected_account = session()->get(Constant::OrderSelectedAccountKey);
        $customer_records = CustomerRepository::getCustomers();
        return view('admin.transaction.create')
            ->with('categories', $category_records)
            ->with('selected_category', $category)
            ->with('products', $product_records)
            ->with('orders', $order_data)
            ->with('accounts', $account_records)
            ->with('customer_info', true)
            ->with('customers', $customer_records)
            ->with('selected_account', $selected_account)
            ->with('user', parent::getUser()); 
    }

    public function addProductToCart(Request $request)
    {
        $user_input = $request->only('product_id', 'unit');
        $user_input_field_rules = [
            'product_id'    => 'required|exists:products,id',
            'unit'          =>  'required|in:' . implode(',', array_keys(ProductRepository::getProductUnit()))
        ];
        $validator = Validator::make($user_input, $user_input_field_rules);
        if ($validator->fails()) 
        {
            return Response::backWithError('Permintaan tidak valid');
        }

        $order_data = session()->get(Constant::OrderDataSessionKey);
        $product_id = $user_input['product_id'];
        if ($order_data) 
        {
           if (array_key_exists($product_id, $order_data)) 
           {
                $order_data[$product_id]['quantity']++;
                session()->put(Constant::OrderDataSessionKey, $order_data);
                return Response::redirectWithSuccess(
                    'transaction.create.form', 
                    'Kuantitas berhasil dirubah');               
           }
        }
        $product_record = ProductRepository::getProductById($product_id);
        $product_price = 0;
        foreach ($product_record->prices as $price) {
            if ($price->unit == $user_input['unit'])
            {
                $product_price = $price->price;
                break;
            }
        }
        $order_data[$product_id] = [
            'unit'      => $user_input['unit'],
            'detail'    => $product_record,
            'price'     => $product_price,
            'quantity'  => 1,
       ];
       session()->put(Constant::OrderDataSessionKey, $order_data);
       return Response::redirectWithSuccess(
            'transaction.create.form', 
            'Produk berhasil ditambahkan ke keranjang');
    }

    public function removeProductFromCart(Request $request)
    {
        $user_input = $request->only('product_id');
        $user_input_field_rules = [
            'product_id'    => 'required|exists:products,id'];
        $validator = Validator::make($user_input, $user_input_field_rules);
        if ($validator->fails()) 
        {
            return Response::backWithError('Permintaan tidak valid');
        }

        $product_id = $user_input['product_id'];
        $order_data = session()->get(Constant::OrderDataSessionKey);
        if (array_key_exists($product_id, $order_data)) {
            unset($order_data[$product_id]);
            session()->put(Constant::OrderDataSessionKey, $order_data);
            return Response::redirectWithSuccess(
                'transaction.create.form', 
                'Produk berhasil dihapus dari keranjang');
        }

        return Response::backWithError('Produk tidak ada dikeranjang');
    }

    public function cartAction(Request $request, $actionType)
    {
        if (!in_array($actionType, ['increment', 'decrement'])) {
            return Response::backWithError('Jenis aksi tidak valid');
        }

        $product_id = $request->input('product_id');
        $order_data = session()->get(Constant::OrderDataSessionKey);
        if (!array_key_exists($product_id, $order_data)) {
            return Response::backWithError('Produk tidak berada dalam kernjang');
        }

        $order_qty = $order_data[$product_id]['quantity'];
        if ($order_qty == 1 && $actionType == Constant::ActionDecrement)
        {
            unset($order_data[$product_id]);
            session()->put(Constant::OrderDataSessionKey, $order_data);
            return redirect()
                ->route('transaction.create.form');
        }

        if ($actionType == Constant::ActionIncrement) {
            $order_data[$product_id]['quantity']++;
            session()->put(Constant::OrderDataSessionKey, $order_data);
            return redirect()
                ->route('transaction.create.form');
        }
        $order_data[$product_id]['quantity']--;
        session()->put(Constant::OrderDataSessionKey, $order_data);
        return redirect()
            ->route('transaction.create.form');
    }

    public function chooseAccount(Request $request)
    {
        $account_id = $request->input('account_id');
        $account_record = AccountRepository::getAccountById($account_id);
        if (!$account_record) {
            return Response::backWithError('Akun tidak ditemukan');
        }
        $prev = session()->get(Constant::OrderSelectedAccountKey);
        if ($prev == $account_id) {
            session()->remove(Constant::OrderSelectedAccountKey);
            return redirect()
                ->route('transaction.create.form');
        }
        session()->put(Constant::OrderSelectedAccountKey, $account_id);
        return redirect()
            ->route('transaction.create.form');
    }

    public function createTransaction(Request $request)
    {
        DB::beginTransaction();
        try {
            $user_input = $request->only('customer');
            $order_data = session()->get(Constant::OrderDataSessionKey);
            if (empty($order_data)) {
                return Response::backWithError('Keranjang kosong');
            }

            $account_id = session()->get(Constant::OrderSelectedAccountKey);
            if (empty($account_id)) {
                return Response::backWithError('Silahkan pilih akun terlebih dahulu');
            }

            $price_total = 0;
            $products = array_values($order_data);
            foreach ($products as $product)  {
                $price_total += $product['price'] * $product['quantity'];
            }

            if ($request->has('new_customer')) {
                $create_customer_record = $request->only('name', 'phone_number', 'address');
                $create_customer_field_rules = [
                    'name' => 'required'
                ];
                $validator = Validator::make($create_customer_record, $create_customer_field_rules);
                if ($validator->fails()) {
                    return redirect()
                        ->route('transaction.customer')
                        ->withErrors($validator)
                        ->withInput();
                }
                $user_input['customer'] = CustomerRepository::createCustomer($create_customer_record);
            }

            if (empty($user_input['customer'] && !$request->has('new_custuomer'))) {
                return Response::backWithError('Informasi pelanggan dibutuhkan'); 
            }
            
            $latest_transaction_id = TransactionRepository::getLatestTransactionId();
            $order_id = Common::generateOrderId($latest_transaction_id);
            $create_transaction_record = [
                'order_id'          => $order_id,
                'price_total'       => $price_total,
                'created_by'        => parent::getUserId(),
                'customer_id'       => $user_input['customer'],
                'transaction_date'  => time(),
                'account_id'        => $account_id];
            $transaction_id = TransactionRepository::createTransaction($create_transaction_record);

            $create_cashflow_record = [
                'account_id'    => $account_id,
                'amount'        => $price_total,
                'created_by'    => parent::getUserId(),
                'identifier'    => $transaction_id,
                'cashflow_type' => Constant::CashflowTransaction,
                'description'   => 'Penambahan saldo untuk transaksi ' . $order_id
            ];
            AccountRepository::createCashflow($create_cashflow_record);
            $total_qty = 0;
            foreach ($products as $product)  {
                $product_id = $product['detail']->id;
                $create_transaction_record = [
                    'transaction_id'    => $transaction_id,
                    'product_id'        => $product_id,
                    'unit'              => $product['unit'],
                    'qty'               => $product['quantity']];
                TransactionRepository::createTransactionDetail($create_transaction_record);

                $price_mapping_record = ProductRepository::getPriceMappingDetail($product_id, $product['unit']);
                $product_total_qty = $product['quantity'] * $price_mapping_record->conversion;
                $total_qty += $product_total_qty;
                $create_stock_param = [
                    'product_id'    => $product_id,
                    'qty'           => ($product_total_qty) * -1,
                    'identifier'    => $transaction_id];
                ProductRepository::createStock($create_stock_param);
            }
            session()->remove(Constant::OrderDataSessionKey);
            session()->remove(Constant::OrderSelectedAccountKey);
            $update_transaction_record = [
                'total_product_qty' => $total_qty
            ];
            TransactionRepository::updateTransaction($transaction_id, $update_transaction_record);
            DB::commit();
            return Response::redirectWithSuccess('transaction.create.form', 'Transaksi berhasil dibuat');
        } catch (Exception $error) {
            return Response::backWithError('Terjadi kesalaharan ' . $error->getMessage()); 
        }
    }

    public function downloadReport(Request $request)
    {
        $file_name = sprintf('Laporan-transaksi-masuk-%s.csv', date('Y-m-d', time()));
        return Excel::download(new TransactionExport($request->all()), $file_name);
    }

    public function editTransaction(Request $request)
    {
        DB::beginTransaction();
        try {
            $transaction_id = $request->input('id');
            $transaction_record = TransactionRepository::getTransactionById($transaction_id);
            if (!$transaction_record) {
                return response()
                    ->json([
                        'status' => false,
                        'message' => 'Data transaksi tidak ditemukan'
                    ], 404);
            }

            $user_input_field_rules = [
                'transaction_date' => 'required|date_format:Y-m-d',
                'account_id' => 'required|integer|exists:accounts,id',
                'customer_id' => 'required|integer|exists:customers,id',
                'items.*' => 'required|array|min:1',
                'items.*.product_id' => 'required|integer|exists:products,id',
                'items.*.qty' => 'required|integer|min:1',
                'items.*.unit' => 'required|integer|min:1',
            ];
            $user_input = $request->only('transaction_date', 'account_id', 'customer_id', 'items');
            $validator = Validator::make($user_input, $user_input_field_rules);
            if ($validator->fails()) {
                return response()
                    ->json([
                        'success' => FALSE,
                        'errors' => $validator->errors()
                    ], 400);
            }

            # Delete previous data
            AccountRepository::cancelCashflowByTransaction($transaction_id);
            ProductRepository::deleteStockByTransactionId($transaction_id);
            TransactionRepository::removeTransactionDetail($transaction_id);

            $price_total = 0;
            $total_qty = 0;
            foreach ($user_input['items'] as $item)  {
                $product_id = $item['product_id'];
                $price_mapping_record = ProductRepository::getPriceMappingDetail($product_id, $item['unit']);
                $price_total += $price_mapping_record->price * $item['qty'];

                $product_total_qty = $item['qty'] * $price_mapping_record->conversion;
                $total_qty += $product_total_qty;
                $create_stock_param = [
                    'product_id'    => $product_id,
                    'qty'           => ($product_total_qty) * -1,
                    'identifier'    => $transaction_id];
                ProductRepository::createStock($create_stock_param);


                $create_transaction_record = [
                    'transaction_id'    => $transaction_id,
                    'product_id'        => $product_id,
                    'unit'              => $item['unit'],
                    'qty'               => $item['qty']];
                TransactionRepository::createTransactionDetail($create_transaction_record);
            }

            $create_cashflow_record = [
                'account_id'    => $user_input['account_id'],
                'amount'        => $price_total,
                'created_by'    => $request->input('created_by'), 
                'identifier'    => $transaction_id,
                'cashflow_type' => Constant::CashflowTransaction,
                'description'   => 'Penambahan saldo untuk transaksi ' . $transaction_record->order_id
            ];
            AccountRepository::createCashflow($create_cashflow_record);

            $update_transaction_record_param = [
                'transaction_date' => strtotime($user_input['transaction_date']),
                'account_id' => $user_input['account_id'],
                'customer_id' => $user_input['customer_id'],
                'price_total' => $price_total,
                'total_product_qty' => $total_qty
            ];
            TransactionRepository::updateTransaction($transaction_id, $update_transaction_record_param);
            Session::flash('success', 'Transaksi berhasil dirubah'); 
            DB::commit();
            return response()
                ->json([
                    'status' => TRUE,
                    'message' => 'Transaksi berhasil dirubah'
                ], 200);
        } catch (Exception $error) {
            DB::rollBack();
            Session::flash('error', sprintf('Gagal merubah transaksi (%s)', $error->getMessage())); 
            return response()
                ->json([
                    'status' => false,
                    'message' => 'Transaksi gagal dirubah'
                ], 400);
        }
    }

    public function editTransactionForm(Request $request, $transactionId)
    {
        $transaction_record = TransactionRepository::getTransactionById($transactionId);
        if (!$transaction_record) {
            return Response::backWithError('Data transaksi tidak ditemukan');
        }
        return view('admin.transaction.form')
            ->with('user', parent::getUser())
            ->with('page_title', 'Mengubah Transaksi')
            ->with('transaction_record', $transaction_record);
    }

    public function getTransactionDetail(Request $request, $transactionId)
    {
        $transaction_record = TransactionRepository::getTransactionById($transactionId);
        if (!$transaction_record) {
            return response()
                ->json([
                    'status' => false,
                    'message' => 'Data transaksi tidak ditemukan'
                ], 404);
        }

        $transaction_detail_records = TransactionRepository::getTransactionDetail($transactionId);
        $transaction_record->items = $transaction_detail_records;

        return response()
            ->json([
                'status' => true,
                'transaction' => $transaction_record
            ]);
    }

    public function getCustomers(Request $request) 
    {
        $customer_records = CustomerRepository::getCustomers();
        return response()
            ->json([
                'status' => true,
                'customer' => $customer_records
            ]);
    }

    public function getAccounts(Request $request) 
    {
        $account_records = AccountRepository::getAccountsWithBalance();
        return response()
            ->json([
                'status' => true,
                'account' => $account_records
            ]);
    }
}
