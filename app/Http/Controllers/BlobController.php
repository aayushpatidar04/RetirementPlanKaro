<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BlobController extends Controller
{
    private const KINDS = ['budget'];

    public function index(Request $request): JsonResponse
    {
        $out = ['budget' => null];

        $rows = DB::table('user_blobs')->where('user_id', $request->user()->id)->get(['kind', 'data']);
        foreach ($rows as $r) {
            $out[$r->kind] = json_decode($r->data, true);
        }

        return response()->json($out);
    }

    public function put(Request $request, string $kind): JsonResponse
    {
        abort_unless(in_array($kind, self::KINDS, true), 404);

        $d    = $request->validate(['data' => ['present', 'array']]);
        $json = json_encode($d['data']);
        if (strlen($json) > 200000) {
            abort(422, 'Too much data.');
        }

        DB::table('user_blobs')->updateOrInsert(
            ['user_id' => $request->user()->id, 'kind' => $kind],
            ['data' => $json, 'updated_at' => now(), 'created_at' => now()]
        );

        return response()->json(['saved' => true]);
    }
}