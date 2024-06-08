<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;
use App\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Constant\Constant;
use App\Util\Common;

class RolesController extends Controller
{
    public function index()
    {
        $user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
        $roles = DB::table('roles')->get();
        foreach($roles as $index => $role)
        {
            $permissions_ids = explode(',', $role->permission);
			$query = DB::table('permission');
			if ($role->id != env('ADMINISTRATOR_ROLE_ID')) {
				$query->whereIn('id', $permissions_ids);
			}
            $roles[$index]->permissions = $query->get();
        }
		$role_ids = array_map(function ($item) {
			return $item->id;
		}, $roles->toArray());
		$user_records = DB::table('users')
							->whereIn('users.role_id', $role_ids)
							->get();
		$grouped_users = [];
		foreach ($user_records as $user_record) {
			if (array_key_exists($user_record->id, $grouped_users)) {
				$grouped_users[$user_record->id][] = $user_record;
				continue;
			}
			$grouped_users[$user_record->id] = [$user_record];
		}
		$data['roles'] = array_map(function ($item) use($grouped_users) {
			$item->users = [];
			if (array_key_exists($item->id, $grouped_users)) {
				$item->users = $grouped_users[$item->id];
			}
			return $item;
		}, $roles->toArray());
		$data['total_row'] = count($roles);
		return view('admin.roles.index', $data);
    }

    public function createForm(Request $request)
    {
        $user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
		$data['target_route'] = 'roles.create';
		$data['page_title'] = 'Menambahkan peran baru';
		$permissions = DB::table('permission')->get()->toArray();
		$parent_permissions = array_filter($permissions, function($item) {
			return $item->id_parent == Constant::PARENT_ATTENDEE;
		});
		$grouped_permission = [];
		foreach ($permissions as $permission)
		{
			$parent_id = $permission->id_parent;
			if ($parent_id == Constant::PARENT_ATTENDEE) {
				continue;
			}
			if (array_key_exists($parent_id, $grouped_permission)) {
				$grouped_permission[$parent_id][] = $permission;
				continue;
			}
			$grouped_permission[$parent_id] = [$permission];
		}
		$parent_permissions = array_map(function ($item) use($grouped_permission) {
			$childs = [];
			if (array_key_exists($item->id, $grouped_permission)) {
				$childs = $grouped_permission[$item->id];
			}
			$item->childs = $childs;
			return $item;
		}, $parent_permissions);
		$data['status'] = Common::getStatus();
		$data['permissions'] = $parent_permissions;
		$data['item'] = NULL; 
		return view('admin.roles.form', $data);  
    }

    public function createRole(Request $request)
    {
        $user_input_field_rules = [
			'name' => 'required',
			'permission' => 'required',
			'status' => 'required|in:' . implode(',', array_keys(Common::getStatus()))
		];
		$user_input = $request->only('name', 'permission', 'status');

		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();
        $user_input['permission'] = implode(',', $request->input('permission'));
		Roles::create($user_input);
		return redirect()
					->route('roles.index')
					->with(['success' => 'Berhasil menambahkan role baru']);
    }

    public function updateForm(Request $request, $roleId)
    {
		$data['page_title'] = 'Mengubah peran';
		$data['target_route'] = 'roles.update';
		$data['item'] = Roles::find($roleId);
		$permissions = DB::table('permission')->get()->toArray();
		$parent_permissions = array_filter($permissions, function($item) {
			return $item->id_parent == Constant::PARENT_ATTENDEE;
		});
		$grouped_permission = [];
		foreach ($permissions as $permission)
		{
			$parent_id = $permission->id_parent;
			if ($parent_id == Constant::PARENT_ATTENDEE) {
				continue;
			}
			if (array_key_exists($parent_id, $grouped_permission)) {
				$grouped_permission[$parent_id][] = $permission;
				continue;
			}
			$grouped_permission[$parent_id] = [$permission];
		}
		$parent_permissions = array_map(function ($item) use($grouped_permission) {
			$childs = [];
			if (array_key_exists($item->id, $grouped_permission)) {
				$childs = $grouped_permission[$item->id];
			}
			$item->childs = $childs;
			return $item;
		}, $parent_permissions);
		$data['status'] = Common::getStatus();
		$data['permissions'] = $parent_permissions;
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
			'status' => 'required'
		];
		$user_input = $request->only('name', 'permission', 'status');

		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return back()
						->withErrors($validator)
						->withInput();
		
		if ($request->has('permission'))
			$user_input['permission'] = implode(',', $request->input('permission')); 

		Roles::where('id', $current_record->id)
				->update($user_input);
		return redirect()
					->route('roles.index')
					->with(['success' => 'Berhasil mengupdate roles']);
    }

	public function deleteRole(Request $request, $rolesId)
	{
		$current_record = DB::table('roles')
							->where('id', $rolesId);
		if (!$current_record) {
			return back()
					->with(['error' => 'Gagal mengupdate roles, entitas tidak ditemukan']);	
		}
		
		$user_roles = DB::table('users')
						->where('role_id', $rolesId)
						->get();
		if (count($user_roles) > 0) {
			return back()
					->with(['error' => 'Role tidak bisa dihapus dikarenakan role tersebut masih digunakan']);		
		}

		DB::table('roles')
			->where('id', $rolesId)
			->delete();
		return redirect()
				->route('roles.index')
				->with(['success' => 'Berhasil menghapus peran']);
}
}
