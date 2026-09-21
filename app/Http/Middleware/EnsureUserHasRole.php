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

        $normalizedRole = strtolower(trim((string) ($user->role ?? '')));
        $staffType = strtolower(trim((string) ($user->staff_type ?? '')));

        $allowed = false;

        if ($role === 'admin') {
            $allowed = in_array($normalizedRole, ['admin', 'staff'], true) || $isAdmin;
        } elseif ($role === 'staff') {
            $allowed = in_array($normalizedRole, ['staff', 'admin', 'teacher', 'instructor'], true) || $isAdmin;
        } elseif ($role === 'teacher') {
            $allowed = (method_exists($user, 'isTeacher') && $user->isTeacher())
                    || $isAdmin
                    || in_array($normalizedRole, ['teacher', 'admin', 'staff', 'instructor'], true)
                    || in_array($staffType, ['teacher', 'instructor'], true);
        } else {
            // Generic match against user->role
            $allowed = ($normalizedRole === strtolower(trim($role)));
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
