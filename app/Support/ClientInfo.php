<?php

namespace App\Support;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/** Small facts about a visitor that the admin client profile shows (device, how they found us). */
class ClientInfo
{
    /** "Windows · Chrome", "Android · Chrome", "iPhone · Safari" */
    public static function device(?string $ua): ?string
    {
        $ua = (string) $ua;
        if ($ua === '') {
            return null;
        }
        $os = match (true) {
            (bool) preg_match('/iPhone/i', $ua) => 'iPhone',
            (bool) preg_match('/iPad/i', $ua) => 'iPad',
            (bool) preg_match('/Android/i', $ua) => 'Android',
            (bool) preg_match('/Windows/i', $ua) => 'Windows',
            (bool) preg_match('/Mac OS X|Macintosh/i', $ua) => 'Mac',
            (bool) preg_match('/Linux/i', $ua) => 'Linux',
            default => 'Other',
        };
        $br = match (true) {
            (bool) preg_match('/Edg\//i', $ua) => 'Edge',
            (bool) preg_match('/OPR\/|Opera/i', $ua) => 'Opera',
            (bool) preg_match('/SamsungBrowser/i', $ua) => 'Samsung Internet',
            (bool) preg_match('/Firefox|FxiOS/i', $ua) => 'Firefox',
            (bool) preg_match('/Chrome|CriOS/i', $ua) => 'Chrome',
            (bool) preg_match('/Safari/i', $ua) => 'Safari',
            default => 'Browser',
        };

        return $os . ' · ' . $br;
    }

    /**
     * Where the visitor came from, using the first visit recorded for their rpk_vid cookie:
     * utm_source / referrer host, else "Referral (CODE)", else "Direct".
     */
    public static function source(Request $request, ?string $refCode = null): string
    {
        try {
            $vid = (string) $request->cookie('rpk_vid');
            if ($vid !== '') {
                $first = DB::table('site_visits')->where('visitor', $vid)->orderBy('visit_date')->orderBy('id')->first();
                if ($first && $first->source) {
                    return substr($first->source, 0, 80);
                }
                if ($first && $first->ref_code) {
                    return 'Referral (' . $first->ref_code . ')';
                }
            }
        } catch (\Throwable $e) {
        }

        return $refCode ? 'Referral (' . $refCode . ')' : 'Direct';
    }
}
