<?php

namespace App\Http\ViewComposers;


use App\Tour;
use Illuminate\View\View;

class HotToursComposer
{
    public $hotTours;

    public function __construct()
    {
        $hotTours = Tour::where('hot', 'on')->where('visibility', 'on')->inRandomOrder()->limit(3)->get();
        foreach ($hotTours as $key => $hotTour) {
            if (null == $hotTour['basic_frequency']) {
                $hotTours[$key]['single_adult'] = $hotTour->getFirstHotel()->single_adult;
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