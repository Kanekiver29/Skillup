<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

abstract class Controller
{
    use AuthorizesRequests;

    /**
     * Ensure the current user has staff-level access (staff or admin).
     */
    protected function authorizeStaff()
    {
        if (!auth()->check() || !method_exists(auth()->user(), 'hasStaffAccess') || !auth()->user()->hasStaffAccess()) {
            abort(403, 'Unauthorized');
        }
    }
}
