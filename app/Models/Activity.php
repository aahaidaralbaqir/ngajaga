<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Util\Common as CommonUtil;
use App\Constant\Constant;

class Activity extends Model
{
    use HasFactory;

	protected $table = 'activity';
	protected $fillable = [
		'name',
		'icon',
		'description',
		'banner',
		'start_time',
		'end_time',
		'recurring',
		'recurring_days',
		'leader',
		'show_landing_page'
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
