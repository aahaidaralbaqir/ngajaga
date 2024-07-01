<?php

namespace App\Exports;

use App\Repositories\ProductRepository;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
class ProductHistoryExport implements FromCollection, WithHeadings, WithMapping 
{

	private $user_inputs = [];
    private $product_id = NULL;
	public function __construct($product_id, $user_inputs)
	{
		$this->user_inputs = $user_inputs;
        $this->product_id = $product_id;
	}

	public function headings(): array 
	{
		return [
			'Jenis',
			'Deskripsi'
		];
	}

    private function buildDescription($product) {
        $description = 'Pembelian barang pada invoice dengan kode ' . $product->invoice_code . ' sebanyak ' . $product->qty;
        if ($product->qty <= 0) {
            $description = 'Penjualan pada transaksi dengna order id ' . $product->order_id . ' sebanyak ' . $product->qty;
        } 
        return $description;
    }

	public function map($product): array
	{
		return [
            $product->qty < 1 ? 'KELUAR' : 'MASUK',
			$this->buildDescription($product)];
	}

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
		return ProductRepository::getProductStockActivityByProductId($this->product_id, $this->user_inputs);
    }
}
