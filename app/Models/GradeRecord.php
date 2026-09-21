<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeRecord extends Model
{
    protected $fillable = [
        'student_id', 'course_id', 'module_id', 'assessment_type', 'title',
        'score', 'max_score', 'remarks', 'graded_by',
    ];

    protected $casts = ['score' => 'float', 'max_score' => 'float'];

    public function student() { return $this->belongsTo(User::class, 'student_id'); }
    public function course() { return $this->belongsTo(Course::class); }
    public function module() { return $this->belongsTo(Module::class); }
    public function teacher() { return $this->belongsTo(User::class, 'graded_by'); }

    public function getPercentageAttribute(): float
    {
        return $this->max_score > 0 ? round(($this->score / $this->max_score) * 100, 1) : 0;
    }
}