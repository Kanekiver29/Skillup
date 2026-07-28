<?php
namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Show form to create a new student.
     */
    public function create()
    {
        return view('staff.students.create');
    }

    /**
     * Store a newly created student.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'student_id' => 'required|string|unique:students,student_id',
        ]);

        Student::create($validated);

        return redirect()->route('students.create')
            ->with('success', 'Student created successfully.');
    }
}
