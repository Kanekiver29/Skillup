<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id',
        'subject_id',
        'lms_local_id',
        'title',
        'slug',
        'description',
        'passing_score',
        'time_limit_minutes',
        'attempt_limit',
        'randomize_questions',
        'show_correct_answers',
        'is_trivia',
        'major_id',
        'difficulty',
        'question_count',
        'question_time_limit_seconds',
        'scheduled_at',
        'media_type',
        'media_url',
        'order',
        'is_published',
        'is_archived',
        'archived_at',
    ];

    protected $casts = [
        'randomize_questions' => 'boolean',
        'show_correct_answers' => 'boolean',
        'is_trivia' => 'boolean',
        'question_count' => 'integer',
        'question_time_limit_seconds' => 'integer',
        'scheduled_at' => 'datetime',
        'is_published' => 'boolean',
        'is_archived' => 'boolean',
        'archived_at' => 'datetime',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class)->orderBy('order');
    }

    public function attempts()
    {
        return $this->hasMany(UserQuizAttempt::class);
    }

    public function userAttempts($userId)
    {
        return $this->attempts()->where('user_id', $userId)->orderByDesc('created_at');
    }

    public function getUserBestScore($userId)
    {
        return $this->attempts()
            ->where('user_id', $userId)
            ->max('score_percentage') ?? 0;
    }

    public function hasUserPassed($userId)
    {
        return $this->attempts()
            ->where('user_id', $userId)
            ->where('passed', true)
            ->exists();
    }

    public function getUserAttemptCount($userId)
    {
        return $this->attempts()->where('user_id', $userId)->count();
    }

    public function canUserRetry($userId)
    {
        $attemptCount = $this->getUserAttemptCount($userId);
        return $attemptCount < $this->attempt_limit;
    }
}
