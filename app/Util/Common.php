<?php 

namespace App\Util;
use App\Constant\Constant;

class Common {
	
	public static function getRole()
	{
		return [Constant::ROLE_HOKAGE => 'hokage',
				Constant::ROLE_RAIKAGE => 'raikage'];
	}

	public static function getRoleNameById(int $id)
	{
		$available_role = self::getRole();
		if (!array_key_exists($id, $available_role))
			return 'Unknow role';
		return $available_role[$id];
	}

	public static function getDefaultAvatar() 
	{
		return '/img/user/user-01.png';
	}

	public static function getAvatar($filename) 
	{
		return '/storage/avatars/' . $filename;
	}
}