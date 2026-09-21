<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    protected function authorizeAdmin()
    {
        if (! auth()->check() || ! auth()->user()->is_admin) {
            abort(403, 'Unauthorized');
        }
    }

    public function index()
    {
        $this->authorizeAdmin();
        return view('Admin.announcements.index');
    }

    public function create()
    {
        $this->authorizeAdmin();
        return view('Admin.announcements.create');
    }

    public function store(Request $request)
    {
        $this->authorizeAdmin();

        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement saved (placeholder).');
    }

    public function edit($announcement)
    {
        $this->authorizeAdmin();
        return view('Admin.announcements.edit', compact('announcement'));
    }

    public function update(Request $request, $announcement)
    {
        $this->authorizeAdmin();

        $request->validate([
            'title' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement updated (placeholder).');
    }

    public function destroy($announcement)
    {
        $this->authorizeAdmin();
        return redirect()->route('admin.announcements.index')->with('success', 'Announcement deleted (placeholder).');
    }
}
