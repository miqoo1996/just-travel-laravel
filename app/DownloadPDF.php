<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DownloadPDF extends Model
{
    protected $fillable = [
      'pdf_name_en',
      'pdf_name_ru',
      'pdf_thumbnail_en',
      'pdf_thumbnail_ru',
      'pdf_file_en',
      'pdf_file_ru',
    ];
}
