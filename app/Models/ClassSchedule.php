<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSchedule extends Model
{
    use HasFactory;

    protected $table = 'class_schedules';

    protected $fillable = [
        'teacher_id',
        'course_id',
        'subject_name',
        'day_of_week',
        'start_time',
        'end_time',
        'room_number',
        'building',
        'student_count',
        'notes',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the duration of the class in minutes
     */
    public function getDurationMinutes()
    {
        $start = \Carbon\Carbon::createFromFormat('H:i:s', $this->start_time);
        $end = \Carbon\Carbon::createFromFormat('H:i:s', $this->end_time);
        return $end->diffInMinutes($start);
    }

    /**
     * Get day index for sorting
     */
    public static function getDayIndex($day)
    {
        return array_search($day, ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']);
    }
}
