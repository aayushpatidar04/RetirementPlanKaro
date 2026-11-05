<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserNotSuspended
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::guard('web')->user();
        if ($user && (($user->status === 'Blocked') || !empty($user->suspended_at))) {
            Auth::guard('web')->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            if ($request->expectsJson() || $request->is('api/*')) {
                return response()->json([
                    'message' => 'Your account has been suspended. Please contact support.',
                    'suspended' => true,
                    'csrf' => csrf_token(),
                ], 403);
            }

            return redirect('/')->with('error', 'Your account has been suspended. Please contact support.');
        }

        return $next($request);
    }
}
