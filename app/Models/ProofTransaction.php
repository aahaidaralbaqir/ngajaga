<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Util\Common as CommonUtil;
use App\Constant\Constant;

class ProofTransaction extends Model
{
    use HasFactory;

	protected $table = 'proof_transaction';
	protected $fillable = [
		'transaction_id',
		'uploaded_by',
		'image'
	];

	public function getImageAttribute($value)
	{
		return CommonUtil::getStorage(Constant::STORAGE_TRANSACTION, $value);
	}

}
