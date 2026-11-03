<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class CouponController extends Controller
{
    public function index(): View
    {
        $coupons = DB::table('coupons')->orderByDesc('id')->get();

        return view('admin.coupons', compact('coupons'));
    }

    public function store(Request $request): RedirectResponse
    {
        $d = $request->validate([
            'code'       => ['required', 'string', 'max:30', 'unique:coupons,code'],
            'type'       => ['required', Rule::in(['flat', 'percent'])],
            'value'      => ['required', 'numeric', 'min:1', 'max:100000'],
            'max_uses'   => ['nullable', 'integer', 'min:1'],
            'expires_at' => ['nullable', 'date'],
        ]);

        DB::table('coupons')->insert([
            'code'       => strtoupper(trim($d['code'])),
            'type'       => $d['type'],
            'value'      => $d['value'],
            'max_uses'   => $d['max_uses'] ?? null,
            'used_count' => 0,
            'active'     => true,
            'expires_at' => $d['expires_at'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return back()->with('ok', 'Coupon created.');
    }

    public function toggle(int $id): RedirectResponse
    {
        $c = DB::table('coupons')->where('id', $id)->first();
        abort_unless($c, 404);
        DB::table('coupons')->where('id', $id)->update(['active' => !$c->active, 'updated_at' => now()]);

        return back()->with('ok', 'Coupon updated.');
    }

    public function destroy(int $id): RedirectResponse
    {
        DB::table('coupons')->where('id', $id)->delete();

        return back()->with('ok', 'Coupon removed.');
    }
}