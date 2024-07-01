<?php

namespace App\Http\Controllers;

use App\Exports\ProductStockExport;
use App\Repositories\ProductRepository;
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
}
