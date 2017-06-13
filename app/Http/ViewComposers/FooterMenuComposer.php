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
            if (($page->footer == 'off' && isset($page->dynamicPage) || ($page->footer == 'on' && !isset($page->dynamicPage)))) {
                $page->footer = 'on';
                $this->menu[] = $page->toArray();
            }
        }
    }

    public function compose(View $view)
    {
        $view->with('menu', $this->menu);
    }
}