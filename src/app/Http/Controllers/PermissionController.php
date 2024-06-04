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
		$data['permissions'] = Permission::where('id_parent', 0)->get();
		$data['methods'] = CommonUtil::getHttpVerbOptions();
		return view('admin.permission.form', $data); 
    }

    public function createPermission(Request $request)
    {
        $user_input_field_rules = [
			'name' => 'required',
			'method' => 'required|in:' . implode(',', CommonUtil::getHttpVerbOptions()),
		];
		$user_input = $request->only('name', 'method', 'id_parent');
		if ($request->has('id_parent') && empty($request->input('id_parent')))
			$user_input['id_parent'] = 0;
		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();

		Permission::create($user_input);
		return redirect()
					->route('permission.index')
					->with(['success' => 'Berhasil menambahkan hak akses baru']);
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
		$data['methods'] = CommonUtil::getHttpVerbOptions();
		$data['permissions'] = Permission::where('id_parent', 0)->where('id', '!=', $permissionId)->get();
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
			'method' => 'required|in:' . implode(',', CommonUtil::getHttpVerbOptions()),
		];
		$user_input = $request->only('name', 'method', 'id_parent');

		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();
		
		
		Permission::where('id', $current_record->id)
				->update($user_input);
		return redirect()
					->route('permission.index')
					->with(['success' => 'Berhasil mengubah hak akses']);
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
					->with(['success' => 'Berhasil menghapus hak akses']);	
	}
}
