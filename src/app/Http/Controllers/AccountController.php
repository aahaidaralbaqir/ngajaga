<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AccountController extends Controller
{
    public function index()
    {
        $account_records = DB::table('accounts')
                                ->select(['accounts.id', 'accounts.name', DB::raw('SUM(cashflows.amount) AS current_balance')])
                                ->leftJoin('cashflows', function ($join) {
                                    $join->on('cashflows.account_id', '=', 'accounts.id');
                                })
                                ->groupBy('accounts.id', 'accounts.name')
                                ->get();
        $data['accounts'] = $account_records;
		$data['total_row'] = count($account_records);
		return view('admin.account.index', $data);
    }
}
