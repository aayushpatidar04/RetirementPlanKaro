<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Support\ReferralProgramme;
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
        // rules (on/off, bonus, friend bonus, max per client) live in Referrals → Reward settings
        ReferralProgramme::credit($user->id, 'verified');
    }
}
