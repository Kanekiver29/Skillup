<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    public function index()
    {
        $userId = auth()->id();
        $q = request('q');
        $perPage = (int) request('per_page', 12);
        $perPage = in_array($perPage, [6,12,24,48,100]) ? $perPage : 12;
        $showArchived = request()->boolean('archived');

        // Build base query depending on instructor ownership column and archived flag
        if (Schema::hasColumn('courses', 'instructor_id')) {
            $ownershipConstraint = function ($qb) use ($userId) {
                $qb->where('instructor_id', $userId)
                   ->orWhere(function($q2) use ($userId) {
                       $q2->whereNull('instructor_id')->where('instructor_name', auth()->user()->name ?? '');
                   });
            };
        } else {
            $ownershipConstraint = function ($qb) {
                $qb->where('instructor_name', auth()->user()->name ?? '');
            };
        }

        if ($showArchived) {
            if (Schema::hasColumn('courses', 'deleted_at')) {
                $base = Course::onlyTrashed()->where($ownershipConstraint);
            } else {
                // migrations not yet run; return empty set for archived view to avoid SQL errors
                $base = Course::whereRaw('0 = 1');
            }
        } else {
            $base = Course::where($ownershipConstraint);
        }

        if ($q) {
            $base->where(function($s) use ($q) {
                $s->where('title', 'like', "%{$q}%")
                  ->orWhere('short_description', 'like', "%{$q}%")
                  ->orWhere('category', 'like', "%{$q}%");
            });
        }

        $courses = $base->orderByDesc('created_at')->paginate($perPage);
        return view('teacher.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('teacher.courses.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'level' => 'nullable|in:Beginner,Intermediate,Advanced',
            'duration_hours' => 'nullable|integer|min:0',
            'image_url' => 'nullable|url',
            'image' => 'nullable|image|max:5120',
            'is_published' => 'sometimes|boolean',
        ]);

        $slugBase = Str::slug($data['title']);
        $slug = $slugBase;
        $i = 1;
        while (Course::where('slug', $slug)->exists()) {
            $slug = $slugBase . '-' . $i++;
        }

        $course = Course::create([
            'instructor_id' => auth()->id(),
            'title' => $data['title'],
            'slug' => $slug,
            'short_description' => $data['short_description'] ?? null,
            'description' => $data['description'] ?? null,
            'category' => $data['category'] ?? null,
            'level' => $data['level'] ?? 'Beginner',
            'duration_hours' => $data['duration_hours'] ?? 0,
            'instructor_name' => auth()->user()->name ?? 'Instructor',
            'instructor_title' => auth()->user()->title ?? null,
            'image_url' => $data['image_url'] ?? null,
            'is_published' => $data['is_published'] ?? false,
        ]);

        return redirect()->route('teacher.courses.index')->with('success', 'Course created.');
    }

    public function edit(Course $course)
    {
        // ensure this teacher owns the course (basic check by instructor_name)
        if (!(($course->instructor_id ?? null) === auth()->id() || (($course->instructor_id === null) && ($course->instructor_name ?? '') === (auth()->user()->name ?? '')))) {
            abort(403);
        }
        return view('teacher.courses.create', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        if (!(($course->instructor_id ?? null) === auth()->id() || (($course->instructor_id === null) && ($course->instructor_name ?? '') === (auth()->user()->name ?? '')))) {
            abort(403);
        }

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description' => 'nullable|string',
            'category' => 'nullable|string',
            'level' => 'nullable|in:Beginner,Intermediate,Advanced',
            'duration_hours' => 'nullable|integer|min:0',
            'image_url' => 'nullable|url',
            'is_published' => 'sometimes|boolean',
        ]);

        $course->update([
            'title' => $data['title'],
            'short_description' => $data['short_description'] ?? null,
            'description' => $data['description'] ?? null,
            'category' => $data['category'] ?? null,
            'level' => $data['level'] ?? $course->level,
            'duration_hours' => $data['duration_hours'] ?? $course->duration_hours,
            'image_url' => $data['image_url'] ?? $course->image_url,
            'is_published' => $data['is_published'] ?? $course->is_published,
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('courses/images', 'public');
            $course->image_url = Storage::url($path);
            $course->save();
        }

        return redirect()->route('teacher.courses.index')->with('success', 'Course updated.');
    }

    public function destroy(Course $course)
    {
        if (!(($course->instructor_id ?? null) === auth()->id() || (($course->instructor_id === null) && ($course->instructor_name ?? '') === (auth()->user()->name ?? '')))) {
            abort(403);
        }

        // Soft-delete (archive)
        $course->delete();

        return redirect()->route('teacher.courses.index')->with('success', 'Course archived.');
    }

    public function restore($id)
    {
        $course = Course::withTrashed()->findOrFail($id);
        if (!(($course->instructor_id ?? null) === auth()->id() || (($course->instructor_id === null) && ($course->instructor_name ?? '') === (auth()->user()->name ?? '')))) {
            abort(403);
        }
        $course->restore();
        return redirect()->route('teacher.courses.index', ['archived' => 1])->with('success', 'Course restored.');
    }

    public function schedule(Course $course)
    {
        if (($course->instructor_name ?? '') !== (auth()->user()->name ?? '')) {
            abort(403);
        }

        return view('teacher.courses.schedule', compact('course'));
    }
}
