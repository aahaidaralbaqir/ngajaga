<?php

namespace App\Http\Controllers;

use App\Constant\Constant;
use Illuminate\Http\Request;
use App\Models\Permission;
use App\Repositories\PermissionRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Util\Common as CommonUtil;
use App\Util\Response;
use Illuminate\Support\Facades\Storage;

class PermissionController extends Controller
{
    public function index(Request $request) 
    {
		$user_profile = parent::getUser();
		$permission_records = PermissionRepository::getPermissions();
		return view('admin.permission.index')
			->with('user', $user_profile)
			->with('permissions', PermissionRepository::getGroupedPermissions($permission_records))
			->with('total_row', PermissionRepository::getTotalPermission($permission_records));
    }

    public function createForm(Request $request)
    {
		return view('admin.permission.form')
			->with('item', NULL)
			->with('page_title', 'Menambahkan hak akses baru')
			->with('target_route', 'permission.create')
			->with('show_parent_dropdown', true)
			->with('user', parent::getUser())
			->with('permissions', PermissionRepository::getParentPermissions()); 
    }

    public function createPermission(Request $request)
    {
        $user_input_field_rules = [
			'name' => 'required',
		];
		$user_input = $request->only('name', 'id_parent');
		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails()) 
		{
			return Response::backWithErrors($validator);
		}
		$user_input['is_default'] = Constant::OPTION_FALSE;
		PermissionRepository::createPermission($user_input);
		return Response::redirectWithSuccess(
			'permission.index', 
			'Berhasil menambahkan hak akses baru');
    }

    public function updateForm(Request $request, $permissionId)
    {
        $current_record = PermissionRepository::getById($permissionId);
        if (empty($current_record))
			Response::backWithError('Hak akses tidak ditemukan');

		$data['page_title'] = 'Mengubah hak akses';
		$data['target_route'] = 'permission.update';
		$user_profile = parent::getUser();
		$data['user'] = $user_profile;
        $data['item'] = $current_record;

		$child_permission = PermissionRepository::getChildPermissions($permissionId);		
		$permission_records = PermissionRepository::getPermissionExcept($permissionId);
		return view('admin.permission.form')
			->with('page_title', 'Mengubak hak akses')
			->with('target_route', 'permission.update')
			->with('user', parent::getUser())
			->with('item', $current_record)
			->with('permissions', $permission_records)
			->with('show_parent_dropdown', count($child_permission) <= 0); 

    }

    public function updatePermission(Request $request)
    {
        $current_record = PermissionRepository::getById($request->id);
		if (empty($current_record))
			return Response::backWithError('Hak akses tidak ditemukan');	
		$user_input_field_rules = [
			'name' => 'required',
		];
		$user_input = $request->only('name', 'id_parent');

		$validator = Validator::make($user_input, $user_input_field_rules);
		if ($validator->fails())
			return Response::backWithErrors($validator);
		
		$child_permission = PermissionRepository::getChildPermissions($request->id);
		if ($request->has('id_parent') && $user_input['id_parent'] != $current_record->id_parent && count($child_permission) > 0)
			return Response::backWithError('Pusat hak akses hanya bisa dirubah untuk anakan');
		
		PermissionRepository::updatePermission($current_record->id, $user_input);
		return Response::redirectWithSuccess(
			'permission.index',
			'Hak akses berhasil dirubah'
		);
    }
}
