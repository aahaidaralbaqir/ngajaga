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
use stdClass;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	protected function getUser()
	{
		$current_user = Auth::user();

		$user = User::where('id', $current_user->id)->with('roles')->first();
		$data = ['name' => $user->name, 
				'email' => $user->email,
				'role_name' => $user->roles->name,
				'permission' => $user->roles->permission,
				'avatar' => CommonUtil::getStorage(Constant::STORAGE_AVATAR, $user->avatar),
				'id' => $user->id
			];
			
		return $data;
	}

	protected function getUserId() {
		return Auth::user()->id;
	}
}
