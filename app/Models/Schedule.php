<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Util\Common as CommonUtil;
use App\Constant\Constant;


class Schedule extends Model
{
    use HasFactory;

	protected $table = 'schedules';
	protected $fillable = [
		'activity_id',
		'scheduled_date',
		'scheduled_start_time',
		'scheduled_end_time',
		'leader'
	];

    public function activity()
    {
        return $this->belongsTo(Activity::class);
    }
}
