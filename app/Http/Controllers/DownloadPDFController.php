<?php

namespace App\Http\Controllers;

use App\DownloadPDF;
use App\SimpleImage;
use App\Http\Controllers\Traits\DownloadPDFTrait;
use Illuminate\Http\Request;

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
            SimpleImage::setModel(clone $file);
            $file->scenario = 'update';
        } else {
            $file = new DownloadPDF();
            $file->scenario = 'insert';
        }

        if ($fields = $request->input()) {
            $this->setFile($request, $fields, 'pdf_file_en');
            $this->setFile($request, $fields, 'pdf_file_ru');
            $this->setFile($request, $fields, 'pdf_thumbnail_en');
            $this->setFile($request, $fields, 'pdf_thumbnail_ru');
            $file->fill($fields);
        }

        if ($file->save()) {
            $this->setFile($request, $fields, 'pdf_file_en', true);
            $this->setFile($request, $fields, 'pdf_file_ru', true);
            $this->setFile($request, $fields, 'pdf_thumbnail_en', true);
            $this->setFile($request, $fields, 'pdf_thumbnail_ru', true);
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
        $model = new DownloadPDF();
        $catalogs = $model->getPdfs(true);
        return view('catalogue', compact('catalogs'));
    }

    public function adminPdfOrders()
    {
        $model = new DownloadPDF();
        $pdfs = $model->getPdfs(true);
        return view('admin.pdf_orders', compact('pdfs'));
    }

    public function adminPdfOrdersSave(Request $request)
    {
        $model = new DownloadPDF();
        $items = $request->get('items');
        $model->saveData($items);
    }

}
