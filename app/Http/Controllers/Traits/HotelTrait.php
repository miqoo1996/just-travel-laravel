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
            $image_name = $this->imageName . config('const.' . $image->getMimeType());
            $image = $imagePathName . $image_name;
            if ($move) {
                $image->move($imagePathName, $image_name);
                SimpleImage::resize($image, $imagePathName . 'thumbnail-' . $image_name, 555, 317, 450, 257);
            }
            $fields[$_file] = $image;
        }
    }

}