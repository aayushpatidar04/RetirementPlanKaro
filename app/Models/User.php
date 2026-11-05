<?php

namespace App\Models;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Contracts\Auth\MustVerifyEmail as MustVerifyEmailContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmailContract
{
    use HasFactory, Notifiable, MustVerifyEmail;

    protected $fillable = [
        'name',
        'surname',
        'mobile',
        'email',
        'city',
        'pan',
        'referral_code',
        'referred_by_code',
        'share_consent',
        'consented_at',
        'password',
        'status',
        'suspended_at',
        'tags',
        'stage',
        'assigned_to',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'consented_at' => 'datetime',
            'suspended_at' => 'datetime',
            'share_consent' => 'boolean',
            'password' => 'hashed',
        ];
    }
}