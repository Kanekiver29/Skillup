<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'slug',
        'description',
        'order',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class)->orderBy('order');
    }

    public function getProgress($userId)
    {
        $totalQuizzes = $this->quizzes()->count();
        if ($totalQuizzes === 0) return 0;

        $passedQuizzes = $this->quizzes()
            ->whereHas('attempts', function ($query) use ($userId) {
                $query->where('user_id', $userId)->where('passed', true);
            })
            ->distinct()
            ->count();

        return round(($passedQuizzes / $totalQuizzes) * 100);
    }
}
