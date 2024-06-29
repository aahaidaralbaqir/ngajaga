<?php
namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DebtRepository {
   public static function getDebtByTransasction($transaction_id)
   {
        return DB::table('debt')
            ->where('transaction_id', $transaction_id)
            ->first();
   }

   public static function createDebt($user_input)
   {
        return DB::table('debt')
            ->insertGetId($user_input);
   }

   public static function getDebtById($debt_id)
   {
        return DB::table('debt')
            ->where('debt.id', $debt_id)
            ->addSelect(DB::raw('customers.name AS customer_name'))
            ->addSelect(DB::raw('transactions.id AS transaction_id'))
            ->addSelect('transactions.order_id')
            ->addSelect('debt.amount')
            ->addSelect('debt.id')
            ->leftJoin('transactions', 'transactions.id', '=', 'debt.transaction_id')
            ->leftJoin('customers', 'customers.id', '=', 'transactions.customer_id')
            ->first();
   }

   public static function updateDebt($debt_id, $user_input)
   {
        return DB::table('debt')
            ->where('id', $debt_id)
            ->update($user_input);
   }

   public static function getDebts($query_params = []) {
        $query = DB::table('debt')
            ->addSelect('debt.id', 'debt.amount')
            ->addSelect(DB::raw('transactions.id AS transaction_id'))
            ->addSelect(DB::raw('customers.name AS customer_name'))
            ->addSelect('transactions.order_id')
            ->leftJoin('transactions', 'transactions.id', '=', 'debt.transaction_id')
            ->leftJoin('customers', 'customers.id', '=', 'transactions.customer_id');
        foreach ($query_params as $field => $value) {
            if (in_array($field, ['search']) && $value) {
                $query->where('transactions.order_id', $value);       
            }
        }
        return $query->get();
   }

   public static function getReceivableByDebtId($debt_id)
   {
        $receiveable_records = DB::table('receivable AS re')
            ->addSelect('re.amount')
            ->addSelect('re.id')
            ->addSelect(DB::raw('us.name AS created_by_name'))
            ->addSelect('re.receivable_date')
            ->leftJoin('users AS us', 'us.id', '=', 're.created_by')
            ->where('re.debt_id', $debt_id)
            ->get();
        return $receiveable_records; 
   }

   public static function getReceivableByDebtIds($debt_ids)
   {
        $receiveable_records = DB::table('receivable AS re')
            ->addSelect(DB::raw('SUM(re.amount) AS receivable_amount'))
            ->addSelect('re.id')
            ->addSelect('re.debt_id')
            ->whereIn('re.debt_id', $debt_ids)
            ->groupBy(['re.id', 're.debt_id'])
            ->get();
        return $receiveable_records;
   }

   public static function createReceivable($user_input)
   {
        return DB::table('receivable')
            ->insertGetId($user_input);
   }

   public static function getReceivableById($receivable_id)
   {
        $record = DB::table('receivable')
            ->where('id', $receivable_id)
            ->first();
        if ($record) {
            $record->receivable_date = date('Y-m-d', $record->receivable_date);
        }
        return $record;
   }

   public static function updateReceivable($receivable_id, $user_input)
   {
        return DB::table('receivable')
            ->where('id', $receivable_id)
            ->update($user_input);
   }
}