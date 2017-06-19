<?php

namespace App\Http\Controllers;

use App\DownloadPDF;
use App\Http\Controllers\Traits\DownloadPDFTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class DownloadPDFController extends Controller
{
    use DownloadPDFTrait;

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
        if ($request->get('file_id')){
            $file = DownloadPDF::find($request->get('file_id'));
        } else {
            $file = new DownloadPDF();
        }

        if ($fields = $request->input()) {
            $this->setFile($request, $file, $fields, 'pdf_file_en');
            $this->setFile($request, $file, $fields, 'pdf_file_ru');
            $this->setFile($request, $file, $fields, 'pdf_thumbnail_en');
            $this->setFile($request, $file, $fields, 'pdf_thumbnail_ru');
            $file->fill($fields);
        }

        if ($file->save()) {
            $this->setFile($request, $file, $fields, 'pdf_file_en', true);
            $this->setFile($request, $file, $fields, 'pdf_file_ru', true);
            $this->setFile($request, $file, $fields, 'pdf_thumbnail_en', true);
            $this->setFile($request, $file, $fields, 'pdf_thumbnail_ru', true);
            return redirect()->route('admin-pdf-list');
        }

        return view('admin.edit_pdf', ['file' => $file, 'errors' => $file->getValidator()->errors()]);
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
