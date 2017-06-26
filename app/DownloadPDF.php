<?php

namespace App;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class DownloadPDF extends Model
{
    public $scenario = 'insert';

    private $validator;

    protected $fillable = [
      'pdf_name_en',
      'pdf_name_ru',
      'pdf_thumbnail_en',
      'pdf_thumbnail_ru',
      'pdf_file_en',
      'pdf_file_ru',
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    private $rules = [
        'pdf_name_en' => 'required|max:255',
        'pdf_name_ru' => 'required|max:255',
        'pdf_thumbnail_en' => 'required|max:255',
        'pdf_thumbnail_ru' => 'required|max:255',
        'pdf_file_en' => 'required|max:255',
        'pdf_file_ru' => 'required|max:255',
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

    public function getPdfs($order = false)
    {
        if ($order) {
            $data =  $this->orderBy('order', 'ASC')->get()->toArray();
        } else {
            $data = $this->all()->toArray();
        }
        return $data;
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
