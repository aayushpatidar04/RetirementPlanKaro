<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VersionSnapshot;
use App\Support\Activity;
use App\Support\VersionHistory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Published Versions. A version is saved automatically each time Pricing, Points,
 * Discount Codes, Referral settings, Session availability, Investment Partners or
 * Testimonials are saved/published (see App\Support\VersionHistory).
 */
class VersionController extends Controller
{
    public function index(Request $request): View
    {
        $this->baseline();

        $filterArea = $request->query('area');
        $areas = VersionHistory::AREAS;

        $versions = $this->withDiffs($filterArea);

        $currentData = [];
        foreach (array_keys($areas) as $area) {
            $currentData[$area] = VersionHistory::capture($area);
        }

        return view('admin.versions', compact('versions', 'areas', 'filterArea', 'currentData'));
    }

    public function restore(Request $request): RedirectResponse|JsonResponse
    {
        $data = $request->validate([
            'version' => 'required|integer|exists:version_snapshots,version',
        ]);

        $snapshot = VersionSnapshot::where('version', $data['version'])->firstOrFail();
        VersionHistory::restore($snapshot);
        $new = VersionHistory::record($snapshot->area, "Restored from version {$snapshot->version}");

        Activity::log(null, 'version.restored', "Restored {$snapshot->area} to version {$snapshot->version}", [
            'restored_version' => $snapshot->version,
            'new_version' => $new?->version,
        ], 'VersionSnapshot', $snapshot->version);

        $msg = "{$snapshot->area} restored to version {$snapshot->version}. The website uses it now.";

        return $request->expectsJson() ? response()->json(['ok' => true, 'message' => $msg]) : back()->with('ok', $msg);
    }

    public function export(Request $request): JsonResponse
    {
        $rows = $this->withDiffs($request->query('area'))->map(fn ($v) => [
            'v' . $v->version,
            $v->created_at?->format('d M Y H:i'),
            $v->area,
            $v->description,
            $v->summary,
            VersionHistory::same($v->data, VersionHistory::capture($v->area)) ? 'Current' : '',
        ])->values()->all();

        return response()->json([
            'filename' => 'Website_Versions_' . now()->format('Ymd') . '.xlsx',
            'sheets' => [[
                'name' => 'Versions',
                'title' => 'Website Versions',
                'head' => ['Version', 'When', 'Area', 'Change', 'Details (before → after)', 'Status'],
                'rows' => $rows,
            ]],
        ]);
    }

    /** Versions newest first, each with a "summary" of what changed vs. the version before it. */
    private function withDiffs(?string $area)
    {
        $all = VersionSnapshot::query()->orderBy('version')->get();
        $prev = [];
        foreach ($all as $v) {
            $v->setAttribute('summary', VersionHistory::diff($prev[$v->area] ?? null, (array) $v->data));
            $prev[$v->area] = (array) $v->data;
        }

        return $all->when($area, fn ($c) => $c->where('area', $area))->sortByDesc('version')->values();
    }

    /** First visit: store the live state of every area, so there is something to go back to. */
    private function baseline(): void
    {
        foreach (array_keys(VersionHistory::AREAS) as $area) {
            if (!VersionSnapshot::where('area', $area)->exists()) {
                VersionHistory::record($area, 'Starting point (live settings when versioning was switched on)');
            }
        }
    }
}
