<?php

namespace App\Http\Controllers\Traits;

use App\SimpleImage;
use Illuminate\Http\Request;

trait HotelTrait
{
    private $imageName = '';

    public function __construct()
    {
        $this->imageName = uniqid();
    }

    public function setFile(Request $request, &$fields, $imagePathName, $_file, $move = false)
    {
        if ($image = $request->file($_file)) {
            if (in_array($image->getMimeType(), ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'])) {
                $images = [];
                $image_name = $this->imageName . config('const.' . $image->getMimeType());
                $imagePath = $imagePathName . $image_name;
                if ($move) {
                    if (isset(SimpleImage::$model->$_file)) {
                        $images[] = SimpleImage::$model->$_file;
                    }
                    $image->move($imagePathName, $image_name);
                    SimpleImage::resize($imagePath, $imagePathName . 'thumbnail-' . $image_name, 555, 317, 450, 257);
                }
                $fields[$_file] = $imagePath;
                SimpleImage::deleteImages($images);
            }
        }
    }

}