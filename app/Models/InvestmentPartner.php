<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvestmentPartner extends Model
{
    use HasFactory;

    protected $fillable = [
        'label',
        'category',
        'partner',
        'url',
        'is_active',
        'clicks',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'clicks' => 'integer',
        'sort_order' => 'integer',
    ];

    public static function getActiveForWebsite(): array
    {
        return static::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'label' => $item->label,
                    'url' => $item->url,
                ];
            })
            ->toArray();
    }
}