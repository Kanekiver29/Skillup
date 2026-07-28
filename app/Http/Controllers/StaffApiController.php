<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use App\Models\Course;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\QuizQuestionAnswer;

class StaffApiController extends Controller
{
    protected function authorizeStaff()
    {
        if (!auth()->check() || !auth()->user()->hasStaffAccess()) {
            abort(403, 'Unauthorized');
        }
    }

    /**
     * Sync the frontend in-memory store into the database.
     * This is a best-effort upsert for demo purposes.
     */
    public function sync(Request $request)
    {
        $this->authorizeStaff();

        $store = $request->input('store');
        if (!is_array($store) && isset($store['courses'])) {
            $store = $store;
        }

        $courses = $store['courses'] ?? $store;
        if (!is_array($courses)) {
            return response()->json(['error' => 'Invalid payload'], 422);
        }

        $saved = [];
        $mapping = ['courses' => [], 'modules' => [], 'quizzes' => [], 'questions' => []];

        foreach ($courses as $courseData) {
            $localCourseId = $courseData['id'] ?? null;
            $title = $courseData['title'] ?? 'Untitled';
            $slug = Str::slug($title) ?: Str::random(8);

            // Prefer updating by provided DB id if present
            $course = null;

            if (!empty($courseData['_dbId'])) {
                $course = Course::find($courseData['_dbId']);
            }

            // try reverse lookup by frontend local id
            if (!$course && !empty($localCourseId)) {
                $course = Course::where('lms_local_id', $localCourseId)->first();
            }

            if (!$course && !empty($courseData['slug'])) {
                $course = Course::where('slug', $courseData['slug'])->first();
            }

            if (!$course) {
                $course = Course::firstOrCreate([
                    'slug' => $slug,
                ], [
                    'title' => $title,
                    'slug' => $slug,
                    'lms_local_id' => $localCourseId ?? null,
                    'description' => $courseData['description'] ?? null,
                    'short_description' => $courseData['short_description'] ?? null,
                    'category' => $courseData['category'] ?? 'Uncategorized',
                    'is_published' => isset($courseData['status']) && $courseData['status'] === 'Active',
                ]);
            }

            // Update basic fields and ensure local id stored
            $course->update([
                'title' => $title,
                'is_published' => isset($courseData['status']) && $courseData['status'] === 'Active',
                'students_count' => $courseData['students'] ?? $course->students_count,
                'lms_local_id' => $localCourseId ?? $course->lms_local_id,
            ]);

            // record mapping
            if ($localCourseId) $mapping['courses'][(string)$localCourseId] = $course->id;

            // Modules
            $modules = $courseData['modules'] ?? [];
            foreach ($modules as $idx => $m) {
                $localModuleId = $m['id'] ?? null;
                $mTitle = $m['title'] ?? 'Module ' . ($idx+1);
                $mSlug = $m['slug'] ?? Str::slug($mTitle) ?: Str::random(6);

                $module = null;
                if (!empty($m['_dbId'])) {
                    $module = Module::find($m['_dbId']);
                }
                // reverse lookup by lms_local_id
                if (!$module && $localModuleId) {
                    $module = Module::where('lms_local_id', $localModuleId)->first();
                }
                if (!$module && $localModuleId && isset($mapping['modules'][(string)$localModuleId])) {
                    $module = Module::find($mapping['modules'][(string)$localModuleId]);
                }
                if (!$module) {
                    $module = Module::firstOrCreate([
                        'course_id' => $course->id,
                        'slug' => $mSlug,
                    ], [
                        'course_id' => $course->id,
                        'lms_local_id' => $localModuleId ?? null,
                        'title' => $mTitle,
                        'slug' => $mSlug,
                        'definition' => $m['content'] ?? null,
                        'order' => $idx,
                        'is_published' => true,
                    ]);
                }

                // Update module content
                $module->update([
                    'title' => $mTitle,
                    'definition' => $m['content'] ?? $module->definition,
                    'order' => $idx,
                ]);

                if ($localModuleId) $mapping['modules'][(string)$localModuleId] = $module->id;

                // Quizzes
                if (isset($m['type']) && strtolower($m['type']) === 'quiz' && !empty($m['questions'])) {
                    $quiz = null;
                    if (!empty($m['_quizDbId'])) {
                        $quiz = Quiz::find($m['_quizDbId']);
                    }
                    if (!$quiz) {
                        // Try to find quiz by module
                        $quiz = Quiz::where('module_id', $module->id)->first();
                    }

                    if (!$quiz) {
                        $quiz = Quiz::create([
                            'module_id' => $module->id,
                            'title' => $mTitle,
                            'slug' => Str::slug($mTitle) . '-' . Str::random(4),
                            'passing_score' => 70,
                            'time_limit_minutes' => isset($m['duration']) ? (int)$m['duration'] : null,
                            'is_published' => true,
                        ]);
                    } else {
                        $quiz->update([
                            'title' => $mTitle,
                            'time_limit_minutes' => isset($m['duration']) ? (int)$m['duration'] : $quiz->time_limit_minutes,
                            'is_published' => true,
                        ]);
                    }

                    // record quiz mapping using local module id key if present
                    if ($localModuleId) {
                        $mapping['quizzes'][(string)$localModuleId] = $quiz->id;
                        // save mapping on quiz for reverse lookup
                        $quiz->lms_local_id = $localModuleId;
                        $quiz->save();
                    }

                    // sync questions (naive approach: delete existing, recreate)
                    $quiz->questions()->delete();
                    foreach ($m['questions'] as $qIdx => $q) {
                        $localQuestionId = $q['id'] ?? null;
                        $question = QuizQuestion::create([
                            'quiz_id' => $quiz->id,
                            'lms_local_id' => $localQuestionId ?? null,
                            'type' => isset($q['type']) ? $q['type'] : 'multiple_choice',
                            'question_text' => $q['question'] ?? 'Question',
                            'points' => $q['points'] ?? 1,
                            'order' => $qIdx,
                        ]);

                        if ($localQuestionId) $mapping['questions'][(string)$localQuestionId] = $question->id;

                        // create answers
                        $options = $q['options'] ?? [];
                        foreach ($options as $aIdx => $opt) {
                            QuizQuestionAnswer::create([
                                'quiz_question_id' => $question->id,
                                'answer_text' => $opt,
                                'is_correct' => isset($q['answer']) && $q['answer'] == $aIdx,
                                'order' => $aIdx,
                            ]);
                        }
                    }
                }
            }

            $saved[] = $course->id;
        }

        return response()->json(['saved_course_ids' => $saved, 'mapping' => $mapping]);
    }
}
