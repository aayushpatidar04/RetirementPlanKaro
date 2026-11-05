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
        $notes = DB::table('client_notes')->where('user_id', $id)->orderByDesc('id')->get();

        return view('admin.users.show', compact('user', 'payments', 'sessions', 'leads', 'blobs', 'reportPts', 'walletPts', 'ledger', 'notes'));
    }



    public function updateTags(Request $request, int $id): RedirectResponse
    {
        $data = $request->validate([
            'tags' => 'nullable|string|max:500',
            'assigned_to' => 'nullable|string|max:100',
            'stage' => 'nullable|string|max:50',
        ]);
        $tags = collect(explode(',', (string)($data['tags'] ?? '')))->map(fn($t)=>trim($t))->filter()->values()->all();
        DB::table('users')->where('id', $id)->update([
            'tags' => json_encode($tags),
            'assigned_to' => $data['assigned_to'] ?? null,
            'stage' => $data['stage'] ?? null,
            'updated_at' => now(),
        ]);
        return redirect()->route('admin.users.show', $id)->with('ok', 'Tags updated.');
    }



}

