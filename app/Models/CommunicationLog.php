<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunicationLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'channel',
        'recipient',
        'subject',
        'body',
        'status',
        'template_id',
        'sent_at',
    ];

    protected $casts = [
        'recipient' => 'array',
        'sent_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}