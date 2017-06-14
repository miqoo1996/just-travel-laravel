<?php

namespace App\Http\Controllers;

use App\Hotel;
use App\PageOrders;
use App\Tour;
use App\TourCategory;
use App\TourCatRel;
use App\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Input;
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
        $model = new Page();
        $pages = $model->getByType(0);
        return view('admin.pages', ['pages' => $pages]);
    }


    public function getIndexPage()
    {
        $tourCategories = TourCategory::getAvailableCategories();
        $hotTours = Tour::where('hot', 'on')->where('visibility', 'on')->inRandomOrder()->limit(3)->get()->toArray();
        $topHotels = Hotel::whereIn('type', config('const.top_hotel_types'))->where('visibility', 'on')->inRandomOrder()->limit(3)->get()->toArray();
        $indexTours = null;
        if (isset($tourCategories[0]['id'])) {
            $currentCatId = (Session::has('cat_id') && (Session::get('cat_id') !== null)) ? Session::get('cat_id') : $tourCategories[0]['id'];
            $indexTours = Tour::toursByCategory($currentCatId);
        }

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
            $tourCategories = TourCategory::getAvailableCategories();
            $data['tourCategory'] = $tourCategory;
            $data['tours'] = Tour::toursByCategory($tourCategory->id, false);
            $data['tourCategories'] = $tourCategories;
            return view('tours_list', $data);
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

    public function adminPageOrders()
    {
        $model = new Page();
        $pagesRightMenu = $model->getPages(['right_menu' => 1, 'footer' => 0]);
        $pagesFooterMenu = $model->getPages(['right_menu' => 0, 'footer' => 1]);

        return view('admin.page_orders', [
            'pagesRightMenu' => $pagesRightMenu,
            'pagesFooterMenu' => $pagesFooterMenu
        ]);
    }

    public function adminPageRightMenuItemOrdersSave(Request $request)
    {
        $model = new PageOrders();
        $items = $request->get('items');
        $model->saveData($items, ['right_menu' => 1, 'footer' => 0]);
    }

    public function adminPageFooterItemOrdersSave(Request $request)
    {
        $model = new PageOrders();
        $items = $request->get('items');
        $model->saveData($items, ['right_menu' => 0, 'footer' => 1]);
    }
}
