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

        $payments = DB::table('payments')
            ->join('users', 'users.id', '=', 'payments.user_id')
            ->when($status !== '', fn ($q) => $q->where('payments.status', $status))
            ->when($from !== '', fn ($q) => $q->whereDate('payments.created_at', '>=', $from))
            ->when($to !== '', fn ($q) => $q->whereDate('payments.created_at', '<=', $to))
            ->orderByDesc('payments.id')
            ->select('payments.*', 'users.name', 'users.surname', 'users.mobile', 'users.email')
            ->paginate(40)
            ->withQueryString();

        $totals = [
            'success' => (float) DB::table('payments')->when($from !== '', fn ($q) => $q->whereDate('created_at', '>=', $from))->when($to !== '', fn ($q) => $q->whereDate('created_at', '<=', $to))->where('status', 'success')->sum('amount'),
            'pending' => DB::table('payments')->when($from !== '', fn ($q) => $q->whereDate('created_at', '>=', $from))->when($to !== '', fn ($q) => $q->whereDate('created_at', '<=', $to))->where('status', 'pending')->count(),
            'failed'  => DB::table('payments')->when($from !== '', fn ($q) => $q->whereDate('created_at', '>=', $from))->when($to !== '', fn ($q) => $q->whereDate('created_at', '<=', $to))->where('status', 'failed')->count(),
        ];

        return view('admin.payments', compact('payments', 'status', 'from', 'to', 'totals'));
    }
}