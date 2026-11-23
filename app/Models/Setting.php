<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $primaryKey = 'key';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['key', 'value'];

    protected static function booted(): void
    {
        // App\Support\Settings caches every row; writes through this model must clear it too
        $clear = fn () => \Illuminate\Support\Facades\Cache::forget('rpk_settings_cache');
        static::saved($clear);
        static::deleted($clear);
    }
}
