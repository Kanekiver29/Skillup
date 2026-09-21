<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LessonController extends Controller
{
    /**
     * Store a newly created lesson in the module.
     */
    public function store(Request $request)
    {
        if (!auth()->check() || !(auth()->user()->hasStaffAccess() || (method_exists(auth()->user(), 'isTeacher') && auth()->user()->isTeacher()))) {
            abort(403, 'Unauthorized');
        }

        $course = Course::findOrFail($request->input('course_id'));
        $module = Module::findOrFail($request->input('module_id'));
        // Ensure the module belongs to the selected course
        if ($module->course_id !== $course->id) {
            abort(400, 'Module does not belong to the selected course');
        }

        $validated = $request->validate([
            'lesson_title' => 'required|string|max:255',
            'lesson_description' => 'nullable|string',
            'lesson_content' => 'nullable|string',
            'lesson_duration' => 'nullable|integer|min:0',
            'lesson_video_url' => 'nullable|url',
            'lesson_order' => 'nullable|integer|min:0',
            'lesson_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        $slug = Str::slug($validated['lesson_title']);
        $originalSlug = $slug;
        $counter = 1;

        while (Lesson::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        $lessonData = [
            'course_id' => $course->id,
            'module_id' => $module->id,
            'title' => $validated['lesson_title'],
            'slug' => $slug,
            'description' => $validated['lesson_description'] ?? null,
            // 'content' is required by DB schema; default to empty string if not provided
            'content' => $validated['lesson_content'] ?? '',
            // ensure DB non-null integer column gets a numeric default
            'duration_minutes' => isset($validated['lesson_duration']) && $validated['lesson_duration'] !== null
                ? (int) $validated['lesson_duration']
                : 0,
            'video_url' => $validated['lesson_video_url'] ?? null,
            'order' => $validated['lesson_order'] ?? ($module->lessons()->max('order') ?? 0) + 1,
            'is_published' => true,
        ];

        if ($request->hasFile('lesson_image')) {
            $path = $request->file('lesson_image')->store('lessons/images', 'public');
            $lessonData['image_url'] = Storage::url($path);
        }

        $lesson = Lesson::create($lessonData);

        return redirect()->route('modules.show', [$course->slug, $module->slug])
            ->with('success', "Lesson '{$lesson->title}' added successfully.");
    }

    /**
     * Display active lessons for staff.
     */
    public function index()
    {
        if (!auth()->check() || !(auth()->user()->hasStaffAccess() || (method_exists(auth()->user(), 'isTeacher') && auth()->user()->isTeacher()))) {
            abort(403, 'Unauthorized');
        }

        $lessons = Lesson::with(['course', 'module'])
            ->orderByDesc('created_at')
            ->get();

        return view('staff.lessons.list', compact('lessons'));
    }

    /**
     * Display archived lessons for staff.
     */
    public function archived()
    {
        if (!auth()->check() || !(auth()->user()->hasStaffAccess() || (method_exists(auth()->user(), 'isTeacher') && auth()->user()->isTeacher()))) {
            abort(403, 'Unauthorized');
        }

        $lessons = collect();

        return view('staff.lessons.archieve', compact('lessons'));
    }

    /**
     * Show lesson edit form.
     */
    public function edit(Lesson $lesson)
    {
        if (!auth()->check() || !(auth()->user()->hasStaffAccess() || (method_exists(auth()->user(), 'isTeacher') && auth()->user()->isTeacher()))) {
            abort(403, 'Unauthorized');
        }

        $courses = Course::all();
        $modules = Module::all();

        return view('staff.lessons.edit', compact('lesson', 'courses', 'modules'));
    }

    /**
     * Update an existing lesson.
     */
    public function update(Request $request, Lesson $lesson)
    {
        if (!auth()->check() || !(auth()->user()->hasStaffAccess() || (method_exists(auth()->user(), 'isTeacher') && auth()->user()->isTeacher()))) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'lesson_title' => 'required|string|max:255',
            'lesson_description' => 'nullable|string',
            'lesson_content' => 'nullable|string',
            'lesson_duration' => 'nullable|integer|min:0',
            'lesson_video_url' => 'nullable|url',
            'lesson_order' => 'nullable|integer|min:0',
            'lesson_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'course_id' => 'required|exists:courses,id',
            'module_id' => 'required|exists:modules,id',
        ]);

        $course = Course::findOrFail($validated['course_id']);
        $module = Module::findOrFail($validated['module_id']);
        if ($module->course_id !== $course->id) {
            abort(400, 'Module does not belong to the selected course');
        }

        $slug = Str::slug($validated['lesson_title']);
        if ($slug !== $lesson->slug) {
            $originalSlug = $slug;
            $counter = 1;
            while (Lesson::where('slug', $slug)->where('id', '!=', $lesson->id)->exists()) {
                $slug = $originalSlug . '-' . $counter++;
            }
        }

        $lesson->course_id = $course->id;
        $lesson->module_id = $module->id;
        $lesson->title = $validated['lesson_title'];
        $lesson->slug = $slug;
        $lesson->description = $validated['lesson_description'] ?? null;
        $lesson->content = $validated['lesson_content'] ?? '';
        $lesson->duration_minutes = isset($validated['lesson_duration']) && $validated['lesson_duration'] !== null
            ? (int) $validated['lesson_duration']
            : 0;
        $lesson->video_url = $validated['lesson_video_url'] ?? null;
        $lesson->order = $validated['lesson_order'] ?? $lesson->order;

        if ($request->hasFile('lesson_image')) {
            $path = $request->file('lesson_image')->store('lessons/images', 'public');
            $lesson->image_url = Storage::url($path);
        }

        $lesson->save();

        return redirect()->route('modules.show', [$course->slug, $module->slug])
            ->with('success', "Lesson '{$lesson->title}' updated successfully.");
    }

    /**
    * Show creation form for a lesson.
    */
    public function create()
    {
        $courses = Course::all();
        $modules = Module::all();
        return view('staff.lessons.create', compact('courses', 'modules'));
    }

    /**
     * Show a specific lesson.
     */
    public function show($courseSlug, $moduleSlug, $lessonSlug)
    {
        $course = Course::where('slug', $courseSlug)->firstOrFail();
        $module = $course->modules()->where('slug', $moduleSlug)->firstOrFail();
        $lesson = $module->lessons()->where('slug', $lessonSlug)->firstOrFail();

        $this->authorize('view', $course);

        $userId = auth()->id();
        $enrollment = null;
        $lessonEnrollment = null;
        $userProgress = 0;
        if ($userId) {
            $enrollment = $course->enrollments()->where('user_id', $userId)->first();
            if ($enrollment) {
                $lessonEnrollment = $lesson->enrollments()
                    ->where('enrollment_id', $enrollment->id)
                    ->first();
                $userProgress = $module->getDetailedProgress($userId);
            }
        }

        $isCompleted = (bool) optional($lessonEnrollment)->completed;
        $nextLesson = $module->lessons()
            ->where('is_published', true)
            ->where(function ($query) use ($lesson) {
                $query->where('order', '>', $lesson->order)
                    ->orWhere(function ($query) use ($lesson) {
                        $query->where('order', $lesson->order)
                            ->where('id', '>', $lesson->id);
                    });
            })
            ->orderBy('order')
            ->orderBy('id')
            ->first();

        $nextLessonUrl = $nextLesson
            ? route('lessons.show', [$course->slug, $module->slug, $nextLesson->slug])
            : route('modules.show', [$course->slug, $module->slug]);

        return view('Userpage.course.lesson', [
            'course' => $course,
            'module' => $module,
            'lesson' => $lesson,
            'enrollment' => $enrollment,
            'lessonEnrollment' => $lessonEnrollment,
            'userProgress' => $userProgress,
            'isCompleted' => $isCompleted,
            'nextLessonUrl' => $nextLessonUrl,
        ]);
    }

    /**
     * Mark a lesson as completed for the current user.
     */
    public function complete(Request $request, $courseSlug, $moduleSlug, $lessonSlug)
    {
        if (!auth()->check()) {
            abort(403, 'Unauthorized');
        }
        $user = auth()->user();
        $course = Course::where('slug', $courseSlug)->firstOrFail();
        $module = $course->modules()->where('slug', $moduleSlug)->firstOrFail();
        $lesson = $module->lessons()->where('slug', $lessonSlug)->firstOrFail();

        $this->authorize('view', $course);

        $enrollment = $course->enrollments()->firstOrCreate(['user_id' => $user->id]);
        $lessonEnroll = $lesson->enrollments()->firstOrCreate([
            'enrollment_id' => $enrollment->id,
            'lesson_id' => $lesson->id,
        ]);
        $lessonEnroll->completed = true;
        $lessonEnroll->completed_at = now();
        $lessonEnroll->save();

        // Award XP for completing a lesson
        try {
            $user = auth()->user();
            if ($user) {
                // 10 XP per lesson
                $user->addXp(10);
            }
        } catch (\Throwable $e) {
            // non-fatal
        }

        $courseCompleted = $this->syncEnrollmentProgress($user->id, $course, $enrollment);
        $successMessage = 'Lesson marked as completed. You earned 10 XP.';
        if ($courseCompleted) {
            $successMessage .= ' Congratulations! Your course certificate is unlocked and ready to view.';
        }

        return back()->with('success', $successMessage);
    }

    private function syncEnrollmentProgress(int $userId, Course $course, Enrollment $enrollment): bool
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

        return $completed;
    }
}
