<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class VideoGallery extends Model
{
    public $scenario = 'insert';

    private $validator;

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

    /**
     * Validation rules.
     *
     * @var array
     */
    private $rules = [
        'video_url_en' => 'required|max:255',
        'video_url_ru' => 'required|max:255',
        'video_title_en' => 'required|max:255',
        'video_title_ru' => 'required|max:255',
        'video_thumbnail_en' => 'required|max:255',
        'video_thumbnail_ru' => 'required|max:255',
    ];

    public function getValidator()
    {
        return $this->validator;
    }
    public function getVideos($order = false)
    {
        if ($order) {
            $videos =  $this->orderBy('order', 'ASC')->get()->toArray();
        } else {
            $videos = $this->all()->toArray();
        }
        return $videos;
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
                $row = self::select(DB::raw('MAX(`order`) + 1 as `max`'))->first();
                $model->order = intval($row->getAttribute('max'));
            }
            // Make a new validator object
            $v = Validator::make($model->getAttributes(), $model->rules);
            // Optionally customize this version using new ->after()
            $v->after(function() use ($v, $model) {
                // Do more validation
            });
            $model->validator = $v;
            return !$v->fails();
        });
        parent::boot();
    }

    public function saveData(array $attributes)
    {
        if (is_array($attributes) && !empty($attributes)) {
            foreach ($attributes as $attribute) {
                if (isset($attribute['page_id'], $attribute['order'])) {
                    $model = (new static())->where('id', intval($attribute['page_id']))->get()->first();
                    if ($model) {
                        $model->scenario = 'update_order';
                        $model->order = intval($attribute['order']);
                        $model->save();
                    }
                }
            }
        };
        return $this;
    }

}
