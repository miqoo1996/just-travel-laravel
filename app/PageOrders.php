<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class PageOrders extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'page_id',
        'order',
        'right_menu',
        'footer'
    ];

    /**
     * Validation rules.
     *
     * @var array
     */
    private $rules = [
        'page_id' => 'required|integer|exists:pages,id',
        'order' => 'required|numeric|max:1000',
        'right_menu' => 'required|numeric|max:1',
        'footer' => 'required|numeric|max:1',
    ];

    public static function boot()
    {
        // Saving event
        static::saving(function ($model) {
            // Make a new validator object
            $v = Validator::make($model->getAttributes(), $model->rules);
            // Optionally customize this version using new ->after()
            $v->after(function() use ($v, $model) {
                // Do more validation
                if (isset($model->right_menu, $model->footer)) {
                    if ($model->right_menu == $model->footer || !in_array($model->right_menu, [0,1]) || !in_array($model->footer, [0,1])) {
                        $v->errors()->add('error', 'Error');
                    }
                }
            });
            return !$v->fails();
        });
        parent::boot();
    }

    public function saveData(array $attributes, array $_data)
    {
        if (is_array($attributes) && !empty($attributes)) {
            $this->where('right_menu', $_data['right_menu'])->where('footer', $_data['footer'])->delete();
            foreach ($attributes as $attribute) {
                if (isset($attribute['page_id'], $attribute['order'])) {
                    $data = [
                        'page_id' => $attribute['page_id'],
                        'order' => $attribute['order'],
                        'right_menu' => $_data['right_menu'],
                        'footer' => $_data['footer']
                    ];
                    (new static())->fill($data)->save();
                }
            }
        };
        return $this;
    }

}
