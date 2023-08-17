<?php 

namespace App\Util;
use App\Constant\Constant;

class Transaction {
    public static function getTransactionStatus()
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
            Constant::TRANSACTION_REQUESTED => 'inline-flex rounded-full bg-requested py-1 px-3 text-sm font-extralight text-white hover:bg-opacity-90',
            Constant::TRANSACTION_FAILED => 'inline-flex rounded-full bg-failed py-1 px-3 text-sm font-extralight text-white hover:bg-opacity-90',
            Constant::TRANSACTION_PAID => 'inline-flex rounded-full bg-[#13C296] py-1 px-3 text-sm font-extralight text-white hover:bg-opacity-90',
            Constant::TRANSACTION_DISTRIBUTED => 'inline-flex rounded-full bg-[#13C296] py-1 px-3 text-sm font-extralight text-white hover:bg-opacity-90',
            Constant::TRANSACTION_EXPIRED => 'inline-flex rounded-full bg-expired py-1 px-3 text-sm font-extralight text-[#212B36] hover:bg-opacity-90',
            Constant::TRANSACTION_PENDING => 'inline-flex rounded-full bg-pending py-1 px-3 text-sm font-extralight text-[#212B36] hover:bg-opacity-90'
        ]; 
        return $transaction_status_classes[$transaction_status];
    }
    public static function getTransactionStatusWithName()
    {
        $transaction_status_names = [
            Constant::TRANSACTION_FAILED => 'FAILED',
            Constant::TRANSACTION_DISTRIBUTED => 'DISTRIBUTED',
            Constant::TRANSACTION_PAID => 'PAID',
            Constant::TRANSACTION_EXPIRED => 'EXPIRE',
            Constant::TRANSACTION_PENDING => 'PENDING',
            Constant::TRANSACTION_REQUESTED => 'REQUESTED'
        ];
        return $transaction_status_names;
    }
    public static function getTransactionNameByTransactionStatus($transaction_status) 
    {
        $transaction_status_names = self::getTransactionStatusWithName();   
        return $transaction_status_names[$transaction_status]; 
    }
}