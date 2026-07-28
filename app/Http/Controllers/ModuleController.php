<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function show($courseSlug, $moduleSlug)
    {
        $course = Course::where('slug', $courseSlug)
            ->with(['modules' => fn ($q) => $q->orderBy('order')])
            ->firstOrFail();
        $module = $course->modules->firstWhere('slug', $moduleSlug)
            ?? $course->modules()->where('slug', $moduleSlug)->firstOrFail();

        $this->authorize('view', $course);

        $userId = auth()->id();
        $userProgress = $userId ? $module->getDetailedProgress($userId) : 0;
        $orderedItems = $module->getOrderedItems();
        $lessons = $orderedItems->where('type', 'lesson')->values();
        $quizzes = $orderedItems->where('type', 'quiz')->values();
        $totalItems = $orderedItems->count();
        $passedQuizzes = $userId
            ? $quizzes->filter(fn ($q) => $q->hasUserPassed($userId))->count()
            : 0;

        // If this module contains a presentation lesson, auto‑open it
        $presentationLesson = $lessons->first(function ($l) {
            return $l->isPresentation();
        });
        if ($presentationLesson) {
            return redirect()->route('lessons.show', [
                $course->slug,
                $module->slug,
                $presentationLesson->slug,
            ]);
        }

        return view('courses.modules.show', [
            'course' => $course,
            'module' => $module,
            'userProgress' => $userProgress,
            'lessons' => $lessons,
            'quizzes' => $quizzes,
            'orderedItems' => $orderedItems,
            'totalItems' => $totalItems,
            'passedQuizzes' => $passedQuizzes,
        ]);
    }

    /**
     * Return current module progress for the active user.
     */
    public function progress($courseSlug, $moduleSlug)
    {
        $course = Course::where('slug', $courseSlug)->firstOrFail();
        $module = $course->modules()->where('slug', $moduleSlug)->firstOrFail();

        $this->authorize('view', $course);

        $userId = auth()->id();
        $userProgress = $userId ? $module->getDetailedProgress($userId) : 0;

        return response()->json([
            'progress' => $userProgress,
        ]);
    }

    public function markComplete($courseSlug, $moduleSlug)
    {
        if (!auth()->check()) {
            abort(403, 'Unauthorized');
        }

        $user = auth()->user();
        $course = Course::where('slug', $courseSlug)->firstOrFail();
        $module = $course->modules()->where('slug', $moduleSlug)->firstOrFail();

        $this->authorize('view', $course);

        $enrollment = $course->enrollments()->firstOrCreate(['user_id' => $user->id]);

        $publishedLessons = $module->lessons()->where('is_published', true)->get();
        foreach ($publishedLessons as $lesson) {
            $lessonEnrollment = $lesson->enrollments()->firstOrCreate([
                'enrollment_id' => $enrollment->id,
                'lesson_id' => $lesson->id,
            ]);
            $lessonEnrollment->completed = true;
            $lessonEnrollment->completed_at = now();
            $lessonEnrollment->save();
        }

        $this->syncEnrollmentProgress($user->id, $course, $enrollment);

        return response()->json([
            'success' => true,
            'progress' => $module->getDetailedProgress($user->id),
        ]);
    }

    public function trackTime(Request $request, $courseSlug, $moduleSlug)
    {
        if (!auth()->check()) {
            abort(403, 'Unauthorized');
        }

        $course = Course::where('slug', $courseSlug)->firstOrFail();
        $module = $course->modules()->where('slug', $moduleSlug)->firstOrFail();

        $this->authorize('view', $course);

        $seconds = (int) $request->input('seconds', 0);
        if ($seconds <= 0) {
            return response()->json(['success' => true]);
        }

        $user = auth()->user();
        $enrollment = $course->enrollments()->firstOrCreate(['user_id' => $user->id]);

        $enrollment->update([
            'progress' => max($enrollment->progress ?? 0, min(100, (int) round(($enrollment->progress ?? 0) + ($seconds / 100))))
        ]);

        return response()->json([
            'success' => true,
            'seconds' => $seconds,
            'module' => $module->slug,
        ]);
    }

    private function syncEnrollmentProgress(int $userId, Course $course, Enrollment $enrollment): void
    {
        $publishedModules = $course->modules()->where('is_published', true)->get();
        $totalModules = $publishedModules->count();
        $completedModules = $publishedModules
            ->filter(fn ($module) => $module->getProgress($userId) === 100)
            ->count();

        $progress = $totalModules > 0 ? (int) round(($completedModules / $totalModules) * 100) : 0;
        $completed = $totalModules > 0 && $completedModules === $totalModules;

        $enrollment->update([
            'progress' => $progress,
            'completed' => $completed,
            'completed_at' => $completed
                ? ($enrollment->completed_at ?? now())
                : null,
        ]);
    }
}
