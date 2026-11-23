<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditController extends Controller
{
    /**
     * Admin/system actions only. Client-side events (actor_type = 'user': "Opened EMI calculator",
     * "Payment success", ...) belong to each client's timeline, not the admin audit trail.
     */
    private function filtered(Request $request)
    {
        return ActivityLog::query()
            ->where(fn ($q) => $q->whereNull('actor_type')->orWhere('actor_type', '!=', 'user'))
            ->when($request->filled('from'), fn ($q) => $q->whereDate('created_at', '>=', $request->query('from')))
            ->when($request->filled('to'), fn ($q) => $q->whereDate('created_at', '<=', $request->query('to')))
            ->when($request->filled('action'), fn ($q) => $q->where('event', $request->query('action')))
            ->when($request->filled('subject_type'), fn ($q) => $q->where('subject_type', $request->query('subject_type')))
            ->when($request->filled('user_id'), fn ($q) => $q->where('user_id', $request->query('user_id')));
    }

    public function index(Request $request): View
    {
        $audits = $this->filtered($request)
            ->with('user:id,name,email')
            ->orderByDesc('created_at')->orderByDesc('id')
            ->paginate(50)
            ->withQueryString();

        $base = fn () => ActivityLog::query()
            ->where(fn ($q) => $q->whereNull('actor_type')->orWhere('actor_type', '!=', 'user'));

        $actions = $base()->distinct()->pluck('event')->filter()->sort()->values();
        $subjectTypes = $base()->distinct()->pluck('subject_type')->filter()->sort()->values();
        $users = User::select('id', 'name')->orderBy('name')->get();

        return view('admin.audit', compact('audits', 'actions', 'subjectTypes', 'users'));
    }

    public function export(Request $request): JsonResponse
    {
        $rows = $this->filtered($request)
            ->orderByDesc('created_at')->orderByDesc('id')
            ->limit(5000)->get()
            ->map(fn ($log) => [
                $log->created_at?->format('d M Y H:i:s') ?? '',
                $this->actor($log),
                $log->event,
                $log->subject_type ?? '—',
                $log->subject_id ?? '—',
                $this->formatProperties($log->properties),
                $log->ip ?? '—',
            ])->all();

        return response()->json([
            'filename' => 'Audit_Trail_' . now()->format('Ymd') . '.xlsx',
            'sheets' => [[
                'name' => 'Audit Trail',
                'title' => 'Audit Trail · date-wise',
                'head' => ['When', 'Admin', 'Action', 'Subject Type', 'Subject ID', 'Details (before → after)', 'IP'],
                'rows' => $rows,
            ]],
        ]);
    }

    private function actor($log): string
    {
        if (!empty($log->actor_name)) {
            return $log->actor_name;
        }

        return ($log->actor_type ?? 'system') === 'system' ? 'System' : '—';
    }

    private function formatProperties($properties): string
    {
        if (is_string($properties)) {
            $properties = json_decode($properties, true);
        }
        if (!is_array($properties) || !$properties) {
            return '—';
        }

        $parts = [];
        foreach ($properties as $key => $value) {
            if (is_array($value) || is_object($value)) {
                $value = json_encode($value, JSON_UNESCAPED_UNICODE);
            }
            $parts[] = $key . ': ' . $value;
        }

        return implode("\n", $parts);
    }
}