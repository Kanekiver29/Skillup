<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GradeManagementController extends Controller
{
    protected function authorizeAdmin()
    {
        if (! auth()->check() || ! auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }
    }

    public function index()
    {
        $this->authorizeAdmin();
        return view('Admin.grades.index');
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('Admin.grades.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'student_id' => 'required',
            'course_id' => 'required',
            'score' => 'required|numeric|min:0|max:100',
        ]);

        return redirect()->route('admin.grades.index')->with('success', 'Grade recorded (placeholder).');
    }

    public function edit($grade)
    {
        $this->authorizeAdmin();
        return view('Admin.grades.edit', compact('grade'));
    }

    public function update(Request $request, $grade)
    {
        $this->authorizeAdmin();

        $request->validate([
            'score' => 'required|numeric|min:0|max:100',
        ]);

        return redirect()->route('admin.grades.index')->with('success', 'Grade approved/updated (placeholder).');
    }

    public function destroy($grade)
    {
        $this->authorizeAdmin();
        return redirect()->route('admin.grades.index')->with('success', 'Grade entry removed (placeholder).');
    }
}
