<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'users'        => DB::table('users')->count(),
            'verified'     => DB::table('users')->whereNotNull('email_verified_at')->count(),
            'leads'        => DB::table('leads')->count(),
            'payments_ok'  => DB::table('payments')->where('status', 'success')->count(),
            'revenue'      => (float) DB::table('payments')->where('status', 'success')->sum('amount'),
            'sessions_due' => DB::table('guidance_sessions')->where('status', 'confirmed')->count(),
        ];

        $recentPayments = DB::table('payments')
            ->join('users', 'users.id', '=', 'payments.user_id')
            ->orderByDesc('payments.id')
            ->limit(8)
            ->select('payments.*', 'users.name', 'users.mobile')
            ->get();

        $recentLeads = DB::table('leads')->orderByDesc('id')->limit(8)->get();

        return view('admin.dashboard', compact('stats', 'recentPayments', 'recentLeads'));
    }
}