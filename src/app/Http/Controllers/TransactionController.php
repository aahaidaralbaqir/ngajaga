<?php

namespace App\Http\Controllers;

use App\Constant\Constant;
use App\Repositories\AccountRepository;
use App\Repositories\CustomerRepository;
use App\Repositories\ProductRepository;
use App\Repositories\TransactionRepository;
use App\Util\Common;
use App\Util\Response;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function createTransactionForm(Request $request) 
    {
        $category = $request->query('cat');
        $user_input_params = $request->all();
        $category_records = ProductRepository::getCategories();
        $product_records = ProductRepository::getDetailProducts($user_input_params);
        $product_ids = array_map(function ($item) {
            return $item->id;
        }, $product_records->toArray());
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
        $product_ids = array_map(function ($item) {
            return $item->id;
        }, $product_records->toArray());
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
            
            $latest_transaction_id = TransactionRepository::getLatestTransactionId();
            $order_id = Common::generateOrderId($latest_transaction_id);
            $create_transaction_record = [
                'order_id'          => $order_id,
                'price_total'       => $price_total,
                'created_by'        => parent::getUserId(),
                'customer_id'       => $user_input['customer'],
                'account_id'        => $account_id];
            $transaction_id = TransactionRepository::createTransaction($create_transaction_record);

            $create_cashflow_record = [
                'account_id' => $account_id,
                'amount'     => $price_total,
                'created_by' => parent::getUserId(),
                'description'   => 'Penambahan saldo untuk transaksi ' . $order_id
            ];
            AccountRepository::createCashflow($create_cashflow_record);

            $create_transaction_records = [];
            foreach ($products as $product)  {
                $product_id = $product['detail']->id;
                $create_transaction_record[] = [
                    'transaction_id'    => $transaction_id,
                    'product_id'        => $product_id,
                    'unit'              => $product['unit'],
                    'qty'               => $product['quantity']];

                $price_mapping_record = ProductRepository::getPriceMappingDetail($product_id, $product['unit']);
                $create_stock_param = [
                    'product_id'    => $product_id,
                    'qty'           => ($product['quantity'] * $price_mapping_record->conversion) * -1,
                    'identifier'    => $transaction_id];
                ProductRepository::createStock($create_stock_param);
            }
            TransactionRepository::createTransactionDetail($create_transaction_records);
            session()->remove(Constant::OrderDataSessionKey);
            session()->remove(Constant::OrderSelectedAccountKey);
            DB::commit();
            return Response::redirectWithSuccess('transaction.create.form', 'Transaksi berhasil dibuat');
        } catch (Exception $error) {
            return Response::backWithError('Terjadi kesalaharan ' . $error->getMessage()); 
        }
    }
}
