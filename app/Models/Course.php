<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Schema;
use App\Models\User;

class Course extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected static function booted()
    {
        // If DB hasn't been migrated to include deleted_at yet, remove the soft-deleting global scope
        // so queries won't reference a non-existent column.
        try {
            if (!Schema::hasColumn('courses', 'deleted_at')) {
                foreach (self::$globalScopes as $k => $scope) {
                    if ($scope instanceof SoftDeletingScope) {
                        unset(self::$globalScopes[$k]);
                    }
                }
            }
        } catch (\Exception $e) {
            // If Schema isn't available (during early bootstrap), skip defensive logic
        }
    }

    protected $fillable = [
        'instructor_id',
        'title',
        'slug',
        'lms_local_id',
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

    /**
     * Students enrolled in the course
     */
    public function students()
    {
        return $this->belongsToMany(User::class, 'enrollments', 'course_id', 'user_id');
    }


    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id')->withDefault(function () {
            return (object) ['name' => $this->instructor_name ?? 'Instructor'];
        });
    }

    /**
     * Get all likes for this course
     */
    public function likes()
    {
        return $this->hasMany(CourseLike::class);
    }

    /**
     * Get the count of likes
     */
    public function getLikesCount()
    {
        return $this->likes()->count();
    }

    /**
     * Check if a user has liked this course
     */
    public function isLikedBy($userId)
    {
        return $this->likes()
            ->where('user_id', $userId)
            ->exists();
    }

    public function getProgress($userId)
    {
        $totalLessons = $this->lessons()->count();
        if ($totalLessons === 0) return 0;

        $completedLessons = $this->lessons()
            ->whereHas('enrollments', function ($query) use ($userId) {
                $query->where('completed', true)
                    ->whereHas('enrollment', function ($q) use ($userId) {
                        $q->where('user_id', $userId);
                    });
            })
            ->count();

        return round(($completedLessons / $totalLessons) * 100);
    }

    /**
     * Compatibility accessor for legacy views that reference course_title.
     */
    public function getCourseTitleAttribute()
    {
        return $this->attributes['course_title'] ?? $this->attributes['title'] ?? null;
    }

    /**
     * Compatibility accessor for legacy views that reference course_description.
     */
    public function getCourseDescriptionAttribute()
    {
        return $this->attributes['course_description'] ?? $this->attributes['description'] ?? null;
    }
}
