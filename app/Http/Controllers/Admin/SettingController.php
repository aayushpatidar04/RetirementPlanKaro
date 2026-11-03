<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\Settings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        $packs = Settings::packs();

        $values = [
            'report_price'        => Settings::get('report_price', 499),
            'session_price'       => Settings::get('session_price', 1000),
            'ref_pts'             => Settings::get('ref_pts', 100),
            'wallet_unlock_cost'  => Settings::get('wallet_unlock_cost', 200),
            'wallet_unlock_hours' => Settings::get('wallet_unlock_hours', 24),
            'welcome_bonus'       => Settings::get('welcome_bonus', 600),
            'referral_bonus'      => Settings::get('referral_bonus', 100),
            'streak_points'       => Settings::get('streak_points', 50),
            'streak_days'         => Settings::get('streak_days', 7),
        ];

        return view('admin.settings', compact('values', 'packs'));
    }

    public function update(Request $request): RedirectResponse
    {
        $d = $request->validate([
            'report_price'        => ['required', 'numeric', 'min:0'],
            'session_price'       => ['required', 'numeric', 'min:0'],
            'ref_pts'             => ['required', 'integer', 'min:0'],
            'wallet_unlock_cost'  => ['required', 'integer', 'min:1'],
            'wallet_unlock_hours' => ['required', 'integer', 'min:1'],
            'welcome_bonus'       => ['required', 'integer', 'min:0'],
            'referral_bonus'      => ['required', 'integer', 'min:0'],
            'streak_points'       => ['required', 'integer', 'min:0'],
            'streak_days'         => ['required', 'integer', 'min:1', 'max:30'],
            'pack1_pts' => ['required', 'integer', 'min:1'], 'pack1_rs' => ['required', 'integer', 'min:1'],
            'pack2_pts' => ['required', 'integer', 'min:1'], 'pack2_rs' => ['required', 'integer', 'min:1'],
            'pack3_pts' => ['required', 'integer', 'min:1'], 'pack3_rs' => ['required', 'integer', 'min:1'],
        ]);

        foreach (['report_price','session_price','ref_pts','wallet_unlock_cost','wallet_unlock_hours','welcome_bonus','referral_bonus','streak_points','streak_days'] as $k) {
            Settings::set($k, $d[$k]);
        }

        Settings::set('packs', json_encode([
            [$d['pack1_pts'], $d['pack1_rs']],
            [$d['pack2_pts'], $d['pack2_rs']],
            [$d['pack3_pts'], $d['pack3_rs']],
        ]));

        return back()->with('ok', 'Settings saved.');
    }
}