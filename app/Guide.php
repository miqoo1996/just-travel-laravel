<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guide extends Model
{
    protected $fillable = [
        'guide_name_en',
        'guide_name_ru'

    ];
}
