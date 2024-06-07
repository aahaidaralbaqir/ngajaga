<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $product_records = DB::table('products')
                            ->select(['products.id', 'products.name', 'products.selling_price', DB::raw('category.name AS category_name'), DB::raw('shelf.name AS shelf_name')])
                            ->leftJoin('category', function ($join) {
                                $join->on('category.id', '=', 'products.category_id');
                            })
                            ->leftJoin('shelf', function ($join) {
                                $join->on('shelf.id', '=', 'products.shelf_id');
                            })
                            ->get()
                            ->toArray();
        $product_ids = array_map(function ($item) {
            return $item['id'];
        }, $product_records);

        $product_stocks = DB::table('stock')
                            ->select(['stock.id', DB::raw('SUM(stock.qty) AS total_stock')])
                            ->whereIn('id', $product_ids)
                            ->groupBy('stock.product_id', 'stock.id')
                            ->get();
        $product_stocks_ids = array();
        foreach ($product_stocks as $product)
        {
            $product_stocks_ids[$product_stocks->id] = $product->total_stock;
        }

        foreach ($product_records as $index => $product_record) 
        {
            $product_records[$index]->stock = $product_stocks_ids[$product_record->id];   
        }
        $data['products'] = $product_records;
        $data['total_row'] = count($product_records);
        return view('admin.product.index', $data);
    }
}
