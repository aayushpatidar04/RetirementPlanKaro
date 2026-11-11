<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Support\Activity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditController extends Controller
{
    public function index(Request $request): View
    {
        $query = ActivityLog::query()
            ->with('user:id,name,email')
            ->orderBy('created_at', 'desc');

        // Filter by date range
        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->query('from'));
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->query('to'));
        }

        // Filter by action
        if ($request->filled('action')) {
            $query->where('event', $request->query('action'));
        }

        // Filter by subject type
        if ($request->filled('subject_type')) {
            $query->where('subject_type', $request->query('subject_type'));
        }

        // Filter by user
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->query('user_id'));
        }

        $audits = $query->paginate(50)->withQueryString();

        // Get distinct actions and subject types for filters
        $actions = ActivityLog::distinct()->pluck('event')->filter()->sort()->values();
        $subjectTypes = ActivityLog::distinct()->pluck('subject_type')->filter()->sort()->values();
        $users = \App\Models\User::select('id', 'name')->get();

        return view('admin.audit', compact('audits', 'actions', 'subjectTypes', 'users'));
    }

    public function export(Request $request): RedirectResponse
    {
        $query = ActivityLog::query()
            ->with('user:id,name,email')
            ->orderBy('created_at', 'desc');

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->query('from'));
        }
        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->query('to'));
        }
        if ($request->filled('action')) {
            $query->where('event', $request->query('action'));
        }
        if ($request->filled('subject_type')) {
            $query->where('subject_type', $request->query('subject_type'));
        }
        if ($request->filled('user_id')) {
            $query->where('user_id', $request->query('user_id'));
        }

        $audits = $query->get();

        $rows = $audits->map(function ($log) {
            return [
                $log->created_at->format('d M Y H:i:s'),
                $log->user?->name ?? 'System',
                $log->event,
                $log->subject_type ?? '—',
                $log->subject_id ?? '—',
                $this->formatProperties($log->properties),
                $log->ip ?? '—',
            ];
        })->toArray();

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

    private function formatProperties(?array $properties): string
    {
        if (!$properties) return '—';
        
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