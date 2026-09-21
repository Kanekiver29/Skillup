<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureSiasAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $user = $request->user();

        $role = strtolower(trim((string) ($user->role ?? '')));
        $isSiasAdminAccount = $user && (
            $user->isAdmin()
            || in_array($role, ['admin', 'sias_admin'], true)
        );

        if (! $user || ! $isSiasAdminAccount) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized. SIAS administrators only.'], 403);
            }

            abort(403, 'Unauthorized. SIAS administrators only.');
        }

        return $next($request);
    }
}
