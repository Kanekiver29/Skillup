<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureStaff
{
    /**
     * Handle an incoming request.
     * Allow access to users with staff or admin role.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (!$user || !method_exists($user, 'hasStaffAccess') || !$user->hasStaffAccess()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. Staff only.'], 403);
            }
            abort(403, 'Unauthorized. Staff only.');
        }
        return $next($request);
    }
}
