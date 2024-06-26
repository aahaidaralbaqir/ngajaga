<?php
namespace App\Repositories;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransactionRepository {
   public static function getLatestTransactionId()
   {
        $transaction_record = DB::table('transactions')
            ->orderBy('id', 'desc')
            ->first();
        if ($transaction_record)
            return $transaction_record->id + 1;
        return 1;
   }

   public static function createTransaction($user_input)
   {
        return DB::table('transactions')
            ->insertGetId($user_input);
   }

   public static function createTransactionDetail($user_inputs)
   {
        return DB::table('transaction_details')
            ->insert($user_inputs);
   }

   public static function getTransactions($user_params = []) 
   {
        $query = DB::table('transactions AS tr')
            ->addSelect('tr.id')
            ->addSelect('tr.order_id')
            ->addSelect('tr.price_total')
            ->addSelect(DB::raw('us.name AS created_by_name'))
            ->addSelect(DB::raw('cs.name AS customer_name'))
            ->addSelect(DB::raw('ac.name AS account_name'))
            ->leftJoin('users AS us', 'us.id', '=', 'tr.created_by')
            ->leftJoin('customers AS cs', 'cs.id', '=', 'tr.customer_id')
            ->leftJoin('accounts AS ac', 'ac.id', '=', 'tr.account_id');
    
        foreach ($user_params as $field => $value) {
            if (empty($value)) {
                continue;
            }
            if (in_array($field, ['customer'])) {
                $query->where('cs.id', $value);   
            }
            if (in_array($field, ['account'])) {
                $query->where('ac.id', $value);       
            }
            if (in_array($field, ['user'])) {
                $query->where('us.id', $value);       
            }
            if (in_array($field, ['transaction_start'])) {
                $start = sprintf('%s 00:00:00', $value);
                $query->where('tr.created_at', '>=', $start);
            }
            if (in_array($field, ['transaction_end'])) {
                $end = sprintf('%s 23:59:50', $value);
                $query->where('tr.created_at', '=<', $end);
            }
            if (in_array($field, ['price_total_start'])) {
                $query->where('tr.price_total', '>=', intval($value));
            }
            if (in_array($field, ['price_total_end'])) {
                $query->where('tr.price_total', '<=',  intval($value));
            }
        }

        return $query->paginate(10);
   }

   public static function getTodayTransactionSummary ()
   {
        $today = Carbon::now()->toDateString();
        return DB::table('transactions')
            ->select(DB::raw('COUNT(*) as total_transaction, SUM(price_total) as total_amount, COALESCE(sum(total_product_qty), 0) AS total_product_qty'))
            ->whereDate('created_at', $today)
            ->first();
   }

   public static function updateTransaction($transaction_id, $user_input)
   {
        return DB::table('transactions')
            ->where('id', $transaction_id)
            ->update($user_input);
   }

   public static function getTransactionById($transaction_id)
   {
        $transaction_record = DB::table('transactions')
            ->where('id', $transaction_id)
            ->first();

        if ($transaction_record) {
            $transaction_record->transaction_date = date('Y-m-d', $transaction_record->transaction_date);
        }

        return $transaction_record;
   }

   public static function cancelTransaction($transaction_id)
   {
        return DB::table('transactions')
            ->where('id', $transaction_id)
            ->delete();
   }

   public static function removeTransactionDetail($transaction_id)
   {
        return DB::table('transaction_details')
            ->where('transaction_id', $transaction_id)
            ->delete();
   }

   public static function getTransactionDetail($transaction_id)
   {
        return DB::table('transaction_details')
            ->where('transaction_id', $transaction_id)
            ->get();
   }
}