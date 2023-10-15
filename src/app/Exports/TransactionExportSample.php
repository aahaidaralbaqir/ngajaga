<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use App\Models\TransactionType;
use App\Models\Payment;
use App\Models\Unit;
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
    private function formatRecord($records)
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
        $unit = Unit::all();
        $result = $this->formatRecord($transaction_type);
        $result2 = $this->formatRecord($payment_type);
        $result3 = $this->formatRecord($unit);
        return  [
            [
                '#',
                'Name',
                'Email',
                'Jenis Transaksi',
                'Metode Pembayaran',
                'Nominal',
                'Satuan'
            ],
            [
                '3',
                'Name',
                'sample@email.com',
                $result,
                $result2,
                '1',
                $result3
            ]
        ];
    }

}
