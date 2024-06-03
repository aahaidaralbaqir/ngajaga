<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Util\Common as CommonUtil;
use App\Util\Transaction as TransactionUtil;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Constant\Constant;

class DashboardController extends Controller
{
	public function getTransactionChartDiagram() 
	{
		$transaction = DB::table('transaction')
						->select(DB::raw("count(*) as total_transaction, transaction.transaction_status, DATE_FORMAT(transaction.created_at,'%m') as month, CASE WHEN transaction.transaction_status = 3 THEN 'Paid' WHEN transaction.transaction_status=6 THEN 'Distributed' ELSE 'Invalid status' END AS transaction_status_name"))
						->whereIn('transaction_status', [Constant::TRANSACTION_PAID, Constant::TRANSACTION_DISTRIBUTED])
						->whereYear('transaction.created_at', date('Y'))
						->groupBy(DB::raw('DATE_FORMAT(transaction.created_at, "%m")'), 'transaction.transaction_status')
						->get();
		$summary = [
			'in' => [],
			'out' => [],
		];
		for ($idx=0; $idx < 12; $idx++) { 
			$summary['in'][] = 0;
			$summary['out'][] = 0;
		}
		foreach($transaction as $item)
		{
			$category = $item->transaction_status == '3' ? 'in' : 'out';
			$index = intval($item->month) - 1;
			$summary[$category][$index] = $item->total_transaction; 
		}
		return response()
					->json($summary,  200);
	}

	public function getTransactionChartDonut() 
	{
		$transaction = DB::table('transaction')
						->select(DB::raw('COUNT(transaction.id) as total_transaction, transaction_type.name'))
						->join('transaction_type', function ($join) {
							$join->on('transaction.id_transaction_type', '=', 'transaction_type.id');
						})
						->whereIn('transaction.transaction_status', [Constant::TRANSACTION_PAID])
						->where('transaction.unit_id', env('UNIT_DEFAULT'))
						->groupBy('transaction.id_transaction_type')
						->get();
		return response()
				->json($transaction,  200);
	}
	public function getDashboardSummary()
	{
		$users = User::get();
		$transaction = DB::table('transaction')->select(DB::raw('SUM(CASE WHEN transaction.paid_amount > 0 THEN transaction.paid_amount ELSE 0 END) as transaction_in, SUM(CASE WHEN transaction.paid_amount > 0 THEN 1 ELSE 0 END) as total_transaction_in,  SUM(CASE WHEN transaction.paid_amount < 0 THEN transaction.paid_amount ELSE 0 END) as transaction_out, SUM(CASE WHEN transaction.paid_amount > 0 THEN 0 ELSE 1 END) as total_transaction_out,  SUM(transaction.paid_amount) as total_transaction'))
			->join('unit', function ($join) {
				$join->on('transaction.unit_id', '=', 'unit.id');
			})
			->whereIn('transaction.transaction_status', [Constant::TRANSACTION_PAID, Constant::TRANSACTION_DISTRIBUTED])
			->where('transaction.unit_id', env('UNIT_DEFAULT'))
			->groupBy('transaction.unit_id')
			->first();
		$transaction_type = DB::table('transaction_type');
		$activity = DB::table('activity')->count();
		$posts = DB::table('post')->where('status', Constant::STATUS_PUBLISHED)->count();
		$amount_in = $transaction == NULL ? 0 : $transaction->transaction_in;
		if ($amount_in == NULL)
			$amount_in = 0;
		$amount_out = $transaction == NULL ? 0 : $transaction->transaction_out;
		if ($amount_out == NULL)
			$amount_out = 0;
		$total_amount = $transaction == NULL ? 0 : $transaction->total_transaction;
		if ($total_amount == NULL)
			$total_amount = 0;
		return [
			'summary' => [
				'user' => $users->count(),
				'transaction_type' => $transaction_type->count(),
				'activity' => $activity, 
				'amount' => [
					'total_in' => $transaction == NULL ? 0 : $transaction->total_transaction_in,
					'total_out' => $transaction == NULL ? 0 : $transaction->total_transaction_out,
					'in' => CommonUtil::formatAmount(Constant::UNIT_NAME_RUPIAH, $amount_in),
					'out' => CommonUtil::formatAmount(Constant::UNIT_NAME_RUPIAH, $amount_out * -1),
					'total' => CommonUtil::formatAmount(Constant::UNIT_NAME_RUPIAH, $total_amount)]],
			'transaction_type' => $transaction_type,
		];
	}
	public function index(Request $request)
	{
		$user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
		$data['dashboard_summary'] = $this->getDashboardSummary();
		return view('admin.index', $data);
	}
}
