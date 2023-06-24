<?php 

namespace App\Util;
use App\Constant\Constant;

class Transaction {
    public function getTransactionStatus()
    {
        $transaction_status = [
            Constant::PG_STATUS_FAILURE => Constant::TRANSACTION_FAILED,
            Constant::PG_STATUS_CANCEL => Constant::TRANSACTION_FAILED,
            Constant::PG_STATUS_SETTLEMENT => Constant::TRANSACTION_PAID,
            Constant::PG_STATUS_EXPIRED => Constant::TRANSACTION_EXPIRED,
            Constant::PG_STATUS_PENDING => Constant::TRANSACTION_PENDING
        ];
        return $transaction_status;
    }

    public static function getTransactionStatusByPGStatus($pg_status)
    {
        $transaction_status = self::getTransactionStatus();
        return $transaction_status[$pg_status];
    }

    public static function getClassByTransactionStatus($transaction_status)
    {
        $transaction_status_classes = [
            Constant::TRANSACTION_FAILED => 'inline-flex rounded-full bg-[#DC3545] py-1 px-3 text-sm font-extralight text-white hover:bg-opacity-90',
            Constant::TRANSACTION_PAID => 'inline-flex rounded-full bg-[#13C296] py-1 px-3 text-sm font-extralight text-white hover:bg-opacity-90',
            Constant::TRANSACTION_EXPIRED => 'inline-flex rounded-full bg-[#EFEFEF] py-1 px-3 text-sm font-extralight text-[#212B36] hover:bg-opacity-90',
            Constant::TRANSACTION_PENDING => 'inline-flex rounded-full bg-[#EFEFEF] py-1 px-3 text-sm font-extralight text-[#212B36] hover:bg-opacity-90'
        ]; 
        return $transaction_status_classes[$transaction_status];
    }
    public function getTransactionStatusWithName()
    {
        $transaction_status_names = [
            Constant::TRANSACTION_FAILED => 'GAGAL',
            Constant::TRANSACTION_PAID => 'DIBAYAR',
            Constant::TRANSACTION_EXPIRED => 'KADALUARSA',
            Constant::TRANSACTION_PENDING => 'TERTUNDA'
        ];
        return $transaction_status_names;
    }
    public static function getTransactionNameByTransactionStatus($transaction_status) 
    {
        $transaction_status_names = self::getTransactionStatusWithName();   
        return $transaction_status_names[$transaction_status]; 
    }
}