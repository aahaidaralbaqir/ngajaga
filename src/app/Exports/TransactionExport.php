<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Illuminate\Support\Facades\DB;
use App\Constant\Constant;
use App\Util\Common as CommonUtil;
class TransactionExport implements FromCollection, WithHeadings, WithMapping 
{

	private $user_inputs = [];
	public function __construct($user_inputs)
	{
		$this->user_inputs = $user_inputs;
	}

	public function headings(): array 
	{
		return [
			'Jenis Transaksi',
			'Total Dana Masuk',
			'Total Dana Keluar',
			'Total Transaksi Masuk',
			'Total Transaksi Keluar'
		];
	}

	public function map($transaction): array
	{
		return [
			$transaction->name,
			CommonUtil::formatAmount($transaction->unit_name, $transaction->transaction_in),
			CommonUtil::formatAmount($transaction->unit_name, $transaction->transaction_out * -1),	
			$transaction->transaction_total_in,
			$transaction->transaction_total_out];
	}

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $query = DB::table('transaction')->select(DB::raw('SUM(CASE WHEN transaction.paid_amount > 0 THEN transaction.paid_amount ELSE 0 END) as transaction_in, SUM(CASE WHEN transaction.paid_amount < 0 THEN transaction.paid_amount ELSE 0 END) as transaction_out, transaction_type.name, unit.name as unit_name, SUM(CASE WHEN transaction.paid_amount > 0 THEN 1  ELSE 0 END) as transaction_total_in, SUM(CASE WHEN transaction.paid_amount < 0 THEN 1 ELSE 0 END) as transaction_total_out'))
                    ->join('transaction_type', function ($join) {
                        $join->on('transaction.id_transaction_type', '=', 'transaction_type.id');
                    })
                    ->join('unit', function ($join) {
                        $join->on('transaction.unit_id', '=', 'unit.id');
                    })->whereIn('transaction.transaction_status', [Constant::TRANSACTION_PAID, Constant::TRANSACTION_DISTRIBUTED]);
		foreach ($this->user_inputs as $key => $value)
		{
			if (in_array($key, ['transaction_end']) && !empty($value))
			{
				$start = $this->user_inputs['transaction_start'];
				$end = $this->user_inputs['transaction_end'];
				if ($start <= $end)
				{
					$start = sprintf('%s 00:00:00', $this->user_inputs['transaction_start']);
					$end = sprintf('%s 23:59:50', $value);
					$query->where('transaction.created_at', '>', $start)->where('transaction.created_at', '<', $end);
				}
			}

			if (in_array($key, ['nominal_end']) && !empty($value))
			{
				if (!empty($user_inputs['nominal_start']))
				{
					$start = intval($this->user_inputs['nominal_start']);
					$end = intval($value); 
					$query->where('transaction.paid_amount', '>=', $start)->where('transaction.paid_amount', '<=', $end);
				}
			}

			if (in_array($key, ['unit_id']) && !empty($value))
			{
				$query->where('transaction.unit_id', '=', $value);
			}
		}
		$result = $query->groupBy('transaction.id_transaction_type')->groupBy('transaction.unit_id')->get();
		return $result;
    }
}
