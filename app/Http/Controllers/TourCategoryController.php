<?php

namespace App\Http\Controllers;

use App\TourCategory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Http\Requests;

class TourCategoryController extends Controller
{
    public function adminGetTourCategories()
    {
        $data['categories'] = TourCategory::all();
        return view('admin.tour_categories', $data);
    }

    public function adminGetNewCategory()
    {
        return view('admin.new_category');
    }

    public function adminPostNewCategory(Request $request)
    {

//        $rules = [
//            'category_name_en' => 'required|unique:tour_categories',
//            'category_name_ru' => 'required|unique:tour_categories',
//        ];
//        $this->validate($request, $rules);
        $category = TourCategory::makeNewCategory($request);
        return ($category)? redirect()->route('admin-tours-categories'): redirect()->back();

    }

    public function adminGetEditCategory($category_id)
    {
        $cat = TourCategory::find($category_id);
        return view('admin.edit_category', ['category' => $cat]);
    }


}
