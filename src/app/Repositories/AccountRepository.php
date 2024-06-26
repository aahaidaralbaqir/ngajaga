<?php
namespace App\Repositories;

use App\Util\Common;
use Illuminate\Support\Facades\DB;

class AccountRepository {
    public static function getAccountsWithBalance($user_param = []) 
    {
        $records = DB::table('accounts AS ac')
            ->addSelect('ac.id')
            ->addSelect('ac.name')
            ->addSelect(DB::raw('SUM(cf.amount) AS current_balance'))
            ->leftJoin('cashflows AS cf', 'ac.id', '=', 'cf.account_id')
            ->groupBy('ac.id', 'ac.name')
            ->get();
        foreach ($records as $idx => $record) {
            $record->formated_current_balance = Common::formatAmount('Rp', $record->current_balance);
        }
        return $records;
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

    public static function createCashflow($user_input)
    {
        return DB::table('cashflows')
            ->insertGetId($user_input);
    }

    public static function getAccountBalance($account_id) 
    {
        $query = DB::table('accounts AS ac')
            ->addSelect('ac.id')
            ->addSelect('ac.name')
            ->addSelect(DB::raw('SUM(cf.amount) AS current_balance'))
            ->leftJoin('cashflows AS cf', 'ac.id', '=', 'cf.account_id')
            ->where('ac.id', $account_id)
            ->groupBy('ac.id', 'ac.name')
            ->first();
        return $query->current_balance; 
    }

    public static function deleteCashflowByPurchaseInvoiceId($invoice_id) 
    {
        return DB::table('cashflows')
            ->where('identifier', $invoice_id)
            ->where('amount', '<=', 0)
            ->delete();
    }

    public static function cancelCashflowByTransaction($transaction_id)
    {
        return DB::table('cashflows')
            ->where('identifier', $transaction_id)
            ->where('amount', '>', 0)
            ->delete();
    }
}