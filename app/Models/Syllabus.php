<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Syllabus extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'effective_start',
        'effective_end',
        'is_published',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'effective_start' => 'date',
        'effective_end' => 'date',
        'is_published' => 'boolean',
        'photos' => 'array',
        'videos' => 'array',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function sections()
    {
        return $this->hasMany(SyllabusSection::class)->orderBy('order');
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function togglePublish()
    {
        $this->is_published = ! $this->is_published;
        $this->save();
    }
}
?>
