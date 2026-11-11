<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    use HasFactory;

    protected $table = 'activity_logs';

    protected $fillable = [
        'user_id',
        'actor_type',
        'actor_id',
        'actor_name',
        'event',
        'description',
        'subject_type',
        'subject_id',
        'properties',
        'ip',
    ];

    protected $casts = [
        'properties' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'subject_id', 'id');
    }

    public function getRouteKeyName(): string
    {
        return 'id';
    }
}