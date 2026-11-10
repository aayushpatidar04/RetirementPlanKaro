<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageTemplate extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'channel',
        'subject',
        'body',
        'is_default',
        'stage_mapping',
    ];

    protected $casts = [
        'is_default' => 'boolean',
        'stage_mapping' => 'array',
    ];

    public const CHANNEL_WHATSAPP = 'wa';
    public const CHANNEL_EMAIL = 'em';

    public function scopeWhatsApp($query)
    {
        return $query->where('channel', self::CHANNEL_WHATSAPP);
    }

    public function scopeEmail($query)
    {
        return $query->where('channel', self::CHANNEL_EMAIL);
    }

    public function scopeDefault($query)
    {
        return $query->where('is_default', true);
    }

    public function getVariables(): array
    {
        return ['name', 'link', 'amount', 'purpose', 'date', 'n', 'names', 'pts', 'coupon', 'type', 'quote'];
    }
}