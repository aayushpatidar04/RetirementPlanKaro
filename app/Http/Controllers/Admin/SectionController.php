<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\AdminAccess;
use App\Support\Settings;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/** Overview page for each sidebar section: one tile per page with a live figure. */
class SectionController extends Controller
{
    public function show(string $key): View
    {
        $sections = AdminAccess::sections();
        abort_unless(isset($sections[$key]), 404);
        [$name, $desc, $items] = $sections[$key];

        $tiles = [];
        foreach ($items as [$area, $label, $route, $about]) {
            if (!AdminAccess::can($area)) {
                continue;
            }
            $tiles[] = ['label' => $label, 'route' => route($route), 'about' => $about, 'stat' => $this->stat($area)];
        }

        if (!$tiles) {
            return view('admin.denied', ['area' => $name, 'message' => AdminAccess::denyMessage($name, 'v')]);
        }

        return view('admin.section', compact('name', 'desc', 'tiles'));
    }

    private function stat(string $area): string
    {
        try {
            $n = fn ($v) => number_format((float) $v);

            return match ($area) {
                'Customers' => $n(DB::table('users')->count()) . ' clients',
                'Leads' => $n(DB::table('users')->whereNotExists(fn ($q) => $q->from('payments')->whereColumn('payments.user_id', 'users.id')->where('status', 'success'))->count()) . ' not yet paying',
                'Payments' => '₹' . $n(DB::table('payments')->where('status', 'success')->sum('amount')) . ' received · '
                    . $n(DB::table('payments')->where('status', 'failed')->count()) . ' failed',
                'Get Quotes' => $n(DB::table('quote_requests')->where('status', 'New')->count()) . ' new requests',
                'Sessions' => $n(DB::table('guidance_sessions')->whereIn('status', ['booked', 'confirmed'])->count()) . ' to conduct',
                'Referrals' => $n(DB::table('referrals')->count()) . ' referral sign ups',
                'Messages & Email' => $n(DB::table('communication_logs')->count()) . ' messages sent',
                'Coupons' => $n(DB::table('coupons')->where('active', true)->count()) . ' active',
                'Pricing & rewards' => 'Report ₹' . $n(Settings::get('report_price', 499)) . ' · Session ₹' . $n(Settings::get('session_price', 1000)),
                'One Window Investing' => $n(DB::table('investment_partners')->where('is_active', true)->count()) . ' options live',
                'Testimonials' => $n(DB::table('testimonials')->where('is_active', true)->where('permission_taken', true)->count()) . ' shown on website',
                'Website versions' => $n(DB::table('version_snapshots')->count()) . ' versions saved',
                'Audit log' => $n(DB::table('activity_logs')->where(fn ($q) => $q->whereNull('actor_type')->orWhere('actor_type', '!=', 'user'))->count()) . ' changes',
                'Team' => $n(DB::table('team_members')->where('is_active', true)->count()) . ' active members',
                'Roles' => $n(DB::table('roles')->count()) . ' roles',
                default => '',
            };
        } catch (\Throwable $e) {
            return '';
        }
    }
}
