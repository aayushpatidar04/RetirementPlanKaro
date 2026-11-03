<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChecklistController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $keys = DB::table('checklist_items')
            ->where('user_id', $request->user()->id)
            ->where('is_checked', true)
            ->pluck('item_key');

        return response()->json(['checked' => $keys]);
    }

    public function toggle(Request $request): JsonResponse
    {
        $d = $request->validate([
            'item_key'   => ['required', 'regex:/^(20s|30s|40s|50s|60p)-\d{1,2}$/'],
            'is_checked' => ['required', 'boolean'],
        ]);

        $on = (bool) $d['is_checked'];
        $now = now();

        DB::table('checklist_items')->updateOrInsert(
            ['user_id' => $request->user()->id, 'item_key' => $d['item_key']],
            [
                'age_group'  => explode('-', $d['item_key'])[0],
                'is_checked' => $on,
                'checked_at' => $on ? $now : null,
                'updated_at' => $now,
                'created_at' => $now,
            ]
        );

        return response()->json(['saved' => true]);
    }
}