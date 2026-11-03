<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\Settings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmailVerificationController extends Controller
{
    // GET /email/verify/{id}/{hash} — the signed link from the email. No login needed in this browser.
    public function verify(Request $request, int $id, string $hash): RedirectResponse
    {
        $user = User::find($id);

        if (!$user || !hash_equals(sha1($user->getEmailForVerification()), $hash)) {
            return redirect('/?verified=0');
        }

        if (!$user->hasVerifiedEmail()) {
            $user->markEmailAsVerified();
            $this->creditReferrer($user);
        }

        return redirect('/?verified=1');
    }

    // POST /api/auth/verify/resend
    public function resend(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return response()->json(['sent' => false, 'already' => true]);
        }

        $user->sendEmailVerificationNotification();

        return response()->json(['sent' => true]);
    }

    private function creditReferrer(User $user): void
    {
        DB::transaction(function () use ($user) {
            $ref = DB::table('referrals')
                ->where('referred_user_id', $user->id)
                ->where('credited', false)
                ->lockForUpdate()
                ->first();

            if (!$ref) {
                return;
            }

            DB::table('points_ledger')->insert([
                'user_id' => $ref->referrer_user_id, 'account' => 'report', 'type' => 'referral_bonus',
                'points' => (int) Settings::get('referral_bonus', 100), 'note' => 'Referred ' . $user->name . ' (verified)',
                'created_at' => now(), 'updated_at' => now(),
            ]);
            DB::table('referrals')->where('id', $ref->id)->update(['credited' => true, 'updated_at' => now()]);
        });
    }
}