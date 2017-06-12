<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoGallery extends Model
{
    protected $fillable = [
        'video_url_en',
        'video_url_ru',
        'embed_en',
        'embed_ru',
        'video_title_en',
        'video_title_ru',
        'video_thumbnail_en',
        'video_thumbnail_ru'
    ];
}
