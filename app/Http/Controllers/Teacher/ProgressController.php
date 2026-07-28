<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ProgressController extends Controller
{
    public function index()
    {
        // Show overview of student progress — minimal stub
        return view('teacher.progress.index');
    }

    public function show($student)
    {
        $studentModel = User::find($student);
        return view('teacher.progress.show', ['student' => $studentModel]);
    }
}
