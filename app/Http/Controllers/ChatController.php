<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    private const SYSTEM = "You are Shubham, a friendly Indian personal-finance guide for RetirementPlanKaro.com. "
        . "Answer in simple English or Hinglish (match the user), in under 150 words, with short bullets when "
        . "useful. Give general education only, no stock tips. Mention assumptions and say to verify current "
        . "EPF/PPF/NPS/tax rates and rules since they change. If the question is not about money or retirement, "
        . "answer briefly and steer back.";

    public function reply(Request $request): JsonResponse
    {
        $key = config('services.anthropic.key');
        if (!$key) {
            return response()->json(['reply' => null]);
        }

        $d = $request->validate([
            'messages'           => ['required', 'array', 'min:1', 'max:20'],
            'messages.*.role'    => ['required', 'string', 'in:user,assistant'],
            'messages.*.content' => ['required', 'string', 'max:1500'],
        ]);

        $messages = collect($d['messages'])->slice(-8)->map(fn ($m) => [
            'role'    => $m['role'],
            'content' => mb_substr($m['content'], 0, 1500),
        ])->values()->all();

        try {
            $r = Http::withHeaders([
                'x-api-key'         => $key,
                'anthropic-version' => '2023-06-01',
            ])->timeout(20)->post('https://api.anthropic.com/v1/messages', [
                'model'      => config('services.anthropic.model', 'claude-sonnet-5-5'),
                'max_tokens' => 500,
                'system'     => self::SYSTEM,
                'messages'   => $messages,
            ]);
        } catch (\Throwable $e) {
            return response()->json(['reply' => null]);
        }

        if (!$r->ok()) {
            return response()->json(['reply' => null]);
        }

        $reply = trim(collect($r->json('content', []))->pluck('text')->implode(''));

        return response()->json(['reply' => $reply ?: null]);
    }
}