<?php

namespace App\Http\Controllers\Traits;

use App\SimpleImage;
use Illuminate\Http\Request;

trait DownloadPDFTrait
{
    private $files = [];

    public function setFile(Request $request, &$fields, $_file, $move = false)
    {
        if($request->hasFile($_file)){
            $data = $request->file($_file);
            if (in_array($data->getMimeType(), ['application/pdf', 'image/jpeg', 'image/jpg', 'image/png', 'image/gif'])) {
                $files = [];
                $this->files[$_file] = isset($this->files[$_file]) ?$this->files[$_file] : uniqid() . config('const.' . $data->getMimeType());
                $data_name = $this->files[$_file];
                $data_path = 'files/pdf/';
                if ($move) {
                    if (isset(SimpleImage::$model->$_file)) {
                        $files[] = SimpleImage::$model->$_file;
                    }
                    $data->move($data_path , $data_name);
                    if (in_array($_file, ['pdf_thumbnail_en', 'pdf_thumbnail_ru'])) {
                        SimpleImage::resize($data_path . $data_name, $data_path . 'thumbnail-' . $data_name, 555, 317, 150, 225);
                    }
                }
                $fields[$_file] = $data_path . $data_name;
                SimpleImage::deleteImages($files);
            }
        }
    }
}