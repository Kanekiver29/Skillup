<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Module extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'course_id',
        'lms_local_id',
        'title',
        'slug',
        'description',
        'definition',
        'example',
        'type',
        'duration',
        'thumbnail',
        'word_url',
        'video_url',
        'image_url',
        'ppt_url',
        'order',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'duration' => 'integer',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lessons()
    {
        return $this->hasMany(Lesson::class)->orderBy('order');
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class)->orderBy('order');
    }

    /**
     * Get overall module progress including lessons and quizzes
     */
    public function getDetailedProgress($userId)
    {
        $lessons = $this->lessons()->where('is_published', true)->get();
        $quizzes = $this->quizzes()->where('is_published', true)->get();
        $totalItems = $lessons->count() + $quizzes->count();

        if ($totalItems === 0) return 0;

        // Count completed lessons
        $completedLessons = $lessons->filter(function ($lesson) use ($userId) {
            return $lesson->enrollments()
                ->where('completed', true)
                ->whereHas('enrollment', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->exists();
        })->count();

        // Count passed quizzes
        $passedQuizzes = $quizzes->filter(function ($quiz) use ($userId) {
            return $quiz->attempts()
                ->where('user_id', $userId)
                ->where('passed', true)
                ->exists();
        })->count();

        $completedItems = $completedLessons + $passedQuizzes;
        return round(($completedItems / $totalItems) * 100);
    }

    /**
     * Get all module items (lessons and quizzes) in order
     */
    public function getOrderedItems()
    {
        $lessons = $this->lessons()
            ->where('is_published', true)
            ->get()
            ->map(function ($lesson) {
                $lesson->type = 'lesson';
                $lesson->item_order = $lesson->order;
                return $lesson;
            });

        $quizzes = $this->quizzes()
            ->where('is_published', true)
            ->get()
            ->map(function ($quiz) {
                $quiz->type = 'quiz';
                $quiz->item_order = $quiz->order;
                return $quiz;
            });

        return collect($lessons)->merge($quizzes)->sortBy('item_order')->values();
    }

    /**
     * Legacy progress method for backward compatibility
     */
    public function getProgress($userId)
    {
        return $this->getDetailedProgress($userId);
    }
}
