<?php 
use App\Constant\constant;
if (!function_exists('is_hokage'))
{
	function is_hokage($role_id) 
	{
		return $role == Constant::ROLE_HOKAGE;  
	}
}