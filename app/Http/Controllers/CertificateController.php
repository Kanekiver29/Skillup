<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    /**
     * Display a course completion certificate when all published modules are complete.
     */
    public function show(string $courseSlug)
    {
        $course = Course::where('slug', $courseSlug)->firstOrFail();
        $user = auth()->user();

        $enrollment = Enrollment::where('user_id', $user->id)
            ->where('course_id', $course->id)
            ->first();

        if (!$enrollment) {
            return redirect()->route('courses.show', $course->slug)
                ->with('error', 'You must enroll in this course to view its certificate.');
        }

        $publishedModules = $course->modules()
            ->where('is_published', true)
            ->get();

        $totalModules = $publishedModules->count();
        $completedModules = $publishedModules
            ->filter(fn ($module) => $module->getProgress($user->id) === 100)
            ->count();

        $isCourseCompleted = $totalModules > 0 && $completedModules === $totalModules;

        if (!$isCourseCompleted) {
            return redirect()->route('courses.show', $course->slug)
                ->with('error', 'Complete all modules and quizzes to unlock your certificate.');
        }

        // Keep enrollment status in sync when user reaches certificate eligibility.
        if (!$enrollment->completed || (int) $enrollment->progress < 100) {
            $enrollment->update([
                'progress' => 100,
                'completed' => true,
                'completed_at' => $enrollment->completed_at ?? now(),
            ]);
        }

        $completionDate = $enrollment->completed_at ?? now();
        $certificateCode = Str::upper('SKILLUP-' . $course->id . '-' . $user->id . '-' . $completionDate->format('Ymd'));

        return view('badges.certificate', [
            'course' => $course,
            'user' => $user,
            'completionDate' => $completionDate,
            'certificateCode' => $certificateCode,
            'totalModules' => $totalModules,
            'completedModules' => $completedModules,
        ]);
    }

    /**
     * Display a list of certificates earned by the authenticated user.
     */
    public function index()
    {
        $user = auth()->user();

        $completedEnrollments = Enrollment::where('user_id', $user->id)
            ->where('completed', true)
            ->with('course')
            ->orderByDesc('completed_at')
            ->get();

        return view('courses.certificates', [
            'completedEnrollments' => $completedEnrollments,
        ]);
    }

    private function generateCertificateCode($course, $user, $completionDate)
    {
        return Str::upper('SKILLUP-' . $course->id . '-' . $user->id . '-' . $completionDate->format('Ymd'));
    }
}
