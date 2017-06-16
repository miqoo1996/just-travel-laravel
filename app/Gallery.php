<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
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

    public function images()
    {
        return $this->hasMany('App\GalleryPhotos')->get();
    }

    public function getImages($order = false, array $where = [])
    {
        if ($order) {
            $images = $this->orderBy('order', 'ASC');
            if (!empty($where)) {
                $images->where($where[0], $where[1]);
            }
            $images = $images->get()->toArray();
        } else {
            $images = $this->all()->toArray();
        }
        return $images;
    }

    public function saveData(array $attributes)
    {
        if (is_array($attributes) && !empty($attributes)) {
            foreach ($attributes as $attribute) {
                if (isset($attribute['page_id'], $attribute['order'])) {
                    $model = (new static())->where('id', intval($attribute['page_id']))->get()->first();
                    if ($model) {
                        $model->order = intval($attribute['order']);
                        $model->save();
                    }
                }
            }
        };
        return $this;
    }

}
