<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
	use AuthorizesRequests, ValidatesRequests;

	public function login(Request $request)
	{
		$user_input_field_rules = [
			'email'	=> 'required|max:100|email',
			'password' => 'required'
		];
		
		$user_input = $request->all();
		$validator = Validator::make($user_input, $user_input_field_rules);
		
		if ($validator->fails())
			return redirect()->route('login')
						->withErrors($validator)
						->withInput();
		
		if (Auth::attempt($request->only('email', 'password')))
		{
			$request->session()
					->regenerate();

			return redirect()->intended('admin');
		}

		return back()->withErrors($validator)
					->withInput();
	}
}
