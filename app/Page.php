<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'page_url',
        'page_name_en',
        'page_name_ru',
        'desc_en',
        'desc_ru',
        'visibility',
        'image',
    ];
}
