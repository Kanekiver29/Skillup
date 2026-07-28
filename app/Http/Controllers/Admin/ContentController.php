<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\Module;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewLessonNotification;
use App\Models\Enrollment;

class ContentController extends Controller
{
    /**
     * Create Assessment
     */
    public function createAssessment(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'module_id' => 'required|exists:modules,id',
        ]);

        try {
            $module = Module::findOrFail($validated['module_id']);

            $assessment = Assessment::create([
                'module_id' => $validated['module_id'],
                'title' => $validated['title'],
                'description' => $validated['description'] ?? '',
                'slug' => $this->createUniqueSlug(Assessment::class, $validated['title']),
                'is_published' => true,
            ]);
            // notify enrolled users about the new assessment
            $this->notifyEnrolledUsers($module, $assessment);

            $courseSlug = $module->course ? $module->course->slug : null;
            $moduleSlug = $module->slug;
            $redirect = $courseSlug && $moduleSlug ? route('modules.show', [$courseSlug, $moduleSlug]) : route('admin.modules.index', ['course_id' => $module->course_id]);

            return response()->json([
                'success' => true,
                'message' => 'Assessment created successfully!',
                'data' => $assessment,
                'redirect_url' => $redirect,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Create Video Lesson
     */
    public function createVideo(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'video_url' => 'required|url',
            'module_id' => 'required|exists:modules,id',
            'duration_minutes' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
        ]);

        try {
            $module = Module::findOrFail($validated['module_id']);

            $lesson = Lesson::create([
                'course_id' => $module->course_id,
                'module_id' => $validated['module_id'],
                'title' => $validated['title'],
                'slug' => $this->createUniqueSlug(Lesson::class, $validated['title']),
                'description' => $validated['description'] ?? '',
                'content' => '',
                'video_url' => $validated['video_url'],
                'duration_minutes' => $validated['duration_minutes'] ?? 0,
                'is_published' => true,
            ]);
            // notify enrolled users about the new video lesson
            $this->notifyEnrolledUsers($module, $lesson);

            $courseSlug = $module->course ? $module->course->slug : null;
            $moduleSlug = $module->slug;
            $redirect = $courseSlug && $moduleSlug ? route('modules.show', [$courseSlug, $moduleSlug]) : route('admin.modules.index', ['course_id' => $module->course_id]);

            return response()->json([
                'success' => true,
                'message' => 'Video lesson created successfully!',
                'data' => $lesson,
                'redirect_url' => $redirect,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Create Presentation
     */
    public function createPresentation(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,ppt,pptx|max:50000',
            'module_id' => 'required|exists:modules,id',
            'description' => 'nullable|string',
        ]);

        try {
            $module = Module::findOrFail($validated['module_id']);

            $uploadPath = public_path('uploads/presentations');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $filename = time() . '_' . $validated['file']->getClientOriginalName();
            $validated['file']->move($uploadPath, $filename);

            // determine next order for lesson within module
            $nextOrder = $module->lessons()->max('order') ?? 0;

            $lesson = Lesson::create([
                'course_id' => $module->course_id,
                'module_id' => $validated['module_id'],
                'title' => $validated['title'],
                'slug' => $this->createUniqueSlug(Lesson::class, $validated['title']),
                'description' => $validated['description'] ?? '',
                'content' => 'uploads/presentations/' . $filename,
                'duration_minutes' => $validated['duration_minutes'] ?? 0,
                'order' => ++$nextOrder,
                // Make presentation immediately available to enrolled users
                'is_published' => true,
            ]);

            // notify enrolled users about the new presentation
            $this->notifyEnrolledUsers($module, $lesson);

            // redirect to the public module view so users can access the new presentation
            $courseSlug = $module->course ? $module->course->slug : null;
            $moduleSlug = $module->slug;

            $redirect = $courseSlug && $moduleSlug
                ? route('modules.show', [$courseSlug, $moduleSlug])
                : route('admin.modules.index', ['course_id' => $module->course_id]);

            return response()->json([
                'success' => true,
                'message' => 'Presentation uploaded and published to module successfully!',
                'data' => $lesson,
                'redirect_url' => $redirect,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Notify all users enrolled in the course for a module about a new lesson.
     */
    private function notifyEnrolledUsers(Module $module, $item)
    {
        try {
            $courseId = $module->course_id;
            $enrollments = Enrollment::where('course_id', $courseId)->with('user')->get();
            $users = $enrollments->pluck('user')->filter();

            if ($users->isNotEmpty()) {
                Notification::send($users->all(), new NewLessonNotification($item, $module));
            }
        } catch (\Exception $e) {
            Log::error('Notification error: ' . $e->getMessage());
        }
    }

    /**
     * Create Quiz
     */
    public function createQuiz(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'questions_count' => 'required|integer|min:1',
            'time_limit_minutes' => 'required|integer|min:5',
            'module_id' => 'required|exists:modules,id',
            'media_type' => 'nullable|in:image,video',
            'media_url' => 'nullable|url',
            'media_file' => 'nullable|file|mimes:jpeg,png,jpg,gif,mp4,avi,mov|max:30000',
        ]);

        try {
            $module = Module::findOrFail($validated['module_id']);

            $quizData = [
                'module_id' => $validated['module_id'],
                'title' => $validated['title'],
                'slug' => $this->createUniqueSlug(Quiz::class, $validated['title']),
                'time_limit_minutes' => $validated['time_limit_minutes'],
                'passing_score' => 70,
                'is_published' => true,
                'description' => $validated['description'] ?? '',
                'media_type' => $validated['media_type'] ?? null,
                'media_url' => $validated['media_url'] ?? null,
            ];

            if ($request->hasFile('media_file')) {
                $file = $request->file('media_file');
                $uploadPath = public_path('uploads/quiz-media');
                if (!file_exists($uploadPath)) {
                    mkdir($uploadPath, 0755, true);
                }

                $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                $file->move($uploadPath, $filename);
                $quizData['media_url'] = asset('uploads/quiz-media/' . $filename);

                $extension = strtolower($file->getClientOriginalExtension());
                $quizData['media_type'] = in_array($extension, ['mp4', 'avi', 'mov']) ? 'video' : 'image';
            } elseif (!empty($validated['media_url']) && empty($validated['media_type'])) {
                if (preg_match('/\.(jpg|jpeg|png|gif)$/i', $validated['media_url'])) {
                    $quizData['media_type'] = 'image';
                } else {
                    $quizData['media_type'] = 'video';
                }
            }

            $quiz = Quiz::create($quizData);

            // notify enrolled users about the new quiz
            $this->notifyEnrolledUsers($module, $quiz);

            $courseSlug = $module->course ? $module->course->slug : null;
            $moduleSlug = $module->slug;
            $redirect = $courseSlug && $moduleSlug ? route('modules.show', [$courseSlug, $moduleSlug]) : route('admin.modules.index', ['course_id' => $module->course_id]);

            return response()->json([
                'success' => true,
                'message' => 'Quiz created! You can now add questions.',
                'data' => $quiz,
                'redirect_url' => $redirect,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Create PowerPoint Presentation
     */
    public function createPowerPoint(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'template' => 'required|string',
            'module_id' => 'required|exists:modules,id',
            'description' => 'nullable|string',
        ]);

        try {
            $module = Module::findOrFail($validated['module_id']);

            $lesson = Lesson::create([
                'course_id' => $module->course_id,
                'module_id' => $validated['module_id'],
                'title' => $validated['title'],
                'slug' => $this->createUniqueSlug(Lesson::class, $validated['title']),
                'description' => $validated['description'] ?? '',
                'content' => json_encode(['template' => $validated['template'], 'slides' => []]),
                'duration_minutes' => $validated['duration_minutes'] ?? 0,
                'is_published' => true,
            ]);
            // notify enrolled users (PowerPoint creation)
            $this->notifyEnrolledUsers($module, $lesson);

            $courseSlug = $module->course ? $module->course->slug : null;
            $moduleSlug = $module->slug;
            $redirect = $courseSlug && $moduleSlug ? route('modules.show', [$courseSlug, $moduleSlug]) : route('admin.modules.index', ['course_id' => $module->course_id]);

            return response()->json([
                'success' => true,
                'message' => 'PowerPoint presentation created!',
                'data' => $lesson,
                'redirect_url' => $redirect,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 400);
        }
    }

    /**
     * Upload Images
     */
    public function uploadImages(Request $request)
    {
        $request->validate([
            'images' => 'nullable|array',
            'images.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf,ppt,pptx,xlsx,xls,doc,docx,mp4,avi,mov|max:30000',
            'files' => 'nullable|array',
            'files.*' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf,ppt,pptx,xlsx,xls,doc,docx,mp4,avi,mov|max:30000',
            'module_id' => 'required|exists:modules,id',
        ]);

        try {
            $moduleId = $request->input('module_id');
            $module = Module::findOrFail($moduleId);

            $uploadPath = public_path('uploads/content');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Collect files from multiple upload key variants and support single-file uploads
            $files = [];
            $uploadKeys = ['images', 'files', 'images[]', 'files[]'];

            foreach ($uploadKeys as $key) {
                if (!$request->hasFile($key)) {
                    continue;
                }

                $rawFiles = $request->file($key);
                if ($rawFiles instanceof UploadedFile) {
                    $files = [$rawFiles];
                } elseif (is_array($rawFiles)) {
                    $files = array_filter($rawFiles, function ($f) {
                        return $f instanceof UploadedFile;
                    });
                }

                if (!empty($files)) {
                    break;
                }
            }

            if (empty($files)) {
                return response()->json([
                    'success' => false,
                    'message' => 'No valid files found. Please select at least one file.',
                ], 422);
            }

            $uploaded = [];
            $createdLessons = [];
            $nextOrder = $module->lessons()->max('order') ?? 0;

            foreach ($files as $file) {
                try {
                    $filename = time() . '_' . Str::random(10) . '.' . $file->getClientOriginalExtension();
                    $file->move($uploadPath, $filename);
                    $filePath = 'uploads/content/' . $filename;
                    $uploaded[] = $filePath;

                    $baseName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $title = Str::title(str_replace(['-', '_'], ' ', $baseName));
                    if (empty(trim($title))) {
                        $title = 'Uploaded Material';
                    }

                    $lessonData = [
                        'course_id' => $module->course_id,
                        'module_id' => $module->id,
                        'title' => $title,
                        'slug' => $this->createUniqueSlug(Lesson::class, $title),
                        'description' => 'Uploaded material: ' . $file->getClientOriginalName(),
                        'content' => $filePath,
                        'video_url' => null,
                        'duration_minutes' => 0,
                        'order' => ++$nextOrder,
                        'is_published' => true,
                    ];

                    $extension = strtolower($file->getClientOriginalExtension());
                    if (in_array($extension, ['mp4', 'avi', 'mov'])) {
                        $lessonData['video_url'] = asset($filePath);
                        $lessonData['content'] = '';
                    }

                    $createdLessons[] = Lesson::create($lessonData);
                } catch (\Exception $fileErr) {
                    Log::error('File upload error: ' . $fileErr->getMessage());
                    continue;
                }
            }

            // notify enrolled users for each created lesson
            foreach ($createdLessons as $created) {
                try {
                    $this->notifyEnrolledUsers($module, $created);
                } catch (\Exception $e) {
                    Log::error('Notify error: ' . $e->getMessage());
                }
            }

            if (empty($uploaded)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to process any files. Please check file sizes and formats.',
                ], 422);
            }

            $courseSlug = $module->course ? $module->course->slug : null;
            $moduleSlug = $module->slug;
            $redirect = $courseSlug && $moduleSlug ? route('modules.show', [$courseSlug, $moduleSlug]) : route('admin.modules.index', ['course_id' => $module->course_id]);

            return response()->json([
                'success' => true,
                'message' => count($uploaded) . ' file(s) uploaded successfully and added to module materials!',
                'data' => [
                    'uploaded_paths' => $uploaded,
                    'lessons' => $createdLessons,
                ],
                'redirect_url' => $redirect,
            ]);
        } catch (\Exception $e) {
            Log::error('Upload handler error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Server error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Get modules for dropdown
     */
    public function getModules(Request $request)
    {
        $modules = Module::with('course')
            ->orderByRaw("COALESCE((select title from courses where courses.id = modules.course_id), '')")
            ->orderBy('title')
            ->get()
            ->map(function ($module) {
                return [
                    'id' => $module->id,
                    'module_title' => $module->title,
                    'course_title' => $module->course ? $module->course->title : null,
                    'title' => $module->course ? $module->course->title . ' / ' . $module->title : $module->title,
                    'course_id' => $module->course_id,
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $modules,
        ]);
    }

    /**
     * Generate a unique slug for the given model class.
     */
    private function createUniqueSlug(string $modelClass, string $title): string
    {
        $baseSlug = Str::slug($title);
        $slug = $baseSlug;
        $counter = 1;

        while ($modelClass::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter;
            $counter++;
        }

        return $slug;
    }
}
