<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VersionSnapshot extends Model
{
    use HasFactory;

    protected $table = 'version_snapshots';

    protected $fillable = [
        'version',
        'area',
        'description',
        'data',
    ];

    protected $casts = [
        'version' => 'integer',
        'data' => 'array',
    ];

    public static function getAreas(): array
    {
        return [
            'Pricing' => ['pricing'],
            'Points' => ['points'],
            'Discount Codes' => ['coupons'],
            'Referral' => ['referral'],
            'Session Availability' => ['session_availability'],
            'Investment Partners' => ['investment_partners'],
            'Testimonials' => ['testimonials_section'],
        ];
    }

    public static function getCurrentData(string $area): ?array
    {
        return static::where('area', $area)
            ->latest('version')
            ->first()?->data;
    }

    public static function createSnapshot(string $area, array $data, string $description): self
    {
        $maxVersion = static::max('version') ?? 0;
        
        return static::create([
            'version' => $maxVersion + 1,
            'area' => $area,
            'description' => $description,
            'data' => $data,
        ]);
    }
}