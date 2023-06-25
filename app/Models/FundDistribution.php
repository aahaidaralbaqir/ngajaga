<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FundDistribution extends Model
{
    use HasFactory;
	protected $table = 'fund_distribution';
	protected $fillable = [
		'beneficiary_id',
		'transaction_id',
		'description'
	];
}
