<?php 
use App\Constant\Constant;
use Illuminate\Support\Facades\Route;
use App\Util\Common as CommonUtil;

if (!function_exists('is_hokage'))
{
	function is_hokage($role_id) 
	{
		return $role == Constant::ROLE_HOKAGE;  
	}
}

if (!function_exists('route_is'))
{
	function route_is($route_name)
	{
		return Route::currentRouteName() == $route_name;
	}
}

if (!function_exists('route_name'))
{
	function route_name()
	{
		return Route::currentRouteName();
	}
}

if (!function_exists('get_banner'))
{
	function get_banner($filename)
	{
		return CommonUtil::getStorage(Constant::STORAGE_BANNER, $filename);	
	}
}