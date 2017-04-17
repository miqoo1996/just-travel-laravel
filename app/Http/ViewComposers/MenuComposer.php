<?php

namespace App\Http\ViewComposers;

use App\Page;
use Illuminate\View\View;

class MenuComposer
{
    /**
     * @var array
     * Stable menu items
     */
    public $menu = [
        [
            'name' => 'Tours',
            'url' => '/tours',
            'prp' => 'fixed'
        ],
        [
            'name' => 'Photo Gallery',
            'url' => '/photo_gallery',
            'prp' => 'fixed'
        ],
        [
            'name' => 'Video Gallery',
            'url' => '/video_gallery',
            'prp' => 'fixed'
        ],
        [
            'name' => 'Catalogue',
            'url' => '/catalogue',
            'prp' => 'fixed'
        ],
        [
            'name' => 'Contacts',
            'url' => '/contacts',
            'prp' => 'fixed'
        ]
    ];


    /**
     * MenuComposer constructor.
     *
     * adding custom created pages to stable menu items and sharing to layouts
     *
     *
     */
    public function __construct()
    {
//        $locale = (Session::has('locale'))? Session::get('locale'): 'en';
        $pages = Page::all();
        $itemsCount = count($this->menu) + 1;
        foreach ($pages as $page){
//            if($locale == 'ru'){
                $this->menu[$itemsCount]['name'] = $page->page_name_ru;
//            } else {
//                $this->menu[]['name'] = $page->page_name_en;
//            }
            $this->menu[$itemsCount]['url'] = $page['url'];
        $itemsCount++;
        }
    }

    public function compose(View $view)
    {
        $view->with('menu', $this->menu);
    }
}