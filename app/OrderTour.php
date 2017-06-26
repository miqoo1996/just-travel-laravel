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

    public function getNotReadedOrders(&$count = 0, $limit = 20)
    {
        $query = $this::select(['*', 'order_tours.created_at as created_at'])
            ->rightJoin('payments', 'payments.order_tour_id', '=', 'order_tours.id')
            ->leftJoin('tours', 'tours.id', '=', 'order_tours.tour_id')
            ->where('read', 0)
            ->get();

        $count = $query->count();
        $items = $query->take($limit)->all();
        return $items;
    }

}
