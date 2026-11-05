<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Support\Settings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public function register(RegisterRequest $request): JsonResponse
    {
        $d = $request->validated(); 

        $referrer = null;
        if (!empty($d['ref'])) {
            $referrer = User::where('referral_code', $d['ref'])->first();
        }

        $user = DB::transaction(function () use ($d, $referrer) {
            $user = User::create([
                'name'             => $d['name'],
                'surname'          => $d['surname'],
                'mobile'           => $d['mobile'],
                'email'            => $d['email'],
                'city'             => $d['city'],
                'pan'              => $d['pan'] ?? null,
                'password'         => $d['password'],
                'referral_code'    => $this->makeCode(),
                'referred_by_code' => $referrer?->referral_code,
                'share_consent'    => (bool) ($d['share'] ?? false),
                'consented_at'     => now(),
            ]);

            // Welcome bonus is not gated by email verification.
            DB::table('points_ledger')->insert([
                'user_id' => $user->id, 'account' => 'wallet', 'type' => 'signup_bonus',
                'points' => (int) Settings::get('welcome_bonus', 600), 'note' => 'Welcome bonus',
                'created_at' => now(), 'updated_at' => now(),
            ]);

            // Referral is recorded now, but the referrer is paid only once this user verifies their email.
            if ($referrer && $referrer->id !== $user->id) {
                DB::table('referrals')->insert([
                    'referrer_user_id' => $referrer->id, 'referred_user_id' => $user->id,
                    'credited' => false, 'created_at' => now(), 'updated_at' => now(),
                ]);
            }

            return $user;
        });

        Auth::login($user, true);
        $request->session()->regenerate();
        $user->sendEmailVerificationNotification();

        return response()->json([
            'user' => $this->payload($user),
            'csrf' => csrf_token(),
        ], 201);
    }

    public function login(Request $request): JsonResponse
    {
        $data = $request->validate([
            'identifier' => ['required', 'string', 'max:190'],
            'password'   => ['required', 'string'],
        ]);

        $id = strtolower(trim($data['identifier']));
        if (filter_var($id, FILTER_VALIDATE_EMAIL)) {
            $field = 'email';
        } else {
            $field = 'mobile';
            $id = preg_replace('/\D/', '', $id);
            if (strlen($id) === 12 && str_starts_with($id, '91')) {
                $id = substr($id, 2);
            }
        }

        $user = User::where($field, $id)->first();
        if ($user && (($user->status === 'Blocked') || !empty($user->suspended_at))) {
            return response()->json([
                'message' => 'Your account has been suspended. Please contact support.',
                'errors' => ['identifier' => ['Your account has been suspended. Please contact support.']],
                'suspended' => true,
            ], 403);
        }

        if (!Auth::attempt([$field => $id, 'password' => $data['password']], true)) {
            return response()->json([
                'message' => 'Login failed',
                'errors'  => ['identifier' => ['No account found, or the password is wrong. Please check and try again.']],
            ], 422);
        }

        $request->session()->regenerate();

        return response()->json([
            'user' => $this->payload(Auth::user()),
            'csrf' => csrf_token(),
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['ok' => true, 'csrf' => csrf_token()]);
    }

    public function me(Request $request): JsonResponse
    {
        $u = $request->user();

        return response()->json([
            'user' => $u ? $this->payload($u) : null,
            'csrf' => csrf_token(),
        ]);
    }

    private function makeCode(): string
    {
        do {
            $c = 'RPK' . strtoupper(Str::random(6));
        } while (User::where('referral_code', $c)->exists());

        return $c;
    }

    private function payload(User $u): array
    {
        return [
            'name'     => $u->name,
            'surname'  => $u->surname,
            'mobile'   => $u->mobile,
            'email'    => $u->email,
            'city'     => $u->city,
            'code'     => $u->referral_code,
            'refBy'    => $u->referred_by_code,
            'verified' => (bool) $u->email_verified_at,
            'consent'  => ['terms' => true, 'risk' => true, 'share' => (bool) $u->share_consent],
        ];
    }
}