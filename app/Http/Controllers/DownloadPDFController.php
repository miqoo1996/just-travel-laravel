<?php

namespace App\Http\Controllers;

use App\DownloadPDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;


use App\Http\Requests;

class DownloadPDFController extends Controller
{
    public function adminGetPDFListPage()
    {
        $files = DownloadPDF::all();
        return view('admin.pdf_list', ['files' => $files]);
    }

    public function adminGetNewPDF()
    {
        return view('admin.new_pdf');
    }

    public function adminPostNewPDF(Request $request)
    {
        if (isset($request->file_id)){
            $file = DownloadPDF::find($request->file_id);
        } else {
            $file = new DownloadPDF();
            $file->save();
        }

        $fields = $request->input();
        if($request->hasFile('pdf_file_en')){
            $oldFile = $file->pdf_file_en;
            File::delete($oldFile);
            $data = $request->file('pdf_file_en');
            $data_name = uniqid() . config('const.' . $data->getMimeType());
            $data_path = 'files/pdf/'.$file->id. '/' . $data_name;
            $data->move('files/pdf/'.$file->id , $data_name);
            $fields['pdf_file_en'] = $data_path;
        }

        if($request->hasFile('pdf_file_ru')){
            $oldFile = $file->pdf_file_ru;
            File::delete($oldFile);
            $data = $request->file('pdf_file_ru');
            $data_name = uniqid() . config('const.' . $data->getMimeType());
            $data_path = 'files/pdf/'.$file->id. '/' . $data_name;
            $data->move('files/pdf/'.$file->id , $data_name);
            $fields['pdf_file_ru'] = $data_path;
        }

        if($request->hasFile('pdf_thumbnail_en')){
            $oldFile = $file->pdf_thumbnail_en;
            File::delete($oldFile);
            $data = $request->file('pdf_thumbnail_en');
            $data_name = uniqid() . config('const.' . $data->getMimeType());
            $data_path = 'images/pdf/'.$file->id. '/' . $data_name;
            $data->move('images/pdf/'.$file->id , $data_name);
            $fields['pdf_thumbnail_en'] = $data_path;
        }

        if($request->hasFile('pdf_thumbnail_ru')){
            $oldFile = $file->pdf_thumbnail_ru;
            File::delete($oldFile);
            $data = $request->file('pdf_thumbnail_ru');
            $data_name = uniqid() . config('const.' . $data->getMimeType());
            $data_path = 'images/pdf/'.$file->id. '/' . $data_name;
            $data->move('images/pdf/'.$file->id , $data_name);
            $fields['pdf_thumbnail_ru'] = $data_path;
        }
        $file->fill($fields);
        $file->save();

        return redirect()->route('admin-pdf-list');
    }

    public function adminGetEditPDF($file_id)
    {
        $file = DownloadPDF::find($file_id);
        return view('admin.edit_pdf', ['file' => $file]);
    }

    public function getCatalogs()
    {
        $catalogs = DownloadPDF::all()->toArray();
        return view('catalogue', compact('catalogs'));
    }
}
