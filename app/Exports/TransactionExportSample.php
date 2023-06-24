<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use App\Models\TransactionType;
use App\Models\Payment;
use App\Constant\Constant; 

class TransactionExportSample implements FromArray
{
    public function headers()
    {
        return [
            '#',
            'Jenis Transaksi',
            'Metode Pembayaran',
            'Email',
            'Nominal'
        ];
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    private function _convert_transaction_type_to_string($records)
    {
        $result = '';
        foreach ($records as $record) {
            $result .= $record['id'] . '=' . $record['name'] . ',';
        }
        return $result;
    }

    public function array(): array
    {
        $transaction_type = TransactionType::where('status', Constant::STATUS_ACTIVE)->get();
        $payment_type = Payment::where('id_parent', '>', 0)->get();
        $result = $this->_convert_transaction_type_to_string($transaction_type);
        $result2 = $this->_convert_transaction_type_to_string($payment_type);
        return  [
            [
                '#',
                'Jenis Transaksi',
                'Metode Pembayaran',
                'Email',
                'Nominal'
            ],
            [
                '3',
                $result,
                $result2,
                'sample@email.com',
                '1'
            ]
        ];
    }

}
