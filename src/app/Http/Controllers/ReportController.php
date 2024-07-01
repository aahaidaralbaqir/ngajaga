<?php

namespace App\Http\Controllers;

use App\Exports\AccountExport;
use App\Exports\AccountHistoryExport;
use App\Exports\ProductHistoryExport;
use App\Exports\ProductStockExport;
use App\Repositories\AccountRepository;
use App\Repositories\ProductRepository;
use App\Util\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Svg\Tag\Rect;

class ReportController extends Controller
{
    public function getProductReport(Request $request)
    {
        $stocks = ProductRepository::getProductStock($request->all());
        return view('admin.report.product')
            ->with('user', parent::getUser())
            ->with('has_filter', $request->query->count() > 0)
            ->with('products', $stocks);
    }

    public function downloadProductReport(Request $request)
    {
        $file_name = sprintf('Laporan-keluar-masuk-product-%s.csv', date('Y-m-d', time()));
        return Excel::download(new ProductStockExport($request->all()), $file_name);
    }

    public function getProductActivity(Request $request, $productId)
    {
        $product_record = ProductRepository::getProductById($productId);
        if (!$product_record) {
            return Response::backWithError('Produk tidak ditemukan');
        }
        $stocks = ProductRepository::getProductStockActivityByProductId($productId, $request->all());
        return view('admin.report.producthistory')
            ->with('user', parent::getUser())
            ->with('item', $product_record)
            ->with('has_filter', $request->query->count() > 0)
            ->with('products', $stocks); 
    }

    public function downloadProductActivity(Request $request, $productId)
    {
        $product_record = ProductRepository::getProductById($productId);
        if (!$product_record) {
            return Response::backWithError('Produk tidak ditemukan');
        }
        $file_name = sprintf('Laporan-aktifitas-produk-%s.csv', $product_record->name);
        return Excel::download(new ProductHistoryExport($productId, $request->all(),), $file_name); 
    }

    public function getAccountReport(Request $request)
    {
        $account_reports = AccountRepository::getAccountReport($request->all());
        return view('admin.report.account')
            ->with('user', parent::getUser())
            ->with('has_filter', $request->query->count() > 0)
            ->with('accounts', $account_reports);  
    }

    public function downloadAccountReport(Request $request)
    {
        $file_name = sprintf('Laporan-akun-%s.csv', date('Y-m-d', time()));
        return Excel::download(new AccountExport($request->all()), $file_name); 
    }

    public function getAccountActivity(Request $request, $accountId)
    {
        $account_record = AccountRepository::getAccountById($accountId);
        if (!$account_record) {
            return Response::backWithError('Akun tidak ditemukan');
        }

        $account_history_records = AccountRepository::getCashflowByAccountId($accountId, $request->all());
        return view('admin.report.accounthistory')
            ->with('item', $account_record)
            ->with('accounts', $account_history_records)
            ->with('has_filter', $request->query->count() > 0)
            ->with('user', parent::getUser());
    }

    public function downloadAccountActivity(Request $request, $accountId)
    {
        $account_record = AccountRepository::getAccountById($accountId);
        if (!$account_record) {
            return Response::backWithError('Akun tidak ditemukan');
        }
        $file_name = sprintf('Laporan-aktifitas-akun-%s.csv', $account_record->name);
        return Excel::download(new AccountHistoryExport($accountId, $request->all(),), $file_name);  
    }
}
