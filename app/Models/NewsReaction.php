<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsReaction extends Model
{
    protected $fillable = ['user_id', 'news_item_id', 'type'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function newsItem()
    {
        return $this->belongsTo(NewsItem::class);
    }
}
