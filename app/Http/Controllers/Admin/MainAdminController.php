<?php 

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MainAdminController extends Controller
{
    /**
     * Show the main admin page.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        // Check if user is admin
        if (! $user || ! $user->is_admin) {
            abort(403, 'Forbidden');
        }

        return view('Admin.main');
    }
}

?>