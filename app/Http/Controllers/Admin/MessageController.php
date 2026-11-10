<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunicationLog;
use App\Models\MessageTemplate;
use App\Models\ScheduledMessage;
use App\Models\User;
use App\Support\Activity;
use App\Support\Settings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(Request $request): View
    {
        $tab = $request->query('tab', 'send'); // send, act, tpl
        $channel = $request->query('channel', 'wa'); // wa, em

        // Get templates
        $waTemplates = MessageTemplate::where('channel', 'wa')->orderBy('name')->get();
        $emTemplates = MessageTemplate::where('channel', 'em')->orderBy('name')->get();

        // Get users for recipient selection
        $users = User::select('id', 'name', 'mobile', 'email', 'stage', 'created_at')
            ->orderBy('name')
            ->get();
        // Lead stages for segmentation
        $leadStages = [
            'Signed up',
            'Payment pending',
            'Payment failed',
            'Paid report',
            'Wallet active',
            'Session booked',
        ];

        // Communication logs (sent messages)
        $logsQuery = CommunicationLog::with('user:id,name,mobile,email')
            ->when($request->filled('from'), fn($q) => $q->whereDate('sent_at', '>=', $request->from))
            ->when($request->filled('to'), fn($q) => $q->whereDate('sent_at', '<=', $request->to))
            ->when($request->filled('channel'), fn($q) => $q->where('channel', $request->channel))
            ->orderByDesc('sent_at')
            ->paginate(40)
            ->withQueryString();

        // Scheduled messages
        $scheduled = ScheduledMessage::orderBy('scheduled_at')->paginate(40)->withQueryString();

        // Default templates per stage (from settings)
        $stageMapping = Settings::get('message_stage_mapping');
        $stageMapping = $stageMapping ? json_decode($stageMapping, true) : [];

        return view('admin.messages', compact(
            'tab',
            'channel',
            'waTemplates',
            'emTemplates',
            'users',
            'leadStages',
            'logsQuery',
            'scheduled',
            'stageMapping'
        ));
    }

    // ===== TEMPLATES =====

    public function storeTemplate(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'channel' => 'required|in:wa,em',
            'subject' => 'nullable|string|max:255',
            'body' => 'required|string',
            'is_default' => 'nullable|boolean',
            'stage_mapping' => 'nullable|array',
        ]);

        $template = MessageTemplate::create([
            'name' => $data['name'],
            'channel' => $data['channel'],
            'subject' => $data['subject'] ?? null,
            'body' => $data['body'],
            'is_default' => $request->boolean('is_default'),
            'stage_mapping' => $data['stage_mapping'] ?? null,
        ]);

        Activity::log(null, 'message.template_created', "Template created: {$template->name}", $template->toArray(), 'MessageTemplate', $template->id);

        return back()->with('ok', 'Template created.');
    }

    public function updateTemplate(Request $request, $id): RedirectResponse
    {
        $template = MessageTemplate::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:100',
            'subject' => 'nullable|string|max:255',
            'body' => 'required|string',
            'is_default' => 'nullable|boolean',
            'stage_mapping' => 'nullable|array',
        ]);

        $template->update([
            'name' => $data['name'],
            'subject' => $data['subject'] ?? null,
            'body' => $data['body'],
            'is_default' => $request->boolean('is_default'),
            'stage_mapping' => $data['stage_mapping'] ?? null,
        ]);

        Activity::log(null, 'message.template_updated', "Template updated: {$template->name}", $template->toArray(), 'MessageTemplate', $template->id);

        return back()->with('ok', 'Template updated.');
    }

    public function deleteTemplate(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id' => 'required|exists:message_templates,id',
        ]);

        $template = MessageTemplate::findOrFail($data['id']);
        $name = $template->name;
        $template->delete();

        Activity::log(null, 'message.template_deleted', "Template deleted: {$name}", ['id' => $data['id']], 'MessageTemplate', $data['id']);

        return back()->with('ok', 'Template deleted.');
    }

    public function duplicateTemplate(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id' => 'required|exists:message_templates,id',
        ]);

        $template = MessageTemplate::findOrFail($data['id']);
        $new = $template->replicate();
        $new->name = $template->name . ' (copy)';
        $new->save();

        Activity::log(null, 'message.template_duplicated', "Template duplicated: {$new->name}", $new->toArray(), 'MessageTemplate', $new->id);

        return back()->with('ok', 'Template duplicated.');
    }

    public function saveStageMapping(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'stage_mapping' => 'required|array',
        ]);

        Settings::set('message_stage_mapping', json_encode($data['stage_mapping'], JSON_UNESCAPED_UNICODE));
        Activity::log(null, 'message.stage_mapping_saved', 'Lead-stage template mapping saved', $data['stage_mapping'], 'Settings', 'message_stage_mapping');

        return back()->with('ok', 'Stage mapping saved.');
    }

    // ===== SEND MESSAGES =====

    public function send(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'channel' => 'required|in:wa,em',
            'recipients' => 'nullable|array',
            'recipient' => 'nullable|array',
            'subject' => 'nullable|string|max:255',
            'body' => 'required|string',
            'template_id' => 'nullable|string',
        ]);

        // Support both single recipient and array of recipients
        $recipients = $data['recipients'] ?? [$data['recipient']];

        foreach ($recipients as $recipient) {
            CommunicationLog::create([
                'user_id' => $recipient['user_id'] ?? null,
                'channel' => $data['channel'],
                'recipient' => [
                    'mobile' => $recipient['mobile'] ?? null,
                    'email' => $recipient['email'] ?? null,
                    'name' => $recipient['name'] ?? null,
                ],
                'subject' => $data['subject'] ?? null,
                'body' => $data['body'],
                'status' => 'sent',
                'template_id' => $data['template_id'] ?? null,
                'sent_at' => now(),
            ]);
        }

        Activity::log(null, 'message.bulk_sent', "Bulk {$data['channel']} sent to " . count($recipients) . " recipients", [
            'channel' => $data['channel'],
            'count' => count($recipients),
            'template_id' => $data['template_id'] ?? null,
        ], 'CommunicationLog', null);

        return back()->with('ok', 'Messages logged.');
    }

    // ===== SCHEDULED MESSAGES =====

    public function schedule(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'channel' => 'required|in:wa,em',
            'recipient' => 'required|array',
            'subject' => 'nullable|string|max:255',
            'body' => 'required|string',
            'template_id' => 'nullable|string',
            'scheduled_at' => 'required|date',
        ]);

        ScheduledMessage::create([
            'channel' => $data['channel'],
            'recipient' => $data['recipient'],
            'subject' => $data['subject'] ?? null,
            'body' => $data['body'],
            'template_id' => $data['template_id'] ?? null,
            'scheduled_at' => $data['scheduled_at'],
            'status' => 'scheduled',
        ]);

        Activity::log(null, 'message.scheduled', "Message scheduled for {$data['scheduled_at']}", $data, 'ScheduledMessage', null);

        return back()->with('ok', 'Message scheduled.');
    }

    public function sendScheduled(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id' => 'required|exists:scheduled_messages,id',
        ]);

        $msg = ScheduledMessage::findOrFail($data['id']);

        // Log as sent
        foreach ((array)$msg->recipient as $recipient) {
            CommunicationLog::create([
                'user_id' => $recipient['user_id'] ?? null,
                'channel' => $msg->channel,
                'recipient' => $recipient,
                'subject' => $msg->subject,
                'body' => $msg->body,
                'status' => 'sent',
                'template_id' => $msg->template_id,
                'sent_at' => now(),
            ]);
        }

        $msg->update([
            'done' => true,
            'sent_at' => now(),
            'status' => 'sent',
        ]);

        Activity::log(null, 'message.scheduled_sent', "Scheduled message sent: {$msg->id}", $msg->toArray(), 'ScheduledMessage', $msg->id);

        return back()->with('ok', 'Message sent and logged.');
    }

    public function cancelScheduled(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id' => 'required|exists:scheduled_messages,id',
        ]);

        $msg = ScheduledMessage::findOrFail($data['id']);
        $msg->update(['status' => 'cancelled']);

        Activity::log(null, 'message.scheduled_cancelled', "Scheduled message cancelled: {$msg->id}", $msg->toArray(), 'ScheduledMessage', $msg->id);

        return back()->with('ok', 'Scheduled message cancelled.');
    }

    // ===== EXPORTS =====

    public function exportLogs(Request $request)
    {
        $logs = CommunicationLog::with('user:id,name,mobile,email')
            ->when($request->filled('from'), fn($q) => $q->whereDate('sent_at', '>=', $request->from))
            ->when($request->filled('to'), fn($q) => $q->whereDate('sent_at', '<=', $request->to))
            ->when($request->filled('channel'), fn($q) => $q->where('channel', $request->channel))
            ->orderByDesc('sent_at')
            ->get();

        $rows = $logs->map(function ($log) {
            return [
                $log->sent_at ? $log->sent_at->format('d M Y H:i') : '',
                $log->recipient['name'] ?? '',
                $log->channel === 'wa' ? 'WhatsApp' : 'Email',
                $log->subject ?? '',
                $log->status,
            ];
        })->toArray();

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

    public function exportTemplates(Request $request)
    {
        $waTemplates = MessageTemplate::where('channel', 'wa')->get();
        $emTemplates = MessageTemplate::where('channel', 'em')->get();

        $waRows = $waTemplates->map(fn($t) => [$t->name, $t->body])->toArray();
        $emRows = $emTemplates->map(fn($t) => [$t->name, $t->subject ?? '', $t->body])->toArray();

        return response()->json([
            'filename' => 'Message_Templates_' . now()->format('Ymd') . '.xlsx',
            'sheets' => [
                [
                    'name' => 'WhatsApp Templates',
                    'title' => 'WhatsApp Templates',
                    'head' => ['Template Name', 'Message'],
                    'rows' => $waRows,
                ],
                [
                    'name' => 'Email Templates',
                    'title' => 'Email Templates',
                    'head' => ['Template Name', 'Subject', 'Message'],
                    'rows' => $emRows,
                ],
            ],
        ]);
    }
}