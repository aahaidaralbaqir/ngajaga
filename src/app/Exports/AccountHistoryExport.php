<?php

namespace App\Exports;

use App\Repositories\AccountRepository;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class AccountHistoryExport implements FromCollection, WithHeadings, WithMapping 
{

	private $user_inputs = [];
    private $account_id = NULL;
	public function __construct($account_id, $user_inputs)
	{
		$this->user_inputs = $user_inputs;
        $this->account_id = $account_id;
	}

	public function headings(): array 
	{
		return [
			'Jenis',
			'Deskripsi'
		];
	}

	public function map($account): array
	{
		return [
            empty($account->cashflow_type) ? 'SALDO AWAL' : strtoupper($account->cashflow_type),
            $account->description]; 
	}

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
		return AccountRepository::getCashflowByAccountId($this->account_id, $this->user_inputs);
    }
}
