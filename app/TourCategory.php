<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class TourCategory extends Model
{
    protected $fillable = [
        'category_name_en',
        'category_name_ru',
        'url'
    ];

    /**
     * @param Request $request
     *
     * creates a new tour category
     *
     * @return boolean
     *
     */
    public static function makeNewCategory(Request $request)
    {
        if (isset($request->category_id)){
            $category = TourCategory::find($request->category_id);
        } else {
            $category = new TourCategory();
        }
        $category->fill($request->input());
        return ($category->save())? true: false;
    }

    public static function getAvailableCategories()
    {
        $tz = (Session::has('tz'))? Session::get('tz'): 4;
        $availableCategories = self::rightJoin('tour_cat_rels', 'tour_cat_rels.cat_id', '=', 'tour_categories.id')
            ->rightJoin('tours', 'tours.id', '=', 'tour_cat_rels.tour_id')
            ->leftJoin('tour_dates', 'tour_dates.tour_id', '=', 'tours.id')
            ->whereNotNull('tours.basic_frequency')
            ->whereNotNull('tour_categories.id')
            ->orWhere('tour_dates.date', '>=', Carbon::now($tz)->addDay(3))
            ->whereNotNull('tour_categories.id')
            ->groupBy('tour_categories.id')
            ->select('tour_categories.*')
            ->get();
        return $availableCategories;
    }
}
