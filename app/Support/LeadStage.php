<?php

namespace App\Support;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

/**
 * Lead stage of every client for Messages & Email (segments, stage → template mapping),
 * worked out from what the client actually did. The stage names are the ones the
 * Messages page already uses. A stage set by hand on the client page (Edit tags → Stage)
 * wins when it is one of these names.
 */
class LeadStage
{
    public const STAGES = [
        'Signed up', 'Payment pending', 'Payment failed',
        'Paid report', 'Wallet active', 'Session booked',
    ];

    /** Every client (or only $ids) with ->lead_stage added. */
    public static function clients(?array $ids = null): Collection
    {
        $users = DB::table('users')
            ->when($ids !== null, fn ($q) => $q->whereIn('id', $ids ?: [0]))
            ->orderBy('name')
            ->get(['id', 'name', 'surname', 'mobile', 'email', 'stage']);

        $uid = $users->pluck('id')->all() ?: [0];
        $pays = DB::table('payments')->whereIn('user_id', $uid)->orderBy('id')->get(['user_id', 'status', 'purpose'])->groupBy('user_id');
        $ses = DB::table('guidance_sessions')->whereIn('user_id', $uid)->whereIn('status', ['booked', 'confirmed', 'done'])
            ->pluck('user_id')->flip();

        return $users->map(function ($u) use ($pays, $ses) {
            $p = $pays[$u->id] ?? collect();
            $ok = fn (string $purpose) => $p->contains(fn ($x) => $x->purpose === $purpose && $x->status === 'success');
            $last = $p->last();

            $u->full_name = trim($u->name . ' ' . $u->surname);
            $u->lead_stage = match (true) {
                in_array($u->stage, self::STAGES, true) => $u->stage,
                isset($ses[$u->id]) => 'Session booked',
                $ok('wallet') => 'Wallet active',
                $ok('report') => 'Paid report',
                $last && $last->status === 'failed' => 'Payment failed',
                $last && $last->status === 'pending' => 'Payment pending',
                default => 'Signed up',
            };

            return $u;
        });
    }
}
