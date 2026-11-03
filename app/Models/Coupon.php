<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'type', 'value', 'max_uses', 'used_count', 'active', 'expires_at'];

    protected $casts = [
        'active' => 'boolean',
        'expires_at' => 'datetime',
        'value' => 'decimal:2',
    ];
}
