<?php

namespace App\Http\Controllers;

use App\TourCategory;
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
        if(!isset($request->page_id)){
            $page = new Page();
            $page->save();
        } else {
            $page = Page::find($request->page_id);
        }

        $fields = $request->input();
        $fields['visibility'] = (!isset($fields['visibility']))? 'off' : $fields['visibility'];

        if($request->hasFile('image')){
                $oldImage = $page->image;
                File::delete($oldImage);
                $image = $request->file('image');
                $image_name = uniqid() . config('const.' . $image->getMimeType());
                $image_path = 'images/pages/'.$page->id. '/' . $image_name;
                $image->move('images/pages/'.$page->id , $image_name);
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
        $locale = (Session::has('locale'))? Session::get('locale'): 'en';
        $tourCategories = TourCategory::all()->toArray();

        return view('index', compact('tourCategories', 'locale'));
    }

}
