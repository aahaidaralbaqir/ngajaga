<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function index()
    {
        $account_records = DB::table('accounts')
                                ->select(['accounts.id', 'accounts.name', DB::raw('SUM(cashflows.amount) AS current_balance')])
                                ->leftJoin('cashflows', function ($join) {
                                    $join->on('cashflows.account_id', '=', 'accounts.id');
                                })
                                ->groupBy('accounts.id', 'accounts.name')
                                ->get();
        $data['accounts'] = $account_records;
		$data['total_row'] = count($account_records);
		return view('admin.account.index', $data);
    }

    public function createForm(Request $request) 
    {
        $data['target_route'] = 'account.create';
        return view('admin.account.form', $data);
    }

    public function editForm(Request $request, $accountId) 
    {
        $account_record = DB::table('accounts')->where('id', $accountId)->first();
        if (!$account_record)
        {
            return back()>with(['error' => 'Akun tidak ditemukan']);
        }
        $data['target_route'] = 'account.edit';
        $data['item'] = $account_record;
        return view('admin.account.form', $data);
    }

    public function create(Request $request)
    {
        $user_input_field_rules = [
			'name' => 'required'
		];
		$user_input = $request->only('name');
		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();

		DB::table('accounts')
            ->insert($user_input);
		return redirect()
					->route('account.index')
					->with(['success' => 'Akun berhasil ditambahkan']);
    }

    public function edit(Request $request)
    {
        $user_input_field_rules = [
			'name' => 'required',
            'id' => 'required'
		];
		$user_input = $request->only('name', 'id');
		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();

		DB::table('accounts')
            ->where('id', $user_input['id'])
            ->update(array (
                'name' => $user_input['name']
            ));
		return redirect()
					->route('account.index')
					->with(['success' => 'Akun berhasil dirubah']);   
    }
}
