<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class CustomerRepository {
    public static function getCustomers($user_params = []) 
    {
        $query = DB::table('customers');

        foreach ($user_params as $field => $value) {
            if (in_array($field, ['search']) && $value) {
                $query->where('customers.name', 'like', '%' . $value . '%')
                ->orWhere('customers.phone_number', 'like', '%' . $value . '%');
            }
        }
        return $query->get();
    }

    public static function createCustomer($user_input)
    {
        $query = DB::table('customers')
            ->insertGetId($user_input);
        return $query;
    }

    public static function updateCustomer($customer_id, $user_input)
    {
        return DB::table('customers')
            ->where('id', $customer_id)
            ->update($user_input);
    }

    public static function getCustomerById($customer_id)
    {
        return DB::table('customers')
            ->where('id', $customer_id)
            ->first();
    }

    public static function getDebtByCustomerId($customer_id)
    {
        return DB::table('transactions AS tr')
            ->addSelect('tr.id')
            ->addSelect('tr.customer_id')
            ->addSelect(DB::raw('de.id AS debt_id'))
            ->leftJoin('debt AS de', 'de.transaction_id', '=', 'tr.id')
            ->where('tr.customer_id', $customer_id)
            ->whereNotNull('de.id')
            ->first();
    }

    public static function getDebtByCustomerIds($customer_ids)
    {
        $debt_records = [];
        foreach ($customer_ids as $customer_id) {
            $debt_record = self::getDebtByCustomerId($customer_id);
            if ($debt_record) {
                $debt_records[] = self::getDebtByCustomerId($customer_id);
            }
        }
        return $debt_records;
    }

    public static function getTransactiontByCustomerId($customer_id)
    {
        return DB::table('transactions AS tr')
            ->addSelect('tr.id')
            ->addSelect('tr.customer_id')
            ->where('tr.customer_id', $customer_id)
            ->first();
    }

    public static function getTransactionByCustomerIds($customer_ids)
    {
        $transaction_records = [];
        foreach ($customer_ids as $customer_id) {
            $transaction_record = self::getTransactiontByCustomerId($customer_id);
            if ($transaction_record) {
                $transaction_records[] = $transaction_record;
            }
        }
        return $transaction_records;
    }

}