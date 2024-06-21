<?php
namespace App\Repositories;

use App\Util\Common;
use Illuminate\Support\Facades\DB;

class ProductRepository {
    public static function getProductUnit() 
    {
        return Common::getUnits();
    }
    
    public static function createPriceMapping($user_inputs)
    {
        return DB::table('price_mapping')
            ->insertGetId($user_inputs);
    }

    public static function getPriceMappingByProductId($product_id)
    {
        return DB::table('price_mapping AS pm')
            ->addSelect('pm.id')
            ->addSelect('pm.product_id')
            ->addSelect(DB::raw('p.name AS product_name'))
            ->addSelect('pm.unit')
            ->addSelect('pm.conversion')
            ->addSelect('pm.price')
            ->where('product_id', $product_id)
            ->get();
    }

    public static function createStockIn($user_input) 
    {
        return DB::table('stock')
            ->insertGetId($user_input);
    }

    public static function getProducts()
    {
        $records = DB::table('products')
            ->select(['products.id', 'products.name', 'products.image', DB::raw('category.name AS category_name'), DB::raw('shelf.name AS shelf_name')])
            ->leftJoin('category', function ($join) {
                $join->on('category.id', '=', 'products.category_id');
            })
            ->leftJoin('shelf', function ($join) {
                $join->on('shelf.id', '=', 'products.shelf_id');
            })
            ->get();
        return $records;
    }

    public static function getProductStockByIdsProduct($product_ids)
    {
        $product_stocks = DB::table('stock')
            ->addSelect('stock.product_id')
            ->addSelect(DB::raw('SUM(stock.qty) AS total_stock'))
            ->whereIn('product_id', $product_ids)
            ->groupBy('stock.product_id')
            ->get();
        return $product_stocks;
    }

    public static function getProductLowestPriceByIds($product_ids)
    {
        $price_mappings = DB::table('price_mapping AS pm')
            ->addSelect(DB::raw('MIN(price) AS lowest_price'))
            ->addSelect('pm.product_id')
            ->whereIn('product_id', $product_ids)
            ->groupBy('pm.product_id')
            ->get();
        return $price_mappings;
    }

    public static function getPriceMappingDetail($product_id, $unit)
    {
        return DB::table('price_mapping')
            ->where('product_id', $product_id)
            ->where('unit', $unit)
            ->first();
    }

    public static function deleteStockByPurchaseInvoiceId($invoice_id)
    {
        return DB::table('stock')
            ->where('identifier', $invoice_id)
            ->where('qty', '>', 0)
            ->delete();
    }
}