<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Util\Common as CommonUtil;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    public function index(Request $request)
	{
		$user = Auth::user();
		$data = ['name' => $user->name, 
				'email' => $user->email, 
				'role_name' => ucfirst(CommonUtil::getRoleNameById($user->role))];
		return view('admin.setting', $data);
	}

	public function updateProfile(Request $request)
	{
		$current_user = Auth::user();
		$user_input_field_rule = [
			'email' => 'required|email|unique:users',
			'name'	=> 'required|max:50'
		];
		
		$user_input = [
			'name' => $request->name,
			'email'	=> $request->email
		];
		if ($current_user->email == $request->email)
			unset($user_input_field_rule['email']);
		$validator = Validator::make($user_input, $user_input_field_rule);
		if ($validator->fails())
			return redirect()->route('setting')
						->withErrors($validator)
						->withInput();

		$password_same = Hash::check($request->old_password, $current_user->password);
		$has_new_password = !empty($request->new_password);
		if ($has_new_password && !$password_same)
			return back()->withErrors(['old_password' => 'Password lama tidak valid. ' . $password_same])
						->withInput();

		
		$updated_data = [
			'name' => $request->name,
			'email' => $request->email];
		
		if (!empty($request->new_password))
		{
			$hashed_password = Hash::make($request->new_password);
			$updated_data['password'] = $hashed_password;
		}

		User::where('id', $current_user->id)
			->where('email', $current_user->email)
			->update($updated_data);
		
		return redirect()
					->route('setting')
					->with(['success' => 'Berhasil mengupdate profile kamu']);
	}
}
