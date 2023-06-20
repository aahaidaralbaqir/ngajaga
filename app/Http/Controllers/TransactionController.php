<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;
use App\Constant\Constant;
use Illuminate\Support\Facades\Validator;
use App\Models\Transaction;
use App\Models\TransactionType;
use App\Models\Customer;

class TransactionController extends Controller
{
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
    }

    public function checkout(Request $request, $transactionId)
    {
        $data['transaction_type'] = TransactionType::all();
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
        return view('checkout', $data);
    }

    public function confirm(Request $request)
    {
        
    }

}
