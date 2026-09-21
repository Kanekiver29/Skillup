<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureAdmin
{
    /**
     * Handle an incoming request.
     * Allow access only to admin users.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        $role = strtolower(trim((string) ($user->role ?? '')));
        $isAdmin = (bool) ($user->is_admin ?? false)
            || in_array($role, ['admin', 'sias_admin'], true);

        if (!$user || ! $isAdmin) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. Admins only.'], 403);
            }
            abort(403, 'Unauthorized. Admins only.');
        }
        return $next($request);
    }
}
