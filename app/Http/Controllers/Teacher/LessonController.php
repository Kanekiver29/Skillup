<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class LessonController extends Controller
{
    private function canManageLesson(?Lesson $lesson): bool
    {
        $user = auth()->user();
        if (! $user) {
            return false;
        }

        if ($user->is_admin) {
            return true;
        }

        if ((method_exists($user, 'isTeacher') && $user->isTeacher())
            || (method_exists($user, 'isStaff') && $user->isStaff())
            || (method_exists($user, 'hasStaffAccess') && $user->hasStaffAccess())
            || in_array(strtolower((string) ($user->role ?? '')), ['teacher', 'admin', 'staff', 'instructor'], true)
            || in_array(strtolower((string) ($user->staff_type ?? '')), ['teacher', 'instructor'], true)) {
            return true;
        }

        $module = $lesson?->module;
        $course = $module?->course;
        if (! $course) {
            return false;
        }

        $userId = $user->id ?? null;
        $teacherName = trim((string) ($user->name ?? ''));
        $courseInstructorId = $course->instructor_id ?? null;
        $courseInstructorName = trim((string) ($course->instructor_name ?? ''));

        if ($userId && $courseInstructorId !== null && (int) $courseInstructorId === (int) $userId) {
            return true;
        }

        return $teacherName !== '' && $courseInstructorName !== '' && strtolower($courseInstructorName) === strtolower($teacherName);
    }

    public function index()
    {
        $query = Lesson::query()->with(['module.course']);
        $user = auth()->user();
        $hasPortalAccess = $user && ($user->is_admin
            || (method_exists($user, 'isTeacher') && $user->isTeacher())
            || (method_exists($user, 'isStaff') && $user->isStaff())
            || (method_exists($user, 'hasStaffAccess') && $user->hasStaffAccess())
            || in_array(strtolower((string) ($user->role ?? '')), ['teacher', 'admin', 'staff', 'instructor'], true)
            || in_array(strtolower((string) ($user->staff_type ?? '')), ['teacher', 'instructor'], true));

        if (! $hasPortalAccess) {
            $query->whereHas('module.course', function ($q) {
                $user = auth()->user();
                $userId = $user?->id;
                $teacherName = trim((string) ($user?->name ?? ''));

                $q->where(function ($inner) use ($userId, $teacherName) {
                    $inner->where('instructor_id', $userId)
                        ->orWhere(function ($inner2) use ($teacherName) {
                            $inner2->whereNull('instructor_id')
                                ->where('instructor_name', $teacherName);
                        });
                });
            });
        }

        $lessons = $query->orderByDesc('created_at')->get();

        return view('teacher.lesson.index', compact('lessons'));
    }

    public function show(Lesson $lesson)
    {
        if (! $this->canManageLesson($lesson)) {
            abort(403);
        }

        return view('teacher.lesson.show', compact('lesson'));
    }

    public function create(Request $request, ?Module $module = null)
    {
        if (! $module && $request->filled('module_id')) {
            $module = Module::findOrFail($request->integer('module_id'));
        }

        if ($module && ! $this->canManageLesson((new Lesson())->setRelation('module', $module))) {
            abort(403);
        }

        // EnsureTeacher already limits this area to staff who can manage curriculum.
        $modules = Module::with('course')->orderBy('title')->get();

        return view('teacher.lesson.create', compact('module', 'modules'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'video' => 'nullable|file|mimetypes:video/mp4,video/quicktime|max:51200',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp,svg|max:10240',
            'material' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip|max:20480',
            'duration_minutes' => 'nullable|integer|min:0',
        ]);

        $module = Module::findOrFail($data['module_id']);

        if (! $this->canManageLesson((new Lesson())->setRelation('module', $module))) {
            abort(403);
        }

        $lesson = new Lesson();
        $lesson->course_id = $module->course_id;
        $lesson->module_id = $module->id;
        $lesson->title = $data['title'];
        $slugBase = Str::slug($data['title']);
        $lesson->slug = $slugBase ?: 'lesson';
        $slugNumber = 1;
        while (Lesson::where('slug', $lesson->slug)->exists()) {
            $lesson->slug = $slugBase . '-' . $slugNumber++;
        }
        $lesson->description = $data['description'] ?? '';
        $lesson->content = $data['content'] ?? '';
        $lesson->duration_minutes = $data['duration_minutes'] ?? 0;
        $lesson->order = ((int) $module->lessons()->max('order')) + 1;
        $lesson->is_published = true;

        if ($request->hasFile('video')) {
            $path = $request->file('video')->store('lessons/videos', 'public');
            $lesson->video_url = Storage::url($path);
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('lessons/images', 'public');
            $lesson->image_url = Storage::url($path);
        }

        if ($request->hasFile('material')) {
            $path = $request->file('material')->store('lessons/materials', 'public');
            $lesson->material_url = Storage::url($path);
        }

        $lesson->save();

        return redirect()->route('teacher.lessons.index')->with('success', 'Lesson created.');
    }

    public function edit(Lesson $lesson)
    {
        if (! $this->canManageLesson($lesson)) {
            abort(403);
        }

        $modules = Module::query();
        if (! auth()->user()?->is_admin) {
            $modules->whereHas('course', function ($q) {
                $user = auth()->user();
                $userId = $user?->id;
                $teacherName = trim((string) ($user?->name ?? ''));

                $q->where(function ($inner) use ($userId, $teacherName) {
                    $inner->where('instructor_id', $userId)
                        ->orWhere(function ($inner2) use ($teacherName) {
                            $inner2->whereNull('instructor_id')
                                ->where('instructor_name', $teacherName);
                        });
                });
            });
        }

        $modules = $modules->orderBy('title')->get();

        return view('teacher.lesson.edit', compact('lesson', 'modules'));
    }

    public function update(Request $request, Lesson $lesson)
    {
        if (! $this->canManageLesson($lesson)) {
            abort(403);
        }

        $data = $request->validate([
            'module_id' => 'required|exists:modules,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'content' => 'nullable|string',
            'video' => 'nullable|file|mimetypes:video/mp4,video/quicktime|max:51200',
            'image' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp,svg|max:10240',
            'material' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip|max:20480',
            'duration_minutes' => 'nullable|integer|min:0',
        ]);

        $module = Module::findOrFail($data['module_id']);
        if (! $this->canManageLesson((new Lesson())->setRelation('module', $module))) {
            abort(403);
        }

        $lesson->module_id = $module->id;
        $lesson->course_id = $module->course_id;
        $lesson->title = $data['title'];
        $slugBase = Str::slug($data['title']);
        $lesson->slug = $slugBase ?: 'lesson-' . $lesson->id;
        $slugNumber = 1;
        while (Lesson::where('slug', $lesson->slug)->where('id', '!=', $lesson->id)->exists()) {
            $lesson->slug = $slugBase . '-' . $slugNumber++;
        }
        $lesson->description = $data['description'] ?? '';
        $lesson->content = $data['content'] ?? '';
        $lesson->duration_minutes = $data['duration_minutes'] ?? $lesson->duration_minutes;
        if ($request->hasFile('video')) {
            if (! empty($lesson->video_url) && str_contains($lesson->video_url, '/storage/')) {
                $relative = substr($lesson->video_url, strpos($lesson->video_url, '/storage/') + 9);
                Storage::disk('public')->delete($relative);
            }
            $path = $request->file('video')->store('lessons/videos', 'public');
            $lesson->video_url = Storage::url($path);
        }

        if ($request->hasFile('image')) {
            if (! empty($lesson->image_url) && str_contains($lesson->image_url, '/storage/')) {
                $relative = substr($lesson->image_url, strpos($lesson->image_url, '/storage/') + 9);
                Storage::disk('public')->delete($relative);
            }
            $path = $request->file('image')->store('lessons/images', 'public');
            $lesson->image_url = Storage::url($path);
        }

        if ($request->hasFile('material')) {
            if (! empty($lesson->material_url) && str_contains($lesson->material_url, '/storage/')) {
                $relative = substr($lesson->material_url, strpos($lesson->material_url, '/storage/') + 9);
                Storage::disk('public')->delete($relative);
            }
            $path = $request->file('material')->store('lessons/materials', 'public');
            $lesson->material_url = Storage::url($path);
        }

        $lesson->save();

        return redirect()->route('teacher.lessons.index')->with('success', 'Lesson updated.');
    }

    public function destroy(Lesson $lesson)
    {
        if (! $this->canManageLesson($lesson)) {
            abort(403);
        }

        if (! empty($lesson->video_url) && str_contains($lesson->video_url, '/storage/')) {
            $relative = substr($lesson->video_url, strpos($lesson->video_url, '/storage/') + 9);
            Storage::disk('public')->delete($relative);
        }

        if (! empty($lesson->material_url) && str_contains($lesson->material_url, '/storage/')) {
            $relative = substr($lesson->material_url, strpos($lesson->material_url, '/storage/') + 9);
            Storage::disk('public')->delete($relative);
        }

        if (! empty($lesson->image_url) && str_contains($lesson->image_url, '/storage/')) {
            $relative = substr($lesson->image_url, strpos($lesson->image_url, '/storage/') + 9);
            Storage::disk('public')->delete($relative);
        }

        $lesson->delete();

        return redirect()->route('teacher.lessons.index')->with('success', 'Lesson deleted.');
    }

    public function download(Lesson $lesson)
    {
        if (! $this->canManageLesson($lesson)) {
            abort(403);
        }

        if (empty($lesson->material_url)) {
            abort(404);
        }

        if (str_contains($lesson->material_url, '/storage/')) {
            $relative = substr($lesson->material_url, strpos($lesson->material_url, '/storage/') + 9);
            if (Storage::disk('public')->exists($relative)) {
                return Storage::disk('public')->download($relative);
            }
        }

        return redirect($lesson->material_url);
    }
}
