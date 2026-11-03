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

        $payments = DB::table('payments')
            ->join('users', 'users.id', '=', 'payments.user_id')
            ->when($status !== '', fn ($q) => $q->where('payments.status', $status))
            ->orderByDesc('payments.id')
            ->select('payments.*', 'users.name', 'users.mobile')
            ->paginate(40)
            ->withQueryString();

        $totals = [
            'success' => (float) DB::table('payments')->where('status', 'success')->sum('amount'),
            'pending' => DB::table('payments')->where('status', 'pending')->count(),
            'failed'  => DB::table('payments')->where('status', 'failed')->count(),
        ];

        return view('admin.payments', compact('payments', 'status', 'totals'));
    }
}