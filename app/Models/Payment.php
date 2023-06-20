<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Util\Common as CommonUtil;
use App\Constant\Constant;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payment_type';
    protected $fillable = [
        'name',
        'status',
        'id_parent',
        'payment_logo',
        'value',
        'expired_time'
    ];

    public function getStatusAttribute($value)
    {
        return $value == 1 ? 'Active' : 'Inactive';
    }

    public function getPaymentLogoAttribute($value)
    {
        return CommonUtil::getStorage(Constant::STORAGE_PAYMENT, $value);;
    }
}
