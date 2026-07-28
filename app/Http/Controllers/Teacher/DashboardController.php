<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Minimal dashboard: forward to courses index for now
        return view('teacher.dashboard');
    }
}
