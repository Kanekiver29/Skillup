<?php

// ─────────────────────────────────────────────────────────────────────────────
// File: routes/teacher.php
//
// Register this file in bootstrap/app.php (Laravel 11) or RouteServiceProvider
// (Laravel 10) — see the comment at the bottom of this file.
// ─────────────────────────────────────────────────────────────────────────────

use App\Http\Controllers\Teacher\CourseController;
use App\Http\Controllers\Teacher\ModuleController;
use App\Http\Controllers\Teacher\DashboardController;
use App\Http\Controllers\Teacher\AssessmentController;
use App\Http\Controllers\Teacher\ProgressController;
use App\Http\Controllers\Teacher\StudentController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Teacher routes
|--------------------------------------------------------------------------
| All routes here are protected by:
|   - auth          → must be logged in
|   - verified      → email must be verified (remove if not using)
|   - role:teacher  → custom middleware that checks Auth::user()->role
|
| If you are NOT using a role middleware yet, remove 'role:teacher' from
| the middleware array below. You can add it back once the middleware exists.
*/

Route::prefix('teacher')
    ->name('teacher.')
    ->middleware(['auth', 'verified', 'role:teacher'])
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // My Courses
        Route::resource('courses', CourseController::class);

        // My Modules (nested under courses)
        Route::resource('courses.modules', ModuleController::class);

        // Assessments (nested under modules)
        Route::resource('courses.modules.assessments', AssessmentController::class);

        // Students
        Route::get('students', [StudentController::class, 'index'])->name('students.index');
        Route::get('students/{student}', [StudentController::class, 'show'])->name('students.show');

        // Progress Tracking
        Route::get('progress', [ProgressController::class, 'index'])->name('progress.index');
        Route::get('progress/{student}', [ProgressController::class, 'show'])->name('progress.show');

        // Profile
        Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');

            // Logout (allow GET/POST for convenience from teacher UI)
            Route::match(['get', 'post'], 'logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');

        // Teacher feature pages (simple named routes used by views)
        Route::get('modules', [\App\Http\Controllers\Teacher\ModuleController::class, 'index'])->name('modules.index');
        Route::get('modules/create', [\App\Http\Controllers\Teacher\ModuleController::class, 'create'])->name('modules.create');
        Route::post('modules', [\App\Http\Controllers\Teacher\ModuleController::class, 'store'])->name('modules.store');
        Route::get('modules/{module}/edit', [\App\Http\Controllers\Teacher\ModuleController::class, 'edit'])->name('modules.edit');
        Route::put('modules/{module}', [\App\Http\Controllers\Teacher\ModuleController::class, 'update'])->name('modules.update');
        Route::delete('modules/{module}', [\App\Http\Controllers\Teacher\ModuleController::class, 'destroy'])->name('modules.destroy');
        Route::post('modules/{module}/publish', [\App\Http\Controllers\Teacher\ModuleController::class, 'publish'])->name('modules.publish');
        Route::post('modules/{module}/unpublish', [\App\Http\Controllers\Teacher\ModuleController::class, 'unpublish'])->name('modules.unpublish');

        // Generic module resource upload helper used by teacher UI
        Route::get('modules/upload-resource', function () {
            $resourceType = request()->query('type', 'pdf');
            $userId = auth()->id();
            $teacherName = auth()->user()->name ?? '';

            if (\Illuminate\Support\Facades\Schema::hasColumn('courses', 'instructor_id')) {
                $courses = \App\Models\Course::where(function($q) use ($userId, $teacherName) {
                    $q->where('instructor_id', $userId)
                      ->orWhere(function($q2) use ($teacherName) {
                          $q2->whereNull('instructor_id')->where('instructor_name', $teacherName);
                      });
                })->get();
            } else {
                $courses = \App\Models\Course::where('instructor_name', $teacherName)->get();
            }

            $modules = \App\Models\Module::whereIn('course_id', $courses->pluck('id')->toArray())->get();

            return view('teacher.modules.upload-resource', compact('resourceType','courses','modules'));
        })->name('modules.upload-resource');

        // Return modules for a given course (JSON) — used by the upload UI
        Route::get('modules/by-course/{course}', function (\App\Models\Course $course) {
            $userId = auth()->id();
            $teacherName = auth()->user()->name ?? '';
            if (!(($course->instructor_id ?? null) === $userId || (($course->instructor_id === null) && ($course->instructor_name ?? '') === $teacherName))) {
                abort(403);
            }
            return response()->json($course->modules()->orderBy('order')->get(['id','title']));
        })->name('modules.by-course');

        Route::post('modules/upload-resource', function (\Illuminate\Http\Request $request) {
            $request->validate([
                'resource_type' => 'required|in:word,video,image,ppt,pdf',
                'resource_file' => 'required|file',
                'course_id' => 'nullable|exists:courses,id',
                'module_id' => 'nullable|exists:modules,id',
            ]);

            $type = $request->input('resource_type');
            // additional mime/size validation per type
            $rules = [
                'word' => ['mimes:doc,docx', 'max:20480'],
                'video' => ['mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-matroska', 'max:102400'],
                'image' => ['image', 'mimes:jpeg,png,gif,svg', 'max:10240'],
                'ppt' => ['mimes:ppt,pptx', 'max:20480'],
                'pdf' => ['mimes:pdf', 'max:10240'],
            ];

            $validator = \Illuminate\Support\Facades\Validator::make(['file' => $request->file('resource_file')], ['file' => $rules[$type] ?? []]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $path = $request->file('resource_file')->store("modules/resources/{$type}", 'public');
            $url = \Illuminate\Support\Facades\Storage::url($path);

            $userId = auth()->id();
            $teacherName = auth()->user()->name ?? '';
            $courseId = $request->input('course_id');
            $moduleId = $request->input('module_id');

            $course = null;
            if ($courseId) {
                $course = \App\Models\Course::find($courseId);
                if (!$course || !(($course->instructor_id ?? null) === $userId || (($course->instructor_id === null) && ($course->instructor_name ?? '') === $teacherName))) {
                    abort(403);
                }
            }

            if ($moduleId) {
                $module = \App\Models\Module::find($moduleId);
                if (!$module) {
                    return redirect()->back()->withErrors(['module_id' => 'Selected module could not be found.'])->withInput();
                }

                $moduleCourse = $module->course;
                if (!($moduleCourse && (($moduleCourse->instructor_id ?? null) === $userId || (($moduleCourse->instructor_id === null) && ($moduleCourse->instructor_name ?? '') === $teacherName)))) {
                    abort(403);
                }

                if ($course && $moduleCourse->id !== $course->id) {
                    return redirect()->back()->withErrors(['module_id' => 'The chosen module does not belong to the selected course.'])->withInput();
                }

                // Use specific columns if present, otherwise fall back to `thumbnail`.
                $has = \Illuminate\Support\Facades\Schema::hasColumn('modules', 'word_url');
                $hasVideo = \Illuminate\Support\Facades\Schema::hasColumn('modules', 'video_url');
                $hasImage = \Illuminate\Support\Facades\Schema::hasColumn('modules', 'image_url');
                $hasPpt = \Illuminate\Support\Facades\Schema::hasColumn('modules', 'ppt_url');
                $hasThumbnail = \Illuminate\Support\Facades\Schema::hasColumn('modules', 'thumbnail');

                switch ($type) {
                    case 'word':
                        if ($has) {
                            if (!empty($module->word_url) && str_contains($module->word_url, '/storage/')) {
                                $relative = substr($module->word_url, strpos($module->word_url, '/storage/') + 9);
                                \Illuminate\Support\Facades\Storage::disk('public')->delete($relative);
                            }
                            $module->word_url = $url;
                        } elseif ($hasThumbnail) {
                            if (!empty($module->thumbnail) && str_contains($module->thumbnail, '/storage/')) {
                                $relative = substr($module->thumbnail, strpos($module->thumbnail, '/storage/') + 9);
                                \Illuminate\Support\Facades\Storage::disk('public')->delete($relative);
                            }
                            $module->thumbnail = $url;
                        }
                        break;
                    case 'video':
                        if ($hasVideo) {
                            if (!empty($module->video_url) && str_contains($module->video_url, '/storage/')) {
                                $relative = substr($module->video_url, strpos($module->video_url, '/storage/') + 9);
                                \Illuminate\Support\Facades\Storage::disk('public')->delete($relative);
                            }
                            $module->video_url = $url;
                        } elseif ($hasThumbnail) {
                            if (!empty($module->thumbnail) && str_contains($module->thumbnail, '/storage/')) {
                                $relative = substr($module->thumbnail, strpos($module->thumbnail, '/storage/') + 9);
                                \Illuminate\Support\Facades\Storage::disk('public')->delete($relative);
                            }
                            $module->thumbnail = $url;
                        }
                        break;
                    case 'image':
                        if ($hasImage) {
                            if (!empty($module->image_url) && str_contains($module->image_url, '/storage/')) {
                                $relative = substr($module->image_url, strpos($module->image_url, '/storage/') + 9);
                                \Illuminate\Support\Facades\Storage::disk('public')->delete($relative);
                            }
                            $module->image_url = $url;
                        } elseif ($hasThumbnail) {
                            if (!empty($module->thumbnail) && str_contains($module->thumbnail, '/storage/')) {
                                $relative = substr($module->thumbnail, strpos($module->thumbnail, '/storage/') + 9);
                                \Illuminate\Support\Facades\Storage::disk('public')->delete($relative);
                            }
                            $module->thumbnail = $url;
                        }
                        break;
                    case 'ppt':
                        if ($hasPpt) {
                            if (!empty($module->ppt_url) && str_contains($module->ppt_url, '/storage/')) {
                                $relative = substr($module->ppt_url, strpos($module->ppt_url, '/storage/') + 9);
                                \Illuminate\Support\Facades\Storage::disk('public')->delete($relative);
                            }
                            $module->ppt_url = $url;
                        } elseif ($hasThumbnail) {
                            if (!empty($module->thumbnail) && str_contains($module->thumbnail, '/storage/')) {
                                $relative = substr($module->thumbnail, strpos($module->thumbnail, '/storage/') + 9);
                                \Illuminate\Support\Facades\Storage::disk('public')->delete($relative);
                            }
                            $module->thumbnail = $url;
                        }
                        break;
                    case 'pdf':
                        if ($hasThumbnail) {
                            if (!empty($module->thumbnail) && str_contains($module->thumbnail, '/storage/')) {
                                $relative = substr($module->thumbnail, strpos($module->thumbnail, '/storage/') + 9);
                                \Illuminate\Support\Facades\Storage::disk('public')->delete($relative);
                            }
                            $module->thumbnail = $url;
                        }
                        break;
                }
                $module->save();
                return redirect()->route('teacher.modules.edit', $module)->with('success', ucfirst($type) . ' uploaded and attached to module.');
            }

            return redirect()->back()->with('success', ucfirst($type) . ' uploaded successfully.');
        })->name('modules.upload-resource.store');

        // Assignments / submissions / grades / attendance / progress pages
        Route::get('assignments', [\App\Http\Controllers\TeacherFeatureController::class, 'assignments'])->name('assignments.index');
        Route::get('assignments/create', [\App\Http\Controllers\TeacherFeatureController::class, 'assignmentCreate'])->name('assignments.create');
        Route::get('assignments/submissions', [\App\Http\Controllers\TeacherFeatureController::class, 'submissions'])->name('assignments.submissions');
        Route::get('assignments/{submission}', [\App\Http\Controllers\TeacherFeatureController::class, 'submissions'])->name('assignments.show');

        Route::get('grades', [\App\Http\Controllers\TeacherFeatureController::class, 'grades'])->name('grades.index');
        Route::get('grades/entry', [\App\Http\Controllers\TeacherFeatureController::class, 'gradesEntry'])->name('grades.entry');
        Route::get('grades/reports', [\App\Http\Controllers\TeacherFeatureController::class, 'gradesReports'])->name('grades.reports');

        Route::get('attendance', [\App\Http\Controllers\TeacherFeatureController::class, 'attendanceToday'])->name('attendance.index');
        Route::get('attendance/records', [\App\Http\Controllers\TeacherFeatureController::class, 'attendanceRecords'])->name('attendance.records');
        Route::get('attendance/reports', [\App\Http\Controllers\TeacherFeatureController::class, 'attendanceReports'])->name('attendance.reports');

        Route::get('progress/overview', [\App\Http\Controllers\TeacherFeatureController::class, 'progressOverview'])->name('progress.overview');
        Route::get('progress/{student}', [\App\Http\Controllers\Teacher\ProgressController::class, 'show'])->name('progress.show');

        // Quizzes (list handled by feature controller; create/edit handled by QuizController)
        Route::get('quizzes', [\App\Http\Controllers\TeacherFeatureController::class, 'quizzes'])->name('quizzes.index');
        Route::get('quizzes/create', [\App\Http\Controllers\QuizController::class, 'create'])->name('quizzes.create');
        Route::post('quizzes', [\App\Http\Controllers\QuizController::class, 'store'])->name('quizzes.store');
        Route::get('quizzes/{quiz}', [\App\Http\Controllers\QuizController::class, 'showTeacher'])->name('quizzes.show');
        Route::get('quizzes/{quiz}/edit', [\App\Http\Controllers\QuizController::class, 'edit'])->name('quizzes.edit');
        Route::put('quizzes/{quiz}', [\App\Http\Controllers\QuizController::class, 'update'])->name('quizzes.update');

        // Course helpers
        Route::get('courses/{course}/schedule', [\App\Http\Controllers\Teacher\CourseController::class, 'schedule'])->name('courses.schedule');

    });


/*
|=============================================================================
| HOW TO REGISTER THIS FILE
|=============================================================================
|
| ── Laravel 11  (bootstrap/app.php) ─────────────────────────────────────────
|
|   ->withRouting(
|       web: __DIR__.'/../routes/web.php',
|       then: function () {
|           Route::middleware('web')
|               ->group(base_path('routes/teacher.php'));
|       },
|   )
|
| ── Laravel 10  (app/Providers/RouteServiceProvider.php) ───────────────────
|
|   public function boot(): void
|   {
|       $this->routes(function () {
|           Route::middleware('web')
|               ->group(base_path('routes/teacher.php'));
|       });
|   }
|
| ── Or simply include it at the bottom of routes/web.php ───────────────────
|
|   require __DIR__.'/teacher.php';
|
|=============================================================================
|
| ROLE MIDDLEWARE (if not already set up)
|
| Generate:
|   php artisan make:middleware EnsureUserHasRole
|
| app/Http/Middleware/EnsureUserHasRole.php:
|
|   public function handle(Request $request, Closure $next, string $role): Response
|   {
|       if (Auth::check() && Auth::user()->role === $role) {
|           return $next($request);
|       }
|       abort(403);
|   }
|
| Register in bootstrap/app.php (Laravel 11):
|
|   ->withMiddleware(function (Middleware $middleware) {
|       $middleware->alias([
|           'role' => \App\Http\Middleware\EnsureUserHasRole::class,
|       ]);
|   })
|
| Or in app/Http/Kernel.php (Laravel 10), under $middlewareAliases:
|
|   'role' => \App\Http\Middleware\EnsureUserHasRole::class,
|
|=============================================================================
*/
