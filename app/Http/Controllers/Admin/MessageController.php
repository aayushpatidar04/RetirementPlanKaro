<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunicationLog;
use App\Models\MessageTemplate;
use App\Models\ScheduledMessage;
use App\Models\User;
use App\Support\Activity;
use App\Support\Settings;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

/**
 * Required model casts:
 *  CommunicationLog : recipient => array, sent_at => datetime
 *  ScheduledMessage : recipient => array, scheduled_at => datetime, sent_at => datetime, done => boolean
 */
class MessageController extends Controller
{
    public const SITE_LINK = 'https://retirementplankaro.com';

    private const LEAD_STAGES = [
        'Signed up', 'Payment pending', 'Payment failed',
        'Paid report', 'Wallet active', 'Session booked',
    ];

    private const SEGMENTS = [
        'paid'   => ['Paid report', 'Wallet active'],
        'unpaid' => ['Payment failed', 'Payment pending'],
        'wallet' => ['Wallet active'],
        'leads'  => ['Signed up'],
    ];

    /* ---------- helpers ---------- */

    public static function normalizePhone(?string $v): ?string
    {
        $d = preg_replace('/\D/', '', (string) $v);
        if (strlen($d) === 12 && str_starts_with($d, '91')) $d = substr($d, 2);
        elseif (strlen($d) === 11 && str_starts_with($d, '0')) $d = substr($d, 1);
        return preg_match('/^[6-9]\d{9}$/', $d) ? $d : null;
    }

    /** Replaces {friend} (first name), {name} (full name), {link}. */
    public static function render(string $body, ?string $name, bool $generic = false): string
    {
        $name = trim((string) $name);
        $anon = $generic || $name === '';
        $first = $anon ? 'Friend' : (preg_split('/\s+/', $name)[0] ?? 'Friend');
        $full = $anon ? 'Friend' : $name;
        return str_ireplace(['{friend}', '{name}', '{link}'], [$first, $full, self::SITE_LINK], $body);
    }

    private function fixedIds(Request $request): array
    {
        $f = $request->query('fixed', []);
        if (is_string($f)) {
            $f = json_decode($f, true) ?? explode(',', $f);
        }
        return array_values(array_filter(array_map('intval', (array) $f)));
    }

    private function recipientRows(string $segment, array $fixed, string $channel): array
    {
        if ($segment === 'new_only') return [];

        $col = $channel === 'wa' ? 'mobile' : 'email';
        $q = User::query()
            ->select('id', 'name', 'mobile', 'email', 'stage')
            ->whereNotNull($col)->where($col, '!=', '')
            ->orderBy('name');

        if ($segment === '__fixed') {
            $q->whereIn('id', $fixed ?: [0]);
        } elseif (str_starts_with($segment, 'stage_')) {
            $q->where('stage', substr($segment, 6));
        } elseif (isset(self::SEGMENTS[$segment])) {
            $q->whereIn('stage', self::SEGMENTS[$segment]);
        }

        return $q->get()->map(fn($u) => [
            'id'     => $u->id,
            'name'   => $u->name,
            'mobile' => $u->mobile,
            'email'  => $u->email,
            'phone'  => self::normalizePhone($u->mobile),
        ])->all();
    }

    private function logFilter($q, Request $r)
    {
        return $q
            ->when($r->filled('from'), fn($q) => $q->whereDate('sent_at', '>=', $r->from))
            ->when($r->filled('to'), fn($q) => $q->whereDate('sent_at', '<=', $r->to))
            ->when(in_array($r->log_channel, ['wa', 'em'], true), fn($q) => $q->where('channel', $r->log_channel));
    }

    private function openUrl(ScheduledMessage $m): ?string
    {
        $r = (array) $m->recipient;
        $body = self::render((string) $m->body, $r['name'] ?? null);
        if ($m->channel === 'wa') {
            $p = self::normalizePhone($r['mobile'] ?? null);
            return $p ? 'https://wa.me/91' . $p . '?text=' . rawurlencode($body) : null;
        }
        if (empty($r['email'])) return null;
        return 'https://mail.google.com/mail/?view=cm&fs=1&to=' . rawurlencode($r['email'])
            . '&su=' . rawurlencode((string) $m->subject) . '&body=' . rawurlencode($body);
    }

    private function backToTemplates(string $channel, $id = null): RedirectResponse
    {
        return redirect()->route('admin.messages', array_filter([
            'tab' => 'tpl', 'tpl_tab' => $channel, 'tpl_idx' => $id,
        ], fn($v) => $v !== null));
    }

    /* ---------- page ---------- */

    public function index(Request $request): View
    {
        $tab = in_array($request->query('tab'), ['send', 'act', 'tpl'], true) ? $request->query('tab') : 'send';
        $channel = $request->query('channel') === 'em' ? 'em' : 'wa';
        $segment = (string) $request->query('segment', 'all');
        $fixed = $this->fixedIds($request);
        $newTemplate = $request->boolean('new_template');

        $leadStages = self::LEAD_STAGES;
        $stageMapping = json_decode((string) Settings::get('message_stage_mapping'), true) ?: [];

        $waTemplates = MessageTemplate::where('channel', 'wa')->orderBy('name')->get();
        $emTemplates = MessageTemplate::where('channel', 'em')->orderBy('name')->get();

        $rows = [];
        $recommendedId = null;
        if ($tab === 'send') {
            $rows = $this->recipientRows($segment, $fixed, $channel);
            $stage = str_starts_with($segment, 'stage_') ? substr($segment, 6) : ($segment === 'leads' ? 'Signed up' : null);
            $recommendedId = $stage ? ($stageMapping[$stage][$channel] ?? null) : null;
        }

        $logsQuery = null;
        if ($tab === 'act') {
            $logsQuery = $this->logFilter(CommunicationLog::query(), $request)
                ->orderByDesc('sent_at')
                ->paginate(40, ['*'], 'logs_page')
                ->withQueryString();
        }

        // pending scheduled items (also needed for the tab badge)
        $pending = ScheduledMessage::where('status', 'scheduled')->where('done', false)
            ->orderBy('scheduled_at')->limit(200)->get();
        $pending->each(fn($m) => $m->setAttribute('open_url', $this->openUrl($m)));
        $dueCount = $pending->filter(fn($m) => Carbon::parse($m->scheduled_at)->lte(now()))->count();

        return view('admin.messages', [
            'tab' => $tab, 'channel' => $channel, 'segment' => $segment, 'fixed' => $fixed,
            'newTemplate' => $newTemplate, 'waTemplates' => $waTemplates, 'emTemplates' => $emTemplates,
            'rows' => $rows, 'leadStages' => $leadStages, 'recommendedId' => $recommendedId,
            'siteLink' => self::SITE_LINK, 'logsQuery' => $logsQuery,
            'pending' => $pending, 'dueCount' => $dueCount, 'stageMapping' => $stageMapping,
        ]);
    }

    /* ---------- templates ---------- */

    public function storeTemplate(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'channel' => 'required|in:wa,em',
            'subject' => 'nullable|string|max:255',
            'body' => 'required|string',
        ]);

        $template = MessageTemplate::create([
            'name' => $data['name'],
            'channel' => $data['channel'],
            'subject' => $data['channel'] === 'em' ? ($data['subject'] ?? null) : null,
            'body' => $data['body'],
        ]);

        Activity::log(null, 'message.template_created', "Template created: {$template->name}", $template->toArray(), 'MessageTemplate', $template->id);

        return $this->backToTemplates($template->channel, $template->id)->with('ok', 'Template created.');
    }

    public function updateTemplate(Request $request, $id): RedirectResponse
    {
        $template = MessageTemplate::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:100',
            'subject' => 'nullable|string|max:255',
            'body' => 'required|string',
        ]);

        // only touch columns the form actually sends (old code wiped is_default / stage_mapping)
        $template->update([
            'name' => $data['name'],
            'subject' => $template->channel === 'em' ? ($data['subject'] ?? null) : null,
            'body' => $data['body'],
        ]);

        Activity::log(null, 'message.template_updated', "Template updated: {$template->name}", $template->toArray(), 'MessageTemplate', $template->id);

        return $this->backToTemplates($template->channel, $template->id)->with('ok', 'Template updated.');
    }

    public function deleteTemplate(Request $request): RedirectResponse
    {
        $data = $request->validate(['id' => 'required|exists:message_templates,id']);

        $template = MessageTemplate::findOrFail($data['id']);
        $name = $template->name;
        $channel = $template->channel;
        $template->delete();

        Activity::log(null, 'message.template_deleted', "Template deleted: {$name}", ['id' => $data['id']], 'MessageTemplate', $data['id']);

        return $this->backToTemplates($channel)->with('ok', 'Template deleted.');
    }

    public function duplicateTemplate(Request $request): RedirectResponse
    {
        $data = $request->validate(['id' => 'required|exists:message_templates,id']);

        $template = MessageTemplate::findOrFail($data['id']);
        $new = $template->replicate();
        $new->name = $template->name . ' (copy)';
        $new->save();

        Activity::log(null, 'message.template_duplicated', "Template duplicated: {$new->name}", $new->toArray(), 'MessageTemplate', $new->id);

        return $this->backToTemplates($new->channel, $new->id)->with('ok', 'Template duplicated.');
    }

    public function saveStageMapping(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'stage_mapping' => 'required|array',
            'stage_mapping.*' => 'array',
            'stage_mapping.*.wa' => 'nullable|integer',
            'stage_mapping.*.em' => 'nullable|integer',
        ]);

        Settings::set('message_stage_mapping', json_encode($data['stage_mapping'], JSON_UNESCAPED_UNICODE));
        Activity::log(null, 'message.stage_mapping_saved', 'Lead-stage template mapping saved', $data['stage_mapping'], 'Settings', 'message_stage_mapping');

        return back()->with('ok', 'Stage mapping saved.');
    }

    /* ---------- sending ---------- */

    private const RECIPIENT_RULES = [
        'recipients' => 'required|array|min:1|max:500',
        'recipients.*.user_id' => 'nullable|integer|exists:users,id',
        'recipients.*.mobile' => 'nullable|string|max:20',
        'recipients.*.email' => 'nullable|email|max:255',
        'recipients.*.name' => 'nullable|string|max:150',
    ];

    public function send(Request $request): JsonResponse|RedirectResponse
    {
        $data = $request->validate(self::RECIPIENT_RULES + [
            'channel' => 'required|in:wa,em',
            'subject' => 'nullable|string|max:255',
            'body' => 'required|string|max:5000',
            'template_id' => 'nullable|integer',
            'generic' => 'nullable|boolean',
        ]);

        $generic = (bool) ($data['generic'] ?? false);
        $templateId = ($data['template_id'] ?? 0) > 0 ? $data['template_id'] : null;

        DB::transaction(function () use ($data, $generic, $templateId) {
            foreach ($data['recipients'] as $r) {
                CommunicationLog::create([
                    'user_id' => $r['user_id'] ?? null,
                    'channel' => $data['channel'],
                    'recipient' => [
                        'mobile' => self::normalizePhone($r['mobile'] ?? null) ?? ($r['mobile'] ?? null),
                        'email' => $r['email'] ?? null,
                        'name' => $r['name'] ?? null,
                    ],
                    'subject' => $data['subject'] ?? null,
                    'body' => self::render($data['body'], $r['name'] ?? null, $generic),
                    'status' => 'sent',
                    'template_id' => $templateId,
                    'sent_at' => now(),
                ]);
            }
        });

        $count = count($data['recipients']);
        Activity::log(null, 'message.bulk_sent', "Bulk {$data['channel']} sent to {$count} recipients", [
            'channel' => $data['channel'], 'count' => $count, 'template_id' => $templateId,
        ], 'CommunicationLog', null);

        return $request->expectsJson()
            ? response()->json(['ok' => true, 'count' => $count])
            : back()->with('ok', 'Messages logged.');
    }

    /* ---------- scheduled ---------- */

    public function schedule(Request $request): JsonResponse|RedirectResponse
    {
        $data = $request->validate(self::RECIPIENT_RULES + [
            'channel' => 'required|in:wa,em',
            'subject' => 'nullable|string|max:255',
            'body' => 'required|string|max:5000',
            'template_id' => 'nullable|integer',
            'scheduled_at' => 'required|date|after:now',
        ]);

        $templateId = ($data['template_id'] ?? 0) > 0 ? $data['template_id'] : null;

        DB::transaction(function () use ($data, $templateId) {
            foreach ($data['recipients'] as $r) {
                ScheduledMessage::create([
                    'channel' => $data['channel'],
                    'recipient' => $r,                     // ONE recipient per row
                    'subject' => $data['subject'] ?? null,
                    'body' => $data['body'],
                    'template_id' => $templateId,
                    'scheduled_at' => $data['scheduled_at'],
                    'status' => 'scheduled',
                    'done' => false,
                ]);
            }
        });

        $count = count($data['recipients']);
        Activity::log(null, 'message.scheduled', "{$count} message(s) scheduled for {$data['scheduled_at']}", [
            'channel' => $data['channel'], 'count' => $count, 'scheduled_at' => $data['scheduled_at'],
        ], 'ScheduledMessage', null);

        return $request->expectsJson()
            ? response()->json(['ok' => true, 'count' => $count])
            : back()->with('ok', "{$count} message(s) scheduled.");
    }

    public function sendScheduled(Request $request): RedirectResponse
    {
        $data = $request->validate(['id' => 'required|exists:scheduled_messages,id']);

        $result = DB::transaction(function () use ($data) {
            $msg = ScheduledMessage::lockForUpdate()->findOrFail($data['id']);
            if ($msg->done || $msg->status !== 'scheduled') {
                return null;
            }

            $r = (array) $msg->recipient;    // a single recipient (old code looped over its fields)
            CommunicationLog::create([
                'user_id' => $r['user_id'] ?? null,
                'channel' => $msg->channel,
                'recipient' => [
                    'mobile' => $r['mobile'] ?? null,
                    'email' => $r['email'] ?? null,
                    'name' => $r['name'] ?? null,
                ],
                'subject' => $msg->subject,
                'body' => self::render((string) $msg->body, $r['name'] ?? null),
                'status' => 'sent',
                'template_id' => $msg->template_id,
                'sent_at' => now(),
            ]);

            $msg->update(['done' => true, 'sent_at' => now(), 'status' => 'sent']);
            return $msg;
        });

        if (!$result) {
            return back()->withErrors('This message was already sent or cancelled.');
        }

        Activity::log(null, 'message.scheduled_sent', "Scheduled message sent: {$result->id}", $result->toArray(), 'ScheduledMessage', $result->id);

        return back()->with('ok', 'Message sent and logged.');
    }

    public function cancelScheduled(Request $request): RedirectResponse
    {
        $data = $request->validate(['id' => 'required|exists:scheduled_messages,id']);

        $msg = ScheduledMessage::findOrFail($data['id']);
        if ($msg->done || $msg->status !== 'scheduled') {
            return back()->withErrors('This message was already sent or cancelled.');
        }
        $msg->update(['status' => 'cancelled', 'done' => true]);   // done=true so it leaves the pending list

        Activity::log(null, 'message.scheduled_cancelled', "Scheduled message cancelled: {$msg->id}", $msg->toArray(), 'ScheduledMessage', $msg->id);

        return back()->with('ok', 'Scheduled message cancelled.');
    }

    /* ---------- exports (JSON -> xlsx() helper in the browser) ---------- */

    public function exportLogs(Request $request): JsonResponse
    {
        $rows = $this->logFilter(CommunicationLog::query(), $request)
            ->orderByDesc('sent_at')->limit(5000)->get()
            ->map(function ($log) {
                $r = (array) $log->recipient;
                return [
                    $log->sent_at ? Carbon::parse($log->sent_at)->format('d M Y H:i') : '',
                    ($r['name'] ?? '') ?: (($r['mobile'] ?? '') ?: ($r['email'] ?? '')),
                    $log->channel === 'wa' ? 'WhatsApp' : 'Email',
                    $log->subject ?? '',
                    $log->status,
                ];
            })->all();

        return response()->json([
            'filename' => 'Communication_Logs_' . now()->format('Ymd') . '.xlsx',
            'sheets' => [[
                'name' => 'Communication Logs',
                'title' => 'Communication Logs',
                'head' => ['Date', 'Recipient', 'Channel', 'Subject', 'Status'],
                'rows' => $rows,
            ]],
        ]);
    }

    public function exportTemplates(): JsonResponse
    {
        $wa = MessageTemplate::where('channel', 'wa')->orderBy('name')->get()
            ->map(fn($t) => [$t->name, $t->body])->all();
        $em = MessageTemplate::where('channel', 'em')->orderBy('name')->get()
            ->map(fn($t) => [$t->name, $t->subject ?? '', $t->body])->all();

        return response()->json([
            'filename' => 'Message_Templates_' . now()->format('Ymd') . '.xlsx',
            'sheets' => [
                ['name' => 'WhatsApp Templates', 'title' => 'WhatsApp Templates', 'head' => ['Template Name', 'Message'], 'rows' => $wa],
                ['name' => 'Email Templates', 'title' => 'Email Templates', 'head' => ['Template Name', 'Subject', 'Message'], 'rows' => $em],
            ],
        ]);
    }
}