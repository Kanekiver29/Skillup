<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Submission extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'assignment_id',
        'user_id',
        'submitted_at',
        'grade',
        'feedback',
    ];
    protected $casts = [
        'submitted_at' => 'datetime',
    ];

    /**
     * The assignment this submission belongs to.
     */
    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    /**
     * The student (user) who submitted.
     */
    public function student()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
