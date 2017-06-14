<?php

namespace App\Http\Controllers;

use App\TourCategory;
use App\TourCatRel;
use Illuminate\Http\Request;

class TourCategoryController extends Controller
{
    public function adminGetTourCategories()
    {
        $categories = TourCategory::all();
        foreach ($categories as $key => $category){
            $categories[$key]['tours_count'] = TourCatRel::where('cat_id', $category->id)->count();
        }
        return view('admin.tour_categories', compact('categories'));
    }

    public function adminGetNewCategory()
    {
        return view('admin.new_category');
    }

    public function adminPostNewCategory(Request $request)
    {
        $category = TourCategory::makeNewCategory($request);
        return ($category)? redirect()->route('admin-tours-categories'): redirect()->back();

    }

    public function adminGetEditCategory($category_id)
    {
        $cat = TourCategory::find($category_id);
        return view('admin.edit_category', ['category' => $cat]);
    }


}
