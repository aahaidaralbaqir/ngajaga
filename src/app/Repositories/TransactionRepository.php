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
            ->addSelect(DB::raw('db.id AS debt_id'))
            ->addSelect(DB::raw('db.amount AS debt_amount'))
            ->leftJoin('users AS us', 'us.id', '=', 'tr.created_by')
            ->leftJoin('customers AS cs', 'cs.id', '=', 'tr.customer_id')
            ->leftJoin('debt AS db', 'db.transaction_id', '=', 'tr.id')
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

        if (array_key_exists('page', $user_params)) {
            return $query->paginate($user_params['page']);
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

   public static function getPaidTransaction()
   {
        $transaction_records = DB::table('transactions')
            ->addSelect('transactions.id', 'transactions.order_id', DB::raw('customers.name AS customer_name'))
            ->addSelect(DB::raw('debt.id AS debt_id'))
            ->leftJoin('customers', 'customers.id', '=', 'transactions.customer_id')
            ->leftJoin('debt', 'transactions.id', '=', 'debt.transaction_id')
            ->get();
        return $transaction_records;
   }

   public static function getDebtByTransasction($transaction_id)
   {
        return DB::table('debt')
            ->where('transaction_id', $transaction_id)
            ->first();
   }

   public static function createDebt($user_input)
   {
        return DB::table('debt')
            ->insert($user_input);
   }

   public static function getDebtById($debt_id)
   {
        return DB::table('debt')
            ->where('id', $debt_id)
            ->first();
   }

   public static function updateDebt($debt_id, $user_input)
   {
        return DB::table('debt')
            ->where('id', $debt_id)
            ->update($user_input);
   }

   public static function getDebts($query_params = []) {
        $debt_records = DB::table('debt')
            ->addSelect('debt.id', 'debt.amount')
            ->addSelect(DB::raw('transactions.id AS transaction_id'))
            ->addSelect(DB::raw('customers.name AS customer_name'))
            ->addSelect('transactions.order_id')
            ->leftJoin('transactions', 'transactions.id', '=', 'debt.transaction_id')
            ->leftJoin('customers', 'customers.id', '=', 'transactions.customer_id')
            ->get();
        return $debt_records;
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
}