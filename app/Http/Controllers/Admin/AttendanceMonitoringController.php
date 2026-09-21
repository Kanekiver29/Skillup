<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AttendanceMonitoringController extends Controller
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
        return view('Admin.attendance.index');
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('Admin.attendance.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'user_id' => 'required',
            'course_id' => 'required',
            'status' => 'required|string',
        ]);

        return redirect()->route('admin.attendance.index')->with('success', 'Attendance recorded (placeholder).');
    }

    public function edit($attendance)
    {
        $this->authorizeAdmin();
        return view('Admin.attendance.edit', compact('attendance'));
    }

    public function update(Request $request, $attendance)
    {
        $this->authorizeAdmin();

        $request->validate([
            'status' => 'required|string',
        ]);

        return redirect()->route('admin.attendance.index')->with('success', 'Attendance updated (placeholder).');
    }

    public function destroy($attendance)
    {
        $this->authorizeAdmin();
        return redirect()->route('admin.attendance.index')->with('success', 'Attendance entry deleted (placeholder).');
    }
}
