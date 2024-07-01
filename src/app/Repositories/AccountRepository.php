<?php
namespace App\Repositories;

use App\Constant\Constant;
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
            ->where('cashflow_type', Constant::CashflowPurchase)
            ->delete();
    }

    public static function cancelCashflowByTransaction($transaction_id)
    {
        return DB::table('cashflows')
            ->where('identifier', $transaction_id)
            ->where('cashflow_type', Constant::CashflowTransaction)
            ->delete();
    }

    public static function deleteCashflowByDebtId($debt_id)
    {
        return DB::table('cashflows')
            ->where('identifier', $debt_id)
            ->where('cashflow_type', Constant::CashflowDebt)
            ->delete();    
    }

    public static function getAccountReport($user_params = array ())
    {
        $query = DB::table('cashflows AS ca')
            ->addSelect(
                DB::raw('SUM(CASE WHEN ca.amount >= 0 THEN ca.amount ELSE 0 END) AS amount_in'),
                DB::raw('SUM(CASE WHEN ca.amount < 0 THEN ca.amount ELSE 0 END) AS amount_out')
            )
            ->addSelect('ac.id', 'ac.name')
            ->join('accounts AS ac', 'ac.id', '=', 'ca.account_id')
            ->groupBy('ac.id', 'ac.name');
        foreach ($user_params as $field => $value) {
            if (in_array($field, ['start_date']) && $value) {
                $start = sprintf('%s 00:00:00', $value);
                $query->where('ca.created_at', '>=', $start);
            }
            if (in_array($field, ['end_date']) && $value) {
                $end = sprintf('%s 23:59:50', $value);
                $query->where('ca.created_at', '<=', $end);
            }
        }
        return $query->get();
    }


}