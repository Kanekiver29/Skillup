<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request and ensure the authenticated user has the given role.
     * Supports: 'admin', 'staff', 'teacher' and any custom role stored on the user model.
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        $user = $request->user();
        if (! $user) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized.'], 403);
            }
            abort(403, 'Unauthorized.');
        }

        $isAdmin = property_exists($user, 'is_admin') && $user->is_admin;

        // Admins are allowed for any role-check unless you want stricter rules
        if ($isAdmin) {
            return $next($request);
        }

        $allowed = false;

        if ($role === 'admin') {
            $allowed = in_array($user->role ?? '', ['admin', 'staff']) || $isAdmin;
        } elseif ($role === 'staff') {
            $allowed = in_array($user->role ?? '', ['staff', 'admin', 'teacher']) || $isAdmin;
        } elseif ($role === 'teacher') {
            $allowed = (method_exists($user, 'isTeacher') && $user->isTeacher()) || $isAdmin;
        } else {
            // Generic match against user->role
            $allowed = ($user->role === $role);
        }

        if (! $allowed) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized.'], 403);
            }
            abort(403, 'Unauthorized.');
        }

        return $next($request);
    }
}
