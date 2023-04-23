<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Util\Common as CommonUtil;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index(Request $request)
	{
		$user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
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
			return redirect()->route('setting.index')
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
					->route('setting.index')
					->with(['success' => 'Berhasil mengupdate profile kamu']);
	}

	public function removeAvatar(Request $request) 
	{
		$current_user = Auth::user();
		if (empty($current_user->avatar))
			return back()->with(['error' => 'Tidak bisa menghapus, karena avatar mu kosong.']);

		$file_location = 'public/avatars/' . $current_user->avatar;
		Storage::delete($file_location);

		$updated_data = [
			'avatar' => NULL
		];
		User::where('id', $current_user->id)
			->update($updated_data);
		
		return redirect()
			->route('setting.index')
			->with(['success' => 'Berhasil menghapus avatar kamu']);
	}

	public function updateAvatar(Request $request)
	{
		$current_user = Auth::user();
		if (!$request->hasFile('image'))
			return back()->withErrors(['avatar' => 'Gagal mengubah avatar kamu'])
					->withInput();
		
		$filename = time() . '.' . $request->file('image')->getClientOriginalExtension();
		$path = $request->file('image')->storeAs('public/avatars', $filename);
		if (empty($path))
			return back()->withErrors(['avatar' => 'Gagal mengubah avatar kamu'])
						->withInput();

		$updated_data = [
			'avatar' => $filename
		];
		User::where('id', $current_user->id)
					->update($updated_data);
		return redirect()
					->route('setting.index')
					->with(['success' => 'Berhasil mengupdate avatar kamu']);	
	}
}
