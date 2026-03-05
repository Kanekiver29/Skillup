<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'short_description',
        'category',
        'level',
        'duration_hours',
        'instructor_name',
        'instructor_title',
        'image_url',
        'rating',
        'students_count',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'rating' => 'float',
    ];

    public function lessons()
    {
        return $this->hasMany(Lesson::class);
    }

    public function modules()
    {
        return $this->hasMany(Module::class)->orderBy('order');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function getProgress($userId)
    {
        $totalLessons = $this->lessons()->count();
        if ($totalLessons === 0) return 0;

        $completedLessons = $this->lessons()
            ->whereHas('enrollments', function ($query) use ($userId) {
                $query->where('user_id', $userId)->where('completed', true);
            })
            ->count();

        return round(($completedLessons / $totalLessons) * 100);
    }
}
