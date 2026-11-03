<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'txnid', 'purpose', 'ref_id', 'pack', 'base_amount', 'coupon_code',
        'coupon_off', 'points_used', 'amount', 'status', 'payu_id', 'mode', 'paid_at'
    ];

    protected $casts = [
        'paid_at' => 'datetime',
        'base_amount' => 'decimal:2',
        'coupon_off' => 'decimal:2',
        'amount' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
