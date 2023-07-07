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
use Illuminate\Support\Facades\Crypt;

class HomeController extends Controller
{
	public function filterCategories($categories)
	{
		$filtered = [];
		foreach ($categories as $key => $value)
		{
			if (!in_array($key, array_keys(CommonUtil::getPrograms())))
				$filtered[$key] = $value;
		}
		return $filtered;
	}
    public function index(Request $request)
    {
        $data['transaction_type'] = TransactionType::all();
		$data['categories'] = $this->filterCategories(CommonUtil::getCategories());
		$data['programs'] = CommonUtil::getPrograms();
		$data['activity'] = Activity::where('show_landing_page', 1)->get();
		$data['structure'] = Structure::all();
		$data['posts'] = Post::whereNotIn('category', array_keys(CommonUtil::getPrograms()))->limit(6)->get(); 
		$data['summary_transaction'] = $this->getSummaryTransaction();
        return view('index', $data);
    }

	public function categories(Request $request, $id)
	{
		$decrypted = Crypt::decryptString($id);
		$decrypted_array = explode('_', $decrypted);
		if (count($decrypted_array) < 2)
		{
			return redirect()
					->route('homepage');
		}
		$page = 'Program';
		if (in_array(intval($decrypted_array[0]), array_keys(CommonUtil::getCategories())))
		{
			$page = 'Jurnal';
		}
		$data['category_name'] = $decrypted_array[1];
		$data['transaction_type'] = TransactionType::all();
		$data['page'] = $page;
		$data['categories'] = $this->filterCategories(CommonUtil::getCategories());
		$data['programs'] = CommonUtil::getPrograms();
		$data['activity'] = Activity::where('show_landing_page', 1)->get();
		$data['posts'] = Post::where('category', $decrypted_array[0])->limit(10)->get(); 
        return view('category', $data);	
	}

	public function detailCategories(Request $request, $id)
	{
		$decrypted = Crypt::decryptString($id);
		$decrypted_array = explode('_', $decrypted);
		if (count($decrypted_array) < 2)
		{
			return redirect()
					->route('homepage');
		}
		$current_record = Post::with('user')->where('id', $decrypted_array[0])->first();
		if (empty($current_record))
		{
			return redirect()
						->route('homepage');
		}
		
		$data['item'] = $current_record;
		$data['transaction_type'] = TransactionType::all();
		$data['categories'] = $this->filterCategories(CommonUtil::getCategories());
		$data['programs'] = CommonUtil::getPrograms();
		$data['activity'] = Activity::where('show_landing_page', 1)->get();
		$data['posts'] = [];
        return view('detail', $data);		
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
