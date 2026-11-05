<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\Activity;
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
        $s = DB::table('guidance_sessions')->where('id', $id)->first();
        DB::table('guidance_sessions')->where('id', $id)->update(['status' => $d['status'], 'updated_at' => now()]);
        if ($s) Activity::log((int) $s->user_id, 'session.status_updated', 'Advisory session status set to '.$d['status'], ['session_id'=>$id,'status'=>$d['status']], 'GuidanceSession', $id);

        return back()->with('ok', 'Session updated.');
    }
}