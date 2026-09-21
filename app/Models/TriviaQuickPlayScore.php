<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TriviaQuickPlayScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'game_type',
        'score',
        'max_score',
        'score_percentage',
        'completed_at',
    ];

    protected $casts = [
        'completed_at' => 'datetime',
        'score' => 'integer',
        'max_score' => 'integer',
        'score_percentage' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
