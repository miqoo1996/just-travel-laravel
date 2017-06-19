<?php

namespace App\Http\Controllers\Traits;

use App\SimpleImage;
use Illuminate\Http\Request;

trait VideoGalleryTrait
{
    private $imageName = '';

    public function __construct()
    {
        $this->imageName = uniqid();
    }

    public function setFile(Request $request, &$fields, $_file, $move = false)
    {
        if ($image = $request->file($_file)) {
            $image_name = $this->imageName . config('const.' . $image->getMimeType());
            $imagePathName = 'images/video_thumbnails/en/';
            $image = $imagePathName . $image_name;
            if ($move) {
                $image->move($imagePathName, $image_name);
                SimpleImage::resize($image, $imagePathName . 'thumbnail-' . $image_name, 280, 160, 280, 160);
            }
            $fields[$_file] = $image;
        }
    }

}