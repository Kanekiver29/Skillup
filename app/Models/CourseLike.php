<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseLike extends Model
{
    protected $table = 'course_likes';
    
    protected $fillable = [
        'user_id',
        'course_id',
    ];

    /**
     * Get the user who liked the course
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the course that was liked
     */
    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
