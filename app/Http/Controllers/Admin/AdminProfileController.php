<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;
use App\Models\Enrollment;
use App\Models\User;

class AdminProfileController extends Controller
{
    /**
     * Show the admin profile page.
     */
    public function show(Request $request)
    {
        $user = $request->user();

        if (!$user || !$user->hasStaffAccess()) {
            abort(403, 'Unauthorized');
        }

        // Enrollment chart data
        // Daily (last 7 days)
        $dailyLabels = [];
        $dailyData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $dailyLabels[] = $date->format('M d');
            $dailyData[] = Enrollment::whereDate('created_at', $date->toDateString())->count();
        }

        // Weekly (last 4 weeks)
        $weeklyLabels = [];
        $weeklyData = [];
        for ($i = 3; $i >= 0; $i--) {
            $start = now()->subWeeks($i)->startOfWeek();
            $end = now()->subWeeks($i)->endOfWeek();
            $weeklyLabels[] = $start->format('M d') . ' - ' . $end->format('M d');
            $weeklyData[] = Enrollment::whereBetween('created_at', [$start, $end])->count();
        }

        // Monthly (last 6 months)
        $monthlyLabels = [];
        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $date = now()->subMonths($i);
            $monthlyLabels[] = $date->format('M Y');
            $monthlyData[] = Enrollment::whereYear('created_at', $date->year)
                ->whereMonth('created_at', $date->month)->count();
        }

        // Yearly (last 4 years)
        $yearlyLabels = [];
        $yearlyData = [];
        for ($i = 3; $i >= 0; $i--) {
            $year = now()->subYears($i)->year;
            $yearlyLabels[] = (string) $year;
            $yearlyData[] = Enrollment::whereYear('created_at', $year)->count();
        }

        return view('Admin.myprofile', [
            'user' => $user,
            'dailyLabels' => $dailyLabels,
            'dailyData' => $dailyData,
            'weeklyLabels' => $weeklyLabels,
            'weeklyData' => $weeklyData,
            'monthlyLabels' => $monthlyLabels,
            'monthlyData' => $monthlyData,
            'yearlyLabels' => $yearlyLabels,
            'yearlyData' => $yearlyData,
        ]);
    }

    /**
     * Update the admin profile.
     */
    public function update(Request $request)
    {
        $user = $request->user();

        if (!$user || !$user->hasStaffAccess()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'bio' => 'nullable|string|max:500',
            'location' => 'nullable|string|max:255',
            'github_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'portfolio_url' => 'nullable|url|max:255',
        ]);

        // Handle profile image upload
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');

            $uploadPath = public_path('uploads/profiles');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Delete old image if exists
            if ($user->profile_image && file_exists($uploadPath . '/' . $user->profile_image)) {
                unlink($uploadPath . '/' . $user->profile_image);
            }

            $filename = time() . '_' . $user->id . '.' . $file->getClientOriginalExtension();
            $file->move($uploadPath, $filename);
            $validated['profile_image'] = $filename;
        }

        $user->update($validated);

        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully!');
    }

    /**
     * Update the admin password.
     */
    public function updatePassword(Request $request)
    {
        $user = $request->user();

        if (!$user || !$user->hasStaffAccess()) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()->numbers()],
        ]);

        // Guard: ensure the stored password is a supported hash before checking
        $stored = (string) $user->password;
        if (!preg_match('/^(\$2[aby]\$|\$argon2)/i', $stored)) {
            // Log a warning for investigation and ask user to reset password
            logger()->warning('User '.$user->id.' has password stored in unsupported format.', ['stored' => $stored]);
            return back()->withErrors(['current_password' => 'Your account password appears to be stored in an unsupported format. Please use the password reset flow to secure your account.']);
        }

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('admin.profile')->with('success', 'Password changed successfully!');
    }

    /**
     * Return real-time enrollment chart data + recent activity as JSON (polled by the dashboard).
     */
    public function liveData(Request $request)
    {
        $user = $request->user();
        if (!$user || !$user->hasStaffAccess()) {
            abort(403);
        }

        // --- chart data ---
        $daily = $this->buildSeries('day', 6);
        $weekly = $this->buildSeries('week', 3);
        $monthly = $this->buildSeries('month', 5);
        $yearly = $this->buildSeries('year', 3);

        // --- recent activity (last 15 enrollments) ---
        $recentEnrollments = Enrollment::with(['user:id,name,email,profile_image', 'course:id,title'])
            ->latest()
            ->take(15)
            ->get()
            ->map(fn ($e) => [
                'student'    => $e->user->name ?? 'Unknown',
                'email'      => $e->user->email ?? '',
                'avatar'     => $e->user->profile_image
                    ? asset('uploads/profiles/' . $e->user->profile_image)
                    : null,
                'initials'   => strtoupper(substr($e->user->name ?? '?', 0, 1)),
                'course'     => $e->course->course_title ?? $e->course->title ?? 'Unknown Course',
                'time'       => $e->created_at->diffForHumans(),
                'timestamp'  => $e->created_at->toIso8601String(),
            ]);

        // --- live counters ---
        $onlineToday = User::whereDate('updated_at', now()->toDateString())->count();
        $enrolledToday = Enrollment::whereDate('created_at', now()->toDateString())->count();
        $totalStudents = User::where('is_admin', false)->where('role', '!=', 'staff')->count();

        return response()->json([
            'chart' => [
                'daily'   => $daily,
                'weekly'  => $weekly,
                'monthly' => $monthly,
                'yearly'  => $yearly,
            ],
            'activity' => $recentEnrollments,
            'counters' => [
                'onlineToday'   => $onlineToday,
                'enrolledToday' => $enrolledToday,
                'totalStudents' => $totalStudents,
            ],
        ]);
    }

    /**
     * Build labels + data arrays for a given interval.
     */
    private function buildSeries(string $unit, int $lookback): array
    {
        $labels = [];
        $data   = [];

        for ($i = $lookback; $i >= 0; $i--) {
            $date = now()->sub($unit, $i);

            switch ($unit) {
                case 'day':
                    $labels[] = $date->format('M d');
                    $data[]   = Enrollment::whereDate('created_at', $date->toDateString())->count();
                    break;
                case 'week':
                    $start = (clone $date)->startOfWeek();
                    $end   = (clone $date)->endOfWeek();
                    $labels[] = $start->format('M d') . ' – ' . $end->format('M d');
                    $data[]   = Enrollment::whereBetween('created_at', [$start, $end])->count();
                    break;
                case 'month':
                    $labels[] = $date->format('M Y');
                    $data[]   = Enrollment::whereYear('created_at', $date->year)
                        ->whereMonth('created_at', $date->month)->count();
                    break;
                case 'year':
                    $labels[] = (string) $date->year;
                    $data[]   = Enrollment::whereYear('created_at', $date->year)->count();
                    break;
            }
        }

        return compact('labels', 'data');
    }
}
