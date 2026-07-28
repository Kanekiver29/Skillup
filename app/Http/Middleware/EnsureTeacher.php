<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureTeacher
{
    /**
     * Allow access to users with role 'teacher' or staff members with staff_type 'teacher' or admins.
     */
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();
        if (! $user) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. Teachers only.'], 403);
            }
            abort(403, 'Unauthorized. Teachers only.');
        }

        $isTeacher = method_exists($user, 'isTeacher') && $user->isTeacher();

        if (! $isTeacher) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. Teachers only.'], 403);
            }
            abort(403, 'Unauthorized. Teachers only.');
        }

        return $next($request);
    }
}
