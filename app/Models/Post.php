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

    public static function serializeResponse($item)
    {
        foreach ($item as $index => $each_item)
        {
            $item[$index]['banner'] = CommonUtil::getStorage(Constant::STORAGE_POST, $each_item['banner']);
            $item[$index]['category_name'] = CommonUtil::getCategoriesById($each_item['category']);
        }
        return $item;
    }
}
