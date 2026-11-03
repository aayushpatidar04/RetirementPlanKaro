<?php

namespace App\Http\Controllers;

use App\Support\Settings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PayController extends Controller
{
    private const SLOTS = ['Morning (9 am to 12 pm)', 'Afternoon (12 pm to 4 pm)', 'Evening (4 pm to 8 pm)'];
    private const MODES = ['Phone call', 'Video call'];
    private const STALE_MINUTES = 45;
    private const PAYU_FAILED = ['failure', 'failed', 'usercancelled', 'dropped', 'bounced'];

    public function state(Request $request): JsonResponse
    {
        $uid = $request->user()->id;
        $this->releaseStale($uid);

        $paid = DB::table('payments')->where('user_id', $uid)->where('purpose', 'report')->where('status', 'success')
            ->where('paid_at', '>', now()->subDays((int) config('rpk.report_days')))
            ->orderByDesc('paid_at')->first();

        $sessions = DB::table('guidance_sessions')->where('user_id', $uid)->where('status', 'confirmed')
            ->orderBy('id')->get()
            ->map(fn ($s) => [
                'id'     => $s->id,
                'ts'     => Carbon::parse($s->created_at)->timestamp * 1000,
                'date'   => $s->date,
                'slot'   => $s->slot,
                'mode'   => $s->mode,
                'mobile' => $s->mobile,
                'note'   => $s->note ?? '',
                'amount' => $this->sessionPrice(),
            ])->values();

        return response()->json([
            'live'           => $this->gatewayLive(),
            'price'          => $this->reportPrice(),
            'session_price'  => $this->sessionPrice(),
            'paid'           => (bool) $paid,
            'paid_at'        => $paid->paid_at ?? null,
            'sessions'       => $sessions,
            'report_points'  => $this->reportBal($uid),
            'ref_pts'        => (int) Settings::get('ref_pts', 100),
            'streak_days'    => (int) Settings::get('streak_days', 7),
            'streak_points'  => (int) Settings::get('streak_points', 50),
            'packs'          => Settings::packs(),
        ]);
    }

    public function couponCheck(Request $request): JsonResponse
    {
        $d = $request->validate(['code' => ['required', 'string', 'max:30']]);
        $r = $this->evalCoupon($request->user()->id, strtoupper(trim($d['code'])), $this->reportPrice());

        if (!$r['ok']) {
            return response()->json(['ok' => false, 'message' => $r['message']], 422);
        }

        return response()->json(['ok' => true, 'off' => $r['off']]);
    }

    public function initiate(Request $request): JsonResponse
    {
        $d = $request->validate([
            'purpose'    => ['required', Rule::in(['report', 'session', 'wallet'])],
            'coupon'     => ['nullable', 'string', 'max:30'],
            'use_points' => ['nullable', 'boolean'],
            'pack'       => ['nullable', 'integer', 'min:0', 'max:2'],
            'session'    => ['nullable', 'array'],
        ]);

        $user    = $request->user();
        $uid     = $user->id;
        $purpose = $d['purpose'];
        $this->releaseStale($uid);

        $base = 0; $couponCode = null; $couponOff = 0; $pts = 0; $pack = null; $info = ''; $sess = null;

        if ($purpose === 'report') {
            if ($this->hasPaidReport($uid)) {
                return response()->json(['already' => true, 'done' => false, 'purpose' => 'report']);
            }
            $base = $this->reportPrice();
            $info = 'Premium Personalized Report';

            if (!empty($d['coupon'])) {
                $c = $this->evalCoupon($uid, strtoupper(trim($d['coupon'])), $base);
                if (!$c['ok']) {
                    return response()->json(['message' => $c['message']], 422);
                }
                $couponCode = $c['coupon']->code;
                $couponOff  = $c['off'];
            }

            if (!empty($d['use_points'])) {
                $bal = $this->reportBal($uid);
                if ($bal >= (int) Settings::get('ref_pts', 100)) {
                    $pts = min($bal, $base - $couponOff);
                }
            }
        } elseif ($purpose === 'session') {
            $sess = $this->sessionData((array) ($d['session'] ?? []));
            $base = $this->sessionPrice();
            $info = 'Guidance Session';
        } else {
            if (!isset($d['pack'])) {
                return response()->json(['message' => 'Choose a points pack.'], 422);
            }
            $pack = (int) $d['pack'];
            $pk   = Settings::packs()[$pack] ?? null;
            if (!$pk) {
                return response()->json(['message' => 'Choose a points pack.'], 422);
            }
            $base = (int) $pk[1];
            $info = 'Wallet ' . $pk[0] . ' points';
        }

        $payable = max(0, $base - $couponOff - $pts);
        $txnid   = 'RPK' . now()->format('ymdHis') . strtoupper(Str::random(5));

        $pid = DB::transaction(function () use ($uid, $purpose, $pack, $base, $couponCode, $couponOff, $pts, $payable, $txnid, $sess) {
            if ($pts > 0 && $this->reportBal($uid) < $pts) {
                abort(422, 'Not enough points.');
            }

            $pid = DB::table('payments')->insertGetId([
                'user_id' => $uid, 'txnid' => $txnid, 'purpose' => $purpose, 'pack' => $pack,
                'base_amount' => $base, 'coupon_code' => $couponCode, 'coupon_off' => $couponOff,
                'points_used' => $pts, 'amount' => $payable, 'status' => 'pending',
                'created_at' => now(), 'updated_at' => now(),
            ]);

            if ($pts > 0) {
                DB::table('points_ledger')->insert([
                    'user_id' => $uid, 'account' => 'report', 'type' => 'report_redeem',
                    'points' => -$pts, 'note' => 'Reserved for ' . $txnid,
                    'created_at' => now(), 'updated_at' => now(),
                ]);
            }

            if ($sess) {
                $sid = DB::table('guidance_sessions')->insertGetId($sess + [
                    'user_id' => $uid, 'payment_id' => $pid, 'status' => 'pending_payment',
                    'created_at' => now(), 'updated_at' => now(),
                ]);
                DB::table('payments')->where('id', $pid)->update(['ref_id' => $sid]);
            }

            return $pid;
        });

        if ($payable <= 0) {
            $this->settle($pid, 'FREE', 'free');

            return response()->json(['done' => true, 'purpose' => $purpose, 'txnid' => $txnid]);
        }

        if (!$this->gatewayLive()) {
            if (config('rpk.payu.fake') && app()->environment('local')) {
                $this->settle($pid, 'FAKE', 'fake');

                return response()->json(['done' => true, 'purpose' => $purpose, 'txnid' => $txnid]);
            }
            $this->fail($pid);

            return response()->json(['message' => 'Payments are not switched on yet. Please try again later.'], 503);
        }

        $payment = DB::table('payments')->find($pid);

        return response()->json(['done' => false, 'purpose' => $purpose, 'txnid' => $txnid] + $this->gatewayForm($user, $payment, $info));
    }

    // Browser redirect from PayU (surl/furl). Delegates to the same handler the
    // server-to-server webhook uses — either one resolving the payment is enough.
    public function callback(Request $request): RedirectResponse
    {
        $this->handleGatewayPost($request->post());

        $txnid = (string) $request->post('txnid', '');
        $final = DB::table('payments')->where('txnid', $txnid)->value('status');
        $tag   = $final === 'success' ? 'ok' : ($final === 'pending' ? 'pending' : 'failed');

        return redirect('/?pay=' . $tag . '&txn=' . urlencode($txnid));
    }

    // Server-to-server confirmation from PayU. Register as the webhook/pingback URL
    // in the PayU dashboard, separate from surl/furl. Doesn't depend on the customer's
    // browser ever coming back (tab closed after UPI approval, lost connection, etc).
    public function webhook(Request $request): JsonResponse
    {
        $this->handleGatewayPost($request->post());

        return response()->json(['ok' => true]); // PayU just needs a 2xx; it retries otherwise
    }

    // Shared by callback() and webhook(). Only an EXPLICIT failure status fails the
    // payment. "pending" and anything ambiguous fall through to verifyWithPayu(); if
    // that's inconclusive too, nothing is written and it stays "pending" for status()
    // polling / releaseStale() to resolve later — never silently marked failed.
    private function handleGatewayPost(array $p): void
    {
        $txnid   = (string) ($p['txnid'] ?? '');
        $payment = $txnid !== '' ? DB::table('payments')->where('txnid', $txnid)->first() : null;
        if (!$payment || $payment->status !== 'pending') {
            return; // unknown txnid, or already settled/failed — safe no-op
        }

        $hashOk = $this->reverseHashOk($p);
        $status = strtolower((string) ($p['status'] ?? ''));

        if ($hashOk && $status === 'success' && $this->sameAmount($p['amount'] ?? '', $payment->amount)) {
            $this->settle($payment->id, (string) ($p['mihpayid'] ?? ''), (string) ($p['mode'] ?? ''));
        } elseif ($hashOk && in_array($status, self::PAYU_FAILED, true)) {
            $this->fail($payment->id);
        } else {
            $v = $this->verifyWithPayu($txnid);
            if ($v && $v['status'] === 'success' && $this->sameAmount($v['amt'], $payment->amount)) {
                $this->settle($payment->id, $v['mihpayid'], $v['mode']);
            } elseif ($v && in_array($v['status'], self::PAYU_FAILED, true)) {
                $this->fail($payment->id);
            }
        }
    }

    public function status(Request $request): JsonResponse
    {
        $txn = (string) $request->query('txn', '');
        $p   = DB::table('payments')->where('txnid', $txn)->where('user_id', $request->user()->id)->first();
        abort_unless($p, 404);

        if ($p->status === 'pending' && $this->gatewayLive()) {
            $v = $this->verifyWithPayu($txn);
            if ($v) {
                if ($v['status'] === 'success' && $this->sameAmount($v['amt'], $p->amount)) {
                    $this->settle($p->id, $v['mihpayid'], $v['mode']);
                } elseif (in_array($v['status'], self::PAYU_FAILED, true)) {
                    $this->fail($p->id);
                }
            }
        }

        return response()->json([
            'status'  => DB::table('payments')->where('id', $p->id)->value('status'),
            'purpose' => $p->purpose,
        ]);
    }

    private function reportPrice(): int
    {
        return (int) Settings::get('report_price', config('rpk.report_price'));
    }

    private function sessionPrice(): int
    {
        return (int) Settings::get('session_price', config('rpk.session_price'));
    }

    private function gatewayLive(): bool
    {
        return (string) config('rpk.payu.key') !== '' && (string) config('rpk.payu.salt') !== '';
    }

    private function reportBal(int $uid): int
    {
        return max(0, (int) DB::table('points_ledger')->where('user_id', $uid)->where('account', 'report')->sum('points'));
    }

    private function hasPaidReport(int $uid): bool
    {
        return DB::table('payments')->where('user_id', $uid)->where('purpose', 'report')->where('status', 'success')
            ->where('paid_at', '>', now()->subDays((int) config('rpk.report_days')))->exists();
    }

    private function sameAmount($a, $b): bool
    {
        return abs((float) $a - (float) $b) < 0.005;
    }

    private function evalCoupon(int $uid, string $code, int $price): array
    {
        $c = DB::table('coupons')->where('code', $code)->first();

        if (!$c || !$c->active) {
            return ['ok' => false, 'message' => 'This coupon is not valid.'];
        }
        if ($c->expires_at && Carbon::parse($c->expires_at)->isPast()) {
            return ['ok' => false, 'message' => 'This coupon has expired.'];
        }
        if ($c->max_uses !== null && $c->used_count >= $c->max_uses) {
            return ['ok' => false, 'message' => 'This coupon has been fully used.'];
        }
        if (DB::table('coupon_redemptions')->where('coupon_id', $c->id)->where('user_id', $uid)->exists()) {
            return ['ok' => false, 'message' => 'You have already used this coupon.'];
        }

        $off = $c->type === 'percent' ? (int) round($price * $c->value / 100) : (int) round($c->value);
        $off = min($off, $price);

        if ($off <= 0) {
            return ['ok' => false, 'message' => 'This coupon is not valid.'];
        }

        return ['ok' => true, 'off' => $off, 'coupon' => $c];
    }

    private function sessionData(array $s): array
    {
        $date = (string) ($s['date'] ?? '');
        $min  = now()->addDay()->toDateString();
        $max  = now()->addDays(60)->toDateString();

        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) || $date < $min || $date > $max) {
            abort(422, 'Pick a date from tomorrow onwards.');
        }
        $slot = (string) ($s['slot'] ?? '');
        if (!in_array($slot, self::SLOTS, true)) {
            abort(422, 'Pick a valid time.');
        }
        $mode = (string) ($s['mode'] ?? '');
        if (!in_array($mode, self::MODES, true)) {
            abort(422, 'Pick how we should talk.');
        }
        $mobile = substr(preg_replace('/\D/', '', (string) ($s['mobile'] ?? '')), -10);
        if (!preg_match('/^[6-9]\d{9}$/', $mobile)) {
            abort(422, 'Enter a valid 10-digit mobile number.');
        }

        return [
            'date'   => $date,
            'slot'   => $slot,
            'mode'   => $mode,
            'mobile' => $mobile,
            'note'   => trim(mb_substr((string) ($s['note'] ?? ''), 0, 300)),
        ];
    }

    private function settle(int $id, string $payuId, string $mode): void
    {
        DB::transaction(function () use ($id, $payuId, $mode) {
            // lockForUpdate: callback(), webhook() and status() polling can all race to
            // settle the same payment within milliseconds. The lock serializes them;
            // the loser re-reads after the winner commits and sees status === 'success',
            // so it exits at the guard below instead of crediting twice.
            $p = DB::table('payments')->where('id', $id)->lockForUpdate()->first();
            if (!$p || $p->status === 'success') {
                return;
            }

            if ($p->status === 'failed' && $p->points_used > 0) {
                DB::table('points_ledger')->insert([
                    'user_id' => $p->user_id, 'account' => 'report', 'type' => 'report_redeem',
                    'points' => -$p->points_used, 'note' => 'Redeemed on ' . $p->txnid,
                    'created_at' => now(), 'updated_at' => now(),
                ]);
            }

            DB::table('payments')->where('id', $id)->update([
                'status' => 'success', 'payu_id' => substr($payuId, 0, 40), 'mode' => substr($mode, 0, 20),
                'paid_at' => now(), 'updated_at' => now(),
            ]);

            if ($p->purpose === 'report' && $p->coupon_code) {
                $c = DB::table('coupons')->where('code', $p->coupon_code)->first();
                if ($c) {
                    DB::table('coupon_redemptions')->insertOrIgnore([
                        'coupon_id' => $c->id, 'user_id' => $p->user_id, 'payment_id' => $id,
                        'created_at' => now(), 'updated_at' => now(),
                    ]);
                    DB::table('coupons')->where('id', $c->id)->increment('used_count');
                }
            }

            if ($p->purpose === 'session' && $p->ref_id) {
                DB::table('guidance_sessions')->where('id', $p->ref_id)->update(['status' => 'confirmed', 'updated_at' => now()]);
            }

            if ($p->purpose === 'wallet' && $p->pack !== null) {
                $pk = Settings::packs()[(int) $p->pack] ?? [0, 0];
                DB::table('points_ledger')->insert([
                    'user_id' => $p->user_id, 'account' => 'wallet', 'type' => 'wallet_purchase',
                    'points' => (int) $pk[0], 'note' => 'Bought ' . $pk[0] . ' points for Rs ' . $pk[1] . ' (' . $p->txnid . ')',
                    'created_at' => now(), 'updated_at' => now(),
                ]);
            }

            $u = DB::table('users')->find($p->user_id);
            DB::table('leads')->insert([
                'user_id' => $p->user_id,
                'event'   => $p->purpose === 'session' ? 'session_booked' : 'paid_' . $p->purpose,
                'mobile'  => $u->mobile ?? null,
                'email'   => $u->email ?? null,
                'payload' => json_encode([
                    'txnid' => $p->txnid, 'amount' => (float) $p->amount, 'coupon' => $p->coupon_code,
                    'points_used' => (int) $p->points_used, 'payu_id' => $payuId,
                ]),
                'created_at' => now(), 'updated_at' => now(),
            ]);
        });
    }

    private function fail(int $id): void
    {
        DB::transaction(function () use ($id) {
            // Same race as settle() — lock first so a concurrent settle()/fail() on
            // the same payment can't both act on a stale read.
            $p = DB::table('payments')->where('id', $id)->lockForUpdate()->first();
            if (!$p || $p->status !== 'pending') {
                return;
            }

            DB::table('payments')->where('id', $id)->update(['status' => 'failed', 'updated_at' => now()]);

            if ($p->points_used > 0) {
                DB::table('points_ledger')->insert([
                    'user_id' => $p->user_id, 'account' => 'report', 'type' => 'report_redeem_refund',
                    'points' => (int) $p->points_used, 'note' => 'Refund, payment not completed (' . $p->txnid . ')',
                    'created_at' => now(), 'updated_at' => now(),
                ]);
            }

            if ($p->purpose === 'session' && $p->ref_id) {
                DB::table('guidance_sessions')->where('id', $p->ref_id)->update(['status' => 'cancelled', 'updated_at' => now()]);
            }
        });
    }

    private function releaseStale(int $uid): void
    {
        $rows = DB::table('payments')->where('user_id', $uid)->where('status', 'pending')
            ->where('created_at', '<', now()->subMinutes(self::STALE_MINUTES))->get();

        foreach ($rows as $p) {
            if ((float) $p->amount <= 0) {
                $this->fail($p->id);
                continue;
            }

            $v = $this->gatewayLive() ? $this->verifyWithPayu($p->txnid) : null;

            if ($v && $v['status'] === 'success' && $this->sameAmount($v['amt'], $p->amount)) {
                $this->settle($p->id, $v['mihpayid'], $v['mode']);
            } elseif ($v && (in_array($v['status'], self::PAYU_FAILED, true) || str_contains($v['status'], 'not found'))) {
                $this->fail($p->id);
            } elseif (!$this->gatewayLive() || Carbon::parse($p->created_at)->lt(now()->subDay())) {
                $this->fail($p->id);
            }
        }
    }

    private function gatewayForm($user, $payment, string $info): array
    {
        $cfg    = config('rpk.payu');
        $amount = number_format((float) $payment->amount, 2, '.', '');
        $first  = trim(preg_replace('/[^A-Za-z0-9 ]/', '', (string) $user->name)) ?? 'Customer';
        $udf1   = (string) $payment->id;

        $fields = [
            'key'         => $cfg['key'],
            'txnid'       => $payment->txnid,
            'amount'      => $amount,
            'productinfo' => $info,
            'firstname'   => $first,
            'email'       => $user->email,
            'phone'       => $user->mobile,
            'surl'        => url('/payu/callback'),
            'furl'        => url('/payu/callback'),
            'udf1'        => $udf1,
        ];

        $fields['hash'] = hash('sha512', implode('|', array_merge(
            [$cfg['key'], $payment->txnid, $amount, $info, $first, $user->email, $udf1],
            array_fill(0, 9, ''),
            [$cfg['salt']]
        )));

        return [
            'action' => $cfg['env'] === 'live' ? 'https://secure.payu.in/_payment' : 'https://test.payu.in/_payment',
            'fields' => $fields,
        ];
    }

    private function reverseHashOk(array $p): bool
    {
        $cfg = config('rpk.payu');

        $parts = [
            $cfg['salt'], $p['status'] ?? '', '', '', '', '', '',
            $p['udf5'] ?? '', $p['udf4'] ?? '', $p['udf3'] ?? '', $p['udf2'] ?? '', $p['udf1'] ?? '',
            $p['email'] ?? '', $p['firstname'] ?? '', $p['productinfo'] ?? '', $p['amount'] ?? '', $p['txnid'] ?? '', $cfg['key'],
        ];
        if (isset($p['additionalCharges']) && $p['additionalCharges'] !== '') {
            array_unshift($parts, $p['additionalCharges']);
        }

        return hash_equals(hash('sha512', implode('|', $parts)), strtolower((string) ($p['hash'] ?? '')));
    }

    private function verifyWithPayu(string $txnid): ?array
    {
        if (!$this->gatewayLive()) {
            return null;
        }

        $cfg  = config('rpk.payu');
        $url  = $cfg['env'] === 'live'
            ? 'https://info.payu.in/merchant/postservice.php?form=2'
            : 'https://test.payu.in/merchant/postservice.php?form=2';
        $hash = hash('sha512', $cfg['key'] . '|verify_payment|' . $txnid . '|' . $cfg['salt']);

        try {
            $r = Http::asForm()->timeout(10)->post($url, [
                'key' => $cfg['key'], 'command' => 'verify_payment', 'var1' => $txnid, 'hash' => $hash,
            ]);
        } catch (\Throwable $e) {
            return null;
        }

        if (!$r->ok()) {
            return null;
        }

        $t = $r->json('transaction_details.' . $txnid);
        if (!is_array($t)) {
            return null;
        }

        return [
            'status'   => strtolower((string) ($t['status'] ?? '')),
            'amt'      => (string) ($t['amt'] ?? $t['transaction_amount'] ?? ''),
            'mihpayid' => (string) ($t['mihpayid'] ?? ''),
            'mode'     => (string) ($t['mode'] ?? ''),
        ];
    }
}