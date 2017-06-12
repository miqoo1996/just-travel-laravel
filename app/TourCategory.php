<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

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
}
