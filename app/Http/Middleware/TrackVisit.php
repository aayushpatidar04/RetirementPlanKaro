<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Support\ReferralProgramme;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

/**
 * Counts one visit per visitor per day for the public site (feeds the admin dashboard).
 * Also counts a click on a referral link (?ref=CODE) once per visitor per day.
 * Never breaks a page: any failure (e.g. table not migrated yet) is swallowed.
 */
class TrackVisit
{
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $this->track($request);
        } catch (\Throwable $e) {
            // tracking must never affect the page
        }
        try {
            $this->touchClient($request);
        } catch (\Throwable $e) {
        }

        return $next($request);
    }

    private function track(Request $request): void
    {
        if (!$request->isMethod('GET') || $request->ajax() || $request->expectsJson()
            || $request->is('admin', 'admin/*', 'api/*', 'up', 'email/*')) {
            return;
        }

        $ua = strtolower((string) $request->userAgent());
        if ($ua === '' || preg_match('/bot|crawl|spider|slurp|preview|monitor|curl|wget|headless|lighthouse/', $ua)) {
            return;
        }

        $vid = (string) $request->cookie('rpk_vid');
        if (!preg_match('/^[A-Za-z0-9]{24}$/', $vid)) {
            $vid = Str::random(24);
            Cookie::queue('rpk_vid', $vid, 60 * 24 * 365);
        }

        $today = now()->toDateString();
        $ref = strtoupper(substr((string) preg_replace('/[^A-Za-z0-9]/', '', (string) $request->query('ref')), 0, 12));

        $row = DB::table('site_visits')->where('visitor', $vid)->where('visit_date', $today)->first();

        $src = $this->campaign($request);

        if (!$row) {
            if ($src !== null) {
                ReferralProgramme::countCampaignClick($src);
            }
            DB::table('site_visits')->insertOrIgnore([
                'visitor' => $vid,
                'visit_date' => $today,
                'path' => substr('/' . ltrim($request->path(), '/'), 0, 255),
                'ref_code' => $ref !== '' ? $ref : null,
                'source' => $this->source($request),
                'created_at' => now(),
            ]);
            if ($ref !== '') {
                $this->countClick($ref);
            }
        } elseif ($src !== null && !str_starts_with((string) $row->source, 'Campaign: ')) {
            DB::table('site_visits')->where('id', $row->id)->update(['source' => substr('Campaign: ' . $src, 0, 60)]);
            ReferralProgramme::countCampaignClick($src);
        } elseif ($ref !== '' && empty($row->ref_code)) {
            DB::table('site_visits')->where('id', $row->id)->update(['ref_code' => $ref]);
            $this->countClick($ref);
        }
    }

    private function countClick(string $ref): void
    {
        DB::table('users')->where('referral_code', $ref)->update(['clicks' => DB::raw('COALESCE(clicks, 0) + 1')]);
    }

    /** ?src=CODE on a campaign link */
    private function campaign(Request $request): ?string
    {
        $src = (string) $request->query('src', '');

        return preg_match('/^[A-Za-z0-9_-]{1,50}$/', $src) ? $src : null;
    }

    /** "Last active" on the client profile: refreshed at most every 5 minutes. */
    private function touchClient(Request $request): void
    {
        $u = Auth::guard('web')->user();
        if (!$u) {
            return;
        }
        $last = $u->last_seen_at ? strtotime((string) $u->last_seen_at) : 0;
        if (time() - $last > 300) {
            DB::table('users')->where('id', $u->id)->update(['last_seen_at' => now()]);
        }
    }

    private function source(Request $request): ?string
    {
        if ($src = $this->campaign($request)) {
            return substr('Campaign: ' . $src, 0, 60);
        }
        $utm = trim((string) $request->query('utm_source'));
        if ($utm !== '') {
            return substr($utm, 0, 60);
        }

        $host = parse_url((string) $request->headers->get('referer'), PHP_URL_HOST);

        return ($host && $host !== $request->getHost()) ? substr($host, 0, 60) : null;
    }
}