<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Testimonial;
use App\Support\Activity;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function index(): View
    {
        $testimonials = Testimonial::orderBy('sort_order')->get();
        $section = $this->getSectionSettings();

        return view('admin.testimonials', compact('testimonials', 'section'));
    }

    private function getSectionSettings(): array
    {
        $setting = Setting::where('key', 'testimonials_section')->first();
        if ($setting && $setting->value) {
            return json_decode($setting->value, true) ?? $this->defaultSection();
        }
        return $this->defaultSection();
    }

    private function defaultSection(): array
    {
        return [
            'on' => true,
            'kicker' => 'Kind words',
            'title' => 'What people say about Retirement Plan Karo',
            'sub' => 'Here is what people liked about planning their retirement here.',
            'note' => 'Testimonials are individual opinions, shared with permission, and are not a promise or guarantee of any result. This tool is for education only.',
        ];
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:40',
            'text' => 'required|string|max:300',
            'permission_taken' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        $maxOrder = Testimonial::max('sort_order') ?? 0;

        $testimonial = Testimonial::create([
            'name' => $data['name'],
            'text' => $data['text'],
            'permission_taken' => $request->boolean('permission_taken'),
            'is_active' => $request->boolean('is_active', true),
            'sort_order' => $maxOrder + 1,
        ]);

        Activity::log(null, 'testimonial.created', "Testimonial added: {$testimonial->name}", $testimonial->toArray(), 'Testimonial', $testimonial->id);

        return back()->with('ok', 'Testimonial added.');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $testimonial = Testimonial::findOrFail($id);

        $data = $request->validate([
            'name' => 'required|string|max:40',
            'text' => 'required|string|max:300',
            'permission_taken' => 'nullable|boolean',
            'is_active' => 'nullable|boolean',
        ]);

        // Prevent showing if permission not taken
        if ($request->boolean('is_active') && !$request->boolean('permission_taken')) {
            return back()->withErrors(['is_active' => 'Permission must be taken before showing on website.']);
        }

        $testimonial->update([
            'name' => $data['name'],
            'text' => $data['text'],
            'permission_taken' => $request->boolean('permission_taken'),
            'is_active' => $request->boolean('is_active'),
        ]);

        Activity::log(null, 'testimonial.updated', "Testimonial updated: {$testimonial->name}", $testimonial->toArray(), 'Testimonial', $testimonial->id);

        return back()->with('ok', 'Testimonial updated.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id' => 'required|exists:testimonials,id',
        ]);

        $testimonial = Testimonial::findOrFail($data['id']);
        $name = $testimonial->name;
        $testimonial->delete();

        // Reorder remaining items
        $this->reorderAfterDelete($testimonial->sort_order);

        Activity::log(null, 'testimonial.deleted', "Testimonial deleted: {$name}", ['id' => $data['id']], 'Testimonial', $data['id']);

        return back()->with('ok', 'Testimonial deleted.');
    }

    public function duplicate(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id' => 'required|exists:testimonials,id',
        ]);

        $testimonial = Testimonial::findOrFail($data['id']);
        $new = $testimonial->replicate();
        $new->name = $testimonial->name . ' (copy)';
        $new->is_active = false; // Copy is hidden by default
        $new->sort_order = (Testimonial::max('sort_order') ?? 0) + 1;
        $new->save();

        Activity::log(null, 'testimonial.duplicated', "Testimonial duplicated: {$new->name}", $new->toArray(), 'Testimonial', $new->id);

        return back()->with('ok', 'Testimonial duplicated. The copy is hidden until you edit and show it.');
    }

    public function moveUp(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id' => 'required|exists:testimonials,id',
        ]);

        $testimonial = Testimonial::findOrFail($data['id']);

        if ($testimonial->sort_order > 1) {
            $prev = Testimonial::where('sort_order', $testimonial->sort_order - 1)->first();
            if ($prev) {
                $testimonial->update(['sort_order' => $prev->sort_order]);
                $prev->update(['sort_order' => $testimonial->sort_order + 1]);
            }
        }

        return back()->with('ok', 'Order updated.');
    }

    public function moveDown(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id' => 'required|exists:testimonials,id',
        ]);

        $testimonial = Testimonial::findOrFail($data['id']);

        $maxOrder = Testimonial::max('sort_order') ?? 0;

        if ($testimonial->sort_order < $maxOrder) {
            $next = Testimonial::where('sort_order', $testimonial->sort_order + 1)->first();
            if ($next) {
                $testimonial->update(['sort_order' => $next->sort_order]);
                $next->update(['sort_order' => $testimonial->sort_order - 1]);
            }
        }

        return back()->with('ok', 'Order updated.');
    }

    private function reorderAfterDelete(int $deletedOrder): void
    {
        $items = Testimonial::where('sort_order', '>', $deletedOrder)
            ->orderBy('sort_order')
            ->get();

        foreach ($items as $index => $item) {
            $item->update(['sort_order' => $deletedOrder + $index]);
        }
    }

    public function updateSection(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'on' => 'nullable|boolean',
            'kicker' => 'nullable|string|max:60',
            'title' => 'nullable|string|max:120',
            'sub' => 'nullable|string|max:200',
            'note' => 'nullable|string|max:500',
        ]);

        $section = $this->getSectionSettings();
        $section['on'] = $request->boolean('on', true);
        $section['kicker'] = $data['kicker'] ?? $section['kicker'];
        $section['title'] = $data['title'] ?? $section['title'];
        $section['sub'] = $data['sub'] ?? $section['sub'];
        $section['note'] = $data['note'] ?? $section['note'];

        Setting::updateOrCreate(
            ['key' => 'testimonials_section'],
            ['value' => json_encode($section, JSON_UNESCAPED_UNICODE)]
        );

        Activity::log(null, 'testimonial.section_updated', 'Testimonial section text updated', $section, 'Setting', 'testimonials_section');

        return back()->with('ok', 'Section text saved. Click Publish to push live.');
    }

    public function toggle(Request $request): JsonResponse
    {
        $data = $request->validate([
            'id' => 'required|exists:testimonials,id',
            'field' => 'required|in:is_active,permission_taken',
            'value' => 'required|boolean',
        ]);

        $testimonial = Testimonial::findOrFail($data['id']);

        // Prevent showing if permission not taken
        if ($data['field'] === 'is_active' && $data['value'] && !$testimonial->permission_taken) {
            return response()->json(['error' => 'Permission must be taken before showing on website.'], 422);
        }

        $testimonial->update([$data['field'] => $data['value']]);

        Activity::log(null, 'testimonial.toggled', "Testimonial {$data['field']} toggled: {$testimonial->name}", [
            'field' => $data['field'],
            'value' => $data['value'],
        ], 'Testimonial', $testimonial->id);

        return response()->json(['ok' => true, 'message' => 'Saved. Click Publish to push live.']);
    }

    public function publish(): RedirectResponse
    {
        // Increment version and update publish timestamp
        $setting = Setting::where('key', 'testimonials_version')->first();
        $version = $setting ? (int)$setting->value + 1 : 1;
        
        Setting::updateOrCreate(
            ['key' => 'testimonials_version'],
            ['value' => (string)$version]
        );
        
        Setting::updateOrCreate(
            ['key' => 'testimonials_published_at'],
            ['value' => now()->format('Y-m-d H:i:s')]
        );

        // Snapshot the current feed for dirty detection
        $feed = $this->getFeed();
        Setting::updateOrCreate(
            ['key' => 'testimonials_published_snapshot'],
            ['value' => json_encode($feed, JSON_UNESCAPED_UNICODE)]
        );

        Activity::log(null, 'testimonial.published', "Testimonials published version {$version}", $feed, 'Setting', 'testimonials_version');

        return back()->with('ok', "Published version {$version}. Website shows the new testimonials now.");
    }

    public function viewJson(): JsonResponse
    {
        $feed = $this->getFeed();
        $version = Setting::where('key', 'testimonials_version')->first()?->value ?? '1';
        
        $json = array_merge(['version' => (int)$version], $feed);
        
        return response()->json($json);
    }

    public function export()
    {
        $testimonials = Testimonial::orderBy('sort_order')->get();
        $section = $this->getSectionSettings();

        $rows = $testimonials->map(function ($t) {
            return [
                $t->sort_order,
                $t->name,
                $t->text,
                $t->permission_taken ? 'Yes' : 'No',
                $t->is_active ? 'Yes' : 'No',
            ];
        })->toArray();

        $sectionRows = [
            ['Section Enabled', $section['on'] ? 'Yes' : 'No'],
            ['Kicker', $section['kicker']],
            ['Title', $section['title']],
            ['Sub-heading', $section['sub']],
            ['Note', $section['note']],
        ];

        return response()->json([
            'filename' => 'Testimonials_' . now()->format('Ymd') . '.xlsx',
            'sheets' => [[
                'name' => 'Testimonials',
                'title' => 'Testimonials',
                'head' => ['Order', 'Name', 'Testimonial', 'Permission Taken', 'Show'],
                'rows' => $rows,
            ], [
                'name' => 'Section Text',
                'title' => 'Section Text',
                'head' => ['Field', 'Value'],
                'rows' => $sectionRows,
            ]],
        ]);
    }

    private function getFeed(): array
    {
        $section = $this->getSectionSettings();
        $testimonials = Testimonial::where('is_active', true)
            ->where('permission_taken', true)
            ->orderBy('sort_order')
            ->get(['id', 'name', 'text'])
            ->toArray();

        return [
            'on' => $section['on'],
            'text' => [
                'kicker' => $section['kicker'],
                'title' => $section['title'],
                'sub' => $section['sub'],
                'note' => $section['note'],
            ],
            'testimonials' => $testimonials,
        ];
    }
}