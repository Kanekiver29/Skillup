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
                return response()->json(['message' => 'Unauthorized. Please log in.'], 401);
            }
            return redirect()->route('login');
        }

        $isTeacher = (method_exists($user, 'isTeacher') && $user->isTeacher())
            || (method_exists($user, 'isAdmin') && $user->isAdmin())
            || (method_exists($user, 'hasStaffAccess') && $user->hasStaffAccess())
            || in_array(strtolower((string)($user->role ?? '')), ['teacher', 'admin', 'staff', 'instructor'], true)
            || in_array(strtolower((string)($user->staff_type ?? '')), ['teacher', 'instructor'], true);

        if (! $isTeacher) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. Teachers only.'], 403);
            }
            return redirect()->route('home')->with('error', 'Access restricted to teacher portal.');
        }

        return $next($request);
    }
}
