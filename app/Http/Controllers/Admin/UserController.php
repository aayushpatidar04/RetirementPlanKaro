<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

        return view('admin.users.show', compact('user', 'payments', 'sessions', 'leads', 'blobs'));
    }
}
