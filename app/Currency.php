<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Currency extends Model
{
    private $validator;

    public $timestamps = false;

    protected $fillable = [
        'usd',
        'eur',
        'rur'
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    private $rules = [
        'usd' => ['required', 'max:10', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
        'eur' => ['required', 'max:10', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
        'rur' => ['required', 'max:10', 'regex:/^(?=.+)(?:[1-9]\d*|0)?(?:\.\d+)?$/'],
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

    public static function getCur()
    {
        $currency = Currency::select('usd', 'amd', 'eur', 'rur')->first()->toArray();

        return $currency;
    }
}
