<?php

namespace App\Support;

use App\Http\Controllers\PayController;
use Illuminate\Support\Facades\DB;

/**
 * Changing a payment's status from the admin portal does the same things the PayU
 * callback would: confirm/cancel the linked session, credit a wallet pack, record a
 * coupon use, and give back points used at checkout.
 */
class PaymentEffects
{
    public const LABELS = [
        'success' => 'Marked as received.',
        'refunded' => 'Recorded as refunded.',
        'failed' => 'Marked as failed.',
        'pending' => 'Marked as pending.',
    ];

    public static function apply(int $paymentId, string $status): string
    {
        $p = DB::table('payments')->find($paymentId);
        if (!$p || $p->status === $status) {
            return 'No change.';
        }
        $pay = app(PayController::class);

        if ($status === 'success') {
            // settle() handles points, coupon, session, wallet pack and paid_at
            $pay->settle($p->id, $p->payu_id ?: 'ADMIN-MANUAL', $p->mode ?: 'Manual');
        } elseif ($status === 'failed' && $p->status === 'pending') {
            $pay->fail($p->id);
        } elseif ($status === 'refunded' && $p->status === 'success') {
            self::refund($p);
        } else {
            DB::table('payments')->where('id', $p->id)->update(['status' => $status, 'updated_at' => now()]);
        }

        Activity::log((int) $p->user_id, 'payment.status_updated', self::LABELS[$status] ?? 'Payment updated',
            ['payment_id' => $p->id, 'txnid' => $p->txnid, 'from' => $p->status, 'to' => $status], 'Payment', $p->id);

        return self::LABELS[$status] ?? 'Payment updated.';
    }

    private static function refund(object $p): void
    {
        DB::transaction(function () use ($p) {
            DB::table('payments')->where('id', $p->id)->update(['status' => 'refunded', 'updated_at' => now()]);

            if ($p->points_used > 0) {
                DB::table('points_ledger')->insert([
                    'user_id' => $p->user_id, 'account' => 'report', 'type' => 'report_redeem_refund',
                    'points' => (int) $p->points_used, 'note' => 'Refund (' . $p->txnid . ')',
                    'created_at' => now(), 'updated_at' => now(),
                ]);
            }
            if ($p->purpose === 'session' && $p->ref_id) {
                DB::table('guidance_sessions')->where('id', $p->ref_id)
                    ->update(['status' => 'cancelled', 'cancel_reason' => 'Payment refunded', 'updated_at' => now()]);
            }
            if ($p->purpose === 'wallet' && $p->pack !== null) {
                $pk = Settings::packs()[(int) $p->pack] ?? [0, 0];
                if ((int) $pk[0] > 0) {
                    DB::table('points_ledger')->insert([
                        'user_id' => $p->user_id, 'account' => 'wallet', 'type' => 'wallet_refund',
                        'points' => -(int) $pk[0], 'note' => 'Pack refunded (' . $p->txnid . ')',
                        'created_at' => now(), 'updated_at' => now(),
                    ]);
                }
            }
        });
    }
}
