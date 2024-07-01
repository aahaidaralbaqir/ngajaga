<?php

namespace App\Http\Controllers;

use App\Constant\Constant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use stdClass;

class DashboardController extends Controller
{
	public function index(Request $request)
	{
		$user_param = $request->all();
		$query = DB::table('transactions AS tr')
            ->select(DB::raw('COUNT(*) as total_transaction, SUM(price_total - COALESCE(debt.amount, 0)) as total_amount, COALESCE(sum(total_product_qty), 0) AS total_product_qty'))
            ->leftJoin('debt', 'debt.transaction_id', '=', 'tr.id');
		$total_purchase = DB::table('purchase_orders AS po')
			->where('status', Constant::PURCHASE_ORDER_COMPLETED);

		$most_purchased_product = DB::table('transaction_details as td')
			->join('transactions as t', 'td.transaction_id', '=', 't.id')
			->join('products as p', 'td.product_id', '=', 'p.id')
			->join('category as c', 'p.category_id', '=', 'c.id')
			->select(
				'td.product_id',
				'p.name as product_name',
				'c.name as category_name',
				'p.image as product_image',
				DB::raw('SUM(td.qty) as total_qty')
			)
			->groupBy('td.product_id', 'p.name', 'c.name', 'p.image')
			->orderBy('total_qty', 'DESC')
			->limit(5);
		foreach ($user_param as $field => $value) {
			if (in_array($field, ['start_date']) && $value) {
                $start = sprintf('%s 00:00:00', $value);
                $query->where('tr.created_at', '>=', $start);
                $total_purchase->where('po.purchase_date', '>=', strtotime($start));
				$most_purchased_product->where('t.created_at', '>=', $start);
            }
            if (in_array($field, ['end_date']) && $value) {
                $end = sprintf('%s 23:59:50', $value);
                $query->where('tr.created_at', '=<', $end);
				$total_purchase->where('po.purchase_date', '=<', strtotime($end));
				$most_purchased_product->where('t.created_at', '<=', $end);
            }
		}
		$transaction_summary = $query->first();
		if (!$transaction_summary) {
			$transaction_summary = new stdClass();
			$transaction_summary->total_transaction = 0;
			$transaction_summary->total_amount = 0;
			$transaction_summary->total_product_qty = 0;
		}
		$debt_summary = DB::table('debt')
			->addSelect(DB::raw('SUM(debt.amount) AS total_debt'))
			->first();
		$total_debt = 0;
		if ($debt_summary) {
			$total_debt = $debt_summary->total_debt;
		}
		
		$user_profile = parent::getUser();

		$lowest_product =  DB::table('products AS pr')
			->select('pr.id', 'pr.name', DB::raw('SUM(st.qty) AS total_qty'))
			->leftJoin('stock AS st', 'st.product_id', '=', 'pr.id')
			->groupBy('pr.id', 'pr.name')
			->having('total_qty', '<', 5)
			->get();

		$data['user'] = $user_profile;
		return view('admin.index')
			->with('user', parent::getUser())
			->with('summary', $transaction_summary)
			->with('total_debt', $total_debt)
			->with('lowest_product', $lowest_product)
			->with('most_purchased_products', $most_purchased_product->get())
			->with('total_purchase', count($total_purchase->get()))
			->with('has_filter', $request->query->count() > 0);
	}
}
