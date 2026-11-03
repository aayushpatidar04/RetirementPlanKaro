<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $period = $request->input('period', 'today');
        $from = $request->input('from');
        $to = $request->input('to');

        [$rStart, $rEnd, $pStart, $pEnd] = $this->getRanges($period, $from, $to);

        $usersTotal = DB::table('users')->count();
        $verifiedTotal = DB::table('users')->whereNotNull('email_verified_at')->count();
        $leadsTotal = DB::table('leads')->count();
        $paymentsOkTotal = DB::table('payments')->where('status', 'success')->count();
        $revenueTotal = (float) DB::table('payments')->where('status', 'success')->sum('amount');
        $sessionsDueTotal = DB::table('guidance_sessions')->whereIn('status', ['booked', 'confirmed'])->count();

        $signups = DB::table('users')->whereBetween('created_at', [$rStart, $rEnd])->count();
        $verified = DB::table('users')->whereNotNull('email_verified_at')->whereBetween('created_at', [$rStart, $rEnd])->count();
        $leads = DB::table('leads')->whereBetween('created_at', [$rStart, $rEnd])->count();
        $revenue = (float) DB::table('payments')->where('status', 'success')->whereBetween('created_at', [$rStart, $rEnd])->sum('amount');
        $paidClients = DB::table('payments')->join('users', 'users.id', '=', 'payments.user_id')->where('payments.status', 'success')->whereBetween('payments.created_at', [$rStart, $rEnd])->distinct()->count('users.id');
        $failed = DB::table('payments')->where('status', 'failed')->whereBetween('created_at', [$rStart, $rEnd])->count();
        $sessionsBooked = DB::table('guidance_sessions')->whereBetween('created_at', [$rStart, $rEnd])->count();

        $signupsP = DB::table('users')->whereBetween('created_at', [$pStart, $pEnd])->count();
        $leadsP = DB::table('leads')->whereBetween('created_at', [$pStart, $pEnd])->count();
        $revenueP = (float) DB::table('payments')->where('status', 'success')->whereBetween('created_at', [$pStart, $pEnd])->sum('amount');
        $paidClientsP = DB::table('payments')->join('users', 'users.id', '=', 'payments.user_id')->where('payments.status', 'success')->whereBetween('payments.created_at', [$pStart, $pEnd])->distinct()->count('users.id');
        $failedP = DB::table('payments')->where('status', 'failed')->whereBetween('created_at', [$pStart, $pEnd])->count();

        $pct = function($cur, $prev, $bad=false) {
            if ($prev == 0) {
                if ($cur == 0) return ['val'=>0, 'cls'=>'cm', 'sign'=>''];
                return ['val'=>100, 'cls'=>$bad?'dn':'up', 'sign'=>$bad?'▼':'▲'];
            }
            $d = round((($cur - $prev)/$prev)*100);
            $good = $bad ? $d <= 0 : $d >= 0;
            return ['val'=>abs($d), 'cls'=>$good?'up':'dn', 'sign'=>$d>=0?($bad?'▼':'▲'):($bad?'▲':'▼')];
        };

        $stats = [
            'users' => $usersTotal,
            'verified' => $verifiedTotal,
            'leads' => $leadsTotal,
            'payments_ok' => $paymentsOkTotal,
            'revenue' => $revenueTotal,
            'sessions_due' => $sessionsDueTotal,
            'signups' => $signups,
            'verified_r' => $verified,
            'leads_r' => $leads,
            'revenue_r' => $revenue,
            'paid_clients' => $paidClients,
            'failed_r' => $failed,
            'sessions_booked' => $sessionsBooked,
            'pc_signups' => $pct($signups, $signupsP),
            'pc_leads' => $pct($leads, $leadsP),
            'pc_revenue' => $pct($revenue, $revenueP),
            'pc_paid' => $pct($paidClients, $paidClientsP),
            'pc_failed' => $pct($failed, $failedP, true),
            'periodLabel' => $this->periodLabel($period, $rStart, $rEnd),
        ];

        $recentPayments = DB::table('payments')
            ->join('users', 'users.id', '=', 'payments.user_id')
            ->orderByDesc('payments.id')
            ->limit(8)
            ->select('payments.*', 'users.name', 'users.mobile')
            ->get();

        $recentLeads = DB::table('leads')->orderByDesc('id')->limit(8)->get();

        return view('admin.dashboard', compact('stats', 'recentPayments', 'recentLeads', 'period'));
    }

    private function getRanges($period, $from, $to)
    {
        $now = Carbon::now();
        switch ($period) {
            case '7':
                $rStart = $now->copy()->subDays(6)->startOfDay(); $rEnd = $now->copy()->endOfDay();
                $pStart = $now->copy()->subDays(13)->startOfDay(); $pEnd = $now->copy()->subDays(7)->endOfDay(); break;
            case '30':
                $rStart = $now->copy()->subDays(29)->startOfDay(); $rEnd = $now->copy()->endOfDay();
                $pStart = $now->copy()->subDays(59)->startOfDay(); $pEnd = $now->copy()->subDays(30)->endOfDay(); break;
            case 'month':
                $rStart = $now->copy()->startOfMonth(); $rEnd = $now->copy()->endOfDay();
                $pStart = $now->copy()->subMonth()->startOfMonth(); $pEnd = $now->copy()->subMonth()->endOfMonth(); break;
            case '90':
                $rStart = $now->copy()->subDays(89)->startOfDay(); $rEnd = $now->copy()->endOfDay();
                $pStart = $now->copy()->subDays(179)->startOfDay(); $pEnd = $now->copy()->subDays(90)->endOfDay(); break;
            case 'custom':
                if ($from && $to) {
                    $rStart = Carbon::parse($from)->startOfDay(); $rEnd = Carbon::parse($to)->endOfDay();
                    $days = $rStart->diffInDays($rEnd)+1;
                    $pEnd = $rStart->copy()->subDay()->endOfDay(); $pStart = $pEnd->copy()->subDays($days-1)->startOfDay();
                    break;
                }
            case 'today':
            default:
                $rStart = $now->copy()->startOfDay(); $rEnd = $now->copy()->endOfDay();
                $pStart = $now->copy()->subDay()->startOfDay(); $pEnd = $now->copy()->subDay()->endOfDay(); break;
        }
        return [$rStart, $rEnd, $pStart, $pEnd];
    }

    private function periodLabel($period, $rStart, $rEnd)
    {
        if ($period === 'custom') return $rStart->format('d M Y') . ' – ' . $rEnd->format('d M Y');
        if ($period === '7') return 'Last 7 days';
        if ($period === '30') return 'Last 30 days';
        if ($period === '90') return 'Last 90 days';
        if ($period === 'month') return 'This month';
        return 'Today';
    }
}
