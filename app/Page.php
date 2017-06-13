<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'page_url',
        'page_name_en',
        'page_name_ru',
        'desc_en',
        'desc_ru',
        'visibility',
        'footer',
        'image',
    ];

    public function getByType($type)
    {
        $pages = Page::where('type', $type)->get();
        return $pages;
    }

    public function getPages($_data, $order = true, $type = null)
    {
        $query = $this;
        if (!isset($_data['right_menu'], $_data['footer'])) {
            return $query->get();
        }
        if ($order) {
            $query = $this
                ->select(['pages.*', 'page_orders.order as order', 'page_orders.footer as o_footer', 'page_orders.right_menu as right_menu'])
                ->leftJoin('page_orders', function ($join) use($_data) {
                    $join->on('page_orders.page_id', '=', 'pages.id');
                })
                ->orderBy('page_orders.order', 'ASC');
        }
        if ($type) {
            $query->where('pages.type', $type);
        }
        $pages = $query->get();
        $right_menu = [];
        $footer_menu = [];
        foreach ($pages as $page) {
            if ($_data['right_menu'] == 1 && $page->visibility == 'on') {
                if (is_null($page->right_menu) || $page->right_menu == 1) {
                    $right_menu[$page->id] = $page->toArray();
                }
            }
            if ($_data['footer'] == 1 && $page->footer == 'on') {
                if (is_null($page->o_footer) || $page->o_footer == 1) {
                    $footer_menu[$page->id] = $page->toArray();
                }
            }
            if (!isset($right_menu[$page->id]) && isset($footer_menu[$page->id])) {
                $right_menu[$page->id] = $footer_menu[$page->id];
            }
            if (!isset($footer_menu[$page->id]) && isset($right_menu[$page->id])) {
                $footer_menu[$page->id] = $right_menu[$page->id];
            }
        }
        if ($_data['right_menu'] == 1) {
            return $right_menu;
        }
        if ($_data['footer'] == 1) {
            return $footer_menu;
        }
        return null;
    }
}
