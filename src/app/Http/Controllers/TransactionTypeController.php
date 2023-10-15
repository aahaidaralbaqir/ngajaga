<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Util\Common as CommonUtil;
use App\Constant\Constant;
use Illuminate\Support\Facades\Validator;
use App\Models\TransactionType;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class TransactionTypeController extends Controller
{
    public function  index(Request $request)
    {
        $user_profile = $this->initProfile();
        $data = array_merge(array(), $user_profile);
        $transaction_type =  TransactionType::all();
        $data['transaction_type'] = $transaction_type;
        return view('admin.transaction.type.index', $data);
    }

    public function showCreateTransactionTypeForm(Request $request)
    {
        $user_profile = $this->initProfile();
        $data = array_merge(array(), $user_profile);
        $data['item'] = NULL;
		$data['status'] = CommonUtil::getStatusExcept([Constant::STATUS_DRAFT, Constant::STATUS_PUBLISHED]);
        return view('admin.transaction.type.form', $data);
    }

    public function showEditTransactionTypeForm(Request $request, $id)
    {
		$current_record = TransactionType::find($id);
		if (empty($current_record))
			return back()
				->with(['error' => 'Gagal mengupdate jenis transaksi, entitas tidak ditemukan']);
		$user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
		$data['item'] = $current_record;
		$data['status'] = CommonUtil::getStatusExcept([Constant::STATUS_DRAFT, Constant::STATUS_PUBLISHED]);
		return view('admin.transaction.type.form', $data);	
    }

    public function createTransactionType(Request $request)
    {
        $user_input_field_rules = [
			'name' => 'required',
			'description' => 'required',
			'status' => 'required|in:' . implode(',', [Constant::STATUS_ACTIVE, Constant::STATUS_INACTIVE])
		];

		$user_input = $request->only('name', 'description', 'status');

		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();
		
		if (!$request->hasFile('icon'))
			return back()->withErrors(['icon' => 'Banner wajib di isi'])
							->withInput();
		
		$filename = time() . '.' . $request->file('icon')->getClientOriginalExtension();
		$path = $request->file('icon')->storeAs('public/transaction', $filename);
		if (empty($path))
		{
			return back()->withErrors(['icon' => 'Gagal mengupload banner'])
						->withInput();
		}
		
		$user_input['icon'] = $filename;

		TransactionType::create($user_input);
		return redirect()
					->route('transaction.type.index')
					->with(['success' => 'Berhasil menambahkan jenis transaksi baru']);
    }

    public function updateTransactionType(Request $request)
    {
		$current_record = TransactionType::find($request->id);
		if (empty($current_record))
			return back()
					->with(['error' => 'Berhasil mengupdate jenis transaksi, entitas tidak ditemukan']);
		
		$user_input_field_rules = [
			'name' => 'required',
			'description' => 'required',
			'status' => 'required|in:' . implode(',', [Constant::STATUS_ACTIVE, Constant::STATUS_INACTIVE]),
		];
		$user_input = $request->only('name', 'description', 'status');

		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();
		
		if ($request->hasFile('icon'))
		{
			$filename = time() . '.' . $request->file('icon')->getClientOriginalExtension();
			$path = $request->file('icon')->storeAs('public/transaction', $filename);
			if (empty($path))
			{
				return back()->withErrors(['icon' => 'Gagal mengupload banner'])
							->withInput();
			}
			$file_location = 'public/transaction/' . CommonUtil::getFileName($current_record->icon);
			Storage::delete($file_location);
			$user_input['icon'] = $filename;
		}
		
		TransactionType::where('id', $current_record->id)
				->update($user_input);
		return redirect()
					->route('transaction.type.index')
					->with(['success' => 'Berhasil mengupdate jenis transaksi']);
    }
}
