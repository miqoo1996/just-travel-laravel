<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class OrderTour extends Model
{
    protected $fillable = [
        'tour_id', 'date_from', 'adults_count', 'children_count', 'infants_count', 'amount'
    ];

    public function tour()
    {
        return $this->hasOne('App\Tour', 'id', 'tour_id');
    }

    public function tourHotel()
    {
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

    public static function isTourDate($tour_id, $date, &$tour = null)
    {
        $carbonDate = Carbon::createFromFormat('d/m/Y', $date);
        $date = $carbonDate->format('Y-m-d');
        /* @var $tour Tour */
        $tour = Tour::with('dates')
            ->select('tours.*')
            ->join('tour_cat_rels', 'tour_cat_rels.tour_id', '=', 'tours.id')
            ->join('tour_categories', 'tour_categories.id', '=', 'tour_cat_rels.cat_id')
            ->find($tour_id);
        if ($tour->property == 'basic') {
            $localDates = array_flip(config('const.bootstrap_week_days'));
            $dayOfWeek = $localDates[$carbonDate->dayOfWeek];
            if (strpos($tour->basic_frequency, $dayOfWeek) !== false) {
                if (empty($tour['dates'])) {
                    foreach ($tour['dates'] as $value) {
                        if ($value['date'] == $date) {
                            return false;
                        }
                    }
                    return true;
                }
                return false;
            }
        }
        if ($tour->custom_day_prp == 'any') {
            return true;
        }
        $tour = $tour->toArray();
        if (!empty($tour['dates'])) {
            foreach ($tour['dates'] as $value) {
                if ($value['date'] == $date) {
                    return true;
                }
            }
        }
        return false;
    }

}
