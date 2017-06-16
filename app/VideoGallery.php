<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VideoGallery extends Model
{
    protected $fillable = [
        'video_url_en',
        'video_url_ru',
        'embed_en',
        'embed_ru',
        'video_title_en',
        'video_title_ru',
        'video_thumbnail_en',
        'video_thumbnail_ru'
    ];

    public function getVideos($order = false)
    {
        if ($order) {
            $videos =  $this->orderBy('order', 'ASC')->get()->toArray();
        } else {
            $videos = $this->all()->toArray();
        }
        return $videos;
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
