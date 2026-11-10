<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuoteRequest;
use App\Support\Activity;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class QuoteController extends Controller
{
    public function index(Request $request): View
    {
        $productType = trim((string) $request->query('product_type', ''));
        $status = trim((string) $request->query('status', ''));
        $from = trim((string) $request->query('from', ''));
        $to = trim((string) $request->query('to', ''));

        $quotes = QuoteRequest::query()
            ->when($productType !== '', fn ($q) => $q->where('product_type', $productType))
            ->when($status !== '', fn ($q) => $q->where('status', $status))
            ->when($from !== '', fn ($q) => $q->whereDate('created_at', '>=', $from))
            ->when($to !== '', fn ($q) => $q->whereDate('created_at', '<=', $to))
            ->orderByDesc('created_at')
            ->paginate(40)
            ->withQueryString();

        $counts = [
            'New' => QuoteRequest::where('status', 'New')->count(),
            'Quote shared' => QuoteRequest::where('status', 'Quote shared')->count(),
            'Follow-up' => QuoteRequest::where('status', 'Follow-up')->count(),
            'Converted' => QuoteRequest::where('status', 'Converted')->count(),
            'Lost' => QuoteRequest::where('status', 'Lost')->count(),
        ];

        return view('admin.quotes', compact(
            'quotes',
            'productType',
            'status',
            'from',
            'to',
            'counts'
        ));
    }

    private function transformDetails(string $productType, array $details): array
    {
        $fields = QuoteRequest::quoteFields()[$productType] ?? [];
        $labelMap = [];
        foreach ($fields as $f) {
            $labelMap[$f['key']] = $f['label'];
        }
        $out = [];
        foreach ($details as $key => $value) {
            if ($value === '' || $value === null) continue;
            $label = $labelMap[$key] ?? ucfirst(str_replace('_', ' ', $key));
            $out[] = [$label, $value];
        }
        return $out;
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'product_type' => ['required', Rule::in(QuoteRequest::productTypes())],
            'customer_name' => 'required|string|max:120',
            'customer_mobile' => ['required', 'string', 'regex:/^\d{10}$/'],
            'customer_email' => 'nullable|email|max:120',
            'customer_city' => 'nullable|string|max:80',
            'details' => 'nullable|array',
            'note' => 'nullable|string|max:500',
            'status' => ['nullable', Rule::in(QuoteRequest::statuses())],
            'consent' => 'required|boolean',
        ]);

        $data['details'] = $this->transformDetails($data['product_type'], $data['details'] ?? []);
        $data['status'] = $data['status'] ?? 'NEW';

        $quote = QuoteRequest::create($data);

        Activity::log(
            $quote->user_id,
            'quote.created',
            'Quote request created',
            ['quote_id' => $quote->id, 'product_type' => $quote->product_type, 'customer_name' => $quote->customer_name],
            'QuoteRequest',
            $quote->id
        );

        return back()->with('ok', 'Quote request saved.');
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $quote = QuoteRequest::findOrFail($id);

        $data = $request->validate([
            'product_type' => ['nullable', Rule::in(QuoteRequest::productTypes())],
            'customer_name' => 'nullable|string|max:120',
            'customer_mobile' => ['nullable', 'string', 'regex:/^\d{10}$/'],
            'customer_email' => 'nullable|email|max:120',
            'customer_city' => 'nullable|string|max:80',
            'details' => 'nullable|array',
            'note' => 'nullable|string|max:500',
            'status' => ['nullable', Rule::in(QuoteRequest::statuses())],
            'consent' => 'nullable|boolean',
        ]);

        if (isset($data['details'])) {
            $pt = $data['product_type'] ?? $quote->product_type;
            $data['details'] = $this->transformDetails($pt, $data['details']);
        }

        $oldStatus = $quote->status;
        $quote->update($data);

        $newStatus = $quote->status;
        $activityDetails = ['quote_id' => $quote->id];
        if ($oldStatus !== $newStatus) {
            $activityDetails['old_status'] = $oldStatus;
            $activityDetails['new_status'] = $newStatus;
        }

        Activity::log(
            $quote->user_id,
            'quote.updated',
            'Quote request updated',
            $activityDetails,
            'QuoteRequest',
            $quote->id
        );

        return back()->with('ok', 'Quote request updated.');
    }

    public function status(Request $request, int $id): RedirectResponse
    {
        $quote = QuoteRequest::findOrFail($id);

        $data = $request->validate([
            'status' => ['required', Rule::in(QuoteRequest::statuses())],
        ]);

        $oldStatus = $quote->status;
        $quote->update(['status' => $data['status']]);

        Activity::log(
            $quote->user_id,
            'quote.status_updated',
            'Quote request status set to ' . $data['status'],
            ['quote_id' => $quote->id, 'old_status' => $oldStatus, 'new_status' => $data['status']],
            'QuoteRequest',
            $quote->id
        );

        return back()->with('ok', 'Status updated.');
    }
}