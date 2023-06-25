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
use App\Client\Midtrans;
use App\Util\Transaction as TransactionUtil;
use App\Util\Common as CommonUtil;
use Illuminate\Support\Facades\DB;
use App\Exports\TransactionExportSample;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
        $data['transaction_statuses'] = TransactionUtil::getTransactionStatusWithName();
        $data['transaction_type'] = TransactionType::all();
        $query = DB::table('transaction')->select(DB::raw('transaction.id, transaction.order_id, transaction.id_payment_type, payment_type.name as payment_name, transaction.transaction_status, transaction_type.name as transaction_type, customer.email as email, transaction.paid_amount, transaction.created_at, unit.name as unit_name'))->leftJoin('payment_type', function ($join) {
            $join->on('transaction.id_payment_type', '=', 'payment_type.id');
        })->leftJoin('customer', function ($join) {
            $join->on('transaction.id', '=', 'customer.transaction_id'); 
        })->join('transaction_type', function ($join) {
            $join->on('transaction.id_transaction_type', '=', 'transaction_type.id');
        })->join('unit', function ($join) {
            $join->on('transaction.unit_id', '=', 'unit.id');
        })->where('transaction.id_payment_type', '>', 0)
		->where('paid_amount', '>', 0);
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

            if (in_array($user_input, ['settlement_end']) && !empty($value))
            {
                if (!empty($user_inputs['settlement_start']))
                {
                    $start = sprintf('%s 00:00:00', $user_inputs['settlement_start']);
                    $end = sprintf('%s 23:59:50', $value);
                    $query->where('transaction.settlement_datetime', '>', $start)->where('transaction.settlement_datetime', '<', $end);
                }http://127.0.0.1:8000/admin/transaction#
            }

            if (in_array($user_input, ['nominal_end']) && !empty($value))
            {
                if (!empty($user_inputs['nominal_start']))
                {
                    $start = intval($user_inputs['nominal_start']);
                    $end = intval($value); 
                    $query->where('transaction.paid_amount', '>=', $start)->where('transaction.paid_amount', '<=', $end);
                }
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
    
		return view('admin.transaction.list.index', $data);
    }
    private function getGroupedPayment($payment)
    {
        $parent_payment = [];
        $child_payment = [];
        foreach($payment as $parent)
        {
            if (empty($parent['id_parent']))
            {
                $parent_payment[] = $parent;
            } else 
            {
                $child_payment[] = $parent;
            }
        }

        foreach($parent_payment as $idx => $each_payment)
        {
            foreach($child_payment as $each_child)
            {
                if ($each_child['id_parent'] == $each_payment['id'])
                {
                    if (array_key_exists('childs', $parent_payment[$idx]))
                    {
                        $parent_payment[$idx]['childs'][] = $each_child;
                        continue;
                    }
                    $parent_payment[$idx]['childs']= [$each_child];
                }
            }
        }
        return $parent_payment;
    }
    public function create(Request $request)
    {
        // Todo: validate id_transaction_type
        $user_input_field_rules = [
            'id_transaction_type' => 'required|not_in:0',
            'name'  => 'required',
            'email' => 'required|email'
        ];
        $user_input =  $request->only('id_transaction_type', 'name', 'email');
		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
        {
            return back()
						->withErrors($validator)
						->withInput();
        }
        
        $transaction_id = Uuid::uuid4();
        $user_input['order_id'] = $transaction_id;
        $user_input['transaction_status'] = Constant::TRANSACTION_PENDING;

        $user_input['id_payment_type'] = 0;
		$user_input['unit_id'] = env('UNIT_DEFAULT',  11);

        $transaction_customer = [
            'transaction_id' => '',
            'name'  => $user_input['name'],
            'email'  => $user_input['email'],
        ];

        foreach($user_input as $input_key => $input_value)
            if (in_array($input_key, ['name', 'email']))
                unset($user_input[$input_key]);
        
        
        $transaction = Transaction::create($user_input);
        if ($transaction)
            $transaction_customer['transaction_id'] = $transaction->id;
        
        Customer::create($transaction_customer);
        return redirect()
                    ->route('transaction.checkout', ['transactionId' => $transaction_id]);
    }

    public function register(Request $request)
    {
        $user_input_field_rules = [
            'name'  => 'required',
            'email' => 'required|email',
            'transaction_id' => 'required',
            'nominal' => 'required|gte:10000',
            'phone_number' => 'required',
            'id_transaction_type' => 'required'
        ];
        $user_input =  $request->only('name', 'email', 'transaction_id', 'id_transaction_type', 'nominal', 'phone_number');
		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
        {
            return back()
						->withErrors($validator)
						->withInput();
        }
        $current_record = Transaction::where('order_id', $request->input('transaction_id'))->first();
        if (!$current_record)
        {
            return back()->with(['error' => 'ID Transaksi tidak dapat ditemukan']);
        }
        $transaction_record = [
            'id_transaction_type' => $user_input['id_transaction_type'],
            'paid_amount'   => $user_input['nominal']
        ];
        $transaction_customer = [
            'name'  => $user_input['name'],
            'email' => $user_input['email'],
            'phone_number' => $user_input['phone_number']
        ];
        Customer::where('transaction_id', $current_record->id)->update($transaction_customer);
        Transaction::where('id', $current_record->id)->update($transaction_record);
        return redirect()->route('transaction.payment', ['transactionId' => $current_record->order_id]);
    }

    public function checkout(Request $request, $transactionId)
    {
        $data['transaction_type'] = TransactionType::all();
        $current_record = Transaction::where('order_id', $transactionId)->with('customer')->first();
        if (!$current_record)
            return redirect()
                ->route('homepage')
                ->with(['error' => 'ID Transaksi tidak dapat ditemukan']);
        if ($current_record->transaction_status != Constant::TRANSACTION_PENDING)
        {
            return back()
                ->with(['error' => 'Tidak dapat mendapatkan transaksi karena status transaksi tidak sesuai']); 
        }
        $data['transaction_record'] = $current_record;
        $data['payments'] = $this->getGroupedPayment(Payment::where('status', TRUE)->get()->toArray());
        return view('checkout', $data);
    }

    public function payment(Request $request, $transactionId)
    {
        $current_record = Transaction::where('order_id', $transactionId)->with('customer')->first();
        if (!$current_record)
            return back()
                ->with(['error' => 'ID Transaksi tidak dapat ditemukan']);
        if ($current_record->transaction_status != Constant::TRANSACTION_PENDING)
        {
            return back()
                ->with(['error' => 'Tidak dapat mendapatkan transaksi karena status transaksi tidak sesuai']); 
        }
        $data['transaction_record'] = $current_record;
        $data['payments'] = $this->getGroupedPayment(Payment::where('status', Constant::STATUS_ACTIVE)->get()->toArray());
        return view('payment', $data); 
    }

    public function pay(Request $request)
    {

    }

    private function _buildMidtransPayload($payment_record, $transaction_record, $transaction_type_record)
    {
        $customer = $transaction_record->customer;
        $expired_transaction = 900; // default
        if ($payment_record->expired_time > 0)
            $expired_transaction = ceil($payment_record->expired_time / Constant::ONE_MINUTE);
        return [
            'expiry' => [
                'unit' => 'minutes',
                'duration' => $expired_transaction
            ],
            'transaction_details' => [
                'order_id' => $transaction_record->order_id,
                'gross_amount' => $transaction_record->paid_amount,
            ],
            'item_details' => [
                [
                    'id' => 1,
                    'price' => $transaction_record->paid_amount,
                    'quantity' => 1,
                    'name' => 'Pembayaran ' . $transaction_type_record->name,
                ]
            ],
            "enabled_payments" => [
                $payment_record->value
            ],
            'customer_details' => [
                'first_name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone_number,
            ]
        ];
    }

    public function paymentToken(Request $request)
    {
        $user_input_field_rules = [
            'transaction_id' => 'required',
            'id_payment' => 'required'
        ];
        $user_input =  $request->only('transaction_id', 'id_payment');
		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
        {
            return response()->json([
                'success' => FALSE,
                'data' => $validator->errors()
            ]);
        }
        $payment_record = Payment::find($user_input['id_payment']);
        if (empty($payment_record))
        {
            return response()->json([
                'success' => FALSE,
                'message' => 'Entitas payment tidak dapat di temukan'
            ], 404);
        }

        $transaction_record = Transaction::with('customer')->where('order_id', $user_input['transaction_id'])->first();
        if (empty($transaction_record))
        {
            return response()->json([
                'success' => FALSE,
                'message' => 'Entitas transaksi tidak dapat di temukan'
            ], 404);
        }
        $transaction_type_record = TransactionType::find($transaction_record->id_transaction_type);
        $request_payload = $this->_buildMidtransPayload($payment_record, $transaction_record, $transaction_type_record);

        $midtrans = new Midtrans();
        $snap_token = $midtrans->createSnapToken($request_payload);
        if (!$snap_token)
        {
            return response()->json([
                'success' => FALSE,
                'message' => 'Gagal membuat snap token'
            ], 400);
        }
        Transaction::where('id', $transaction_record->id)->update(['snap_token' => $snap_token, 'id_payment_type' => $payment_record->id]);
        return response()->json([
            'success' => TRUE,
            'message' => 'Success create snap token',
            'data' => $snap_token
        ], 200);
    }

    public function notification(Request $request)
    {
        $user_input_field_rules = [
            'order_id' => 'required',
        ];
        $user_input =  $request->only('order_id');
		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
        {
            return response()->json([
                'success' => FALSE,
                'data' => $validator->errors()
            ]);
        }

        $transaction_record = Transaction::where('order_id', $user_input['order_id'])->first();
        if (empty($transaction_record))
        {
            return response()->json([
                'success' => FALSE,
                'message' => 'Entitas transaksi tidak dapat di temukan'
            ], 404);
        }

        $midtrans = new Midtrans();
        $midtrans_record = $midtrans->getTransactionStatus($user_input['order_id']);
        if (!$midtrans_record)
        {
            return response()->json([
                'success' => FALSE,
                'message' => 'Gagal mengambil status transaksi ke midtrans'
            ], 400); 
        }

        $transaction_status = TransactionUtil::getTransactionStatusByPGStatus($midtrans_record->transaction_status);
        $settlement_time = $midtrans_record['settlement_time'];
        Transaction::where('id', $transaction_record->id)->update(['transaction_status' => $transaction_status, 'settlement_datetime' => $settlement_time]);
        return response()->json([
            'success' => TRUE,
        ], 200);
    }

    public function complete(Request $request, $transactionId)
    {
        $current_record = Transaction::where('order_id', $transactionId)->with('customer')->first();
        if (!$current_record)
            return redirect()
                ->route('homepage')
                ->with(['error' => 'ID Transaksi tidak dapat ditemukan']);
        $data['transaction_record'] = $current_record;
        return view('complete', $data);
    }

    public function sampleFile(Request $request)
    {
        return Excel::download(new TransactionExportSample, 'sample_export_transaction.csv');
    }

	public function showCreateTransactionForm(Request $request)
	{
		$user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
		$data['item'] = NULL;
		$data['unit'] = Unit::all();
		$data['payments'] = Payment::where('id_parent',  env('MANUAL_PAYMENT_ID', 1))->get();
		$data['transaction_type'] = TransactionType::where('status', Constant::STATUS_ACTIVE)->get();
		return view('admin.transaction.list.form', $data);
	}


	public function createTransaction(Request $request)
	{
		$current_user = Auth::user();
		$user_input_field_rules = [
			'id_transaction_type' => 'required',
			'unit_id' => 'required',
			'id_transaction_type' => 'required',
			'nominal' => 'required',
			'name' => 'required',
			'email' => 'required|email',
			'phone_number' => 'required'
		];

		$user_input =  $request->only('id_transaction_type', 'unit_id', 'nominal', 'name', 'email', 'phone_number', 'id_payment_type');
		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
        {
            return back()
						->withErrors($validator)
						->withInput();
        }

		foreach ($user_input as $key => $value)
		{
			if (in_array($key, ['unit_id', 'id_transaction_type', 'nominal', 'id_payment_type']))
			{
				$user_input[$key] = intval($value);
			}
		}

		$transaction_status = Constant::TRANSACTION_REQUESTED;
		if ($current_user->role_id ==  env('ADMINISTRATOR_ROLE_ID', 1))
			$transaction_status = Constant::TRANSACTION_PAID;	

		$transaction_id = Uuid::uuid4();
		$transaction_record = [
			'id_transaction_type' => $user_input['id_transaction_type'],
			'unit_id' => $user_input['unit_id'],
			'id_payment_type' => $user_input['id_payment_type'],
			'paid_amount' => $user_input['nominal'],
			'user_id' => $current_user->id,
			'order_id' => $transaction_id,
			'transaction_status' => $transaction_status
		];
		
		$transaction_result = Transaction::create($transaction_record);
		
		$customer_record = [
			'transaction_id' => $transaction_result->id,
			'name' => $user_input['name'],
			'email' => $user_input['email'],
			'phone_number' => $user_input['phone_number'] 
		];

		$customer_result = Customer::create($customer_record);
		return redirect()
                	->route('transaction.index')
					->with(['success' => 'Berhasil menambahkan transaksi']);
	}

	public function showUpdateTransactionForm(Request $request, $transactionId)
	{
		$current_record = DB::table('transaction')->select(DB::raw('transaction.id, transaction.order_id, transaction.id_payment_type, payment_type.name as payment_name, transaction.transaction_status, transaction_type.name as transaction_type, customer.email as email, transaction.paid_amount, customer.name as name, customer.email as email, customer.phone_number as phone_number, transaction.created_at, unit.name as unit_name, transaction.unit_id, transaction.id_transaction_type, transaction.user_id'))
		->leftJoin('payment_type', function ($join) {
            $join->on('transaction.id_payment_type', '=', 'payment_type.id');
        })->leftJoin('customer', function ($join) {
            $join->on('transaction.id', '=', 'customer.transaction_id'); 
        })->join('transaction_type', function ($join) {
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
		$user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
		$data['transaction_statuses'] = TransactionUtil::getTransactionStatusWithName();
		$data['item'] = $current_record;
		$data['unit'] = Unit::all();
		$data['payments'] = Payment::where('id_parent',  env('MANUAL_PAYMENT_ID', 1))->get();
		$data['transaction_type'] = TransactionType::where('status', Constant::STATUS_ACTIVE)->get();
		return view('admin.transaction.list.form', $data);
	}

	public function updateTransaction(Request $request)
	{
		$current_record = Transaction::find($request->id);
		$current_user = Auth::user();
		$user_input_field_rules = [
			'name' => 'required',
			'email' => 'required|email',
			'phone_number' => 'required'
		];

		$user_input =  $request->only('id_transaction_type', 'unit_id', 'nominal', 'name', 'email', 'phone_number', 'id_payment_type', 'transaction_status');
		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
        {
            return back()
						->withErrors($validator)
						->withInput();
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
			$transaction_record['paid_amount'] = $user_input['nominal'];
		}

		if (!empty($transaction_record))
			$transaction_result = Transaction::where(['id' => $current_record->id])->update($transaction_record);
		
		$customer_record = [
			'name' => $user_input['name'],
			'email' => $user_input['email'],
			'phone_number' => $user_input['phone_number'] 
		];

		$customer_result = Customer::where(['transaction_id' => $current_record->id])->update($customer_record);
		return redirect()
                	->route('transaction.index')
					->with(['success' => 'Berhasil mengupdate transaksi']);
	}

	public function summaryTransactionType(Request $request)
	{
		if (empty($request->id_transaction_type))
		{
			return response()->json([
				'error' => TRUE,
				'message' => 'Request tidak sesuai'
			], 400);
		}
		
		$summary_transaction = DB::table('transaction')
								->select(DB::raw('SUM(transaction.paid_amount) as total_amount, transaction_type.name, transaction_type.id'))
								->join('transaction_type', function ($join) {
									$join->on('transaction.id_transaction_type', '=', 'transaction_type.id');
								})
								->groupBy('transaction.id_transaction_type')
								->where('transaction.id_transaction_type', $request->id_transaction_type)
								->first();
		$response = [
			'error' => FALSE,
			'data' => [
				'total' => CommonUtil::formatAmount(Constant::UNIT_NAME_RUPIAH, 0)
			]];
		if ($summary_transaction != NULL)
		{
			$response['data']['total'] = CommonUtil::formatAmount(Constant::UNIT_NAME_RUPIAH, intval($summary_transaction->total_amount));
			$response['data']['name'] =	$summary_transaction->name;
		}
		return response()->json([
			'error' => FALSE,
			'data' => $response
		]);
	}
}
