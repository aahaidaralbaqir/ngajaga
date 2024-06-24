<?php
namespace App\Repositories;

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
}