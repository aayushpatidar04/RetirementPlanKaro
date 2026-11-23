<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        [$period, $rStart, $rEnd, $pStart, $pEnd] = $this->getRanges(
            (string) $request->input('period', 'today'),
            $request->input('from'),
            $request->input('to')
        );

        $cur = $this->periodStats($rStart, $rEnd);
        $prev = $this->periodStats($pStart, $pEnd);

        // all-time figures
        $usersTotal = DB::table('users')->count();
        $verifiedTotal = DB::table('users')->whereNotNull('email_verified_at')->count();
        $activeTotal = DB::table('users')
            ->whereNull('suspended_at')
            ->where(fn ($q) => $q->whereNull('status')->orWhereNotIn('status', ['Blocked', 'Suspended']))
            ->count();
        $sessionsDue = DB::table('guidance_sessions')->whereIn('status', ['booked', 'confirmed'])->count();

        $ok = $cur['paid_ok'];
        $collection = ($ok + $cur['failed']) > 0 ? (int) round($ok / ($ok + $cur['failed']) * 100) : 0;

        $stats = [
            // all time
            'users' => $usersTotal,
            'verified' => $verifiedTotal,
            'active_clients' => $activeTotal,
            'sessions_due' => $sessionsDue,

            // in period
            'visits' => $cur['visits'],
            'signups' => $cur['signups'],
            'verified_r' => $cur['verified'],
            'leads_r' => $cur['leads'],
            'revenue_r' => $cur['revenue'],
            'paid_clients' => $cur['paid_clients'],
            'failed_r' => $cur['failed'],
            'collection_rate' => $collection,
            'sessions_booked' => $cur['sessions'],
            'referral_regs' => $cur['referrals'],
            'messages_sent' => $cur['messages'],
            'coupons_redeemed' => $cur['coupons'],
            'points_issued' => $cur['points'],

            // all time
            'ref_clicks' => (int) DB::table('users')->sum('clicks')
                + (int) collect(json_decode((string) \App\Support\Settings::get('referral_campaign_links'), true) ?: [])->sum('clicks'),
            'partner_clicks' => (int) DB::table('investment_partners')->sum('clicks'),

            // vs previous period
            'pc_visits' => $this->pct($cur['visits'], $prev['visits']),
            'pc_signups' => $this->pct($cur['signups'], $prev['signups']),
            'pc_leads' => $this->pct($cur['leads'], $prev['leads']),
            'pc_revenue' => $this->pct($cur['revenue'], $prev['revenue']),
            'pc_paid' => $this->pct($cur['paid_clients'], $prev['paid_clients']),
            'pc_failed' => $this->pct($cur['failed'], $prev['failed'], true),
            'pc_points' => $this->pct($cur['points'], $prev['points']),

            'periodLabel' => $this->periodLabel($period, $rStart, $rEnd),
        ];

        $charts = $this->charts($rStart, $rEnd);

        return view('admin.dashboard', compact('stats', 'period', 'charts'));
    }

    /** Every in-period metric for one date range (used for the current and the previous period). */
    private function periodStats(Carbon $a, Carbon $b): array
    {
        $created = fn (string $table, string $col = 'created_at') => DB::table($table)->whereBetween($col, [$a, $b]);

        // money is counted on the day it was collected, not the day checkout was opened
        $ok = fn () => DB::table('payments')->where('status', 'success')
            ->whereBetween(DB::raw('COALESCE(payments.paid_at, payments.created_at)'), [$a, $b]);

        return [
            'visits' => $this->safe(fn () => DB::table('site_visits')
                ->whereBetween('visit_date', [$a->toDateString(), $b->toDateString()])->count(), 0),
            'signups' => $created('users')->count(),
            'verified' => $created('users', 'email_verified_at')->count(),
            'leads' => $created('leads')->count(),
            'revenue' => (float) $ok()->sum('amount'),
            'paid_ok' => $ok()->count(),
            'paid_clients' => $ok()->distinct()->count('user_id'),
            'failed' => $created('payments')->where('status', 'failed')->count(),
            'sessions' => $created('guidance_sessions')->count(),
            'referrals' => $created('referrals')->count(),
            'messages' => $created('communication_logs', 'sent_at')->count(),
            'coupons' => $created('coupon_redemptions')->count(),
            'points' => (int) $created('points_ledger')->where('points', '>', 0)->sum('points'),
        ];
    }

    /** Day-by-day series for the charts + payment status split. Short ranges are padded to 7 days. */
    private function charts(Carbon $rStart, Carbon $rEnd): array
    {
        $from = $rStart->copy()->startOfDay();
        $to = $rEnd->copy()->endOfDay();
        $days = (int) round($from->diffInDays($to->copy()->startOfDay(), true)) + 1;
        $padded = $days < 7;
        if ($padded) {
            $from = $to->copy()->subDays(6)->startOfDay();
        }

        $keys = [];
        foreach (CarbonPeriod::create($from, $to) as $d) {
            $keys[$d->toDateString()] = 0;
        }

        $visits = $this->safe(fn () => DB::table('site_visits')
            ->whereBetween('visit_date', [$from->toDateString(), $to->toDateString()])
            ->selectRaw('visit_date as d, COUNT(*) as c')->groupBy('visit_date')->pluck('c', 'd')->all(), []);

        $regs = DB::table('users')->whereBetween('created_at', [$from, $to])
            ->selectRaw('DATE(created_at) as d, COUNT(*) as c')->groupByRaw('DATE(created_at)')->pluck('c', 'd')->all();

        $rev = DB::table('payments')->where('status', 'success')
            ->whereBetween(DB::raw('COALESCE(paid_at, created_at)'), [$from, $to])
            ->selectRaw('DATE(COALESCE(paid_at, created_at)) as d, SUM(amount) as s')
            ->groupByRaw('DATE(COALESCE(paid_at, created_at))')->pluck('s', 'd')->all();

        $pay = DB::table('payments')->whereBetween('created_at', [$rStart, $rEnd])
            ->selectRaw('status, COUNT(*) as c')->groupBy('status')->pluck('c', 'status')->all();

        $labels = $v = $r = $m = [];
        foreach (array_keys($keys) as $day) {
            $labels[] = Carbon::parse($day)->format('d M');
            $v[] = (int) ($visits[$day] ?? 0);
            $r[] = (int) ($regs[$day] ?? 0);
            $m[] = (float) ($rev[$day] ?? 0);
        }

        return [
            'padded' => $padded,
            'labels' => $labels,
            'visits' => $v,
            'regs' => $r,
            'revenue' => $m,
            'pay' => [
                (int) ($pay['success'] ?? 0),
                (int) ($pay['failed'] ?? 0),
                (int) ($pay['pending'] ?? 0),
                (int) ($pay['refunded'] ?? 0),
            ],
        ];
    }

    /** Arrow = direction of change; colour = good/bad (for "bad" metrics like failures, up is red). */
    private function pct($cur, $prev, bool $bad = false): array
    {
        if ($prev == 0) {
            if ($cur == 0) {
                return ['val' => 0, 'cls' => 'cm', 'sign' => ''];
            }
            return ['val' => 100, 'cls' => $bad ? 'dn' : 'up', 'sign' => '▲'];
        }

        $d = (int) round((($cur - $prev) / $prev) * 100);
        $good = $bad ? $d <= 0 : $d >= 0;

        return ['val' => abs($d), 'cls' => $d === 0 ? 'cm' : ($good ? 'up' : 'dn'), 'sign' => $d === 0 ? '' : ($d > 0 ? '▲' : '▼')];
    }

    private function getRanges(string $period, ?string $from, ?string $to): array
    {
        $now = Carbon::now();

        switch ($period) {
            case '7':
            case '30':
            case '90':
                return array_merge([$period], $this->rolling($now, (int) $period));

            case 'month':
                $rStart = $now->copy()->startOfMonth();
                $rEnd = $now->copy()->endOfDay();
                // same number of days of the previous month (subMonth() would overflow, e.g. 31 Mar -> 3 Mar)
                $pStart = $now->copy()->subMonthNoOverflow()->startOfMonth();
                $pEnd = $pStart->copy()->addDays($now->day - 1)->endOfDay();
                if ($pEnd->gt($pStart->copy()->endOfMonth())) {
                    $pEnd = $pStart->copy()->endOfMonth();
                }
                return ['month', $rStart, $rEnd, $pStart, $pEnd];

            case 'custom':
                try {
                    if ($from && $to) {
                        $a = Carbon::parse($from)->startOfDay();
                        $b = Carbon::parse($to)->endOfDay();
                        if ($a->gt($b)) {
                            [$a, $b] = [$b->copy()->startOfDay(), $a->copy()->endOfDay()];
                        }
                        $days = (int) round($a->diffInDays($b->copy()->startOfDay(), true)) + 1;
                        $pEnd = $a->copy()->subDay()->endOfDay();
                        $pStart = $pEnd->copy()->subDays($days - 1)->startOfDay();
                        return ['custom', $a, $b, $pStart, $pEnd];
                    }
                } catch (\Throwable $e) {
                    // bad date in the URL: fall back to today
                }
                // no break

            default:
                return ['today', $now->copy()->startOfDay(), $now->copy()->endOfDay(),
                    $now->copy()->subDay()->startOfDay(), $now->copy()->subDay()->endOfDay()];
        }
    }

    /** Last $n days ending today, and the $n days before that. */
    private function rolling(Carbon $now, int $n): array
    {
        $rStart = $now->copy()->subDays($n - 1)->startOfDay();
        $rEnd = $now->copy()->endOfDay();
        $pEnd = $rStart->copy()->subDay()->endOfDay();
        $pStart = $pEnd->copy()->subDays($n - 1)->startOfDay();

        return [$rStart, $rEnd, $pStart, $pEnd];
    }

    private function periodLabel(string $period, Carbon $rStart, Carbon $rEnd): string
    {
        return match ($period) {
            'custom' => $rStart->format('d M Y') . ' – ' . $rEnd->format('d M Y'),
            '7' => 'Last 7 days',
            '30' => 'Last 30 days',
            '90' => 'Last 90 days',
            'month' => 'This month',
            default => 'Today',
        };
    }

    /** Run a query that may hit a table that has not been migrated yet. */
    private function safe(callable $fn, $default)
    {
        try {
            return $fn();
        } catch (\Throwable $e) {
            return $default;
        }
    }
}