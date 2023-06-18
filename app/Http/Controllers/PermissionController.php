<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use Illuminate\Support\Facades\Validator;
use App\Util\Common as CommonUtil;
use Illuminate\Support\Facades\Storage;

class PermissionController extends Controller
{
    public function index(Request $request) 
    {
        $user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
		$data['permission'] = Permission::all()->toArray();
		return view('admin.permission.index', $data);
    }

    public function createForm(Request $request)
    {
        $user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
		$data['item'] = NULL; 
		return view('admin.permission.form', $data); 
    }

    public function createPermission(Request $request)
    {
        $user_input_field_rules = [
			'name' => 'required',
			'alias' => 'required',
			'url' => 'required',
		];
		$user_input = $request->only('name', 'alias', 'url', 'icon');

		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();

		Permission::create($user_input);
		return redirect()
					->route('permission.index')
					->with(['success' => 'Berhasil menambahkan permission baru']);
    }

    public function updateForm(Request $request, $permissionId)
    {
        $current_record = Permission::find($permissionId);
        if (empty($current_record))
        {
           return back()
                    ->with(['error' => 'Entitas tidak ditemukan']);
        }
        $user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
        $data['item'] = $current_record;
		
		return view('admin.permission.form', $data); 
    }

    public function updatePermission(Request $request)
    {
        $current_record = Permission::find($request->id);
		if (empty($current_record))
			return back()
					->with(['error' => 'Gagal mengupdate permission, entitas tidak ditemukan']);
		
		$user_input_field_rules = [
			'name' => 'required',
			'alias' => 'required',
			'url' => 'required'
		];
		$user_input = $request->only('name', 'alias', 'url', 'icon');

		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();
		
		
		Permission::where('id', $current_record->id)
				->update($user_input);
		return redirect()
					->route('permission.index')
					->with(['success' => 'Berhasil mengupdate permission']);
    }

    public function deletePermission(Request $request, $permissionId)
	{
		$current_record = Permission::find($permissionId);
        if (empty($current_record))
        {
           return back()
                    ->with(['error' => 'Entitas tidak ditemukan']);
        }
		
		Permission::where('id', $permissionId)->delete();
		return redirect()
					->route('permission.index')
					->with(['success' => 'Berhasil menghapus permission']);	
	}
}
