<?php

namespace App\Http\Controllers;

use App\Constant\Constant;
use Illuminate\Http\Request;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use App\Util\Common as CommonUtil;
use Illuminate\Support\Facades\Storage;

class PermissionController extends Controller
{
    public function index(Request $request) 
    {
        $user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
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
		$data['permissions'] = $parent_permissions;
		$data['total_row'] = count($permissions);
		return view('admin.permission.index', $data);
    }

    public function createForm(Request $request)
    {
        $user_profile = $this->initProfile();
		$data = array_merge(array(), $user_profile);
		$data['item'] = NULL;
		$data['page_title'] = 'Menambahkan hak akses baru';
		$data['target_route'] = 'permission.create';
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
		$data['page_title'] = 'Mengubah hak akses';
		$data['target_route'] = 'permission.update';
        $data['item'] = $current_record;

		$child_permission = DB::table('permission')
							 ->where('id_parent', $current_record->id)
							 ->get();
		
		$data['show_parent_dropdown'] = count($child_permission) <= 0;
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
		
		$child_permission = DB::table('permission')
							 ->where('id_parent', $current_record->id)
							 ->get();
		
		$data['show_parent_dropdown'] = count($child_permission) <= 0;
		if ($request->has('id_parent') && $user_input['id_parent'] != $current_record->id_parent && count($child_permission) > 0)
		{
			return back()
                    ->with(['error' => 'Hak akses yang berjenis parent tidak pusa di rubah']);
		}
		
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
		
		$child_permission = DB::table('permission')
								->where('id_parent', $permissionId)
								->get();
		if (count($child_permission) > 0) {
			return back()
					->with(['error' => 'Gagal mengahapus hak akases dikarenakan hak akses mempunyai anakan']);
		}
		Permission::where('id', $permissionId)->delete();
		return redirect()
					->route('permission.index')
					->with(['success' => 'Berhasil menghapus hak akses']);	
	}
}
