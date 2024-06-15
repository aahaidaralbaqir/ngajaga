<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class AccountRepository {
    public static function getAccountsWithBalance($user_param = []) 
    {
        $query = DB::table('accounts AS ac')
            ->addSelect('ac.id')
            ->addSelect('ac.name')
            ->addSelect(DB::raw('SUM(cf.amount) AS current_balance'))
            ->leftJoin('cashflows AS cf', 'ac.id', '=', 'cf.account_id')
            ->groupBy('ac.id', 'ac.name')
            ->get();
        return $query;
    }

    public static function getAccountById($account_id)
    {
        $query = DB::table('accounts AS ac')
            ->addSelect('ac.id')
            ->addSelect('ac.name')
            ->where('id', $account_id)
            ->first();
        return $query;
    }

    public static function createAccount($user_input)
    {
        return DB::table('accounts')
            ->insertGetId($user_input);
    }

    public static function updateAccount($account_id, $user_input)
    {
        return DB::table('accounts')
            ->where('id', $account_id)
            ->update($user_input);
    }
}