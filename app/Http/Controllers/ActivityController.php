<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityType;
use Illuminate\Support\Facades\Validator;

class ActivityController extends Controller
{
	public function getActivityType(Request $request)
	{
		$user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
		$data['activities_type'] = ActivityType::all();	
		return view('admin.activity.type.index', $data);
	}

	public function showCreateActivityTypeForm(Request $request)
	{
		$user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
		$data['item'] = NULL;
		return view('admin.activity.type.form', $data);	
	}

	public function createActivityType(Request $request)
	{
		$user_input_field_rules = [
			'name' => 'required',
			'description' => 'required'
		];
		$user_input = $request->only('name', 'description');

		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();
		
		if (!$request->hasFile('banner'))
			return back()->withErrors(['banner' => 'Banner wajib di isi'])
							->withInput();

		if (!$request->hasFile('icon'))
			return back()->withErrors(['icon' => 'Icon wajib di isi'])
							->withInput();
		
		$filename = time() . '.' . $request->file('banner')->getClientOriginalExtension();
		$path = $request->file('banner')->storeAs('public/activity', $filename);
		if (empty($path))
		{
			return back()->withErrors(['banner' => 'Gagal mengupload banner'])
						->withInput();
		}
		
		$user_input['banner'] = $filename;

		$filename = time() . '.' . $request->file('icon')->getClientOriginalExtension();
		$path = $request->file('icon')->storeAs('public/activity', $filename);
		if (empty($path))
		{
			return back()->withErrors(['icon' => 'Gagal mengupload icon'])
						->withInput();
		}
		$user_input['icon'] = $filename;
		ActivityType::create($user_input);
		return redirect()
					->route('activity.type.index')
					->with(['success' => 'Berhasil menambahkan jenis kegiatan baru']);
	} 

	public function updateActivityType(Request $request)
	{
	}
}
