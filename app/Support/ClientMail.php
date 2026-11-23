<?php

namespace App\Support;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Plain-text email to a client from the admin portal, through the app's mailer
 * (MAIL_* in .env). Locally MAIL_MAILER=log writes the email to storage/logs instead of sending.
 */
class ClientMail
{
    /** @return bool true when the mailer accepted the message */
    public static function send(?string $to, string $subject, string $body): bool
    {
        $to = trim((string) $to);
        if (!filter_var($to, FILTER_VALIDATE_EMAIL)) {
            return false;
        }
        try {
            Mail::raw($body, function ($m) use ($to, $subject) {
                $m->to($to)->subject($subject !== '' ? $subject : 'Retirement Plan Karo');
            });

            return true;
        } catch (\Throwable $e) {
            Log::warning('Client email failed', ['to' => $to, 'error' => $e->getMessage()]);

            return false;
        }
    }
}
