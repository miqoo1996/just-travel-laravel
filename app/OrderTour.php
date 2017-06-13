<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderTour extends Model
{
	protected $fillable = [
		'tour_id' , 'date_from', 'adults_count', 'children_count', 'infants_count', 'amount'
	];

	public function tour()
    {
		return $this->hasOne('App\Tour', 'id', 'tour_id');
	}

	public function tourHotel(){
		return $this->hasMany('App\TourHotel', 'hotel_id', 'hotel_id');
	}

    public function customDays()
    {
        return $this->hasMany('App\TourCustomDay', 'tour_id', 'tour_id');
	}

    public function hotel()
    {
        return $this->hasOne('App\Hotel', 'id', 'hotel_id');
    }

    public function members()
    {
        return $this->hasMany('App\OrderMember', 'order_tour_id', 'id');
    }
}
