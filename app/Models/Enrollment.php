<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'course_id',
        'subject_id',
        'qualification_name',
        'qualification_code',
        'training_program',
        'unit_of_competency',
        'training_center',
        'batch_class',
        'training_schedule',
        'training_start_date',
        'training_end_date',
        'training_mode',
        'training_location',
        'scholarship_type',
        'scholarship_reference_no',
        'enrollment_date',
        'supporting_documents',
        'document_status',
        'completed',
        'progress',
        'final_grade',
        'completed_at',
        'year_level',
        'section',
        'semester',
        'enrolled_at',
        'status',
    ];

    protected $casts = [
        'completed' => 'boolean',
        'completed_at' => 'datetime',
        'enrolled_at' => 'datetime',
        'training_start_date' => 'date',
        'training_end_date' => 'date',
        'enrollment_date' => 'date',
        'supporting_documents' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
