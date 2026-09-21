<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assessment;
use App\Models\Module;
use App\Models\Course;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;

class AssessmentController extends Controller
{
    public function index(Request $request)
    {
        $course = $request->route('course');
        $module = $request->route('module');
        if ($module && ! $module instanceof Module) {
            $module = Module::findOrFail($module);
        }
        $assessments = $module
            ? $module->assessments()->latest()->get()
            : collect();

        return view('teacher.assessments.index', compact('course', 'module', 'assessments'));
    }

    public function create(Request $request)
    {
        return view('teacher.assessments.create');
    }

    public function store(Request $request)
    {
        // Basic validation stub
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'passing_score' => 'nullable|numeric|min:0|max:100',
            'time_limit_minutes' => 'nullable|integer|min:0',
            'is_published' => 'sometimes|boolean',
        ]);
        $moduleParam = $request->route('module');
        $module = $moduleParam instanceof Module ? $moduleParam : Module::findOrFail($moduleParam);

        // Admins can manage all assessments; teachers remain restricted to their own course modules.
        $course = $module->course;
        if (!auth()->user()->is_admin) {
            $teacherName = auth()->user()->name ?? '';
            if (!($course && ((($course->instructor_id ?? null) === auth()->id()) || (($course->instructor_id === null) && ($course->instructor_name ?? '') === $teacherName)))) {
                abort(403);
            }
        }

        $data = $request->only(['title','description','passing_score','time_limit_minutes','is_published']);
        $slugBase = Str::slug($data['title']);
        $slug = $slugBase;
        $i = 1;
        while (Assessment::where('slug', $slug)->exists()) {
            $slug = $slugBase.'-'. $i++;
        }

        $assessment = Assessment::create([
            'module_id' => $module->id,
            'title' => $data['title'],
            'slug' => $slug,
            'description' => $data['description'] ?? null,
            'passing_score' => $data['passing_score'] ?? null,
            'time_limit_minutes' => $data['time_limit_minutes'] ?? null,
            'is_published' => $data['is_published'] ?? false,
        ]);

        return redirect()->route('teacher.courses.modules.assessments.index', ['course' => $course->id, 'module' => $module->id])
            ->with('success', 'Assessment created.');
    }

    public function show(Request $request, $id)
    {
        $assessment = Assessment::findOrFail($id);
        return view('teacher.assessments.show', compact('assessment'));
    }

    public function edit(Request $request, $id)
    {
        $assessment = Assessment::findOrFail($id);
        return view('teacher.assessments.edit', compact('assessment'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'passing_score' => 'nullable|numeric|min:0|max:100',
            'time_limit_minutes' => 'nullable|integer|min:0',
            'is_published' => 'sometimes|boolean',
        ]);

        $assessment = Assessment::findOrFail($id);
        $module = $assessment->module;
        $course = $module->course;
        if (!auth()->user()->is_admin) {
            $teacherName = auth()->user()->name ?? '';
            if (!($course && ((($course->instructor_id ?? null) === auth()->id()) || (($course->instructor_id === null) && ($course->instructor_name ?? '') === $teacherName)))) {
                abort(403);
            }
        }

        $data = $request->only(['title','description','passing_score','time_limit_minutes','is_published']);
        $assessment->update([
            'title' => $data['title'],
            'description' => $data['description'] ?? $assessment->description,
            'passing_score' => $data['passing_score'] ?? $assessment->passing_score,
            'time_limit_minutes' => $data['time_limit_minutes'] ?? $assessment->time_limit_minutes,
            'is_published' => $data['is_published'] ?? $assessment->is_published,
        ]);

        return redirect()->route('teacher.courses.modules.assessments.index', ['course' => $course->id, 'module' => $module->id])->with('success', 'Assessment updated.');
    }

    public function destroy(Request $request, $id)
    {
        $assessment = Assessment::findOrFail($id);
        $module = $assessment->module;
        $course = $module->course;
        if (!auth()->user()->is_admin) {
            $teacherName = auth()->user()->name ?? '';
            if (!($course && ((($course->instructor_id ?? null) === auth()->id()) || (($course->instructor_id === null) && ($course->instructor_name ?? '') === $teacherName)))) {
                abort(403);
            }
        }

        $assessment->delete();
        return redirect()->route('teacher.courses.modules.assessments.index', ['course' => $course->id, 'module' => $module->id])->with('success', 'Assessment deleted.');
    }
}
