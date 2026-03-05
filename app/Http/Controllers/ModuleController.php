<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Models\Course;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function show($courseSlug, $moduleSlug)
    {
        $course = Course::where('slug', $courseSlug)->firstOrFail();
        $module = $course->modules()->where('slug', $moduleSlug)->firstOrFail();
        
        $this->authorize('view', $course);

        $userProgress = Module::find($module->id)->getProgress(auth()->id());
        $quizzes = $module->quizzes()->where('is_published', true)->get();

        return view('courses.modules.show', [
            'course' => $course,
            'module' => $module,
            'userProgress' => $userProgress,
            'quizzes' => $quizzes,
        ]);
    }
}
