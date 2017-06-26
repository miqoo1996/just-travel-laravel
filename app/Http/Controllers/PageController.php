<?php

namespace App\Http\Controllers;

use App\Page;
use App\SimpleImage;
use App\Tour;
use App\Hotel;
use App\PageOrders;
use App\TourCategory;
use App\Http\Controllers\Traits\PageTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{
    use PageTrait;

    public function adminGetNewPage()
    {
        return view('admin.new_page');
    }

    public function adminPostNewPage(Request $request)
    {
        if (!$request->get('page_id')) {
            $page = new Page();
        } else {
            $page = Page::find($request->get('page_id'));
            SimpleImage::setModel(clone $page);
        }

        if($fields = $request->input()) {
            $fields['visibility'] = $request->get('visibility', 'off');
            $fields['footer'] = $request->get('footer', 'off');
            $this->setFile($request, $fields, 'image');
            $page->fill($fields);
        }

        if ($page->save()) {
            $this->setFile($request, $fields, 'image', true);
            return redirect()->route('admin-pages-list');
        }
        return view('admin.edit_page', ['page' => $page, 'errors' => $page->getValidator()->errors()]);
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
        $topHotels = Hotel::whereIn('type', config('const.top_hotel_types'))->where('visibility', 'on')->inRandomOrder()->limit(3)->get()->toArray();
        $hotTours = Tour::getHotTours()->toArray();

        $countTours = 0;
        $indexTours = null;
        if (isset($tourCategories[0]['id'])) {
            $currentCatId = Session::has('cat_id') && Session::get('cat_id') !== null ? Session::get('cat_id') : $tourCategories[0]['id'];
            $indexTours = Tour::toursByCategory($currentCatId, 6);
            $countTours = Tour::getTourCountByCategory($currentCatId);
        }

        return view('index', compact('tourCategories', 'locale', 'indexTours', 'hotTours', 'topHotels', 'currentCatId', 'countTours'));
    }

    public function getPageByUrl($page_url)
    {
        $tourCategory = TourCategory::where('url', $page_url)->first();
        if(null == $tourCategory){
            $page = Page::where('page_url', $page_url)->orWhere('page_url', '/'.$page_url)->first();
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
