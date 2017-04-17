<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Currency extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'usd',
        'eur',
        'rur'
    ];
    public static function getCur()
    {
        $currency = Currency::first()->toArray();

        return $currency;
    }
}
