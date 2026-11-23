<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\Activity;
use App\Support\Settings;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SessionController extends Controller
{
    public static function availabilityDefaults(): array
    {
        return [
            'on' => true,
            'days' => [1,2,3,4,5,6], // Mon-Sat
            'slots' => "Morning (9 am – 12 pm)\nAfternoon (12 pm – 4 pm)\nEvening (4 pm – 8 pm)",
            'modes' => 'Phone call, Video call',
            'blocked' => '',
            'win' => 14,
            'max' => 3,
            'dur' => 30,
            'notice' => 'A WhatsApp confirmation is sent once the booking is confirmed.',
        ];
    }

    public static function availability(): array
    {
        $raw = Settings::get('session_availability');
        $d = self::availabilityDefaults();
        if ($raw) {
            $j = json_decode($raw, true);
            if (is_array($j)) $d = array_merge($d, $j);
        }
        $d['on'] = !empty($d['on']);
        $d['days'] = array_values(array_map('intval', is_array($d['days'] ?? null) ? $d['days'] : $d['days']));
        foreach (['win','max','dur'] as $k) $d[$k] = max(0, (int) ($d[$k] ?? 0));
        foreach (['slots','modes','blocked','notice'] as $k) $d[$k] = (string) ($d[$k] ?? '');
        return $d;
    }

    public function index(Request $request): View
    {
        $from = trim((string) $request->query('from', ''));
        $to = trim((string) $request->query('to', ''));
        $status = trim((string) $request->query('status', ''));
        $tab = $request->query('tab') === 'availability' ? 'availability' : 'bookings';

        $sessions = DB::table('guidance_sessions')
            ->join('users', 'users.id', '=', 'guidance_sessions.user_id')
            ->when($from !== '', fn ($q) => $q->whereDate('guidance_sessions.date', '>=', $from))
            ->when($to !== '', fn ($q) => $q->whereDate('guidance_sessions.date', '<=', $to))
            ->when($status !== '', function ($q) use ($status) {
                $s = $status === 'completed' ? 'done' : $status;
                $q->where('guidance_sessions.status', $s);
            })
            ->orderByDesc('guidance_sessions.date')
            ->orderByDesc('guidance_sessions.id')
            ->select('guidance_sessions.*', 'users.name', 'users.surname', 'users.email', 'users.mobile as user_mobile', 'users.city')
            ->paginate(40)
            ->withQueryString();

        $counts = [
            'all' => DB::table('guidance_sessions')->count(),
            'booked' => DB::table('guidance_sessions')->where('status', 'booked')->count(),
            'pending_payment' => DB::table('guidance_sessions')->where('status', 'pending_payment')->count(),
            'confirmed' => DB::table('guidance_sessions')->where('status', 'confirmed')->count(),
            'done' => DB::table('guidance_sessions')->where('status', 'done')->count(),
            'cancelled' => DB::table('guidance_sessions')->where('status', 'cancelled')->count(),
        ];
        $availability = self::availability();
        $previewDates = $this->previewDates($availability);

        return view('admin.sessions', compact('sessions', 'from', 'to', 'status', 'tab', 'counts', 'availability', 'previewDates'));
    }

    /**
     * What the website booking form may offer (Advisory sessions → Availability & Rules):
     * on/off, bookable dates from tomorrow to the booking window, weekdays (1=Mon..7=Sun),
     * blocked dates, days already at the daily limit, time slots and call types.
     */
    public static function bookingRules(): array
    {
        $a = self::availability();
        $split = fn (string $s, string $re) => array_values(array_filter(array_map('trim', preg_split($re, $s))));
        $slots = $split($a['slots'], '/\r?\n/') ?: ['Morning (9 am to 12 pm)', 'Afternoon (12 pm to 4 pm)', 'Evening (4 pm to 8 pm)'];
        $modes = $split($a['modes'], '/[,\r\n]+/') ?: ['Phone call', 'Video call'];
        $blocked = array_values(array_filter($split($a['blocked'], '/[,\s]+/'), fn ($d) => preg_match('/^\d{4}-\d{2}-\d{2}$/', $d)));
        $win = max(1, min(90, $a['win'] ?: 14));
        $min = Carbon::tomorrow()->toDateString();
        $max = Carbon::today()->addDays($win)->toDateString();

        $full = [];
        if ($a['max'] > 0) {
            $full = DB::table('guidance_sessions')->whereBetween('date', [$min, $max])
                ->whereNotIn('status', ['cancelled'])
                ->selectRaw('date, COUNT(*) as c')->groupBy('date')->havingRaw('COUNT(*) >= ?', [$a['max']])
                ->pluck('date')->map(fn ($d) => substr((string) $d, 0, 10))->all();
        }

        return [
            'on' => $a['on'], 'days' => $a['days'] ?: [1, 2, 3, 4, 5, 6], 'slots' => $slots, 'modes' => $modes,
            'blocked' => $blocked, 'full' => $full, 'min' => $min, 'max' => $max,
            'max_per_day' => $a['max'], 'duration' => $a['dur'], 'notice' => $a['notice'],
        ];
    }

    /** Why a date can't be booked, or null when it can. */
    public static function dateProblem(string $date, ?array $rules = null): ?string
    {
        $r = $rules ?? self::bookingRules();
        if (!$r['on']) return 'Online booking is closed right now. Please try again later.';
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date) || $date < $r['min'] || $date > $r['max']) {
            return 'Pick a date between ' . Carbon::parse($r['min'])->format('d M') . ' and ' . Carbon::parse($r['max'])->format('d M') . '.';
        }
        if (!in_array((int) Carbon::parse($date)->dayOfWeekIso, $r['days'], true)) return 'Sessions are not held on ' . Carbon::parse($date)->format('l') . 's. Please pick another day.';
        if (in_array($date, $r['blocked'], true)) return 'This date is not available. Please pick another day.';
        if (in_array($date, $r['full'], true)) return 'This date is fully booked. Please pick another day.';

        return null;
    }

    private function previewDates(array $a): array
    {
        if (empty($a['on'])) return [];
        $blocked = collect(explode(',', (string)($a['blocked'] ?? '')))->map(fn($x)=>trim($x))->filter()->values()->all();
        $days = array_map('intval', (array)($a['days'] ?? []));
        $win = max(1, min(60, (int)($a['win'] ?? 14)));
        $out = []; $d = Carbon::today();
        for ($i=0; $i<$win && count($out) < 14; $i++) {
            $iso = $d->copy()->addDays($i);
            $dow = (int)$iso->dayOfWeekIso; // 1=Mon..7=Sun
            $ymd = $iso->toDateString();
            if (in_array($dow, $days, true) && !in_array($ymd, $blocked, true)) $out[] = $iso->format('D d M');
        }
        return $out;
    }

    public function saveAvailability(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'on' => 'nullable',
            'days' => 'nullable|array',
            'days.*' => 'integer|min:1|max:7',
            'slots' => 'nullable|string|max:2000',
            'modes' => 'nullable|string|max:500',
            'blocked' => 'nullable|string|max:2000',
            'win' => 'nullable|integer|min:0|max:365',
            'max' => 'nullable|integer|min:0|max:100',
            'dur' => 'nullable|integer|min:0|max:600',
            'notice' => 'nullable|string|max:500',
        ]);
        $a = [
            'on' => $request->boolean('on'),
            'days' => array_values(array_map('intval', $data['days'] ?? [])),
            'slots' => (string)($data['slots'] ?? ''),
            'modes' => (string)($data['modes'] ?? ''),
            'blocked' => (string)($data['blocked'] ?? ''),
            'win' => (int)($data['win'] ?? 14),
            'max' => (int)($data['max'] ?? 3),
            'dur' => (int)($data['dur'] ?? 30),
            'notice' => (string)($data['notice'] ?? ''),
        ];
        Settings::set('session_availability', json_encode($a, JSON_UNESCAPED_UNICODE));
        \App\Support\VersionHistory::record('Session Availability', 'Availability and booking rules saved');
        Activity::log(null, 'sessions.availability_saved', 'Advisory session availability saved', $a, 'Settings', 'session_availability');
        return redirect()->route('admin.sessions', ['tab' => 'availability'])->with('ok', 'Availability saved.');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $data = $request->validate([
            'date' => 'nullable|date',
            'slot' => 'nullable|string|max:40',
            'mode' => 'nullable|string|max:20',
            'question' => 'nullable|string|max:500',
            'advisor' => 'nullable|string|max:120',
            'status' => 'required|in:pending_payment,booked,confirmed,done,cancelled',
            'cancel_reason' => 'nullable|string|max:300',
        ]);
        $s = DB::table('guidance_sessions')->where('id', $id)->first();
        if (!$s) return back()->with('ok', 'Session not found.');
        $upd = [
            'date' => $data['date'] ?: $s->date,
            'slot' => $data['slot'] ?: ($s->slot ?: '—'),
            'mode' => $data['mode'] ?: ($s->mode ?: 'Call'),
            'question' => $data['question'] ?? $s->question,
            'note' => $data['question'] ?? $s->note,
            'advisor' => $data['advisor'] ?? $s->advisor,
            'status' => $data['status'],
            'cancel_reason' => $data['status'] === 'cancelled' ? ($data['cancel_reason'] ?? $s->cancel_reason) : null,
            'updated_at' => now(),
        ];
        DB::table('guidance_sessions')->where('id', $id)->update($upd);
        Activity::log((int) $s->user_id, 'session.updated', 'Advisory session updated', ['session_id'=>$id,'status'=>$data['status']], 'GuidanceSession', $id);
        return back()->with('ok', 'Session updated.');
    }

    public function status(Request $request, int $id): RedirectResponse
    {
        $d = $request->validate(['status' => ['required', Rule::in(['confirmed', 'done', 'cancelled', 'booked'])]]);
        $s = DB::table('guidance_sessions')->where('id', $id)->first();
        DB::table('guidance_sessions')->where('id', $id)->update(['status' => $d['status'], 'updated_at' => now()]);
        if ($s) Activity::log((int) $s->user_id, 'session.status_updated', 'Advisory session status set to '.$d['status'], ['session_id'=>$id,'status'=>$d['status']], 'GuidanceSession', $id);
        return back()->with('ok', 'Session updated.');
    }
}