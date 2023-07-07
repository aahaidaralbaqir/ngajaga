<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Util\Common as CommonUtil;
use App\Constant\Constant;

class Heroes extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'order',
        'title',
        'subtitle',
        'description',
        'link'
    ];

    protected $table = 'heroes';

	public function getImageAttribute($value)
	{
		return CommonUtil::getStorage(Constant::STORAGE_BANNER, $value);
	}
}
