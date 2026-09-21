<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Module;
use App\Models\Course;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ModuleController extends Controller
{
    private function userOwnsCourse($course): bool
    {
        $user = auth()->user();
        if (! $user) {
            return false;
        }

        // Admins, staff, and teachers are authorized to manage modules
        if ($user->is_admin || (method_exists($user, 'isAdmin') && $user->isAdmin()) || (method_exists($user, 'isTeacher') && $user->isTeacher()) || (method_exists($user, 'isStaff') && $user->isStaff()) || (method_exists($user, 'hasStaffAccess') && $user->hasStaffAccess())) {
            return true;
        }

        if (! $course) {
            return true;
        }

        $userId = $user->id ?? null;
        $teacherName = trim((string) ($user->name ?? ''));
        $courseInstructorId = $course->instructor_id ?? null;
        $courseInstructorName = trim((string) ($course->instructor_name ?? ''));

        if ($userId && $courseInstructorId !== null && (int) $courseInstructorId === (int) $userId) {
            return true;
        }

        if ($teacherName !== '' && $courseInstructorName !== '' && strtolower($courseInstructorName) === strtolower($teacherName)) {
            return true;
        }

        return false;
    }

    private function teacherCourseQuery()
    {
        $user = auth()->user();
        $userId = $user?->id;
        $teacherName = $user?->name ?? '';

        $query = Course::query();

        // Admins, staff, and teachers see courses
        if (!$user->is_admin && !(method_exists($user, 'isTeacher') && $user->isTeacher()) && !(method_exists($user, 'isStaff') && $user->isStaff())) {
            if (Schema::hasColumn('courses', 'instructor_id')) {
                $query->where(function ($q) use ($userId, $teacherName) {
                    $q->where('instructor_id', $userId)
                      ->orWhere(function ($q2) use ($teacherName) {
                          $q2->whereNull('instructor_id')
                              ->where('instructor_name', $teacherName);
                      });
                });
            } else {
                $query->where('instructor_name', $teacherName);
            }
        }

        return $query->orderBy('title');
    }

    public function index(Request $request)
    {
        $userId = auth()->id();
        $courseId = $request->query('course_id');
        $user = auth()->user();

        if (! $user) {
            return redirect()->route('login');
        }

        // Admins, staff, and teachers see modules
        if ($user->is_admin || (method_exists($user, 'isTeacher') && $user->isTeacher()) || (method_exists($user, 'isStaff') && $user->isStaff())) {
            $base = Module::with('course');
        } elseif (Schema::hasColumn('courses', 'instructor_id')) {
            $base = Module::whereHas('course', function ($q) use ($userId) {
                $q->where('instructor_id', $userId)
                  ->orWhere(function($q2) use ($userId) {
                      $q2->whereNull('instructor_id')->where('instructor_name', auth()->user()->name ?? '');
                  });
            })->with('course');
        } else {
            $base = Module::whereHas('course', function ($q) {
                $q->where('instructor_name', auth()->user()->name ?? '');
            })->with('course');
        }

        if ($courseId) {
            $base->where('course_id', $courseId);
        }

        $modules = $base->orderByDesc('created_at')->get();
        return view('teacher.modules.index', compact('modules'));
    }

    public function create()
    {
        $courses = $this->teacherCourseQuery()->get();

        if ($courses->isEmpty()) {
            $courses = Course::query()->orderBy('title')->limit(50)->get();
        }

        return view('teacher.modules.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_published' => 'sometimes|boolean',
            'resource_word' => 'nullable|file|mimes:doc,docx|max:20480',
            'resource_video' => 'nullable|file|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-matroska|max:102400',
            'resource_image' => 'nullable|image|mimes:jpeg,png,gif,svg|max:10240',
            'resource_ppt' => 'nullable|file|mimes:ppt,pptx|max:20480',
        ]);

        $course = Course::findOrFail($data['course_id']);
        if (!$this->userOwnsCourse($course)) {
            abort(403, 'Forbidden');
        }

        $slugBase = Str::slug($data['title']);
        $slug = $slugBase;
        $i = 1;
        while (Module::where('slug', $slug)->exists()) {
            $slug = $slugBase . '-' . $i++;
        }

        $module = Module::create([
            'course_id' => $data['course_id'],
            'title' => $data['title'],
            'slug' => $slug,
            'description' => $data['description'] ?? null,
            'order' => $data['order'] ?? 0,
            'is_published' => $data['is_published'] ?? true,
        ]);

        if ($request->hasFile('resource_word')) {
            $path = $request->file('resource_word')->store('modules/resources/word', 'public');
            $module->word_url = Storage::url($path);
        }

        if ($request->hasFile('resource_video')) {
            $path = $request->file('resource_video')->store('modules/resources/video', 'public');
            $module->video_url = Storage::url($path);
        }

        if ($request->hasFile('resource_image')) {
            $path = $request->file('resource_image')->store('modules/resources/image', 'public');
            $module->image_url = Storage::url($path);
        }

        if ($request->hasFile('resource_ppt')) {
            $path = $request->file('resource_ppt')->store('modules/resources/ppt', 'public');
            $module->ppt_url = Storage::url($path);
        }

        $module->save();

        return redirect()->route('teacher.modules.index', ['course_id' => $module->course_id])->with('success', 'Module created.');
    }

    public function edit(Module $module)
    {
        if (!$this->userOwnsCourse($module->course)) {
            abort(403, 'Forbidden');
        }

        $courses = $this->teacherCourseQuery()->get();

        if ($courses->isEmpty()) {
            $courses = Course::query()->orderBy('title')->limit(50)->get();
        }

        return view('teacher.modules.create', compact('module', 'courses'));
    }

    public function update(Request $request, Module $module)
    {
        if (!$this->userOwnsCourse($module->course)) {
            abort(403, 'Forbidden');
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'description' => 'nullable|string',
            'order' => 'nullable|integer',
            'is_published' => 'sometimes|boolean',
            'resource_word' => 'nullable|file|mimes:doc,docx|max:20480',
            'resource_video' => 'nullable|file|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-matroska|max:102400',
            'resource_image' => 'nullable|image|mimes:jpeg,png,gif,svg|max:10240',
            'resource_ppt' => 'nullable|file|mimes:ppt,pptx|max:20480',
        ]);

        $course = Course::findOrFail($data['course_id']);
        if (!$this->userOwnsCourse($course)) {
            abort(403, 'Forbidden');
        }

        $module->update([
            'title' => $data['title'],
            'course_id' => $data['course_id'],
            'description' => $data['description'] ?? null,
            'order' => $data['order'] ?? $module->order,
            'is_published' => $data['is_published'] ?? $module->is_published,
        ]);

        if ($request->hasFile('resource_word')) {
            if (!empty($module->word_url) && str_contains($module->word_url, '/storage/')) {
                $relative = substr($module->word_url, strpos($module->word_url, '/storage/') + 9);
                Storage::disk('public')->delete($relative);
            }
            $path = $request->file('resource_word')->store('modules/resources/word', 'public');
            $module->word_url = Storage::url($path);
        }

        if ($request->hasFile('resource_video')) {
            if (!empty($module->video_url) && str_contains($module->video_url, '/storage/')) {
                $relative = substr($module->video_url, strpos($module->video_url, '/storage/') + 9);
                Storage::disk('public')->delete($relative);
            }
            $path = $request->file('resource_video')->store('modules/resources/video', 'public');
            $module->video_url = Storage::url($path);
        }

        if ($request->hasFile('resource_image')) {
            if (!empty($module->image_url) && str_contains($module->image_url, '/storage/')) {
                $relative = substr($module->image_url, strpos($module->image_url, '/storage/') + 9);
                Storage::disk('public')->delete($relative);
            }
            $path = $request->file('resource_image')->store('modules/resources/image', 'public');
            $module->image_url = Storage::url($path);
        }

        if ($request->hasFile('resource_ppt')) {
            if (!empty($module->ppt_url) && str_contains($module->ppt_url, '/storage/')) {
                $relative = substr($module->ppt_url, strpos($module->ppt_url, '/storage/') + 9);
                Storage::disk('public')->delete($relative);
            }
            $path = $request->file('resource_ppt')->store('modules/resources/ppt', 'public');
            $module->ppt_url = Storage::url($path);
        }

        $module->save();

        return redirect()->route('teacher.modules.index')->with('success', 'Module updated.');
    }

    public function destroy(Module $module)
    {
        if (!$this->userOwnsCourse($module->course)) {
            abort(403, 'Forbidden');
        }

        $module->delete();
        return redirect()->route('teacher.modules.index')->with('success', 'Module archived.');
    }

    public function publish(Module $module)
    {
        if (!$this->userOwnsCourse($module->course)) {
            abort(403, 'Forbidden');
        }

        $module->update(['is_published' => true]);
        return redirect()->back()->with('success', 'Module published.');
    }

    public function unpublish(Module $module)
    {
        if (!$this->userOwnsCourse($module->course)) {
            abort(403, 'Forbidden');
        }

        $module->update(['is_published' => false]);
        return redirect()->back()->with('success', 'Module unpublished.');
    }
}
