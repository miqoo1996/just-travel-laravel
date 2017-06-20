<?php

namespace App\Http\Controllers\Traits;

use App\SimpleImage;
use Illuminate\Http\Request;

trait VideoGalleryTrait
{
    private $images = [];
    private $imageName = '';

    public function __construct()
    {
        $this->imageName = uniqid();
    }

    public function setFile(Request $request, &$fields, $_file, $move = false)
    {
        $images = [];
        if ($image = $request->file($_file)) {
            if (in_array($image->getMimeType(), ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'])) {
                $this->imageName = uniqid();
                $this->images[$_file] = isset($this->images[$_file]) ? $this->images[$_file] : $this->imageName . config('const.' . $image->getMimeType());
                $image_name = $this->images[$_file];
                $imagePathName = 'images/video_thumbnails/en/';
                $imagePath = $imagePathName . $image_name;
                if ($move) {
                    if (isset(SimpleImage::$model->$_file)) {
                        $images[] = SimpleImage::$model->$_file;
                    }
                    $image->move($imagePathName, $image_name);
                    SimpleImage::resize($imagePath, $imagePathName . 'thumbnail-' . $image_name, 280, 160, 280, 160);
                }
                $fields[$_file] = $imagePath;
            }
        }
        SimpleImage::deleteImages($images);
    }

}