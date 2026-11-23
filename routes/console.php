<?php

use App\Http\Controllers\Admin\MessageController;
use App\Models\CommunicationLog;
use App\Models\ScheduledMessage;
use App\Support\ClientMail;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
 * Scheduled emails (Messages & Email → Schedule) go out on their own once due.
 * Scheduled WhatsApp messages can't be sent automatically (they open in WhatsApp),
 * so they stay in the Activity tab with a "due" badge in the admin menu.
 *
 * Server cron (every minute):  * * * * * cd /path/to/app && php artisan schedule:run >> /dev/null 2>&1
 */
Artisan::command('messages:send-due', function () {
    $due = ScheduledMessage::where('status', 'scheduled')->where('done', false)
        ->where('channel', 'em')->where('scheduled_at', '<=', now())->orderBy('scheduled_at')->limit(200)->get();

    $sent = 0;
    $failed = 0;
    foreach ($due as $m) {
        DB::transaction(function () use ($m, &$sent, &$failed) {
            $msg = ScheduledMessage::lockForUpdate()->find($m->id);
            if (!$msg || $msg->done || $msg->status !== 'scheduled') {
                return;
            }
            $r = (array) $msg->recipient;
            $body = MessageController::render((string) $msg->body, $r['name'] ?? null);
            $ok = ClientMail::send($r['email'] ?? null, (string) $msg->subject, $body);
            CommunicationLog::create([
                'user_id' => $r['user_id'] ?? null,
                'channel' => 'em',
                'recipient' => ['mobile' => $r['mobile'] ?? null, 'email' => $r['email'] ?? null, 'name' => $r['name'] ?? null],
                'subject' => $msg->subject,
                'body' => $body,
                'status' => $ok ? 'sent' : 'failed',
                'template_id' => $msg->template_id,
                'sent_at' => now(),
            ]);
            $msg->update(['done' => true, 'sent_at' => now(), 'status' => $ok ? 'sent' : 'failed']);
            $ok ? $sent++ : $failed++;
        });
    }

    $this->info("Scheduled emails sent: {$sent}, failed: {$failed}");
})->purpose('Send scheduled emails that are due');

Schedule::command('messages:send-due')->everyMinute()->withoutOverlapping();
