<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class DownloadPDF extends Model
{
    private $validator;

    protected $fillable = [
      'pdf_name_en',
      'pdf_name_ru',
      'pdf_thumbnail_en',
      'pdf_thumbnail_ru',
      'pdf_file_en',
      'pdf_file_ru',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    private $rules = [
        'pdf_name_en' => 'required|max:255',
        'pdf_name_ru' => 'required|max:255',
        'pdf_thumbnail_en' => 'required|max:255',
        'pdf_thumbnail_ru' => 'required|max:255',
        'pdf_file_en' => 'required|max:255',
        'pdf_file_ru' => 'required|max:255',
    ];

    public function getValidator()
    {
        return $this->validator;
    }

    public static function boot()
    {
        // Saving event
        static::saving(function ($model) {
            // Make a new validator object
            $v = Validator::make($model->getAttributes(), $model->rules);
            // Optionally customize this version using new ->after()
            $v->after(function() use ($v, $model) {
                // Do more validation
            });
            $model->validator = $v;
            return !$v->fails();
        });
        parent::boot();
    }
}
