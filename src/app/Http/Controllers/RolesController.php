<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Roles;
use App\Models\Permission;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Constant\Constant;
use App\Repositories\PermissionRepository;
use App\Repositories\RoleRepository;
use App\Util\Common;
use App\Util\Response;

class RolesController extends Controller
{
    public function index()
    {
		$user_profile = parent::getUser();
		$data['user'] = $user_profile;
        $roles = RoleRepository::getRoles(); 
		$data['total_row'] = count($roles);
		return view('admin.roles.index')
			->with('user', parent::getUser())
			->with('roles', $roles)
			->with('total_row', count($roles));
    }

    public function createForm()
    {
		$permissions = PermissionRepository::getPermissions();
			
		return view('admin.roles.form')
			->with('user', parent::getUser())
			->with('target_route', 'roles.create')
			->with('page_title', 'Menambahkan peran baru')
			->with('permissions', PermissionRepository::getGroupedPermissions($permissions))
			->with('item', NULL)
			->with('status', Common::getStatus());  
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
		{
			return Response::backWithErrors($validator);
		}

        $user_input['permission'] = implode(',', $request->input('permission'));
		RoleRepository::createRole($user_input);	
		return Response::redirectWithSuccess(
			'roles.index',
			'Berhasil menambahkan peran baru');
    }

    public function updateForm(Request $request, $roleId)
    {
		$current_record = RoleRepository::getById($roleId);
		if (!$current_record)
			return Response::backWithError('Peran tidak ditemukan');
		$permissions = PermissionRepository::getPermissions();
		$current_record->permission = explode(',', $current_record->permission);
		return view('admin.roles.form')
			->with('user', parent::getUser())
			->with('page_title', 'Mengubah peran')
			->with('target_route', 'roles.update')
			->with('item', $current_record)
			->with('status', Common::getStatus())
			->with('permissions', PermissionRepository::getGroupedPermissions($permissions));  
    }

    public function updateRole(Request $request)
    {
        $current_record = RoleRepository::getById($request->input('id'));
		if (!$current_record)
			return Response::backWithError('Peran tidak ditemukan');

		$user_input_field_rules = [
			'name' => 'required',
			'permission' => 'required',
			'status' => 'required'
		];
		$user_input = $request->only('name', 'permission', 'status');
		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return Response::backWithErrors($validator);
		
		if ($request->has('permission'))
			$user_input['permission'] = implode(',', $request->input('permission')); 

		RoleRepository::updateRole($current_record->id, $user_input);
		return Response::redirectWithSuccess(
			'roles.index', 
			'Berhasil mengubah peran');
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
