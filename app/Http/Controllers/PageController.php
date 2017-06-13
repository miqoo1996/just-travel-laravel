<?php

namespace App\Http\Controllers;

use App\Hotel;
use App\Tour;
use App\TourCategory;
use App\TourCatRel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Page;
use Illuminate\Support\Facades\DB;
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
        $tourCategories = TourCategory::getAvailableCategories();
        $hotTours = Tour::where('hot', 'on')->where('visibility', 'on')->inRandomOrder()->limit(3)->get()->toArray();
        $topHotels = Hotel::whereIn('type', config('const.top_hotel_types'))->where('visibility', 'on')->inRandomOrder()->limit(3)->get()->toArray();
        $currentCatId = (Session::has('cat_id') && (Session::get('cat_id') !== null)) ? Session::get('cat_id') : $tourCategories[0]['id'];
        $indexTours = Tour::toursByCategory($currentCatId);

        return view('index', compact('tourCategories', 'locale', 'indexTours', 'hotTours', 'topHotels', 'currentCatId'));
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
            $tourCategories = TourCatRel::join('tour_categories', 'tour_categories.id', '=', 'tour_cat_rels.cat_id')
                ->select('tour_categories.*')->distinct()->get()->toArray();
            $data['tourCategory'] = $tourCategory;
            $data['tours'] = Tour::toursByCategory($tourCategory->id, false);
            $data['tourCategories'] = $tourCategories;
            return view('tours', $data);
        }
    }

    public function getTags()
    {
        $allTags = [];
        $counter = 0;
        $tags = Tour::where('visibility', 'on')->select('tags_en','tags_ru', 'tour_name_en', 'tour_name_ru')->distinct()->get();
        foreach ($tags as $tagStr){
            $tagsStrEn = explode(',', $tagStr->tags_en);
            foreach ($tagsStrEn as $tagStrEn){
                $allTags[$counter]['name'] = $tagStrEn;
                $allTags[$counter]['code'] = 'tag';
                $counter++;

            }
            $tagsStrRu = explode(',', $tagStr->tags_ru);
            foreach ($tagsStrRu as $tagStrRu){
                $allTags[$counter]['name'] = $tagStrRu;
                $allTags[$counter]['code'] = 'tag';
                $counter++;
            }

            $allTags[$counter]['name'] = $tagStr->tour_name_en;
            $allTags[$counter]['code'] = 'title';
            $counter++;
            $allTags[$counter]['name'] = $tagStr->tour_name_ru;
            $allTags[$counter]['code'] = 'title';
            $counter++;
        }
        $allTags = array_unique($allTags, SORT_REGULAR);
        foreach ($allTags as $res){
            $result[] = $res;
        }

        return response()->json(array_filter(($result)));
    }
}
