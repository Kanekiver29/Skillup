<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SectionManagementController extends Controller
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
        return view('Admin.sections.index');
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('Admin.sections.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'name' => 'required|string|max:255',
            'course_id' => 'required',
        ]);

        return redirect()->route('admin.sections.index')->with('success', 'Section created (placeholder).');
    }

    public function edit($section)
    {
        $this->authorizeAdmin();
        return view('Admin.sections.edit', compact('section'));
    }

    public function update(Request $request, $section)
    {
        $this->authorizeAdmin();

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        return redirect()->route('admin.sections.index')->with('success', 'Section updated (placeholder).');
    }

    public function destroy($section)
    {
        $this->authorizeAdmin();
        return redirect()->route('admin.sections.index')->with('success', 'Section deleted (placeholder).');
    }
}
