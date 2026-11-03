<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class Settings
{
    private const CACHE_KEY = 'rpk_settings_cache';

    public static function all(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return DB::table('settings')->pluck('value', 'key')->all();
        });
    }

    public static function get(string $key, $default = null)
    {
        $all = self::all();

        return array_key_exists($key, $all) ? $all[$key] : $default;
    }

    public static function set(string $key, $value): void
    {
        DB::table('settings')->updateOrInsert(
            ['key' => $key],
            ['value' => (string) $value, 'updated_at' => now(), 'created_at' => now()]
        );
        Cache::forget(self::CACHE_KEY);
    }

    public static function packs(): array
    {
        $raw = self::get('packs');
        if ($raw) {
            $d = json_decode($raw, true);
            if (is_array($d)) {
                return $d;
            }
        }

        return config('rpk.packs');
    }
}