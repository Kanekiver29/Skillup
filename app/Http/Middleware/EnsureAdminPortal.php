<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureAdminPortal
{
    public function handle(Request $request, Closure $next)
    {
        if (! $request->is('admin') && ! $request->is('admin/*')) {
            return $next($request);
        }

        $user = $request->user();
        if (! $user) {
            return redirect()->guest(route('login'));
        }

        $role = strtolower(trim((string) ($user->role ?? '')));
        $isAdminAccount = (bool) ($user->is_admin ?? false)
            || in_array($role, ['admin', 'sias_admin'], true);

        $allowed = $request->is('admin/backup') || $request->is('admin/backup/*')
            ? in_array($role, ['admin', 'sias_admin'], true) || (bool) ($user->is_admin ?? false)
            : $isAdminAccount;

        if (! $allowed) {
            abort(403, 'This account does not have access to this administration portal.');
        }

        return $next($request);
    }
}
