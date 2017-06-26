<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class Gallery extends Model
{
    public $scenario = 'insert';

    private $validator;

    protected $fillable = [
        'gallery_name_en',
        'gallery_name_ru',
        'gallery_desc_en',
        'gallery_desc_ru',
        'gallery_url',
        'main_image',
        'gallery',
        'portfolio'
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    private $rules = [
        'gallery_url' => 'required|max:255',
        'gallery_name_en' => 'required|max:255',
        'gallery_name_ru' => 'required|max:255',
        'gallery_desc_en' => 'required',
        'gallery_desc_ru' => 'required'
    ];

    public function getValidator()
    {
        return $this->validator;
    }

    public static function boot()
    {
        // Saving event
        static::saving(function ($model) {
            if ($model->scenario == 'update_order') {
                $model->rules = [];
                parent::boot();
                return;
            } elseif ($model->scenario == 'insert') {
                $row = self::select(DB::raw('MAX(`portfolio_order`) + 1 as `pmax`, MAX(`gallery_order`) + 1 as `gmax`'))->first();
                $model->portfolio_order = intval($row->getAttribute('pmax'));
                $model->gallery_order = intval($row->getAttribute('gmax'));
            }
            $model->rules['gallery_url'] = sprintf('required|unique:hotels,hotel_url|unique:pages,page_url|unique:tours,tour_url,id|unique:galleries,gallery_url,%d,id|unique:tour_categories,url|max:255', $model->id);
            // Make a new validator object
            $v = Validator::make($model->getAttributes(), $model->rules);
            // Optionally customize this version using new ->after()
            $v->after(function() use ($v, $model) {
                // Do more validation
                if (isset($model->gallery)) {
                    if (!in_array($model->gallery, ['on', 'off'])) {
                        $v->errors()->add('error:gallery', 'Error');
                    }
                }
                if (isset($model->portfolio)) {
                    if (!in_array($model->portfolio, ['on', 'off'])) {
                        $v->errors()->add('error:portfolio', 'Error');
                    }
                }
            });
            $model->validator = $v;
            return !$v->fails();
        });
        parent::boot();
    }

    public function images()
    {
        return $this->hasMany('App\GalleryPhotos')->get();
    }

    public function getImages($order = false, array $where = [])
    {
        if ($order) {
            $images = $this->orderBy($where[0] == 'portfolio' ? 'portfolio_order' : 'gallery_order', 'ASC');
            if (!empty($where)) {
                $images->where($where[0], $where[1]);
            }
            $images = $images->get()->toArray();
        } else {
            $images = $this->all()->toArray();
        }
        return $images;
    }

    public function saveData(array $attributes, $order_type)
    {
        if (is_array($attributes) && !empty($attributes)) {
            foreach ($attributes as $attribute) {
                if (isset($attribute['page_id'], $attribute['order'])) {
                    $model = (new static())->where('id', intval($attribute['page_id']))->get()->first();
                    if ($model) {
                        $model->scenario = 'update_order';
                        $model->$order_type = intval($attribute['order']);
                        $model->save();
                    }
                }
            }
        };
        return $this;
    }

}
