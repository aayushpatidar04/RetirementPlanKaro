<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class WithdrawalController extends Controller
{
    public function show(Request $request): JsonResponse
    {
        $uid = $request->user()->id;
        $s = DB::table('swp_settings')->where('user_id', $uid)->first();

        return response()->json([
            'saved' => (bool) $s,
            'mode'  => $s->mode ?? 'mine',
            'show'  => $s->show_filter ?? 'all',
            'goals' => DB::table('life_goals')->where('user_id', $uid)->orderBy('id')
                ->get(['name', 'target_age as age', 'cost_today as amt']),
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $d = $request->validate([
            'mode'         => ['nullable', Rule::in(['mine', 'need'])],
            'show'         => ['nullable', Rule::in(['all', 'post'])],
            'goals'        => ['present', 'array', 'max:50'],
            'goals.*.name' => ['nullable', 'string', 'max:60'],
            'goals.*.age'  => ['nullable', 'numeric', 'min:0', 'max:120'],
            'goals.*.amt'  => ['nullable', 'numeric', 'min:0', 'max:10000000000000'],
        ]);

        $uid = $request->user()->id;
        $now = now();

        DB::transaction(function () use ($uid, $d, $now) {
            $vals = ['mode' => $d['mode'] ?? 'mine', 'show_filter' => $d['show'] ?? 'all', 'updated_at' => $now];

            if (DB::table('swp_settings')->where('user_id', $uid)->exists()) {
                DB::table('swp_settings')->where('user_id', $uid)->update($vals);
            } else {
                DB::table('swp_settings')->insert($vals + ['user_id' => $uid, 'created_at' => $now]);
            }

            DB::table('life_goals')->where('user_id', $uid)->delete();

            $rows = array_map(fn ($g) => [
                'user_id'    => $uid,
                'name'       => trim((string) ($g['name'] ?? '')) ?? 'Other goal',
                'target_age' => (float) ($g['age'] ?? 0),
                'cost_today' => (float) ($g['amt'] ?? 0),
                'created_at' => $now,
                'updated_at' => $now,
            ], array_values($d['goals']));

            if ($rows) {
                DB::table('life_goals')->insert($rows);
            }
        });

        return response()->json(['saved' => true]);
    }
}