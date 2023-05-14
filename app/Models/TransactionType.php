<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Util\Common as CommonUtil;
use App\Constant\Constant;

class TransactionType extends Model
{
    use HasFactory;

    protected $table = 'transaction_type';
    protected $fillable = [
        'name',
        'description',
        'banner'
    ];

    public function getBannerAttribute($value)
	{
		return CommonUtil::getStorage(Constant::STORAGE_TRANSACTION, $value);
	}

}
