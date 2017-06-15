<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;

trait VideoGalleryTrait
{
    public function setFile(Request $request, &$fields, $_file, $move = false)
    {
        if ($image = $request->file($_file)) {
            $image_name = uniqid() . config('const.' . $image->getMimeType());
            $image_path = 'images/video_thumbnails/en/' . $image_name;
            if ($move) {
                $image->move('images/video_thumbnails/en', $image_name);
            }
            $fields[$_file] = $image_path;
        }
    }
}