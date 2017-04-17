<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    protected $fillable = [
        'hotel_url',
        'regions',
        'hotel_name_en',
        'hotel_name_ru',
        'desc_en',
        'desc_ru',
        'short_desc_en',
        'short_desc_ru',
        'tags_en',
        'tags_ru',
        'type',
        'images',
        'main_image',
        'visibility'
    ];
}
