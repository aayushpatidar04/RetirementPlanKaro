<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function index(Request $request): View
    {
        $status = trim((string) $request->query('status', ''));
        $from = trim((string) $request->query('from', ''));
        $to = trim((string) $request->query('to', ''));

        $payments = $this->query($status, $from, $to)
            ->paginate(40)
            ->withQueryString();

        $totals = [
            'success' => (float) DB::table('payments')->when($from !== '', fn ($q) => $q->whereDate('created_at', '>=', $from))->when($to !== '', fn ($q) => $q->whereDate('created_at', '<=', $to))->where('status', 'success')->sum('amount'),
            'pending' => DB::table('payments')->when($from !== '', fn ($q) => $q->whereDate('created_at', '>=', $from))->when($to !== '', fn ($q) => $q->whereDate('created_at', '<=', $to))->where('status', 'pending')->count(),
            'failed'  => DB::table('payments')->when($from !== '', fn ($q) => $q->whereDate('created_at', '>=', $from))->when($to !== '', fn ($q) => $q->whereDate('created_at', '<=', $to))->where('status', 'failed')->count(),
        ];

        return view('admin.payments', compact('payments', 'status', 'from', 'to', 'totals'));
    }

    private function query(string $status, string $from, string $to)
    {
        return DB::table('payments')
            ->join('users', 'users.id', '=', 'payments.user_id')
            ->when($status !== '', fn ($q) => $q->where('payments.status', $status))
            ->when($from !== '', fn ($q) => $q->whereDate('payments.created_at', '>=', $from))
            ->when($to !== '', fn ($q) => $q->whereDate('payments.created_at', '<=', $to))
            ->orderByDesc('payments.id')
            ->select('payments.*', 'users.name', 'users.surname', 'users.mobile', 'users.email');
    }

    /** Every payment matching the filters (not just the page on screen), for Export Excel. */
    public function export(Request $request): \Illuminate\Http\JsonResponse
    {
        $status = trim((string) $request->query('status', ''));
        $from = trim((string) $request->query('from', ''));
        $to = trim((string) $request->query('to', ''));

        $rows = $this->query($status, $from, $to)->get()->map(fn ($p) => [
            $p->txnid, trim($p->name . ' ' . $p->surname), $p->mobile, $p->email, ucfirst((string) $p->purpose),
            (float) $p->base_amount, (string) ($p->coupon_code ?: ''), (float) $p->coupon_off, (int) $p->points_used, (float) $p->amount,
            $p->status, (string) ($p->payu_id ?: ''), (string) ($p->mode ?: ''),
            \Illuminate\Support\Carbon::parse($p->created_at)->format('d M Y, h:i A'),
            $p->paid_at ? \Illuminate\Support\Carbon::parse($p->paid_at)->format('d M Y, h:i A') : '',
        ])->all();

        return response()->json([
            'filename' => 'Transactions_' . ($from ?: 'start') . '_to_' . ($to ?: 'today') . '.xlsx',
            'sheets' => [[
                'name' => 'Transactions', 'title' => 'Transactions / Payments',
                'sub' => 'Retirement Plan Karo · ' . count($rows) . ' records' . ($status ? ' · ' . $status : ''),
                'head' => ['Txn ID', 'Customer', 'Mobile', 'Email', 'Purpose', 'Price', 'Coupon', 'Coupon off', 'Points used', 'Amount paid', 'Status', 'PayU ID', 'Mode', 'Created', 'Paid at'],
                'rows' => $rows,
            ]],
        ]);
    }
}
