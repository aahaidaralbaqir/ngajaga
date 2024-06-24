<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Repositories\TransactionRepository;
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
			'No.Pembelian',
			'Total Pembayaran',
			'Di Buat Oleh',
			'Nama Pelanggan',
			'Akun'
		];
	}

	public function map($transaction): array
	{
		return [
			$transaction->order_id,
			CommonUtil::formatAmount('Rp', $transaction->price_total),
			$transaction->created_by_name,
			$transaction->customer_name,
			$transaction->account_name];
	}

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
		return TransactionRepository::getTransactions($this->user_inputs);
    }
}
