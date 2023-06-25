<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;
use App\Models\Permission;
use Illuminate\Support\Facades\Validator;
use App\Util\Common as CommonUtil;
use Illuminate\Support\Facades\Storage;

class RolesController extends Controller
{
    public function index()
    {
        $user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
        $roles = Roles::all()->toArray();
        foreach($roles as $index => $role)
        {
            $permissions_ids = explode(',', $role['permission']);
            $roles[$index]['permissions'] = Permission::select('*')->whereIn('id', $permissions_ids)->get();
        }
		$data['roles'] = $roles;
		return view('admin.roles.index', $data);
    }

    public function createForm(Request $request)
    {
        $user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
        $data['list_permission'] = Permission::all();
		$data['item'] = NULL; 
		return view('admin.roles.form', $data);  
    }

    public function createRole(Request $request)
    {
        $user_input_field_rules = [
			'name' => 'required',
			'permission' => 'required'
		];
		$user_input = $request->only('name', 'permission');

		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();
        $user_input['permission'] = implode(',', $request->input('permission'));

        $user_input['status'] = FALSE;
        if ($request->has('status')) $user_input['status'] = TRUE;
		Roles::create($user_input);
		return redirect()
					->route('roles.index')
					->with(['success' => 'Berhasil menambahkan role baru']);
    }

    public function updateForm(Request $request, $roleId)
    {
        $user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
		$data['item'] = Roles::find($roleId);
		$data['list_permission'] = Permission::all();
		return view('admin.roles.form', $data);  
    }

    public function updateRole(Request $request)
    {
        $current_record = Roles::find($request->id);
		if (empty($current_record))
			return back()
					->with(['error' => 'Gagal mengupdate roles, entitas tidak ditemukan']);
		
		$user_input_field_rules = [
			'name' => 'required',
			'permission' => 'required',
		];
		$user_input = $request->only('name', 'permission');

		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();

		$user_input['status'] = FALSE;
		if ($request->has('status'))
			$user_input['status'] = TRUE;
		
		if ($request->has('permission'))
			$user_input['permission'] = implode(',', $request->input('permission')); 

		Roles::where('id', $current_record->id)
				->update($user_input);
		return redirect()
					->route('roles.index')
					->with(['success' => 'Berhasil mengupdate roles']);
    }
}
