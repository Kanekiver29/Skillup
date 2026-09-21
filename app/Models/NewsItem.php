<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsItem extends Model
{
    protected $fillable = [
        'title',
        'category',
        'content',
        'featured_image',
        'video_file',
        'is_featured',
        'published_at',
        'target_audience',
        'view_count',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at')->where('published_at', '<=', now());
    }

    public function reactions()
    {
        return $this->hasMany(NewsReaction::class);
    }

    public function comments()
    {
        return $this->hasMany(NewsComment::class);
    }

    public function media()
    {
        return $this->hasMany(NewsMedia::class);
    }

    public function images()
    {
        return $this->media()->where('type', 'image');
    }

    public function videos()
    {
        return $this->media()->where('type', 'video');
    }
}
