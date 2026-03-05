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
        return view('Admin.main');
    }
}
