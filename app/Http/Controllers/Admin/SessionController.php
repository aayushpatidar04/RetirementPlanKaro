<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class SessionController extends Controller
{
    public function index(): View
    {
        $sessions = DB::table('guidance_sessions')
            ->join('users', 'users.id', '=', 'guidance_sessions.user_id')
            ->orderByDesc('guidance_sessions.id')
            ->select('guidance_sessions.*', 'users.name', 'users.email')
            ->paginate(40);

        return view('admin.sessions', compact('sessions'));
    }

    public function status(Request $request, int $id): RedirectResponse
    {
        $d = $request->validate(['status' => ['required', Rule::in(['confirmed', 'done', 'cancelled'])]]);
        DB::table('guidance_sessions')->where('id', $id)->update(['status' => $d['status'], 'updated_at' => now()]);

        return back()->with('ok', 'Session updated.');
    }
}