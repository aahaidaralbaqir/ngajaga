<?php

namespace App\Http\Controllers;

use App\Repositories\AccountRepository;
use App\Util\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    const ACCOUNT_CREATE_ROUTE = 'account.create';
    const ACCOUNT_UPDATE_ROUTE = 'account.edit';

    public function index()
    {
        $user = parent::getUser();
        $account_records = AccountRepository::getAccountsWithBalance(); 

		return view('admin.account.index')
            ->with('user', $user)
            ->with('accounts', $account_records);
    }

    public function createForm() 
    {
        return view('admin.account.form')
            ->with('target_route', self::ACCOUNT_CREATE_ROUTE)
            ->with('user', parent::getUser());
    }

    public function editForm(Request $request, $accountId) 
    {
        $user_profile = parent::getUser();
        $account_record = AccountRepository::getAccountById($accountId); 
        if (!$account_record)
            return Response::backWithError('Akun tidak ditemukan');

        return view('admin.account.form')
            ->with('user', $user_profile)
            ->with('item', $account_record)
            ->with('target_route', self::ACCOUNT_UPDATE_ROUTE);
    }

    public function create(Request $request)
    {
        $user_input_field_rules = [
			'name' => 'required'
        ];
		$user_input = $request->only('name');
		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
            return Response::backWithErrors($validator);

		AccountRepository::createAccount($user_input);
        return Response::redirectWithSuccess(
            'account.index', 
            'Akun baru berhasil dibuat');
    }

    public function edit(Request $request)
    {
        $account_id = $request->input('id');
        $account_record = AccountRepository::getAccountById($account_id); 
        if (!$account_record)
            return Response::backWithError('Akun tidak ditemukan');
        $user_input_field_rules = [
			'name' => 'required',
        ];
		$user_input = $request->only('name');
		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
            return Response::backWithErrors($validator);

		AccountRepository::updateAccount($account_id, $user_input);
        return Response::redirectWithSuccess(
            'account.index', 
            'Akun berhasil dirubah');   
    }
}
