<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class Page extends Model
{
    private $validator;

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

    /**
     * Validation rules.
     *
     * @var array
     */
    private $rules = [
        'page_name_en' => 'required|max:255',
        'page_name_ru' => 'required|max:255',
        'desc_en' => 'required|max:50000',
        'desc_ru' => 'required|max:50000'
    ];

    public function getValidator()
    {
        return $this->validator;
    }

    public static function boot()
    {
        // Saving event
        static::saving(function ($model) {
            $model->rules['page_url'] = sprintf('required|unique:hotels,hotel_url|unique:pages,page_url,%d,id|unique:tours,tour_url,id|unique:galleries,gallery_url|unique:tour_categories,url|max:255', $model->id);
            // Make a new validator object
            $v = Validator::make($model->getAttributes(), $model->rules);
            // Optionally customize this version using new ->after()
            $v->after(function() use ($v, $model) {
                // Do more validation
                if (isset($model->visibility)) {
                    if (!in_array($model->visibility, ['on', 'off'])) {
                        $v->errors()->add('error:visibility', 'Error');
                    }
                }
                if (isset($model->footer)) {
                    if (!in_array($model->footer, ['on', 'off'])) {
                        $v->errors()->add('error:footer', 'Error');
                    }
                }
            });
            $model->validator = $v;
            return !$v->fails();
        });
        parent::boot();
    }

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
            if ($page->visibility == 'on' && $_data['right_menu'] == 1 && (is_null($page->right_menu) || $page->right_menu == 1)) {
                $items[$page->id] = $page->toArray();
            } elseif ($page->footer == 'on' && $_data['footer'] == 1 && (is_null($page->o_footer) || $page->o_footer == 1)) {
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
