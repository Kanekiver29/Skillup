<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

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
?>
