<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'gallery_name_en',
        'gallery_name_ru',
        'gallery_desc_en',
        'gallery_desc_ru',
        'gallery_url',
        'main_image',
        'gallery',
        'portfolio'
    ];

    public function images()
    {
        return $this->hasMany('App\GalleryPhotos')->get();
    }
}
