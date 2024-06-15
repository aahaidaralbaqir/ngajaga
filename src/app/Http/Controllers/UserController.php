<?php

namespace App\Http\Controllers;

use App\Constant\Constant;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Roles;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
	use AuthorizesRequests, ValidatesRequests;

	public function index(Request $request)
	{
		$user_profile = $this->getUser();
		$data['user'] = $user_profile;
		$user_record = User::with('roles')->where('status', Constant::STATUS_ACTIVE)->get();
		$data['users'] = $user_record;
		$data['total_row'] = count($user_record);
		return view('admin.user.index', $data);
	}

	public function createForm(Request $request)
	{
		$user_profile = $this->getUser();
		$data['user'] = $user_profile;
		$data['target_route'] = 'user.create';
		$data['page_title'] = 'Buat pengguna baru';
		$data['item'] = NULL;
		$data['roles'] = Roles::where('status', Constant::STATUS_ACTIVE)->get();	
		return view('admin.user.form', $data);
	}

	public function updateUser(Request $request)
	{
		$current_user = User::find($request->id);
		if (!$current_user) {
			return back()
				->with(array (
					'error' => 'User tidak ditemukan'
				));
		}
		$user_input_field_rules = [
			'name' => 'required',
			'email' => 'required',
			'role_id' => 'required',
		];


		$user_input = $request->only('name', 'email', 'role_id');
		if (!empty($request->input('password'))) {
			$user_input_field_rules['old_password'] = ['required', 
				function ($attribute, $value, $fail) use ($current_user) {
					if (!Hash::check($value, $current_user->password)) {
						return $fail(_('The current password is incorrect '));
					}
				}];
			$user_input['old_password'] = $request->input('old_password');
		}

		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();
	
		if ($request->input('password') != '') {
			unset($user_input['old_password']);
			$user_input['password'] = Hash::make($request->input('password'));
		}

		User::where('id', $current_user->id)->update($user_input);
		return redirect()
					->route('user.index')
					->with(['success' => 'Pengguna berhasil dirubah']);	
	}

	public function updateForm(Request $request, $userId)
	{
		$current_user = User::find($userId);
		if (!$current_user) {
			return redirect()
					->route('user.index')
					->with(['error' => 'Pengguna tidak ditemukan']);
		}
		$user_profile = $this->getUser();
		$data = array_merge(array(), $user_profile);
		$data['item'] = $current_user;
		$data['target_route'] = 'user.update';
		$data['page_title'] = 'Mengubah pengguna';
		$data['roles'] = Roles::where('status', Constant::STATUS_ACTIVE)->get();	
		return view('admin.user.form', $data);
	}

	public function createUser(Request $request)
	{
		$user_input_field_rules = [
			'name' => 'required',
			'email' => 'required',
			'password' => 'required',
			'role_id' => 'required',
		];
		$user_input = $request->only('name', 'email', 'role_id', 'password');

		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();
		
		
		$user_input['password'] = Hash::make($user_input['password']);
	
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

			return redirect()->route('dashboard');
		}

		return back()->withErrors(['password' => 'Invalid username or password'])
					->withInput();
	}

	public function logout(Request $request)
	{
		Auth::logout();
		
		$request->session()->invalidate();
		$request->session()->regenerateToken();
		
		return redirect('/login');
	}

	public function deleteUser(Request $request, $userId)
	{
		$current_user = User::find($userId);
		if (!$current_user) {
			return back()
				->with(array (
					'error' => 'User tidak ditemukan'
				));
		}

		DB::table('users')->where('id', $userId)
			->update(array('status' => Constant::STATUS_INACTIVE));
		return redirect()
					->route('user.index')
					->with(['success' => 'Pengguna berhasil dihapus']);	
	}
}
