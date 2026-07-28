<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Events\UploadCreated;

class UploadController extends Controller
{
    /**
     * Show the upload form for staff.
     */
    public function create()
    {
        // Ensure staff access
        if (!auth()->check() || !auth()->user()->hasStaffAccess()) {
            abort(403, 'Unauthorized');
        }
        return view('staff.uploads.create');
    }

    /**
     * Handle the uploaded file.
     */
    public function store(Request $request)
    {
        if (!auth()->check() || !auth()->user()->hasStaffAccess()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'file' => 'required|file|max:10240', // max 10MB
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $path = $request->file('file')->store('uploads', 'public');

        // Here you could create an Upload model record if exists. For now just redirect.
        try {
            event(new UploadCreated([
                'user_id' => Auth::id(),
                'path' => $path,
                'title' => $validated['title'],
            ]));
        } catch (\Throwable $e) {
            // ignore broadcast failures
        }
        return redirect()->route('staff.dashboard')
            ->with('success', "File '{$validated['title']}' uploaded successfully.");
    }
}
