<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\VersionSnapshot;
use App\Support\Activity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VersionController extends Controller
{
    public function index(Request $request): View
    {
        $filterArea = $request->query('area');
        $areas = VersionSnapshot::getAreas();
        
        $query = VersionSnapshot::query()->orderBy('version', 'desc');
        if ($filterArea) {
            $query->where('area', $filterArea);
        }
        $versions = $query->get();

        // Current data for each area
        $currentData = [];
        foreach ($areas as $areaName => $settingKeys) {
            $currentData[$areaName] = $this->getAreaData($areaName, $settingKeys);
        }

        return view('admin.versions', compact('versions', 'areas', 'filterArea', 'currentData'));
    }

    private function getAreaData(string $areaName, array $settingKeys): array
    {
        $data = [];
        foreach ($settingKeys as $key) {
            $setting = Setting::where('key', $key)->first();
            if ($setting && $setting->value) {
                $data[$key] = json_decode($setting->value, true);
            }
        }
        return $data;
    }

    public function restore(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'version' => 'required|integer|exists:version_snapshots,version',
        ]);

        $snapshot = VersionSnapshot::where('version', $data['version'])->firstOrFail();
        
        // Apply the snapshot data to settings
        $this->applySnapshot($snapshot);
        
        // Create new snapshot with current data
        $newVersion = $this->createSnapshotForArea($snapshot->area, "Restored from version {$snapshot->version}");

        Activity::log(null, 'version.restored', "Restored {$snapshot->area} to version {$snapshot->version}", [
            'restored_version' => $snapshot->version,
            'new_version' => $newVersion->version,
        ], 'VersionSnapshot', $snapshot->version);

        return back()->with('ok', "Version {$snapshot->version} restored. New version {$newVersion->version} created.");
    }

    public function export(Request $request): RedirectResponse
    {
        $filterArea = $request->query('area');
        
        $query = VersionSnapshot::query()->orderBy('version', 'desc');
        if ($filterArea) {
            $query->where('area', $filterArea);
        }
        $versions = $query->get();

        $rows = $versions->map(function ($v) {
            $status = $this->isCurrent($v) ? 'Current' : '';
            return [
                'v' . $v->version,
                $v->created_at->format('d M Y H:i'),
                $v->area,
                $v->description,
                $this->formatDiff($v->data),
                $status,
            ];
        })->toArray();

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

    private function applySnapshot(VersionSnapshot $snapshot): void
    {
        $areaKeys = VersionSnapshot::getAreas()[$snapshot->area] ?? [];
        
        foreach ($areaKeys as $key) {
            if (isset($snapshot->data[$key])) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => json_encode($snapshot->data[$key], JSON_UNESCAPED_UNICODE)]
                );
            }
        }
    }

    private function createSnapshotForArea(string $area, string $description): VersionSnapshot
    {
        $areaKeys = VersionSnapshot::getAreas()[$area] ?? [];
        $data = $this->getAreaData($area, $areaKeys);
        
        return VersionSnapshot::createSnapshot($area, $data, $description);
    }

    private function isCurrent(VersionSnapshot $snapshot): bool
    {
        $areaKeys = VersionSnapshot::getAreas()[$snapshot->area] ?? [];
        $currentData = $this->getAreaData($snapshot->area, $areaKeys);
        
        return json_encode($currentData) === json_encode($snapshot->data);
    }

    private function formatDiff(array $data): string
    {
        $parts = [];
        foreach ($data as $key => $value) {
            $parts[] = $key . ': ' . json_encode($value, JSON_UNESCAPED_UNICODE);
        }
        return implode("\n", $parts);
    }
}