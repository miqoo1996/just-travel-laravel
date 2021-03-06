<?php

namespace App\Http\ViewComposers;

use App\Page;
use Illuminate\View\View;

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
        $model = new Page();
        $this->menu = $model->getPages(['right_menu' => 0, 'footer' => 1]);
    }

    public function compose(View $view)
    {
        $view->with('menu', $this->menu);
    }
}