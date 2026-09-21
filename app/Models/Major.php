<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Major extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'description',
        'department',
        'icon',
        'color',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Courses that belong to this major
     */
    public function courses()
    {
        return $this->hasMany(Course::class, 'major_id');
    }

    /**
     * Get the primary/designated course for this major
     */
    public function primaryCourse()
    {
        return $this->hasOne(Course::class, 'major_id')->where('is_primary', true)->orderBy('created_at');
    }

    /**
     * Students enrolled in this major
     */
    public function students()
    {
        return $this->hasMany(User::class, 'major_id');
    }
}
