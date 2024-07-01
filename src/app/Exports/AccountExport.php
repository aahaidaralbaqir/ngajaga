<?php

namespace App\Exports;

use App\Constant\Constant;
use App\Repositories\AccountRepository;
use App\Repositories\ProductRepository;
use App\Util\Common;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class AccountExport implements FromCollection, WithHeadings, WithMapping 
{

	private $user_inputs = [];
	public function __construct($user_inputs)
	{
		$this->user_inputs = $user_inputs;
	}

	public function headings(): array 
	{
		return [
			'Nama Akun',
			'Uang Masuk',
			'Uang Keluar',
			'Saldo Saat Ini',
		];
	}

	public function map($account): array
	{
		return [
            $account->name,
            Common::formatAmount(Constant::UNIT_NAME_RUPIAH, $account->amount_in),
            Common::formatAmount(Constant::UNIT_NAME_RUPIAH, $account->amount_out * -1),
            Common::formatAmount(Constant::UNIT_NAME_RUPIAH, $account->amount_in - $account->amount_out * -1),
        ];
	}

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
		return AccountRepository::getAccountReport($this->user_inputs);
    }
}
