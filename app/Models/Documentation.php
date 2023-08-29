<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Util\Common as CommonUtil;
use App\Constant\Constant;

class Documentation extends Model
{
    use HasFactory;
	protected $table = 'documentation';
	protected $fillable = [
		'activity_id',
		'image'
	];

	public function getImageAttribute($value)
	{
		return CommonUtil::getStorage(Constant::STORAGE_DOCUMENTATION, $value);
	}
}
