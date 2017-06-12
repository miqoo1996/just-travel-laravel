<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GalleryPhotos extends Model
{
    protected $fillable = [
        'image_name',
        'image_path',
        'gallery_id',
    ];
}
