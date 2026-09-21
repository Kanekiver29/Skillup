<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsMedia extends Model
{
    protected $fillable = ['news_item_id', 'file_path', 'type'];

    public function newsItem()
    {
        return $this->belongsTo(NewsItem::class);
    }
}
