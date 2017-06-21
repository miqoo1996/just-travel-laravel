<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Hotel extends Model
{
    private $validator;

    protected $fillable = [
        'hotel_url',
        'regions',
        'hotel_name_en',
        'hotel_name_ru',
        'desc_en',
        'desc_ru',
        'short_desc_en',
        'short_desc_ru',
        'tags_en',
        'tags_ru',
        'type',
        'images',
        'hotel_main_image',
        'visibility'
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    private $rules = [
        'hotel_url' => 'required|max:255',
        'hotel_name_en' => 'required|max:255',
        'hotel_name_ru' => 'required|max:255',
        'desc_en' => 'required',
        'desc_ru' => 'required',
        'tags_en' => 'required|max:255',
        'tags_ru' => 'required|max:255',
        'type' => 'required|max:255',
    ];

    private $types = [
        '1_star',
        '2_star',
        '3_star',
        '4_star',
        '5_star',
        'motel',
        'hostel',
    ];

    public function getValidator()
    {
        return $this->validator;
    }

    public static function boot()
    {
        // Saving event
        static::saving(function ($model) {
            $model->rules['hotel_url'] = sprintf('required|unique:hotels,hotel_url,%d,id|unique:pages,page_url|unique:tours,tour_url,id|unique:galleries,gallery_url|unique:tour_categories,url|max:255', $model->id);
            // Make a new validator object
            $v = Validator::make($model->getAttributes(), $model->rules);
            // Optionally customize this version using new ->after()
            $v->after(function() use ($v, $model) {
                // Do more validation
                if (isset($model->visibility)) {
                    if (!in_array($model->visibility, ['on', 'off'])) {
                        $v->errors()->add('error:visibility', 'Error');
                    }
                }
                if (isset($model->type)) {
                    if (!in_array($model->type, $model->types)) {
                        $v->errors()->add('error:type', 'Error');
                    }
                }
            });
            $model->validator = $v;
            return !$v->fails();
        });
        parent::boot();
    }
}
