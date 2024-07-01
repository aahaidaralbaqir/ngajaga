<?php
namespace App\Repositories;

use App\Constant\Constant;
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
            ->addSelect('pm.unit')
            ->addSelect('pm.conversion')
            ->addSelect('pm.price')
            ->where('product_id', $product_id)
            ->get();
    }

    public static function createStock($user_input) 
    {
        return DB::table('stock')
            ->insertGetId($user_input);
    }

    public static function getProducts($user_input_params = array())
    {
        $query = DB::table('products')
            ->select(['products.id', 'products.name', 'products.image', DB::raw('category.name AS category_name'), DB::raw('shelf.name AS shelf_name')])
            ->leftJoin('category', function ($join) {
                $join->on('category.id', '=', 'products.category_id');
            })
            ->leftJoin('shelf', function ($join) {
                $join->on('shelf.id', '=', 'products.shelf_id');
            });
        foreach ($user_input_params as $key => $value) {
            if (in_array($key, ['cat']))
                $query->where('category.id', $value);
            if (in_array($key, ['search']) && $value)
                $query->where('products.name', 'like', '%' . $value . '%');
        }
        return $query->paginate(10);
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

    public static function deleteStockByTransactionId($transaction_id)
    {
        return DB::table('stock')
            ->where('identifier', $transaction_id)
            ->where('qty', '<', 0)
            ->delete();
    }

    public static function getCategories()
    {
        return DB::table('category')
            ->get();
    }

    public static function getDetailProducts($user_params) {
        $product_records = self::getProducts($user_params);
        $product_ids = [];
        foreach ($product_records as $product_record) {
            $product_ids[] = $product_record->id;
        }
        $product_stocks = self::getProductStockByIdsProduct($product_ids);
        $product_stocks_ids = array();
        foreach ($product_stocks as $product)
        {
            $product_stocks_ids[$product->product_id] = $product->total_stock;
        }
        $price_mapping_records = self::getProductLowestPriceByIds($product_ids);
        $price_mapping_ids = array();
        foreach ($price_mapping_records as $price_mapping)
            $price_mapping_ids[$price_mapping->product_id] = $price_mapping->lowest_price;

        foreach ($product_records as $index => $product_record) 
        {
            $stock = 0;
            if (array_key_exists($product_record->id, $product_stocks_ids))
                $stock = $product_stocks_ids[$product_record->id];  
            $lowest_price = 0;
            if (array_key_exists($product_record->id, $price_mapping_ids))
                $lowest_price = $price_mapping_ids[$product_record->id];  
            $product_records[$index]->image = Common::getStorage(Constant::STORAGE_PRODUCT, $product_record->image);
            $product_records[$index]->stock = $stock;
            $product_records[$index]->lowest_price = $lowest_price;
        }
        return $product_records;
    }

    public static function getProductUnitByProductIds($product_ids = [])
    {
        $price_mapping_records = DB::table('price_mapping')
            ->whereIn('product_id', $product_ids)
            ->orderBy('id', 'asc')
            ->get();
        $product_units = self::getProductUnit();
        foreach ($price_mapping_records as $idx => $price_mapping) {
            $price_mapping->unit_name = $product_units[$price_mapping->unit];
            $price_mapping_records[$idx] = $price_mapping;
        }
        $group_product_units = array();
        foreach ($price_mapping_records as $price_mapping) {
            if (array_key_exists($price_mapping->product_id, $group_product_units)) {
                $prev = $group_product_units[$price_mapping->product_id];
                $prev[] = $price_mapping;
                $group_product_units[$price_mapping->product_id] = $prev;
                continue;
            }
            $group_product_units[$price_mapping->product_id] = [$price_mapping];
        }
        return $group_product_units;
    }

    public static function getProductById($product_id)
    {
        $product_record = DB::table('products')
            ->where('id', $product_id)
            ->first();

        if ($product_record) {
            $product_record->prices = self::getPriceMappingByProductId($product_id);
            $product_record->image = Common::getStorage(Constant::STORAGE_PRODUCT, $product_record->image);
        }

        return $product_record;
    }

    public static function getProductStock($user_param = array())
    {
        $query = DB::table('stock AS st')
            ->select('st.product_id', 'products.name',
                DB::raw('SUM(CASE WHEN st.qty >= 0 THEN st.qty ELSE 0 END) AS stock_in'),
                DB::raw('SUM(CASE WHEN st.qty < 0 THEN st.qty ELSE 0 END) AS stock_out'))
            ->join('products', 'st.product_id', '=', 'products.id')
            ->groupBy('st.product_id', 'products.name');
        
        foreach ($user_param as $field => $value) {
            if (in_array($field, ['start_date'])) {
                $start = sprintf('%s 00:00:00', $value);
                $query->where('st.created_at', '>=', $start);
            }
            if (in_array($field, ['end_date'])) {
                $end = sprintf('%s 23:59:50', $value);
                $query->where('st.created_at', '=<', $end);
            }
        }

        if (array_key_exists('per_page', $user_param))
            return $query->paginate($user_param['per_page']);
        return $query->paginate(10);
    }

    public static function getProductStockActivityByProductId($product_id, $user_params = array())
    {
        $query = DB::table('stock AS st')
            ->addSelect('st.id', 'st.product_id', 'st.qty')
            ->addSelect(DB::raw('tr.id AS transaction_id'))
            ->addSelect(DB::raw('pi.id AS purchase_invoice_id'))
            ->addSelect('tr.order_id', 'tr.transaction_date')
            ->addSelect('pi.invoice_code')
            ->where('st.product_id', $product_id)
            ->leftJoin('transactions AS tr', 'st.identifier', '=', 'tr.id')
            ->leftJoin('purchase_invoices AS pi', 'st.identifier', '=', 'pi.id');

        foreach ($user_params as $field => $value) {
            if (in_array($field, ['start_date']) && $value) {
                $start = sprintf('%s 00:00:00', $value);
                $query->where('st.created_at', '>=', $start);
            }
            if (in_array($field, ['end_date']) && $value) {
                $end = sprintf('%s 23:59:50', $value);
                $query->where('st.created_at', '<=', $end);
            }
        }

        if (array_key_exists('per_page', $user_params))
            return $query->paginate($user_params['per_page']); 
        return $query->paginate(10);
    }
}