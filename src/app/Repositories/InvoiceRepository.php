<?php
namespace App\Repositories;

use Illuminate\Support\Facades\DB;

class InvoiceRepository {
    public static function createInvoice($user_input)
    {
        return DB::table('purchase_invoices')
            ->insertGetId($user_input);
    }

    public static function editInvoice($invoice_id, $user_input)
    {
        return DB::table('purchase_invoices')
            ->where('id', $invoice_id)
            ->update($user_input);
    }

    public static function getInvoices()
    {
        $invoice_records = DB::table('purchase_invoices AS pi')
            ->addSelect('pi.id', 'pi.invoice_code')
            ->addSelect('pi.received_date', 'pi.description', 'pi.created_at')
            ->addSelect('po.purchase_number')
            ->addSelect('pi.payment_total')
            ->addSelect(DB::raw('ac.name AS account_name'))
            ->leftJoin('purchase_orders AS po', 'po.id', '=', 'pi.purchase_order_id')
            ->join('accounts AS ac', 'ac.id', '=', 'pi.account_id')
            ->get();

        foreach ($invoice_records as $index => $invoice)
        {
            $invoice->received_date = date('Y m d', $invoice->received_date); 
            $invoice_records[$index] = $invoice;  
        }
        return $invoice_records;
    }

    public static function getInvoiceById($invoice_id)
    {
        $query = DB::table('purchase_invoices AS pi')
            ->addSelect('pi.id', 'pi.invoice_code')
            ->addSelect('pi.purchase_order_id')
            ->addSelect('pi.account_id')
            ->addSelect('pi.received_date', 'pi.description', 'pi.created_at')
            ->addSelect('po.purchase_number')
            ->leftJoin('purchase_orders AS po', 'po.id', '=', 'pi.purchase_order_id')
            ->where('pi.id', $invoice_id)
            ->first();
        if ($query)
            $query->received_date = date('Y-m-d', $query->received_date);
        return $query;
    }

    public static function getLatestInvoiceId()
    {
        $invoice_record = DB::table('purchase_invoices AS pi')
            ->orderBy('id', 'desc')
            ->first();
        if ($invoice_record)
            return $invoice_record->id + 1;
        return 1;
    }
}