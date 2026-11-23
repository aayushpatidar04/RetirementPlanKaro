<?php

namespace App\Http\Middleware;

use App\Support\AdminAccess;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

/**
 * Signed-in check + role permissions for every admin route.
 * GET needs View, POST/PUT needs Edit, delete routes need Delete,
 * exports need "@export" and publish needs "@publish".
 */
class AdminAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        AdminAccess::flush();
        $actor = AdminAccess::actor();

        if (!$actor) {
            // a team member who was deactivated while signed in
            if (Auth::guard('team')->check()) {
                Auth::guard('team')->logout();
            }
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Please sign in again.'], 401);
            }

            return redirect()->guest('/admin/login');
        }

        $need = AdminAccess::requirement($request->route()?->getName(), $request->method());
        if ($need) {
            [$area, $act, $special] = $need;
            $ok = AdminAccess::can($area, $act) && (!$special || AdminAccess::can($special));
            if (!$ok) {
                $msg = AdminAccess::denyMessage($area, $act, $special && AdminAccess::can($area, $act) ? $special : null);

                // exports are fetched by the page's script, so they always get JSON back
                if ($request->expectsJson() || $request->ajax() || ($special === '@export' && $request->isMethod('GET'))) {
                    return response()->json(['message' => $msg], 403);
                }
                if ($request->isMethod('GET')) {
                    return response()->view('admin.denied', ['area' => $area, 'message' => $msg], 403);
                }

                return back()->with('denied', $msg);
            }
        }

        return $next($request);
    }
}
