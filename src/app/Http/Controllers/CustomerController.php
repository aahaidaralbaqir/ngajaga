<?php

namespace App\Http\Controllers;

use App\Repositories\CustomerRepository;
use App\Util\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $customer_records = CustomerRepository::getCustomers($request->all());
        $customer_ids = [];
        foreach ($customer_records as $customer_record)
            $customer_ids[] = $customer_record->id;
        $transaction_records = CustomerRepository::getTransactionByCustomerIds($customer_ids);
        $debt_records = CustomerRepository::getDebtByCustomerIds($customer_ids);

        $grouped_transaction_records = [];
        foreach ($transaction_records as $transaction_record) {
            $customer_id = $transaction_record->customer_id;
            if (array_key_exists($customer_id, $grouped_transaction_records)) {
                $grouped_transaction_records[$customer_id][] = $transaction_record;
                continue;
            }
            $grouped_transaction_records[$customer_id] = [$transaction_record];
        }

        $grouped_debt_records = [];
        foreach ($debt_records as $debt_record) {
            $customer_id = $debt_record->customer_id;
            if (array_key_exists($customer_id, $grouped_debt_records)) {
                $grouped_debt_records[$customer_id][] = $debt_record;
                continue;
            }
            $grouped_debt_records[$customer_id] = [$debt_record]; 
        }

        foreach ($customer_records as $index => $customer_record) {
            $total_debt = 0;
            $total_transaction = 0;
            if (array_key_exists($customer_record->id, $grouped_transaction_records)) {
                $total_transaction = count($grouped_transaction_records[$customer_record->id]);
            }

            if (array_key_exists($customer_record->id, $grouped_debt_records)) {
                $total_debt = count($grouped_debt_records[$customer_record->id]);
            }
            $customer_record->total_debt = $total_debt;
            $customer_record->total_transaction = $total_transaction;
            $customer_records[$index] = $customer_record;
        }


        return view('admin.customer.index')
            ->with('user', parent::getUser())
            ->with('has_filter', $request->query->count() > 0)
            ->with('customers', $customer_records);
    }

    public function createCustomerForm(Request $request)
    {
        return view('admin.customer.form')
            ->with('item', NULL)
            ->with('target_route', 'customer.create')
            ->with('page_title', 'Menambahkan pelanggan baru')
            ->with('user', parent::getUser());
    }

    public function createCustomer(Request $request)
    {
        $user_input = $request->only('name', 'address', 'phone_number');
        $user_input_field_rules = [
            'name'          => 'required',
            'address'       => 'required',
            'phone_number'  => 'required'];
        $validator = Validator::make($user_input, $user_input_field_rules);
        if ($validator->fails()) {
            return Response::backWithErrors($validator);
        }

        CustomerRepository::createCustomer($user_input);
        return Response::redirectWithSuccess('customer.index', 'Pelanggan baru berhasil ditambahkan');
    }

    public function editCustomerForm(Request $request, $customerId)
    {
        $customer_record = CustomerRepository::getCustomerById($customerId);
        if (!$customer_record) {
            return Response::backWithError('Pelanggan tidak ditemukan');
        }
        return view('admin.customer.form')
            ->with('item', $customer_record)
            ->with('target_route', 'customer.edit')
            ->with('page_title', 'Menambahkan pelanggan baru')
            ->with('user', parent::getUser()); 
    }

    public function editCustomer(Request $request)
    {
        $customer_id = $request->input('id');
        $customer_record = CustomerRepository::getCustomerById($customer_id);
        if (!$customer_record) {
            return Response::backWithError('Pelanggan tidak ditemukan');
        }

        $user_input = $request->only('name', 'address', 'phone_number');
        $user_input_field_rules = [
            'name'          => 'required',
            'address'       => 'required',
            'phone_number'  => 'required'];
        $validator = Validator::make($user_input, $user_input_field_rules);
        if ($validator->fails()) {
            return Response::backWithErrors($validator);
        }

        CustomerRepository::updateCustomer($customer_id, $user_input);
        return Response::redirectWithSuccess('customer.index', 'Pelanggan berhasil dirubah');
    }
}
