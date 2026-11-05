<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class UserController extends Controller
{
    public function index(Request $request): View
    {
        $q = trim((string) $request->query('q', ''));

        $users = DB::table('users')
            ->when($q !== '', function ($query) use ($q) {
                $query->where(function ($w) use ($q) {
                    $w->where('name', 'like', "%{$q}%")
                        ->orWhere('surname', 'like', "%{$q}%")
                        ->orWhere('email', 'like', "%{$q}%")
                        ->orWhere('mobile', 'like', "%{$q}%")
                        ->orWhere('referral_code', 'like', "%{$q}%");
                });
            })
            ->orderByDesc('id')
            ->paginate(30)
            ->withQueryString();

        return view('admin.users.index', compact('users', 'q'));
    }

    public function show(int $id): View
    {
        $user = DB::table('users')->find($id);
        $payments = DB::table('payments')->where('user_id', $id)->orderByDesc('id')->get();
        $sessions = DB::table('guidance_sessions')->where('user_id', $id)->orderByDesc('id')->get();
        $leads = DB::table('leads')->where('user_id', $id)->orderByDesc('id')->get();
        $blobs = DB::table('user_blobs')->where('user_id', $id)->get();
        $reportPts = (int) DB::table('points_ledger')->where('user_id', $id)->where('account','report')->sum('points');
        $walletPts = (int) DB::table('points_ledger')->where('user_id', $id)->where('account','wallet')->sum('points');
        $ledger = DB::table('points_ledger')->where('user_id', $id)->orderByDesc('id')->limit(50)->get();

        return view('admin.users.show', compact('user', 'payments', 'sessions', 'leads', 'blobs', 'reportPts', 'walletPts', 'ledger'));
    }


    public function adjustPoints(Request $request, int $id): RedirectResponse
    {
        $data = $request->validate([
            'kind' => 'required|in:Points,Wallet (₹)',
            'amount' => 'required|numeric|not_in:0',
            'reason' => 'required|string|max:120',
        ]);
        $account = $data['kind'] === 'Points' ? 'report' : 'wallet';
        DB::table('points_ledger')->insert([
            'user_id' => $id,
            'account' => $account,
            'type' => 'admin_adjust',
            'points' => (int) $data['amount'],
            'note' => 'Admin: ' . $data['reason'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        return redirect()->route('admin.users.show', $id)->with('ok', 'Adjustment saved.');
    }

}

