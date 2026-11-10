<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\InvestmentPartner;
use App\Support\Activity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class InvestmentPartnerController extends Controller
{
    public function index(): View
    {
        $partners = InvestmentPartner::orderBy('sort_order')->get();

        return view('admin.investment-partners', compact('partners'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'label' => 'required|string|max:120',
            'category' => 'nullable|string|max:60',
            'partner' => 'nullable|string|max:100',
            'url' => 'required|url|max:500',
            'is_active' => 'nullable|boolean',
        ]);

        $maxOrder = InvestmentPartner::max('sort_order') ?? 0;

        $partner = InvestmentPartner::create([
            'label' => $data['label'],
            'category' => $data['category'] ?? 'Other',
            'partner' => $data['partner'] ?? null,
            'url' => $data['url'],
            'is_active' => $request->boolean('is_active'),
            'sort_order' => $maxOrder + 1,
        ]);

        Activity::log(null, 'investment_partner.created', "Investment partner created: {$partner->label}", $partner->toArray(), 'InvestmentPartner', $partner->id);

        return back()->with('ok', 'Investment partner added.');
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $partner = InvestmentPartner::findOrFail($id);

        $data = $request->validate([
            'label' => 'required|string|max:120',
            'category' => 'nullable|string|max:60',
            'partner' => 'nullable|string|max:100',
            'url' => 'required|url|max:500',
            'is_active' => 'nullable|boolean',
        ]);

        $partner->update([
            'label' => $data['label'],
            'category' => $data['category'] ?? 'Other',
            'partner' => $data['partner'] ?? null,
            'url' => $data['url'],
            'is_active' => $request->boolean('is_active'),
        ]);

        Activity::log(null, 'investment_partner.updated', "Investment partner updated: {$partner->label}", $partner->toArray(), 'InvestmentPartner', $partner->id);

        return back()->with('ok', 'Investment partner updated.');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id' => 'required|exists:investment_partners,id',
        ]);

        $partner = InvestmentPartner::findOrFail($data['id']);
        $name = $partner->label;
        $partner->delete();

        // Reorder remaining items
        $this->reorderAfterDelete($partner->sort_order);

        Activity::log(null, 'investment_partner.deleted', "Investment partner deleted: {$name}", ['id' => $data['id']], 'InvestmentPartner', $data['id']);

        return back()->with('ok', 'Investment partner deleted.');
    }

    public function duplicate(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id' => 'required|exists:investment_partners,id',
        ]);

        $partner = InvestmentPartner::findOrFail($data['id']);
        $new = $partner->replicate();
        $new->label = $partner->label . ' (copy)';
        $new->clicks = 0;
        $new->sort_order = (InvestmentPartner::max('sort_order') ?? 0) + 1;
        $new->save();

        Activity::log(null, 'investment_partner.duplicated', "Investment partner duplicated: {$new->label}", $new->toArray(), 'InvestmentPartner', $new->id);

        return back()->with('ok', 'Investment partner duplicated.');
    }

    public function moveUp(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id' => 'required|exists:investment_partners,id',
        ]);

        $partner = InvestmentPartner::findOrFail($data['id']);

        if ($partner->sort_order > 1) {
            $prev = InvestmentPartner::where('sort_order', $partner->sort_order - 1)->first();
            if ($prev) {
                $partner->update(['sort_order' => $prev->sort_order]);
                $prev->update(['sort_order' => $partner->sort_order + 1]);
            }
        }

        return back()->with('ok', 'Order updated.');
    }

    public function moveDown(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'id' => 'required|exists:investment_partners,id',
        ]);

        $partner = InvestmentPartner::findOrFail($data['id']);

        $maxOrder = InvestmentPartner::max('sort_order') ?? 0;

        if ($partner->sort_order < $maxOrder) {
            $next = InvestmentPartner::where('sort_order', $partner->sort_order + 1)->first();
            if ($next) {
                $partner->update(['sort_order' => $next->sort_order]);
                $next->update(['sort_order' => $partner->sort_order - 1]);
            }
        }

        return back()->with('ok', 'Order updated.');
    }

    private function reorderAfterDelete(int $deletedOrder): void
    {
        $items = InvestmentPartner::where('sort_order', '>', $deletedOrder)
            ->orderBy('sort_order')
            ->get();

        foreach ($items as $index => $item) {
            $item->update(['sort_order' => $deletedOrder + $index]);
        }
    }

    public function export()
    {
        $partners = InvestmentPartner::orderBy('sort_order')->get();

        $rows = $partners->map(function ($p) {
            return [
                $p->sort_order,
                $p->label,
                $p->category,
                $p->partner ?? '',
                $p->url,
                $p->clicks,
                $p->is_active ? 'Yes' : 'No',
            ];
        })->toArray();

        return response()->json([
            'filename' => 'Investment_Partners_' . now()->format('Ymd') . '.xlsx',
            'sheets' => [[
                'name' => 'Investment Partners',
                'title' => 'Investment Partners',
                'head' => ['Order', 'Label', 'Category', 'Partner', 'URL', 'Clicks', 'Active'],
                'rows' => $rows,
            ]],
        ]);
    }
}