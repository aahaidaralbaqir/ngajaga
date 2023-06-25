<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use App\Constant\Constant;
use Illuminate\Support\Facades\Validator;
use App\Models\Transaction;
use App\Models\TransactionType;
use App\Models\Payment;
use App\Models\Unit;
use App\Models\Customer;
use App\Models\FundDistribution;
use App\Client\Midtrans;
use App\Models\Beneficiary;
use App\Util\Transaction as TransactionUtil;
use Illuminate\Support\Facades\DB;
use App\Exports\TransactionExportSample;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class DistributionController extends Controller
{
    public function index(Request $request)
    {
        $user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
        $data['transaction_statuses'] = TransactionUtil::getTransactionStatusWithName();
        $data['transaction_type'] = TransactionType::all();
		$data['beneficiary'] = Beneficiary::all();
        $query = DB::table('transaction')->select(DB::raw('transaction.id, transaction.order_id, transaction.id_payment_type, payment_type.name as payment_name, transaction.transaction_status, transaction_type.name as transaction_type, transaction.paid_amount, transaction.created_at, unit.name as unit_name, beneficiary.name as beneficiary_name, beneficiary.id as beneficiary_id'))->leftJoin('payment_type', function ($join) {
            $join->on('transaction.id_payment_type', '=', 'payment_type.id');
        })->leftJoin('fund_distribution', function ($join) {
            $join->on('transaction.id', '=', 'fund_distribution.transaction_id'); 
        })->join('beneficiary', function ($join) {
			$join->on('fund_distribution.beneficiary_id', '=', 'beneficiary.id');
		})
		->join('transaction_type', function ($join) {
            $join->on('transaction.id_transaction_type', '=', 'transaction_type.id');
        })->join('unit', function ($join) {
            $join->on('transaction.unit_id', '=', 'unit.id');
        })->where('transaction.id_payment_type', '>', 0)
		->where('transaction.paid_amount', '<=', 0);
        $user_inputs = $request->all();
        foreach($user_inputs as $user_input => $value)
        {
            if (in_array($user_input, ['transaction_end']) && !empty($value))
            {
                if (!empty($user_inputs['transaction_start']))
                {
                    $start = sprintf('%s 00:00:00', $user_inputs['transaction_start']);
                    $end = sprintf('%s 23:59:50', $value);
                    $query->where('transaction.created_at', '>', $start)->where('transaction.created_at', '<', $end);
                }
            }

            if (in_array($user_input, ['nominal_end']) && !empty($value))
            {
                if (!empty($user_inputs['nominal_start']))
                {
                    $start = intval($user_inputs['nominal_start']) * -1;
                    $end = intval($value) * -1; 
                    $query->where('transaction.paid_amount', '>=', $start)->where('transaction.paid_amount', '<=', $end);
                }
            }

			if ($user_input == 'id_beneficiary' && !empty($value))
			{
				$query->where('fund_distribution.beneficiary_id', '=', $value);
			}
			
            if ($user_input == 'transaction_status' && !empty($value))
            {
                $query->where('transaction.transaction_status', '=', $value);
            }

            if ($user_input == 'transaction_type' && !empty($value))
            {
                $query->where('transaction.id_transaction_type', '=', $value);
            }
        }
        $transactions = $query->get();

		$data['transaction'] = $transactions;
    
		return view('admin.distribution.index', $data);
    }

	public function showCreateDistributionForm(Request $request)
	{
		$user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
		$data['item'] = NULL;
		$data['unit'] = Unit::all();
		$data['beneficiary'] = Beneficiary::all();
		$data['payments'] = Payment::where('id_parent',  env('MANUAL_PAYMENT_ID', 1))->get();
		$data['transaction_type'] = TransactionType::where('status', Constant::STATUS_ACTIVE)->get();
		return view('admin.distribution.form', $data);
	}

	public function showUpdateDistributionForm(Request $request, $transactionId)
	{
		$current_record = DB::table('transaction')->select(DB::raw('transaction.id, transaction.user_id, transaction.id_transaction_type, transaction.unit_id, transaction.order_id, transaction.id_payment_type, payment_type.name as payment_name, transaction.transaction_status, transaction_type.name as transaction_type, transaction.paid_amount, transaction.created_at, unit.name as unit_name, beneficiary.name as beneficiary_name, beneficiary.id as beneficiary_id, fund_distribution.description'))->leftJoin('payment_type', function ($join) {
            $join->on('transaction.id_payment_type', '=', 'payment_type.id');
        })->leftJoin('fund_distribution', function ($join) {
            $join->on('transaction.id', '=', 'fund_distribution.transaction_id'); 
        })->leftJoin('beneficiary', function ($join) {
			$join->on('fund_distribution.beneficiary_id', '=', 'beneficiary.id');
		})
		->join('transaction_type', function ($join) {
            $join->on('transaction.id_transaction_type', '=', 'transaction_type.id');
        })->join('unit', function ($join) {
            $join->on('transaction.unit_id', '=', 'unit.id');
        })->where('transaction.order_id', $transactionId)->first();
		if (empty($current_record->id))
		{
			return redirect()
					->route('distribution.index')
					->with(['error' => 'Gagal mengupdate transaksi, entitas tidak di temukan']);
		}
		$data['beneficiary'] = Beneficiary::all();
		$user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
		$data['beneficiary'] = Beneficiary::all();
		$data['transaction_statuses'] = TransactionUtil::getTransactionStatusWithName();
		// cast amount 
		$current_record->paid_amount = $current_record->paid_amount * -1;
		$data['item'] = $current_record;
		$data['unit'] = Unit::all();
		$data['payments'] = Payment::where('id_parent',  env('MANUAL_PAYMENT_ID', 1))->get();
		$data['transaction_type'] = TransactionType::where('status', Constant::STATUS_ACTIVE)->get();
		return view('admin.distribution.form', $data);
	}

	public static function getTransactionTotal($transaction_type_id)
	{
		$summary_transaction = DB::table('transaction')
								->select(DB::raw('SUM(transaction.paid_amount) as total_amount, transaction_type.name, transaction_type.id'))
								->join('transaction_type', function ($join) {
									$join->on('transaction.id_transaction_type', '=', 'transaction_type.id');
								})
								->groupBy('transaction.id_transaction_type')
								->where('transaction.id_transaction_type', $transaction_type_id)
								->first();
		if ($summary_transaction == NULL)
			return 0;
		return $summary_transaction->total_amount;
	}

	public function createDistribution(Request $request)
	{
		$current_user = Auth::user();
		$user_input_field_rules = [
			'id_transaction_type' => 'required',
			'unit_id' => 'required',
			'id_beneficiery' => 'required',
			'nominal' => 'required',
			'id_payment_type',
			'description'
		];

		$user_input =  $request->only('id_transaction_type', 'unit_id', 'nominal', 'id_payment_type', 'id_beneficiery', 'description');
		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
        {
            return back()
						->withErrors($validator)
						->withInput();
        }

		foreach ($user_input as $key => $value)
		{
			if (in_array($key, ['unit_id', 'id_transaction_type', 'nominal', 'id_payment_type', 'id_beneficiery']))
			{
				$user_input[$key] = intval($value);
			}
		}

		// revalidate amount
		if ($user_input['nominal'] > self::getTransactionTotal($user_input['id_transaction_type']))
		{
			return back()
					->with(['error' => 'Gagal menambah transaksi, total dana yang ingin dikeluarkan melebihi saldo saat ini']);
		}

		$transaction_status = Constant::TRANSACTION_REQUESTED;
		if ($current_user->role_id ==  env('ADMINISTRATOR_ROLE_ID', 1))
			$transaction_status = Constant::TRANSACTION_DISTRIBUTED;	

		$transaction_id = Uuid::uuid4();
		$transaction_record = [
			'id_transaction_type' => $user_input['id_transaction_type'],
			'unit_id' => $user_input['unit_id'],
			'id_payment_type' => $user_input['id_payment_type'],
			'paid_amount' => intval($user_input['nominal']) * -1,
			'user_id' => $current_user->id,
			'order_id' => $transaction_id,
			'transaction_status' => $transaction_status
		];
		
		$transaction_result = Transaction::create($transaction_record);
		
		$fund_distribution_record = [
			'transaction_id' => $transaction_result->id,
			'description' => $user_input['description'],
			'beneficiary_id' => $user_input['id_beneficiery'] 
		];

		$customer_result = FundDistribution::create($fund_distribution_record);
		return redirect()
                	->route('distribution.index')
					->with(['success' => 'Berhasil mendistribusikan dana baru']);
	}

	public function updateDistribution(Request $request)
	{
		$current_record = Transaction::find($request->id);
		if (empty($current_record))
		{
			return back()
					->with(['error' => 'Gagal mengupdate transaksi, entitas tidak di temukan']);	
		}
		$current_user = Auth::user();
		$user_input_field_rules = [
			'description' => 'required',
			'id_beneficiery' => 'required',
		];

		$user_input =  $request->only('id_transaction_type', 'unit_id', 'nominal', 'id_beneficiery', 'description', 'id_payment_type', 'transaction_status');
		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
        {
			echo $validator->errors();
			die();
            return back()
						->withErrors($validator)
						->withInput();
        }

		if ($user_input['nominal'] > self::getTransactionTotal($user_input['id_transaction_type']))
		{
			return back()
					->with(['error' => 'Gagal mengupdate transaksi, total dana yang ingin dikeluarkan melebihi saldo saat ini']);
		}

		foreach ($user_input as $key => $value)
		{
			if (in_array($key, ['unit_id', 'id_transaction_type', 'nominal', 'id_payment_type']))
			{
				$user_input[$key] = intval($value);
			}
		}

		if ($current_record->user_id > 0)
		{
			$transaction_record['transaction_status'] = $user_input['transaction_status'];
			$transaction_record['id_transaction_type'] = $user_input['id_transaction_type'];
			$transaction_record['unit_id'] = $user_input['unit_id'];
			$transaction_record['id_payment_type'] = $user_input['id_payment_type'];
			$transaction_record['paid_amount'] = $user_input['nominal'] * -1;
		}

		if (!empty($transaction_record))
			$transaction_result = Transaction::where(['id' => $current_record->id])->update($transaction_record);
		
		$beneficiary_record = [
			'beneficiary_id' => $user_input['id_beneficiery'],
			'description' => $user_input['description'] 
		];

		$customer_result = FundDistribution::where(['transaction_id' => $current_record->id])->update($beneficiary_record);
		return redirect()
                	->route('distribution.index')
					->with(['success' => 'Berhasil mengupdate transaksi']);
	}
}
