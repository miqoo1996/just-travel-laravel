<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Tour extends Model
{
    protected $fillable = [
        'tour_url',
        'tour_category',
        'tour_name_en',
        'tour_name_ru',
        'desc_en',
        'desc_ru',
        'short_desc_en',
        'short_desc_ru',
        'tags_en',
        'tags_ru',
        'basic_frequency',
        'basic_price_adult',
        'basic_price_child',
        'basic_price_infant',
        'custom_day_prp',
        'tour_images',
        'tour_main_image',
        'hot_image',
        'visibility',
        'hot',
        'traveler_email',
        'tour_price',
        'tour_day'
    ];

    /**
     * @return mixed
     */
    public function getFirstHotelAdultPrice()
    {
        return $this->hasMany('App\TourHotel', 'tour_id', 'id')->select('single_adult')->first();
    }

    /**
     * @return mixed
     */
    public function getCategories()
    {
        return $this->hasMany('App\TourCatRel', 'tour_id', 'id')->join('tour_categories', 'tour_categories.id', '=', 'tour_cat_rels.cat_id')->get()->toArray();
    }

    /**
     * @return mixed
     */
    public function getHotels()
    {
        return $this->hasMany('App\TourHotel', 'tour_id', 'id')->get();
    }

    public function getFirstHotel()
    {
        return $this->hasOne('App\TourHotel', 'tour_id', 'id')->first();
    }

    /**
     * @return mixed
     */
    public function getCustomDays()
    {
        return $this->hasMany('App\TourCustomDay', 'tour_id', 'id')->get();

    }

    public function getTourDates()
    {
        return $this->hasMany('App\TourDate', 'tour_id', 'id')->where('date', '>=', date('Y-m-d'))->get()->pluck('date');
    }

    public static function rewriteDates($dates)
    {
        $result = '';
        foreach ($dates as $date) {
            if ($result == '') {
                $result .= Carbon::createFromFormat('Y-m-d', $date)->format('d/m/Y');
            } else {
                $result .= ',' . Carbon::createFromFormat('Y-m-d', $date)->format('d/m/Y');
            }
        }
        return $result;
    }

    /**
     * @param $category_id
     * @param $limit
     * @return mixed
     */
    public static function ToursByCategory($category_id, $limit = false)
    {
        $data['tourCategory'] = TourCategory::find($category_id)->toArray();
        if ($data['tourCategory']['property'] == 'basic') {
            $data['tours'] = TourCatRel::where('cat_id', $category_id)
                ->join('tours', 'tour_cat_rels.tour_id', '=', 'tours.id')
                ->where('visibility', 'on')
                ->orderBy('tours.updated_at', 'DESC')->get()->toArray();
        } else {
            $tz = (Session::has('tz'))? Session::get('tz') : 4;
            $data['tours'] = TourDate::where('tour_dates.date', '>=', Carbon::now()->addDay(3)->format('Y-m-d'))
                ->rightJoin('tours', 'tours.id', '=', 'tour_dates.tour_id')
                ->rightJoin('tour_cat_rels', 'tour_cat_rels.tour_id', '=', 'tours.id')
                ->rightJoin('tour_categories', 'tour_categories.id', '=' ,'tour_cat_rels.cat_id')
                ->where('tour_categories.id', $category_id)
                ->groupBy('tours.id')->get();
        }
        return $data;
    }

    public static function getToursByCat($cat_id)
    {
        $tourIds = TourCatRel::where('cat_id', $cat_id)->get()->pluck('tour_id')->toArray();
        $tours = self::whereIn('id', $tourIds)->get()->toArray();
//        if(count($tours)) return redirect('errors.404');
    }

    public static function generateDateWeekDays(Carbon $start_date, Carbon $end_date)
    {
        $dates = [];
        $localdates = array_flip(config('const.bootstrap_week_days'));
        $date = $start_date;
        while ($date <= $date->lte($end_date)){
            $dates[] = $localdates[$date->dayOfWeek];
            $date->addDay();
        }

        $dates = array_unique($dates);
        return $dates;
    }

    public static function generateDateRange(Carbon $start_date, Carbon $end_date)
    {
        $dates = [];
        $date = $start_date;
        while($date <= $date->lte($end_date)){
            $dates[] = $date->format('Y-m-d');
            $date->addDay();
        }
        return $dates;
    }

    public static function searchTours($request)
    {

        $category = (!empty($request->category)) ? explode('/', $request->category) : false;

        $tours = Tour::join('tour_dates', function ($join) {
                $join->on('tour_dates.tour_id', '=', 'tours.id');
            })
            ->join('tour_cat_rels', function ($join) {
                $join->on('tour_cat_rels.tour_id', '=', 'tours.id');
            })
            ->join('tour_categories', function ($join){
                $join->on('tour_categories.id', '=', 'tour_cat_rels.cat_id');
            });

        $dateStart = (!empty($request->date_start)) ? Carbon::createFromFormat('d/m/Y', $request->date_start) : Carbon::today();
        $dateEnd = (!empty($request->date_end)) ? Carbon::createFromFormat('d/m/Y', $request->date_end) : Carbon::today()->addDays(7);
        $weekDays = Tour::generateDateWeekDays($dateStart, $dateEnd);
        $tourDates = Tour::generateDateRange($dateStart, $dateEnd);
        $tourTags = (empty($request->tags)) ? false : explode(" ", $request->tags);

        if ($category) {
            if ($category[1] == 'basic') {
                $tours = Tour::basicPart($category, $tours, $weekDays, $tourDates);
                $tours = Tour::tourTags($tours, $tourTags);
            } elseif ($category[1] == 'custom') {
                $tours = Tour::customPart($category, $tours, $tourDates, $category[0]);
                $tours = Tour::tourTags($tours, $tourTags);
            }
        } else {
            $tours = Tour::basicPart($category, $tours, $weekDays, $tourDates);
            $tours = Tour::tourTags($tours, $tourTags);
            $tours = Tour::customPart($category, $tours, $tourDates, true);
            $tours = Tour::tourTags($tours, $tourTags);
        }
        $tours = $tours->select(['tours.*', 'tour_categories.property', 'tour_dates.date'])->groupBy('tours.id')->get();
        foreach ($tours as $key => $tour) {
            $tours[$key]['single_adult'] = $tour->getFirstHotel()['single_adult'];
        }
        return $tours;
    }

    public static function basicPart($category, $tours, $weekDays, $tourDates)
    {

        $tours = $tours->where('tour_categories.property', 'basic')->where(function ($query) use ($weekDays) {
            foreach ($weekDays as $key => $weekDay) {
                if ($key == 0) {
                    $query = $query->where('tours.basic_frequency', 'like', '%' . $weekDay . '%');
                } else {
                    $query = $query->orWhere('tours.basic_frequency', 'like', '%' . $weekDay . '%');
                }
            }
        });

        $tours = $tours->where(function ($query) use ($tourDates) {
            foreach ($tourDates as $tourDate) {
                $query = $query->whereNot('tour_dates.date', $tourDate);
            }
        });

        if($category){
            $tours = $tours->where('tour_categories.id', intval($category[0]));
        }
        $tours = $tours->where('tours.visibility', 'on');

        return $tours;
    }

    public static function customPart($category, $tours, $tourDates, $joined = false)
    {
        if ($joined) {
            $tours = $tours->orWhere(function ($query) use ($joined) {
                $query->orWhere('tour_categories.property', 'custom');
            });
        } else {
            $tours = $tours->where(function ($query) use ($joined) {
                $query->where('tours.visibility', 'on')
                    ->where('tour_categories.property', 'custom');
            });
        }
        $tours = $tours->where(function ($query) use ($tourDates) {
            foreach ($tourDates as $key => $tourDate) {
                if ($key == 0) {
                    $query = $query->where('tour_dates.date', $tourDate);
                } else {
                    $query = $query->orWhere('tour_dates.date', $tourDate);
                }
            }
        });
        $tz = (Session::has('tz'))? Session::get('tz') : 4;
        $tours = $tours->where('tour_dates.date', '>=', Carbon::now($tz)->addDay(3)->format('Y-m-d'));

        if($category){
            $tours = $tours->where('tour_categories.id', intval($category[0]));
        }
        return $tours;
    }

    public static function tourTags($tours, $tourTags)
    {
        if ($tourTags) {
            $tours = $tours->where(function ($query) use ($tourTags) {
                foreach ($tourTags as $key => $tourTag) {
                    $query = $query->where('tours.tags_ru', 'like', '%' . $tourTag . '%');
                    $query = $query->orWhere('tours.tags_ru', 'like', '%' . $tourTag . '%');
                    $query = $query->orWhere('tours.tags_en', 'like', '%' . $tourTag . '%');
                    $query = $query->orWhere('tours.tour_name_en', 'like', '%' . $tourTag . '%');
                    $query = $query->orWhere('tours.tour_name_ru', 'like', '%' . $tourTag . '%');
                }
            });
        }
        return $tours;
    }
}


