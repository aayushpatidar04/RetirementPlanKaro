<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LeadController extends Controller
{
    // The page already fires leads through CFG.hook as plain-text JSON; CFG.hook now points here.
    public function store(Request $request)
    {
        $raw = $request->getContent();
        if ($raw === '' || strlen($raw) > 20000) {
            return response()->noContent();
        }

        $d = json_decode($raw, true);
        if (!is_array($d)) {
            return response()->noContent();
        }

        $event  = substr((string) ($d['ev'] ?? $d['type'] ?? 'lead'), 0, 60);
        $mobile = isset($d['mobile']) ? substr(preg_replace('/\D/', '', (string) $d['mobile']), -10) : null;
        $mobile = $mobile ?: null;
        $email  = isset($d['email']) ? substr((string) $d['email'], 0, 190) : null;

        // "signup" fires on every login in the page: keep one row per person
        if ($event === 'signup' && $mobile && DB::table('leads')->where('event', 'signup')->where('mobile', $mobile)->exists()) {
            return response()->noContent();
        }

        // Never store a PAN number in leads
        if (isset($d['details']['pan'])) {
            $d['details']['pan'] = '(provided)';
        }

        DB::table('leads')->insert([
            'user_id'    => $request->user()?->id,
            'event'      => $event,
            'mobile'     => $mobile,
            'email'      => $email,
            'payload'    => json_encode($d),
            'ip'         => $request->ip(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->noContent();
    }
}