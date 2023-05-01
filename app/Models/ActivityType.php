<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Util\Common as CommonUtil;
use App\Constant\Constant;

class ActivityType extends Model
{
    use HasFactory;

	protected $table = 'activity';
	protected $fillable = [
		'name',
		'icon',
		'description',
		'banner'
	];

	public function getIconAttribute($value)
	{
		return CommonUtil::getStorage(Constant::STORAGE_ACTIVITY, $value);
	}

	public function getBannerAttribute($value)
	{
		return CommonUtil::getStorage(Constant::STORAGE_ACTIVITY, $value);
	}
}
