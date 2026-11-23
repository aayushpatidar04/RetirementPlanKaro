<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\Activity;
use App\Support\VersionHistory;
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

    private function rules(?int $ignoreId = null): array
    {
        return [
            'code'       => ['required', 'string', 'max:30', 'regex:/^[A-Za-z0-9_-]+$/', Rule::unique('coupons', 'code')->ignore($ignoreId)],
            'type'       => ['required', Rule::in(['flat', 'percent'])],
            'value'      => ['required', 'numeric', 'min:1', 'max:100000'],
            'max_uses'   => ['nullable', 'integer', 'min:1'],
            'expires_at' => ['nullable', 'date'],
        ];
    }

    private function clean(array $d): array
    {
        if ($d['type'] === 'percent' && $d['value'] > 100) {
            abort(back()->withErrors(['value' => 'A percent discount cannot be more than 100.'])->withInput());
        }

        return [
            'code'       => strtoupper(trim($d['code'])),
            'type'       => $d['type'],
            'value'      => $d['value'],
            'max_uses'   => $d['max_uses'] ?? null,
            'expires_at' => $d['expires_at'] ?? null,
            'updated_at' => now(),
        ];
    }

    public function store(Request $request): RedirectResponse
    {
        $request->merge(['code' => strtoupper(trim((string) $request->input('code')))]);
        $row = $this->clean($request->validate($this->rules(), ['code.regex' => 'Use letters, digits, - or _ only.']));

        $id = DB::table('coupons')->insertGetId($row + ['used_count' => 0, 'active' => true, 'created_at' => now()]);

        Activity::log(null, 'coupon.created', "Discount code created: {$row['code']}", $row, 'Coupon', $id);
        VersionHistory::record('Discount Codes', "Code {$row['code']} added");

        return back()->with('ok', 'Coupon created.');
    }

    public function toggle(int $id): RedirectResponse
    {
        $c = DB::table('coupons')->where('id', $id)->first();
        abort_unless($c, 404);
        DB::table('coupons')->where('id', $id)->update(['active' => !$c->active, 'updated_at' => now()]);

        Activity::log(null, 'coupon.toggled', 'Discount code ' . $c->code . ($c->active ? ' disabled' : ' enabled'), [], 'Coupon', $id);
        VersionHistory::record('Discount Codes', 'Code ' . $c->code . ($c->active ? ' disabled' : ' enabled'));

        return back()->with('ok', 'Coupon updated.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $c = DB::table('coupons')->where('id', $id)->first();
        abort_unless($c, 404);

        if (DB::table('coupon_redemptions')->where('coupon_id', $id)->exists()) {
            // keep the history of who used it; just stop it working
            DB::table('coupons')->where('id', $id)->update(['active' => false, 'updated_at' => now()]);
            $msg = 'This code has already been used, so it was disabled instead of deleted (its history is kept).';
        } else {
            DB::table('coupons')->where('id', $id)->delete();
            $msg = 'Coupon removed.';
        }

        Activity::log(null, 'coupon.deleted', "Discount code removed: {$c->code}", (array) $c, 'Coupon', $id);
        VersionHistory::record('Discount Codes', "Code {$c->code} removed");

        return back()->with('ok', $msg);
    }
}
