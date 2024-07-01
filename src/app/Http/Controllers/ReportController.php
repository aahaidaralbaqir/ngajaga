<?php

namespace App\Http\Controllers;

use App\Exports\ProductHistoryExport;
use App\Exports\ProductStockExport;
use App\Repositories\ProductRepository;
use App\Util\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

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
}
