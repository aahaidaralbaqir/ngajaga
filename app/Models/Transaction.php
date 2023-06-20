<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $table = 'transaction';
    protected $fillable = [
        'id_transaction_type',
        'order_id',
        'paid_amount',
        'va_number',
        'transaction_status',
        'redirect_payment',
        'user_id'
    ];

    public function customer()
    {
        return $this->hasOne(Customer::class, 'transaction_id', 'id');
    }
}
