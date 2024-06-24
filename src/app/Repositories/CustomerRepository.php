<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class CustomerRepository {
    public static function getCustomers() 
    {
        $query = DB::table('customers')
            ->get();
        return $query;
    }

    public static function createCustomer($user_input)
    {
        $query = DB::table('customers')
            ->insertGetId($user_input);
        return $query;
    }
}