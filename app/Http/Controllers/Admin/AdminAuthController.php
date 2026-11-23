<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\Activity;
use App\Support\AdminAccess;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminAuthController extends Controller
{
    public function showLogin(): View|RedirectResponse
    {
        if (AdminAccess::actor()) {
            return redirect(AdminAccess::home());
        }

        return view('admin.login');
    }

    /** Owner account (admins table) first, then team members who have been given a password. */
    public function login(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'email'    => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);
        $data['email'] = strtolower(trim($data['email']));

        if (Auth::guard('admin')->attempt($data, true)) {
            $request->session()->regenerate();
            AdminAccess::flush();
            Activity::log(null, 'admin.login', 'Signed in to the admin portal');

            return redirect()->intended(AdminAccess::home());
        }

        if (Auth::guard('team')->attempt($data + ['is_active' => true], true)) {
            $request->session()->regenerate();
            $m = Auth::guard('team')->user();
            $m->forceFill(['last_login_at' => now()])->save();
            AdminAccess::flush();
            Activity::log(null, 'admin.login', 'Signed in to the admin portal');

            return redirect(AdminAccess::home());
        }

        return back()->withErrors(['email' => 'Those credentials do not match, or this account is inactive.'])->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::guard('admin')->logout();
        Auth::guard('team')->logout();
        AdminAccess::flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }
}
