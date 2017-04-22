<?php

namespace App\Http\ViewComposers;

use App\Page;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;

class FooterMenuComposer
{
    /**
     * @var array
     * Stable menu items
     */
    public $menu = [
        [
            'page_name_en' => 'Tours',
            'page_name_ru' => 'Туры',
            'page_url' => '/tours',
            'prp' => 'fixed'
        ],
        [
            'page_name_en' => 'Photo Gallery',
            'page_name_ru' => 'Фото Галерея',
            'page_url' => '/galleries',
            'prp' => 'fixed'
        ],
        [
            'page_name_en' => 'Video Gallery',
            'page_name_ru' => 'Видео Галерея',
            'page_url' => '/video_gallery',
            'prp' => 'fixed'
        ],
        [
            'page_name_en' => 'Catalogue',
            'page_name_ru' => 'Каталог',
            'page_url' => '/catalogue',
            'prp' => 'fixed'
        ],
        [
            'page_name_en' => 'Contacts',
            'page_name_ru' => 'Контакты',
            'page_url' => '/contacts',
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
        $pages = Page::where('footer', 'on')->get()->toArray();
        $itemsCount = count($this->menu) + 1;
        foreach ($pages as $page){
            $this->menu[$itemsCount] = $page;
        $itemsCount++;
        }
    }

    public function compose(View $view)
    {
        $view->with('menu', $this->menu);
    }
}