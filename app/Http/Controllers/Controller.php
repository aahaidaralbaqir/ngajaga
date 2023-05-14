<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Auth;
use App\Util\Common as CommonUtil;
use App\Constant\Constant;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

	protected function initProfile()
	{
		$current_user = Auth::user();

		$user = Auth::user();
		$data = ['name' => $user->name, 
				'email' => $user->email, 
				'role'  => $user->role,
				'avatar' => CommonUtil::getDefaultAvatar(),
				'role_name' => ucfirst(CommonUtil::getRoleNameById($user->role))];
		if (!empty($user->avatar))
			$data['avatar'] = CommonUtil::getStorage(Constant::STORAGE_AVATAR, $user->avatar);
		return $data;
	}
}
