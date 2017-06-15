<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Gallery extends Model
{
    private $validator;

    protected $fillable = [
        'gallery_name_en',
        'gallery_name_ru',
        'gallery_desc_en',
        'gallery_desc_ru',
        'gallery_url',
        'main_image',
        'gallery',
        'portfolio'
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    private $rules = [
        'gallery_url' => 'required|max:255',
        'gallery_name_en' => 'required|max:255',
        'gallery_name_ru' => 'required|max:255',
        'gallery_desc_en' => 'required|max:50000',
        'gallery_desc_ru' => 'required|max:50000'
    ];

    public function getValidator()
    {
        return $this->validator;
    }

    public static function boot()
    {
        // Saving event
        static::saving(function ($model) {
            $model->rules['gallery_url'] = sprintf('required|unique:hotels,hotel_url|unique:pages,page_url|unique:tours,tour_url,id|unique:galleries,gallery_url,%d,id|unique:tour_categories,url|max:255', $model->id);
            // Make a new validator object
            $v = Validator::make($model->getAttributes(), $model->rules);
            // Optionally customize this version using new ->after()
            $v->after(function() use ($v, $model) {
                // Do more validation
                if (isset($model->gallery)) {
                    if (!in_array($model->gallery, ['on', 'off'])) {
                        $v->errors()->add('error:gallery', 'Error');
                    }
                }
                if (isset($model->portfolio)) {
                    if (!in_array($model->portfolio, ['on', 'off'])) {
                        $v->errors()->add('error:portfolio', 'Error');
                    }
                }
            });
            $model->validator = $v;
            return !$v->fails();
        });
        parent::boot();
    }

    public function images()
    {
        return $this->hasMany('App\GalleryPhotos')->get();
    }
}
