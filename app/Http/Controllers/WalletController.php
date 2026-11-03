<?php

namespace App\Http\Controllers;

use App\Support\Settings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class WalletController extends Controller
{
    private const OPTIONS = ['returns', 'portfolio', 'tax', 'sip', 'emi', 'budget'];

    public function status(Request $request): JsonResponse
    {
        $uid = $request->user()->id;

        $rows = DB::table('wallet_unlocks')->where('user_id', $uid)->where('expires_at', '>', now())
            ->get(['option_key', 'expires_at']);

        $unlocks = [];
        foreach ($rows as $r) {
            $unlocks[$r->option_key] = Carbon::parse($r->expires_at)->toIso8601String();
        }

        return response()->json(['balance' => $this->bal($uid), 'unlocks' => $unlocks]);
    }

    public function unlock(Request $request): JsonResponse
    {
        $d   = $request->validate(['key' => ['required', Rule::in(self::OPTIONS)]]);
        $uid = $request->user()->id;
        $per = (int) Settings::get('wallet_unlock_cost', 200);
        $hrs = (int) Settings::get('wallet_unlock_hours', 24);

        return DB::transaction(function () use ($uid, $d, $per, $hrs) {
            DB::table('users')->where('id', $uid)->lockForUpdate()->first();

            $existing = DB::table('wallet_unlocks')->where('user_id', $uid)->where('option_key', $d['key'])->first();
            if ($existing && $existing->expires_at > now()->toDateTimeString()) {
                return response()->json([
                    'balance'    => $this->bal($uid),
                    'expires_at' => Carbon::parse($existing->expires_at)->toIso8601String(),
                ]);
            }

            if ($this->bal($uid) < $per) {
                return response()->json(['message' => 'Not enough points.'], 422);
            }

            $expires = now()->addHours($hrs);

            DB::table('points_ledger')->insert([
                'user_id' => $uid, 'account' => 'wallet', 'type' => 'wallet_unlock_debit',
                'points' => -$per, 'note' => 'Unlocked ' . $d['key'],
                'created_at' => now(), 'updated_at' => now(),
            ]);

            DB::table('wallet_unlocks')->updateOrInsert(
                ['user_id' => $uid, 'option_key' => $d['key']],
                ['expires_at' => $expires, 'unlocked_at' => now(), 'updated_at' => now(), 'created_at' => now()]
            );

            return response()->json(['balance' => $this->bal($uid), 'expires_at' => $expires->toIso8601String()]);
        });
    }

    private function bal(int $uid): int
    {
        return max(0, (int) DB::table('points_ledger')->where('user_id', $uid)->where('account', 'wallet')->sum('points'));
    }
}