<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'channel',
        'recipient',
        'subject',
        'body',
        'template_id',
        'scheduled_at',
        'done',
        'sent_at',
        'status',
    ];

    protected $casts = [
        'recipient' => 'array',
        'scheduled_at' => 'datetime',
        'sent_at' => 'datetime',
        'done' => 'boolean',
    ];
}