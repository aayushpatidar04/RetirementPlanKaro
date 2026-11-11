<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'text',
        'permission_taken',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'permission_taken' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public static function getActiveForWebsite(): array
    {
        return static::where('is_active', true)
            ->where('permission_taken', true)
            ->orderBy('sort_order')
            ->get()
            ->map(function ($item) {
                return [
                    'id' => $item->id,
                    'name' => $item->name,
                    'text' => $item->text,
                ];
            })
            ->toArray();
    }
}