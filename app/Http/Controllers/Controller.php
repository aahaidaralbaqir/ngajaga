<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Util\Common as CommonUtil;
use App\Constant\Constant;
use App\Models\User;
use App\Models\Permission;
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	protected function initProfile()
	{
		$current_user = Auth::user();

		$user = User::where('id', $current_user->id)->with('roles')->first();
		$current_permission = Permission::whereIn('id', explode(',', $current_user->roles->permission))
									->get();
		$permission = [];
		foreach ($current_permission as $permssion)
		{
			$permission[] = $permssion->alias;
		}
		$data = ['name' => $user->name, 
				'email' => $user->email,
				'role_name' => $user->roles->name,
				'permissions' => $permission, 
				'avatar' => $user->avatar];
		
		return $data;
	}
}
