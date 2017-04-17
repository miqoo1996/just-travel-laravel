<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = [
        'gallery_name',
        'gallery_url',
        'main_image'
    ];

    public function images()
    {
        return $this->hasMany('App\GalleryPhotos')->get();
    }
}
