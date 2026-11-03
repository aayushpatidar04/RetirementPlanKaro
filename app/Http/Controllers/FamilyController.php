<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class FamilyController extends Controller
{
    private const REL    = ['Self', 'Spouse', 'Father', 'Mother', 'Son', 'Daughter', 'Brother', 'Sister', 'Grandparent', 'Other'];
    private const HEALTH = ['None', 'Individual', 'Family floater', 'Employer (group) only'];
    private const WHERE  = ['Savings account', 'Liquid fund or FD', 'Both', 'Not kept separately'];

    public function index(Request $request): JsonResponse
    {
        $members = DB::table('family_members')
            ->where('user_id', $request->user()->id)
            ->orderBy('id')
            ->get();

        return response()->json(['members' => $members]);
    }

    public function store(Request $request): JsonResponse
    {
        $d = $this->validated($request);
        $id = DB::table('family_members')->insertGetId($d + [
            'user_id'    => $request->user()->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['member' => DB::table('family_members')->find($id)], 201);
    }

    public function update(Request $request, int $id): JsonResponse
    {
        $row = DB::table('family_members')->where('id', $id)->where('user_id', $request->user()->id)->first();
        if (!$row) {
            abort(404);
        }

        $d = $this->validated($request);
        DB::table('family_members')->where('id', $id)->update($d + ['updated_at' => now()]);

        return response()->json(['member' => DB::table('family_members')->find($id)]);
    }

    public function destroy(Request $request, int $id): JsonResponse
    {
        $deleted = DB::table('family_members')->where('id', $id)->where('user_id', $request->user()->id)->delete();
        if (!$deleted) {
            abort(404);
        }

        return response()->json(['ok' => true]);
    }

    private function validated(Request $request): array
    {
        $d = $request->validate([
            'name' => ['required', 'string', 'max:60'],
            'rel'  => ['required', Rule::in(self::REL)],
            'age'  => ['required', 'numeric', 'min:0', 'max:110'],
            'inc'  => $this->money(), 'exp' => $this->money(), 'liq' => $this->money(),
            'ill'  => $this->money(), 'debt' => $this->money(), 'sip' => $this->money(),
            'tm'   => ['nullable', Rule::in(['Yes', 'No'])],
            'lc'   => $this->money(), 'tp' => $this->money(), 'tt' => ['nullable', 'numeric', 'min:0', 'max:120'],
            'hs'   => ['nullable', Rule::in(self::HEALTH)],
            'hc'   => $this->money(), 'hp' => $this->money(),
            'ht'   => ['nullable', Rule::in(['Yes', 'No'])],
            'ef'   => $this->money(),
            'ew'   => ['nullable', Rule::in(self::WHERE)],
        ]);

        return [
            'name' => $d['name'], 'rel' => $d['rel'], 'age' => $d['age'],
            'inc' => $d['inc'] ?? 0, 'exp' => $d['exp'] ?? 0, 'liq' => $d['liq'] ?? 0,
            'ill' => $d['ill'] ?? 0, 'debt' => $d['debt'] ?? 0, 'sip' => $d['sip'] ?? 0,
            'tm' => $d['tm'] ?? 'No', 'lc' => $d['lc'] ?? 0, 'tp' => $d['tp'] ?? 0, 'tt' => $d['tt'] ?? 0,
            'hs' => $d['hs'] ?? 'None', 'hc' => $d['hc'] ?? 0, 'hp' => $d['hp'] ?? 0,
            'ht' => $d['ht'] ?? 'No', 'ef' => $d['ef'] ?? 0, 'ew' => $d['ew'] ?? 'Savings account',
        ];
    }

    private function money(): array
    {
        return ['nullable', 'numeric', 'min:0', 'max:10000000000000'];
    }
}