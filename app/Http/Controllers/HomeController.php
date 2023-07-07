<?php

namespace App\Http\Controllers;
use App\Models\TransactionType;
use App\Models\Heroes;
use App\Models\Activity;
use App\Models\Structure;
use App\Models\Post;
use App\Util\Common as CommonUtil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Constant\Constant;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $data['transaction_type'] = TransactionType::all();
		$data['categories'] = CommonUtil::getCategories();
		$data['programs'] = CommonUtil::getPrograms();
		$data['activity'] = Activity::where('show_landing_page', 1)->get();
		$data['structure'] = Structure::all();
		$data['posts'] = Post::whereIn('category', array_keys(CommonUtil::getCategories()))->limit(6)->get(); 
		$data['summary_transaction'] = $this->getSummaryTransaction();
        return view('index', $data);
    }

    public function pay(Request $request)
    {   
        return view('pay');
    }

	public function getSummaryTransaction()
	{
		$rest = DB::table('transaction')
					->select(DB::raw('SUM(transaction.paid_amount) as total_in_in_a_month'))
					->where('transaction.transaction_status', Constant::TRANSACTION_PAID)
					->whereMonth('created_at', Carbon::now()->month)
					->where('unit_id', env('UNIT_DEFAULT'))
					->first();
		$rest2 = DB::table('transaction')
					->select(DB::raw('SUM(transaction.paid_amount) AS total_out_in_a_month'))
					->whereMonth('created_at', Carbon::now()->month)
					->where('unit_id', env('UNIT_DEFAULT'))
					->where('transaction.transaction_status', Constant::TRANSACTION_DISTRIBUTED)
					->first();
		$rest3 = DB::table('transaction')
					->select(DB::raw('SUM(transaction.paid_amount) as total'))
					->where('transaction.transaction_status', Constant::TRANSACTION_PAID)
					->where('unit_id', env('UNIT_DEFAULT'))
					->first();
		$total_in  = $rest->total_in_in_a_month;
		$total_out  = $rest2->total_out_in_a_month;
		if ($total_in == NULL)
			$total_in = 0;
		if ($total_out == NULL)
			$total_out = 0;
		return [
			'total' => CommonUtil::formatAmount(Constant::UNIT_NAME_RUPIAH, $rest3->total),
			'month' => [
				'in' => CommonUtil::formatAmount(Constant::UNIT_NAME_RUPIAH, $total_in), 
				'out' => CommonUtil::formatAmount(Constant::UNIT_NAME_RUPIAH, $total_out * -1), 
			]
		];
	}

	public function getBanner(Request $request)
	{
		$banners = Heroes::orderBy('order', 'asc')->get();
		return response()->json([
			'message' => 'Success get banner',
			'data' => $banners
		], 200);
	}
}
