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
        'icon',
		'status'
    ];

    public function getIconAttribute($value)
	{
		return CommonUtil::getStorage(Constant::STORAGE_TRANSACTION, $value);
	}

	public function getStatusAttribute($value)
    {
        return CommonUtil::getStatusById($value);
    }
}
