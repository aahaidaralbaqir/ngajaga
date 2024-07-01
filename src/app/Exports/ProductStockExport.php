<?php

namespace App\Exports;

use App\Repositories\ProductRepository;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class ProductStockExport implements FromCollection, WithHeadings, WithMapping 
{

	private $user_inputs = [];
	public function __construct($user_inputs)
	{
		$this->user_inputs = $user_inputs;
	}

	public function headings(): array 
	{
		return [
			'Nama Produk',
			'Stok Masuk',
			'Stok Keluar',
			'Stok Saat Ini',
		];
	}

	public function map($product): array
	{
		return [
			$product->name,
			$product->stock_in,
			$product->stock_out,
			$product->stock_in - $product->stock_out];
	}

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
		return ProductRepository::getProductStock($this->user_inputs);
    }
}
