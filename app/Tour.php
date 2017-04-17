<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
        'specific_days',
        'basic_frequency',
        'basic_price_adult',
        'basic_price_child',
        'basic_price_infant',
        'custom_day_prp',
        'custom_dates',
        'tour_images',
        'main_image',
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

    /**
     * @return mixed
     */
    public function getCustomDays()
    {
        return $this->hasMany('App\TourCustomDay', 'tour_id', 'id')->get();

    }

    /**
     * @param $category_id
     * @return mixed
     */
    public static function ToursByCategory($category_id)
    {
        $data['tourCategory'] = TourCategory::find($category_id)->toArray();
        $data['tours'] = TourCatRel::where('cat_id', $category_id)
            ->join('tours', 'tour_cat_rels.tour_id', '=', 'tours.id')
            ->where('visibility', 'on')
            ->orderBy('tours.updated_at', 'DESC')->limit(6)->get()->toArray();
        return $data;
    }



}
