<?php

namespace App\Http\Controllers\Traits;

use App\DownloadPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

trait DownloadPDFTrait
{
    public function setFile(Request $request, DownloadPDF $file, &$fields, $_file, $move = false)
    {
        if($request->hasFile($_file)){
            if ($file->pdf_file_en) {
                $oldFile = $file->pdf_file_en;
                File::delete($oldFile);
            }
            $data = $request->file($_file);
            $data_name = uniqid() . config('const.' . $data->getMimeType());
            $data_path = 'files/pdf/'.($file->id ? $file->id : '0'). '/' . $data_name;
            if ($move) {
                $data->move('files/pdf/'.$file->id , $data_name);
            }
            $fields[$_file] = $data_path;
        }
    }
}