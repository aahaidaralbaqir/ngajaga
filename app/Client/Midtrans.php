<?php
 
namespace App\Client;
 
use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;

class Midtrans {
    protected $serverKey;
    protected $isProduction;
    protected $isSanitized;
    protected $is3ds;
 
    public function __construct()
    {
        $this->serverKey = config('midtrans.server_key');
        $this->isProduction = config('midtrans.is_production');
        $this->isSanitized = config('midtrans.is_sanitized');
        $this->is3ds = config('midtrans.is_3ds');
 
        $this->_configureMidtrans();
    }
 
    public function _configureMidtrans()
    {
        Config::$serverKey = $this->serverKey;
        Config::$isProduction = $this->isProduction;
        Config::$isSanitized = $this->isSanitized;
        Config::$is3ds = $this->is3ds;
    }

    public function createSnapToken($requestPayload)
    {
        $snapToken = Snap::getSnapToken($requestPayload);

        return $snapToken;
    }

    public function getTransactionStatus($orderId)
    {
        return Transaction::status($orderId);
    }
}