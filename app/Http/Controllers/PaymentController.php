<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
		$data['payment'] = Payment::all(); 
		return view('admin.payment.index', $data); 
    }

    public function createForm(Request $request)
    {
        $user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
		$data['payments'] = Payment::where('id_parent', 0)->get(); 
        $data['item'] = NULL;
		return view('admin.payment.form', $data);  
    }

    public function updateForm(Request $request, $paymentId)
    {
        $current_record = Payment::find($paymentId);
        if (empty($current_record))
        {
           return back()
                    ->with(['error' => 'Entitas tidak ditemukan']);
        }
        $user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
        $data['payments'] = Payment::where('id_parent', 0)->get(); 
        $data['item'] = $current_record;
		return view('admin.payment.form', $data);  
    }

    public function createPayment(Request $request)
    {
        $user_input_field_rules = [
			'name' => 'required',
			'value' => 'required',
			'expired_time' => 'required'
		];
		$user_input = $request->only('name', 'id_parent', 'value', 'expired_time');

		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();

        $user_input['status'] = FALSE;

        if ($request->hasFile('payment_logo'))
		{
			$filename = time() . '.' . $request->file('payment_logo')->getClientOriginalExtension();
			$path = $request->file('payment_logo')->storeAs('public/payment_logo', $filename);
			if (empty($path))
			{
				return back()->withErrors(['payment_logo' => 'Gagal mengupload logo payment'])
							->withInput();
			}
			$user_input['payment_logo'] = $filename;
		}
        if ($request->has('status')) $user_input['status'] = TRUE;
		Payment::create($user_input);
		return redirect()
					->route('payment.index')
					->with(['success' => 'Berhasil menambahkan role baru']);
    }

    public function updatePayment(Request $request)
    {
        $current_record = Payment::find($request->id);
		if (empty($current_record))
			return back()
					->with(['error' => 'Gagal mengupdate permission, entitas tidak ditemukan']);
        
        $user_input_field_rules = [
            'name' => 'required',
            'value' => 'required',
            'expired_time' => 'required'
        ];
        $user_input = $request->only('name', 'id_parent', 'value', 'expired_time');

        $validator = Validator::make($user_input, $user_input_field_rules);
        if ($validator->fails())
            return back()
                        ->withErrors($validator)
                        ->withInput();

        $user_input['status'] = 2;

        if ($request->hasFile('payment_logo'))
        {
            $file_location = 'public/payment_logo/' . CommonUtil::getFileName($current_record->payment_logo);
			Storage::delete($file_location);
            $filename = time() . '.' . $request->file('payment_logo')->getClientOriginalExtension();
            $path = $request->file('payment_logo')->storeAs('public/payment_logo', $filename);
            if (empty($path))
            {
                return back()->withErrors(['payment_logo' => 'Gagal mengupload logo payment'])
                            ->withInput();
            }
            $user_input['payment_logo'] = $filename;
        }
        if ($request->has('status')) $user_input['status'] = TRUE;
        Payment::where('id', $request->id)->update($user_input);
        return redirect()
                    ->route('payment.index')
                    ->with(['success' => 'Berhasil menambahkan role baru']);
    }
}
