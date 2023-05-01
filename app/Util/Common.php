<?php 

namespace App\Util;
use App\Constant\Constant;

class Common {
	
	public static function getRole()
	{
		return [Constant::ROLE_HOKAGE => 'hokage',
				Constant::ROLE_RAIKAGE => 'raikage'];
	}

	public static function getCategories()
	{
		return [Constant::CATEGORY_KAJIAN => Constant::CATEGORY_KAJIAN_NAME,
				Constant::CATEGORY_KHUTBAH => Constant::CATEGORY_KHUTBAH_NAME,
				Constant::CATEGORY_BULETIN => Constant::CATEGORY_BULETIN_NAME];
	}

	public static function getCategoriesById(int $id)
	{
		$available_categories = self::getCategories();
		if (!array_key_exists($id, $available_categories))
			return 'Unknow categories';
		return $available_categories[$id];	
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

	public static function getStorage($storage_name, $filename) 
	{
		return '/storage/' .$storage_name. '/' . $filename;
	}

	public static function getFileName($fullpath) 
	{
		$path = explode('/', $fullpath);
		if (empty($path))
			return $fullpath;
		return $path[count($path) - 1];
	}
}