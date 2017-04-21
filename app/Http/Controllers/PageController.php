<?php

namespace App\Http\Controllers;

use App\Hotel;
use App\Tour;
use App\TourCategory;
use App\TourCatRel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Page;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    public function adminGetNewPage()
    {
        return view('admin.new_page');
    }

    public function adminPostNewPage(Request $request)
    {
        if (!isset($request->page_id)) {
            $page = new Page();
            $page->save();
        } else {
            $page = Page::find($request->page_id);
        }

        $fields = $request->input();
        $fields['visibility'] = (!isset($fields['visibility'])) ? 'off' : $fields['visibility'];
        $fields['footer'] = (!isset($fields['footer'])) ? 'off' : $fields['footer'];

        if ($request->hasFile('image')) {
            $oldImage = $page->image;
            File::delete($oldImage);
            $image = $request->file('image');
            $image_name = uniqid() . config('const.' . $image->getMimeType());
            $image_path = 'images/pages/' . $page->id . '/' . $image_name;
            $image->move('images/pages/' . $page->id, $image_name);
            $fields['image'] = $image_path;
        }

        $page->fill($fields);
        $page->save();
        return redirect()->route('admin-pages-list');
    }

    public function adminGetEditPage($page_id)
    {
        $page = Page::find($page_id);
        return view('admin.edit_page', ['page' => $page]);
    }

    public function adminGetPagesList()
    {
        $pages = Page::all();
        return view('admin.pages', ['pages' => $pages]);
    }


    public function getIndexPage()
    {
        $locale = (Session::has('locale')) ? Session::get('locale') : 'en';
        $tourCatRelations = TourCatRel::all()->pluck('cat_id')->toArray();
        $tourCategories = TourCategory::whereIn('id', array_unique($tourCatRelations))->get()->toArray();
        $hotTours = Tour::where('hot', 'on')->inRandomOrder()->limit(3)->get()->toArray();
        $topHotels = Hotel::whereIn('type', config('const.top_hotel_types'))
            ->where('visibility', 'on')->inRandomOrder()->limit(3)->get()->toArray();
        if (count($tourCategories)) {
            $currentCatId = (Session::has('cat_id')) ? Session::get('cat_id') : $tourCategories[0]['id'];
            $indexTours = Tour::ToursByCategory($currentCatId);
        } else {
            $indexTours = false;
        }
        return view('index', compact('tourCategories', 'locale', 'indexTours', 'hotTours', 'topHotels'));
    }

    public function getPageByUrl($page_url)
    {
        $tourCategory = TourCategory::where('url', $page_url)->first();
        if(null == $tourCategory){
            $page = Page::where('page_url', $page_url)->first();
            if(null == $page){
                return view('errors.404');
            }
            return view('page_detail', compact('page'));
        } else {
            $tourIds = TourCatRel::all()->pluck('tour_id')->toArray();
            $data['tourCategory'] = $tourCategory;
            $data['tours'] = Tour::ToursByCategory($tourCategory->id, false);
//            dd($data['tours']);
            $data['tourCategories'] = TourCategory::whereIn('id', array_unique($tourIds))->get()->toArray();
            return view('tours', $data);
        }
    }
}
