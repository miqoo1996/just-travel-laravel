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

    ];


    /**
     * MenuComposer constructor.
     *
     * adding custom created pages to stable menu items and sharing to layouts
     */
    public function __construct()
    {
        $pages = Page::get();
        foreach ($pages as $page) {
            if (($page->visibility == 'off' && isset($page->dynamicPage) || ($page->visibility == 'on' && !isset($page->dynamicPage)))) {
                $page->visibility = 'on';
                $this->menu[] = $page->toArray();
            }
        }
    }

    public function compose(View $view)
    {
        $view->with('menu', $this->menu);
    }
}