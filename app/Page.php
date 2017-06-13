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

    public function getRightMenuPages()
    {
        $items = [];
        $pages = $this->where('visibility', 'on')->get();
        if ($pages) {
            foreach ($pages as $page) {
                $items[$page->id] = $page->toArray();
            }
        }
        return $items;
    }

    public function getFooterPages()
    {
        $items = [];
        $pages = $this->where('footer', 'on')->get();
        if ($pages) {
            foreach ($pages as $page) {
                $items[$page->id] = $page->toArray();
            }
        }
        return $items;
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
        if (!$pages) {
            return null;
        }
        $items = [];
        foreach ($pages as $page) {
            if ($page->visibility == 'on' && $_data['right_menu'] == 1 && $page->right_menu) {
                $items[$page->id] = $page->toArray();
            } elseif ($page->footer == 'on' && $_data['footer'] == 1 && $page->o_footer == 1) {
                $items[$page->id] = $page->toArray();
            }
        }
        if ($_data['right_menu'] == 1 && empty($items)) {
            $items = $this->getRightMenuPages();
        }
        if ($_data['footer'] == 1 && empty($items)) {
            $items = $this->getFooterPages();
        }
        return $items;
    }
}
