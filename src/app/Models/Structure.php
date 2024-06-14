<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Util\Common as CommonUtil;
use App\Constant\Constant;

class Structure extends Model
{
    use HasFactory;
    protected $table = 'structure';
    protected $fillable = [
        'id',
        'name',
        'title',
        'avatar',
        'id_parent'];
    
}
