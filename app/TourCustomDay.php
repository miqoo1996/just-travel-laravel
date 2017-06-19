<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TourCustomDay extends Model
{
    protected $fillable = [
        'tour_id',
        'desc_en',
        'title_en',
        'desc_ru',
        'title_ru',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    private $rules = [
        'tour_id' => 'required|numeric|exists:tours,tour_id',
        'tour_name_en' => 'required|max:255',
        'desc_en' => 'required|max:500000',
        'short_desc_en' => 'max:500000',
        'tags_en' => 'max:255',
        'tour_images' => 'max:255',
        'hot_image' => 'max:255',
        'traveler_email' => 'email|max:255',
    ];

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
            return !$v->fails();
        });
        parent::boot();
    }
}
