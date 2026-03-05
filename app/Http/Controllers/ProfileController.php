<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    /**
     * Show the user's profile.
     */
    public function show(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return redirect('/login');
        }

        // Get user's enrollments with course details
        $enrollments = $user->enrollments()
            ->with('course')
            ->latest()
            ->paginate(10);
        
        // Get completed courses count
        $completedCourses = $user->enrollments()
            ->where('completed', true)
            ->count();

        return view('Userpage.profile', [
            'user' => $user,
            'enrollments' => $enrollments,
            'completedCourses' => $completedCourses,
        ]);
    }

    /**
     * Show the profile edit form.
     */
    public function edit(Request $request)
    {
        $user = $request->user();

        return view('Userpage.profile-edit', [
            'user' => $user,
        ]);
    }

    /**
     * Update the user's profile.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'bio' => 'nullable|string|max:500',
            'location' => 'nullable|string|max:255',
            'github_url' => 'nullable|url',
            'portfolio_url' => 'nullable|url',
            'skills' => 'nullable|json',
            'profile_public' => 'nullable|boolean',
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            
            // Ensure directory exists
            $uploadPath = public_path('uploads/profiles');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Delete old image if exists
            if ($user->profile_image && file_exists($uploadPath . '/' . $user->profile_image)) {
                unlink($uploadPath . '/' . $user->profile_image);
            }

            // Generate unique filename using MIME-derived extension (safe)
            $filename = time() . '_' . $user->id . '.' . $file->guessExtension();
            
            // Save the file
            $file->move($uploadPath, $filename);
            $validated['profile_image'] = $filename;
        }

        // Handle skills JSON
        if (isset($validated['skills'])) {
            $validated['skills'] = json_decode($validated['skills'], true);
        }

        // Handle boolean profile_public
        $validated['profile_public'] = $request->has('profile_public');

        $user->update($validated);

        return redirect()->route('userpage.profile')->with('success', 'Profile updated successfully!');
    }

    /**
     * Show the user's dashboard.
     * For regular users: Shows their profile and stats
     * For admins: Shows all user accounts
     */
    public function dashboard(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return redirect('/login');
        }

        // If user is admin, redirect them to the main admin dashboard
        if ($user->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        // For regular users, show their profile and stats
        $enrollments = $user->enrollments()
            ->with('course')
            ->latest()
            ->get();

        $totalHours = $user->enrollments()->sum('hours_spent') ?? 0;
        $completedCourses = $user->enrollments()->where('completed', true)->count();
        $inProgressCourses = $user->enrollments()->where('completed', false)->count();
        $badges = 24; // This could come from a database

        return view('Userpage.dashboard', [
            'user' => $user,
            'enrollments' => $enrollments,
            'totalHours' => $totalHours,
            'completedCourses' => $completedCourses,
            'inProgressCourses' => $inProgressCourses,
            'badges' => $badges,
            'isAdmin' => false,
        ]);
    }
}
