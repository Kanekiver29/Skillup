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
        if (!$user || (! $user->is_admin && ($user->role ?? '') !== 'admin')) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. Admins only.'], 403);
            }
            abort(403, 'Unauthorized. Admins only.');
        }
        return $next($request);
    }
}
