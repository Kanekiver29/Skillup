<?php

namespace App\Http\Controllers\staff;

use App\Http\Controllers\Admin\ModuleController as AdminModuleController;

class ModuleController extends AdminModuleController
{
    public function index(\Illuminate\Http\Request $request)
    {
        $this->authorizeStaff();
        $query = \App\Models\Module::with('course')->withCount('quizzes');
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }
        $modules = $query->orderBy('course_id')->orderBy('order')->paginate(20);
        $courses = \App\Models\Course::orderBy('title')->get();
        $archivedModules = \App\Models\Module::onlyTrashed()->with('course')->withCount('quizzes')->get();
        return view('staff.modules.index', compact('modules','courses','archivedModules'));
    }

    public function create(\Illuminate\Http\Request $request)
    {
        $this->authorizeStaff();
        $courses = \App\Models\Course::orderBy('title')->get();
        $selectedCourseId = $request->query('course_id');
        return view('staff.modules.create', compact('courses','selectedCourseId'));
    }

    public function edit(\App\Models\Module $module)
    {
        $this->authorizeStaff();
        $courses = \App\Models\Course::orderBy('title')->get();
        return view('staff.modules.edit', compact('module','courses'));
    }

    /**
     * Show the inline editor used by staff (real-time editor view).
     */
    public function editor(\App\Models\Module $module)
    {
        $this->authorizeStaff();
        $modules = \App\Models\Module::with('course')->orderBy('course_id')->orderBy('order')->get();
        return view('staff.modules.editor', compact('module', 'modules'));
    }
}
