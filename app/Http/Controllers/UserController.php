<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
	use AuthorizesRequests, ValidatesRequests;

	public function index(Request $request)
	{
		$user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
		$data['users'] = User::with('roles')->get();
		return view('admin.user.index', $data);
	}

	public function createForm(Request $request)
	{
		$user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
		$data['item'] = NULL;
		$data['roles'] = Roles::where('status', true)->get();	
		return view('admin.user.form', $data);
	}

	public function updateUser(Request $request)
	{
		$user_input_field_rules = [
			'name' => 'required',
			'email' => 'required',
			'role_id' => 'required',
		];
		$user_input = $request->only('name', 'email', 'role_id');
		$current_user = User::find($request->id);
		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();
		
		User::where('id', $current_user->id)->update($user_input);
		return redirect()
					->route('user.index')
					->with(['success' => 'Berhasil mengupdate pengguna']);	
	}

	public function updateForm(Request $request, $userId)
	{
		$user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
		$data['item'] = User::find($userId);
		$data['roles'] = Roles::where('status', true)->get();	
		return view('admin.user.form', $data);
	}

	public function createUser(Request $request)
	{
		$user_input_field_rules = [
			'name' => 'required',
			'email' => 'required',
			'role_id' => 'required',
		];
		$user_input = $request->only('name', 'email', 'role_id');

		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();
		
		
		$default_password = Hash::make('password123');
		$user_input['password'] = $default_password;
	
		User::create($user_input);
		return redirect()
					->route('user.index')
					->with(['success' => 'Berhasil menambahkan user baru']);
	}

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

	public function logout(Request $request)
	{
		Auth::logout();
		
		$request->session()->invalidate();
		$request->session()->regenerateToken();
		
		return redirect('/login');
	}
}
