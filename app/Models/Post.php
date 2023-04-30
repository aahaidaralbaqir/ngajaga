<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Util\Common as CommonUtil;
use App\Constant\Constant;

class Post extends Model
{
    use HasFactory;

    protected $table = 'post';
    protected $fillable = [
        'title',
        'category',
        'content',
        'banner',
        'user_id'
    ];

    public function getBannerAttribute($value) 
    {
        return CommonUtil::getStorage(Constant::STORAGE_POST, $value);
    }

    public function getCategoryAttribute($value)
    {
        return CommonUtil::getCategoriesById($value);
    }
}
