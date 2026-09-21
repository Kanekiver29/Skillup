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

        // In-progress courses count
        $inProgress = $user->enrollments()
            ->where('completed', false)
            ->count();

        // Average progress across all enrolled courses
        $avgProgress = $user->enrollments()->avg('progress') ?? 0;

        // Earned badges and completed certificates
        $earnedBadges = $user->badges()
            ->with('badge')
            ->latest('earned_at')
            ->take(6)
            ->get();

        $completedCertificates = $user->enrollments()
            ->where('completed', true)
            ->with('course')
            ->orderByDesc('completed_at')
            ->take(6)
            ->get();

        return view('Userpage.profile', [
            'user' => $user,
            'enrollments' => $enrollments,
            'completedCourses' => $completedCourses,
            'inProgress' => $inProgress,
            'avgProgress' => round($avgProgress, 1),
            'earnedBadges' => $earnedBadges,
            'completedCertificates' => $completedCertificates,
        ]);
    }

    /**
     * Show the profile edit form.
     */
    public function edit(Request $request)
    {
        $user = $request->user();

        // If accessed under teacher routes, return teacher profile edit view
        if ($request->is('teacher/*')) {
            return view('teacher.profile-edit', [ 'user' => $user ]);
        }

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
            'lrn' => 'nullable|string|max:20|unique:users,lrn,' . $user->id,
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

            // Generate unique filename
            $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            
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

        $redirectRoute = $request->is('teacher/*') ? 'teacher.profile.edit' : 'userpage.profile';

        return redirect()->route($redirectRoute)->with('success', 'Profile updated successfully!');
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
        $badges = $user->badges()->count(); // Get actual badge count

        // Earned badges and completed certificates for dashboard
        $earnedBadges = $user->badges()
            ->with('badge')
            ->latest('earned_at')
            ->take(6)
            ->get();

        $completedCertificates = $user->enrollments()
            ->where('completed', true)
            ->with('course')
            ->orderByDesc('completed_at')
            ->take(6)
            ->get();

        return view('Userpage.dashboard', [
            'user' => $user,
            'enrollments' => $enrollments,
            'totalHours' => $totalHours,
            'completedCourses' => $completedCourses,
            'inProgressCourses' => $inProgressCourses,
            'badges' => $badges,
            'earnedBadges' => $earnedBadges,
            'completedCertificates' => $completedCertificates,
            'isAdmin' => false,
        ]);
    }

    /**
     * Show the user's learning history (enrollments and quiz attempts).
     */
    public function history(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return redirect('/login');
        }

        // Get enrollments history
        $enrollments = $user->enrollments()
            ->with('course')
            ->latest()
            ->limit(20)
            ->get();

        // Get quiz attempts history
        $quizAttempts = $user->quizAttempts()
            ->with(['quiz.module.course'])
            ->latest()
            ->limit(20)
            ->get();

        // Stats
        $totalEnrollments = $user->enrollments()->count();
        $completedCourses = $user->enrollments()->where('completed', true)->count();
        $totalQuizzes = $quizAttempts->count();
        $totalHours = $user->enrollments()->sum('hours_spent') ?? 0;

        return view('history.history', compact(
            'user',
            'enrollments',
            'quizAttempts',
            'totalEnrollments',
            'completedCourses',
            'totalQuizzes',
            'totalHours'
        ));
    }

    /**
     * JSON endpoint used by the profile page to poll for updates
     * on each enrolled course's progress/status.
     */
    public function enrollmentStats(Request $request)
    {
        $user = $request->user();

        if (! $user) {
            return response()->json([], 401);
        }

        $stats = $user->enrollments()
            ->with('course:id,title')
            ->get(['id', 'course_id', 'progress', 'completed']);

        return response()->json($stats);
    }

    /**
     * Update user career profile (interest and skill level)
     */
    public function updateCareerProfile(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $validated = $request->validate([
            'interest' => 'nullable|string|max:255',
            'skill_level' => 'nullable|string|max:255',
        ]);

        $user = auth()->user();

        // Get or create user profile
        $profile = $user->profile ?? new \App\Models\UserProfile(['user_id' => $user->id]);

        // Update only provided fields
        if (isset($validated['interest']) && !empty($validated['interest'])) {
            $profile->interest = $validated['interest'];
        }

        if (isset($validated['skill_level']) && !empty($validated['skill_level'])) {
            $profile->skill_level = $validated['skill_level'];
        }

        $profile->save();

        return response()->json([
            'success' => true,
            'message' => 'Career profile updated successfully',
            'profile' => $profile,
        ]);
    }

    /**
     * Get user career profile
     */
    public function getCareerProfile()
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }

        $user = auth()->user();
        $profile = $user->profile ?? new \App\Models\UserProfile();

        return response()->json([
            'success' => true,
            'profile' => $profile,
        ]);
    }
}
