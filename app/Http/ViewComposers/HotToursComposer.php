<?php

namespace App\Http\ViewComposers;

use App\Tour;
use Illuminate\View\View;

class HotToursComposer
{
    public $hotTours;

    public static $limit = 3;

    public static $noShowedTourId = 0;

    public function __construct()
    {
        $hotTours = Tour::getHotTours(self::$limit, self::$noShowedTourId);

        foreach ($hotTours as $key => $hotTour) {
            if (null == $hotTour['basic_frequency']) {
                $hotTours[$key]['single_adult'] = isset($hotTour->getFirstHotel()->single_adult) ? $hotTour->getFirstHotel()->single_adult : 0;
                if ($hotTours[$key]->custom_day_prp == 'custom') {
                    $hotTours[$key]['date'] = explode(',', $hotTours[$key]->custom_dates)[0];
                } else {
                    $hotTours[$key]['date'] = date('d/m/Y');
                }
            }
        }
        $this->hotTours = $hotTours;
    }

    public function compose(View $view)
    {
        $view->with('hotTours', $this->hotTours);
    }
}