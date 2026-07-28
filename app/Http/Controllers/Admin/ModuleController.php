<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Module;
use App\Events\ModuleCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ModuleController extends Controller
{
    /**
     * Authorize that the current user is an admin or staff.
     */
    protected function authorizeStaff()
    {
        if (!auth()->check() || !auth()->user()->hasStaffAccess()) {
            abort(403, 'Unauthorized');
        }
    }

    /**
     * Display all modules grouped by course.
     */
    public function index(Request $request)
    {
        $this->authorizeStaff();

        $query = Module::with('course')->withCount('quizzes');

        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }

        $modules = $query->orderBy('course_id')->orderBy('order')->paginate(20);
        $courses = Course::orderBy('title')->get();

        // Fetch archived modules
        $archivedQuery = Module::onlyTrashed()->with('course')->withCount('quizzes');
        if ($request->filled('course_id')) {
            $archivedQuery->where('course_id', $request->course_id);
        }
        $archivedModules = $archivedQuery->orderBy('deleted_at', 'desc')->get();

        return view('Admin.modules.index', compact('modules', 'courses', 'archivedModules'));
    }

    /**
     * Show form to create a new module.
     */
    public function create(Request $request)
    {
        $this->authorizeStaff();

        $courses = Course::orderBy('title')->get();
        $selectedCourseId = $request->query('course_id');

        return view('Admin.modules.create', compact('courses', 'selectedCourseId'));
    }

    /**
     * Store a newly created module.
     */
    public function store(Request $request)
    {
        $this->authorize('create', \App\Models\Module::class);

        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'definition' => 'nullable|string',
            'example' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'is_published' => 'sometimes|boolean',
        ]);

        $validated['slug'] = Str::slug($validated['title']);
        $validated['order'] = $validated['order'] ?? Module::where('course_id', $validated['course_id'])->max('order') + 1;
        $validated['is_published'] = $request->has('is_published');

        // Ensure slug is unique
        $baseSlug = $validated['slug'];
        $counter = 1;
        while (Module::where('slug', $validated['slug'])->exists()) {
            $validated['slug'] = $baseSlug . '-' . $counter++;
        }

        $module = Module::create($validated);

        // Broadcast module creation for realtime dashboards
        try {
            event(new ModuleCreated($module));
        } catch (\Throwable $e) {
            // ignore broadcasting errors
        }

        return redirect()->route('admin.modules.index', ['course_id' => $validated['course_id']])
            ->with('success', 'Module created successfully.');
    }

    /**
     * Show form to edit a module.
     */
    public function edit(Module $module)
    {
        $this->authorize('view', $module);

        $courses = Course::orderBy('title')->get();

        return view('Admin.modules.edit', compact('module', 'courses'));
    }

    /**
     * Update an existing module.
     */
    public function update(Request $request, Module $module)
    {
        $this->authorize('update', $module);

        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'definition' => 'nullable|string',
            'example' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'is_published' => 'sometimes|boolean',
        ]);

        if ($module->title !== $validated['title']) {
            $validated['slug'] = Str::slug($validated['title']);

            // Ensure slug is unique (excluding current module)
            $baseSlug = $validated['slug'];
            $counter = 1;
            while (Module::where('slug', $validated['slug'])->where('id', '!=', $module->id)->exists()) {
                $validated['slug'] = $baseSlug . '-' . $counter++;
            }
        }

        $validated['is_published'] = $request->has('is_published');

        $module->update($validated);

        return redirect()->route('admin.modules.index', ['course_id' => $module->course_id])
            ->with('success', 'Module updated successfully.');
    }

    /**
     * Archive a module (soft delete).
     */
    public function destroy(Module $module)
    {
        $this->authorize('delete', $module);

        $courseId = $module->course_id;
        $title = $module->title;
        $module->delete();

        return redirect()->route('admin.modules.index', ['course_id' => $courseId])
            ->with('success', "Module '$title' archived.");
    }

    /**
     * Restore an archived module.
     */
    public function restore($id)
    {
        // allow only staff/admin via policy (module restore treated as update)
        $module = Module::withTrashed()->findOrFail($id);
        $this->authorize('update', $module);

        $module = Module::withTrashed()->findOrFail($id);
        $module->restore();

        return redirect()->route('admin.modules.index', ['course_id' => $module->course_id])
            ->with('success', "Module '{$module->title}' restored.");
    }

    /**
     * Permanently delete an archived module.
     */
    public function forceDelete($id)
    {
        $module = Module::withTrashed()->findOrFail($id);
        $this->authorize('delete', $module);

        $module = Module::withTrashed()->findOrFail($id);
        $courseId = $module->course_id;
        $title = $module->title;
        $module->forceDelete();

        return redirect()->route('admin.modules.index', ['course_id' => $courseId])
            ->with('success', "Module '$title' permanently deleted.");
    }

    /**
     * API: update module via AJAX (used by staff editor). Returns JSON.
     */
    public function apiUpdate(Request $request, Module $module)
    {
        $this->authorize('update', $module);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'definition' => 'nullable|string',
            'example' => 'nullable|string',
            'order' => 'nullable|integer|min:0',
            'is_published' => 'sometimes|boolean',
        ]);

        $module->update(array_merge($validated, ['is_published' => $request->has('is_published')]));

        // Fire ModuleEdited event for realtime updates
        try {
            event(new \App\Events\ModuleEdited($module));
        } catch (\Throwable $e) {
            // ignore broadcasting failures
        }

        return response()->json(['status' => 'ok', 'module' => $module]);
    }
}
