<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SyllabusSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'syllabus_id',
        'section_title',
        'content',
        'order',
    ];

    public function syllabus()
    {
        return $this->belongsTo(Syllabus::class);
    }
}
?>
