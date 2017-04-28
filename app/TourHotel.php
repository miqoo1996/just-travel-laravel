<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TourHotel extends Model
{
    protected $table = 'tour_hotels';

    public function tour()
    {
        return $this->hasOne('App\Tour', 'id',  'tour_id')->first();
    }

    public function hotel()
    {
        return $this->hasOne('App\Hotel', 'id', 'hotel_id')->first();
    }

    public function customDays()
    {
        return $this->hasMany('App\TourCustomDay', 'tour_id', 'tour_id')->count();
    }
}
