<?php
namespace App\Repositories;

use App\Constant\Constant;
use App\Util\Common;
use Illuminate\Support\Facades\DB;

class PurchaseRepository {
    public static function getPurchaseOrderByNumber($purchase_number) 
    {
        return DB::table('purchase_orders')
            ->where('purchase_number', $purchase_number)
            ->first();
    }

    public static function createPurchaseOrder($user_input)
    {
        return DB::table('purchase_orders')
            ->insertGetId($user_input);
    }

    public static function createPurchaseOrderItem($order_items)
    {
        return DB::table('purchase_order_items')
            ->insert($order_items);
    }

    public static function getLatestPurchaseOrder()
    {
        $latest_purchase_order = DB::table('purchase_orders')
            ->orderBy('id', 'desc')
            ->first();
        if (!$latest_purchase_order)
            return 1;
        return $latest_purchase_order->id + 1;
    }

    public static function generateSupplierCode($supplierName)
    {
            // Convert to uppercase and remove spaces
        $transformedName = strtoupper(str_replace(' ', '', $supplierName));

        // Get the first 2 characters
        $firstTwo = substr($transformedName, 0, 2);
        
        // Get the middle character
        $middleIndex = floor(strlen($transformedName) / 2);
        $middle = substr($transformedName, $middleIndex, 1);
        
        // Get the last 2 characters
        $lastTwo = substr($transformedName, -2);

        // Concatenate to form the 5-character pattern
        $pattern = $firstTwo . $middle . $lastTwo;
        
        return $pattern;
    }

    public static function getSuppliers()
    {
        $supplier_records = DB::table('suppliers')
            ->addSelect('id')
            ->addSelect('name')
            ->addSelect('address')
            ->addSelect('email')
            ->addSelect('phone_number')
            ->get();

        foreach ($supplier_records as $idx => $supplier)
        {
            $supplier->code = self::generateSupplierCode($supplier->name);
            $supplier_records[$idx] = $supplier;
        }

        return $supplier_records;
    }

    public static function getPurchaseOrderById($purchase_order_id)
    {
        $query = DB::table('purchase_orders AS po')
            ->addSelect('po.id')
            ->addSelect('po.purchase_number')
            ->addSelect('po.purchase_date')
            ->addSelect('po.status')
            ->addSelect('po.supplier_id')
            ->where('po.id', $purchase_order_id)
            ->first();
        if ($query) {
            $query->purchase_date = date('Y-m-d', $query->purchase_date);
            $query->supplier = DB::table('suppliers')
                ->where('id', $query->supplier_id)
                ->first();
        }
        return $query;
    }
    
    public static function getPurchaseOrderItemByPurchaseOrderId($purchase_order_id)
    {
        $order_item_records = DB::table('purchase_order_items AS poi')
            ->addSelect('poi.id')
            ->addSelect('poi.product_id')
            ->addSelect('poi.qty')
            ->addSelect('poi.price')
            ->addSelect('poi.unit')
            ->addSelect('poi.received_qty')
            ->addSelect('poi.received_price')
            ->addSelect('poi.total_price')
            ->addSelect('poi.received_price')
            ->where('poi.purchase_order_id', $purchase_order_id)
            ->get();
        return $order_item_records;
    }

    public static function getPurchaserOrderItemDetailByPurchaseOrderId($purchase_order_id)
    {
        $order_item_records = DB::table('purchase_order_items AS poi')
            ->addSelect('poi.id')
            ->addSelect('poi.product_id')
            ->addSelect('poi.qty')
            ->addSelect('poi.price')
            ->addSelect('poi.unit')
            ->addSelect('poi.received_qty')
            ->addSelect('poi.received_price')
            ->addSelect('poi.total_price')
            ->addSelect('poi.notes')
            ->addSelect('poi.received_price')
            ->addSelect(DB::raw('pr.name AS product_name'))
            ->leftJoin('products AS pr', 'pr.id', '=', 'poi.product_id')
            ->where('poi.purchase_order_id', $purchase_order_id)
            ->get();
        $product_units = Common::getUnits();
        foreach ($order_item_records as $idx => $order_item)
        {
            $order_item->unit_name = $product_units[$order_item->unit];
            $order_item_records[$idx] = $order_item;
        }
        return $order_item_records; 
    }

    public static function updatePurchaseOrder($purchase_order_id, $user_input)
    {
        $query = DB::table('purchase_orders')
            ->where('id', $purchase_order_id)
            ->update(($user_input));
        return $query;
    }

    public static function updatePurchaseOrderItem($order_item_id, $user_input)
    {
        $query = DB::table('purchase_order_items')
            ->where('id', $order_item_id)
            ->update(($user_input));
        return $query;
    }

    public static function getPendingPurchaseOrders()
    {
        $query = DB::table('purchase_orders')
            ->where('status', Constant::PURCHASE_ORDER_WAITING)
            ->get();
        return $query;
    }

    public static function getPurchaseOrders($user_param) {
        $query = DB::table('purchase_orders')
            ->select(['purchase_orders.id', 'purchase_orders.purchase_date', DB::raw('suppliers.name AS supplier_name'), DB::raw('users.name AS created_by_name'), 'purchase_orders.status', 'purchase_orders.purchase_number', DB::raw('pi.id AS purchase_invoice_id')])
            ->leftJoin('suppliers', function ($join) {
                $join->on('suppliers.id', '=', 'purchase_orders.supplier_id');
            })
            ->leftJoin('purchase_invoices AS pi', 'pi.purchase_order_id', '=','purchase_orders.id')
            ->leftJoin('users', function ($join) {
                $join->on('users.id', '=', 'purchase_orders.created_by');
            });

        if (array_key_exists('status', $user_param))
            $query->whereIn('purchase_orders.status', $user_param['status']);
        return $query->get();
    }
}