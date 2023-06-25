<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Beneficiary;
use App\Models\TransactionType;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class BeneficiaryController extends Controller
{
	public function index(Request $request)
	{
		$user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
		$results = DB::table('beneficiary')
						->select(DB::raw('beneficiary.id, transaction_type.name as category, beneficiary.name'))
						->join('transaction_type', function ($join) {
							$join->on('beneficiary.id_transaction_type', '=', 'transaction_type.id');
						})->get();
		$data['beneficiaries'] = $results;
		return view('admin.beneficiary.index', $data);
	}

	public function createForm(Request $request)
	{
		$user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
		$data['item'] = NULL;
		$data['transaction_type'] = TransactionType::all();
		return view('admin.beneficiary.form', $data);
	}

	public function updateForm(Request $request, $beneficiaryId)
	{
		$user_profile = $this->initProfile();
		$current_record = Beneficiary::find($beneficiaryId);
		$data = array_merge(array(), $user_profile);
		$data['item'] = $current_record;
		$data['transaction_type'] = TransactionType::all();
		return view('admin.beneficiary.form', $data);	
	}

	public function updateBeneficiary(Request $request)
	{
		$current_record = Beneficiary::find($request->id);
		if (empty($current_record))
		{
			return back()->with(['error' => 'Gagal mengupdate penerima dana, entitas tidak ditemukan']);
		}
		$user_input_field_rules = [
			'name' => 'required',
			'id_transaction_type' => 'required'
		];
		$user_input = $request->only('name', 'id_transaction_type');

		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();

		Beneficiary::where('id', $current_record->id)->update($user_input);
		return redirect()
					->route('beneficiary.index')
					->with(['success' => 'Berhasil mengupdate penerima dana']);
	}

	public function createBeneficiary(Request $request)
	{
		$user_input_field_rules = [
			'name' => 'required',
			'id_transaction_type' => 'required'
		];
		$user_input = $request->only('name', 'id_transaction_type');

		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();

		Beneficiary::create($user_input);
		return redirect()
					->route('beneficiary.index')
					->with(['success' => 'Berhasil menambahkan penerima dana baru']);
	}

	public function deleteBeneficiary(Request $request, $beneficiaryId)
	{
		$current_record = Beneficiary::find($beneficiaryId);
		if (empty($current_record))
		{
			return back()->with(['error' => 'Gagal mengupdate penerima dana, entitas tidak ditemukan']);
		}
		Beneficiary::where('id', $current_record->id)->delete();	
		return redirect()
					->route('beneficiary.index')
					->with(['success' => 'Berhasil menghapus penerima dana']);
	}
}
