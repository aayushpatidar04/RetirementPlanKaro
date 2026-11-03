<?php

namespace App\Http\Controllers;

use App\Support\Settings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PointsController extends Controller
{
    public function balance(Request $request): JsonResponse
    {
        $uid = $request->user()->id;
        $streakDays = (int) Settings::get('streak_days', 7);

        $report  = (int) DB::table('points_ledger')->where('user_id', $uid)->where('account', 'report')->sum('points');
        $wallet  = (int) DB::table('points_ledger')->where('user_id', $uid)->where('account', 'wallet')->sum('points');
        $friends = DB::table('referrals')->where('referrer_user_id', $uid)->count();

        $s         = DB::table('user_streaks')->where('user_id', $uid)->first();
        $today     = now()->toDateString();
        $yesterday = now()->subDay()->toDateString();
        $day       = $s->day ?? 0;
        $isToday   = false;

        if ($s) {
            if ($s->last_date === $today) {
                $isToday = true;
            } elseif ($s->last_date !== $yesterday || $day >= $streakDays) {
                $day = 0;
            }
        }

        return response()->json([
            'report'  => max(0, $report),
            'wallet'  => max(0, $wallet),
            'friends' => $friends,
            'code'    => $request->user()->referral_code,
            'streak'  => ['day' => $day, 'today' => $isToday],
        ]);
    }

    public function streakCheck(Request $request): JsonResponse
    {
        $uid        = $request->user()->id;
        $today      = now()->toDateString();
        $yesterday  = now()->subDay()->toDateString();
        $streakDays = (int) Settings::get('streak_days', 7);
        $dayPts     = (int) Settings::get('streak_points', 50);

        return DB::transaction(function () use ($uid, $today, $yesterday, $streakDays, $dayPts) {
            DB::table('user_streaks')->insertOrIgnore([
                'user_id' => $uid, 'last_date' => null, 'day' => 0,
                'created_at' => now(), 'updated_at' => now(),
            ]);

            $s = DB::table('user_streaks')->where('user_id', $uid)->lockForUpdate()->first();

            if ($s->last_date === $today) {
                return response()->json(['credited' => false]);
            }

            $day = ($s->last_date === $yesterday && $s->day < $streakDays) ? $s->day + 1 : 1;

            DB::table('user_streaks')->where('user_id', $uid)->update([
                'last_date' => $today, 'day' => $day, 'updated_at' => now(),
            ]);

            DB::table('points_ledger')->insert([
                'user_id' => $uid, 'account' => 'report', 'type' => 'streak_bonus',
                'points' => $dayPts, 'note' => 'Day ' . $day . ' streak',
                'created_at' => now(), 'updated_at' => now(),
            ]);

            return response()->json(['credited' => true, 'day' => $day, 'points' => $dayPts]);
        });
    }
}