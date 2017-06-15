<?php

namespace App;

use Carbon\Carbon;
use function foo\func;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class Tour extends Model
{
    private $isCustom = false;

    private $validator;

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
     * Validation rules.
     *
     * @var array
     */
    private $rules = [
        'tour_url' => 'max:255',
        'tour_name_en' => 'required|max:255',
        'desc_en' => 'required|max:500000',
        'short_desc_en' => 'max:500000',
        'tags_en' => 'max:255',
        'tour_images' => 'max:255',
        'hot_image' => 'max:255',
        'traveler_email' => 'email|max:255',
    ];

    public function getRules()
    {
        if (!$this->isCustom()) {
            $this->rules += [
                'tour_url' => sprintf('required|unique:hotels,hotel_url|unique:pages,page_url|unique:tours,tour_url,%d,id|unique:galleries,gallery_url|unique:tour_categories,url|max:255', $this->id),
                'tour_name_ru' => 'required|max:255',
                'desc_ru' => 'required|max:500000',
                'short_desc_ru' => 'max:500000',
                'tags_ru' => 'max:255',
                'tour_main_image' => 'required|max:255',
            ];
        }

        return $this->rules;
    }

    public function getValidator()
    {
        return $this->validator;
    }

    public static function boot()
    {
        // Saving event
        static::saving(function ($model) {
            // Make a new validator object
            $v = Validator::make($model->getAttributes(), $model->getRules());
            // Optionally customize this version using new ->after()
            $v->after(function() use ($v, $model) {
                // Do more validation
                if (isset($model->visibility)) {
                    if (!in_array($model->visibility, ['on', 'off'])) {
                        $v->errors()->add('error:visibility', 'Error');
                    }
                }
                if ((!isset($model->tour_dates) || (isset($model->tour_dates) && !$model->tour_dates)) && isset($model->custom_day_prp) && $model->custom_day_prp == 'custom') {
                    $v->errors()->add('error:tour_dates', 'The calendar field is required');
                } else {
                    unset($model->tour_dates);
                }
            });
            $model->validator = $v;
            return !$v->fails();
        });
        parent::boot();
    }

    public function setIsCustom($custom)
    {
        $this->isCustom = (bool)$custom;
    }

    public function isCustom()
    {
        return (bool)$this->isCustom;
    }

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
    public function categories()
    {
        return $this->hasMany('App\TourCatRel', 'tour_id', 'id')->join('tour_categories', 'tour_categories.id', '=', 'tour_cat_rels.cat_id');
    }

    /**
     * @return mixed
     */
    public function hotels()
    {
        return $this->hasMany('App\TourHotel', 'tour_id', 'id');
    }

    /**
     * @return mixed
     */
    public function getFirstHotel()
    {
        return $this->hasOne('App\TourHotel', 'tour_id', 'id')->first();
    }

    /**
     * @return mixed
     */
    public function customDays()
    {
        return $this->hasMany('App\TourCustomDay', 'tour_id', 'id');

    }

    /**
     * @return mixed
     */
    public function tourDates()
    {
        return $this->hasMany('App\TourDate', 'tour_id', 'id')->where('date', '>=', date('Y-m-d'))->select('date');
    }

    /**
     * @return mixed
     */
    public function adminTourDates()
    {
        return $this->hasMany('App\TourDate', 'tour_id', 'id');
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
    public static function toursByCategory($category_id, $limit = false)
    {
        $tz = (Session::has('tz'))? Session::get('tz'): 4;
        $tours = self::rightJoin('tour_cat_rels', function ($query) use ($category_id){
            $query->on('tour_cat_rels.tour_id', '=', 'tours.id')
            ->where('tour_cat_rels.cat_id', '=' , $category_id);
        })->leftJoin('tour_dates', function ($query) use ($tz){
            $query->on('tour_dates.tour_id', '=', 'tours.id')
                ->where('tour_dates.date', '>=', Carbon::now($tz)->addDay(3));
        })->leftJoin('tour_hotels', function ($query) use ($tz){
            $query->on('tour_hotels.tour_id', '=', 'tours.id');
        })
            ->whereNotNull('tours.id')
        ->orWhereNotNull('tours.basic_frequency')
        ->groupBy('tours.id')->get();
        return $tours;
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
    }

    public static function searchTours($request)
    {

        $category = (!empty($request->category)) ? explode('/', $request->category) : false;

        $tours = Tour::leftJoin('tour_dates', function ($join) {
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
            $tours[$key]['double_adult'] = $tour->getFirstHotel()['double_adult'];
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
            if ($tourDates) {
                foreach ($tourDates as $key => $tourDate) {
                    if ($key == 0) {
                        $query = $query->where('tour_dates.date', $tourDate);
                    } else {
                        $query = $query->orWhere('tour_dates.date', $tourDate);
                    }
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


