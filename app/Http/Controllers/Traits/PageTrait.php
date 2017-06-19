<?php

namespace App\Http\Controllers\Traits;

use App\SimpleImage;
use Illuminate\Http\Request;

trait PageTrait
{
    private $imageName = '';

    public function __construct()
    {
        $this->imageName = uniqid();
    }

    public function setFile(Request $request, &$fields, $_file, $move = false)
    {
        if ($request->hasFile($_file)) {
            $image = $request->file($_file);
            $image_name = $this->imageName . config('const.' . $image->getMimeType());
            $image_path = 'images/pages/';
            if ($move) {
                $image->move($image_path, $image_name);
                SimpleImage::resize($image_path . $image_name, $image_path . 'thumbnail-' . $image_name, 690, 391, 690, 391);
            }
            $fields[$_file] = $image_path . $image_name;
        }
    }

}