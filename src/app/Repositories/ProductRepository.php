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

}