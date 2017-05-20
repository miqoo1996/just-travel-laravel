<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderTour extends Model
{
	protected $fillable = [
		'tour_id' , 'date_from', 'adult', 'child', 'infant'
	];

	public function tour()
    {
		return $this->hasOne('App\Tour', 'id', 'tour_id')->first()->toArray();
	}

	public function tourHotel(){
		return $this->hasOne('App\TourHotel', 'hotel_id', 'hotel_id')->first()->toArray();
	}

    public function customDays()
    {
        return $this->hasMany('App\TourCustomDay', 'tour_id', 'tour_id')->count();
	}

    public function hotel()
    {
        return $this->hasOne('App\Hotel', 'id', 'hotel_id')->first()->toArray();
    }

    public function members()
    {
        return $this->hasMany('App\OrderMember', 'order_id', 'id')->get()->toArray();
    }
}
