<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 14-Apr-17
 * Time: 20:17
 */

namespace App\Http\ViewComposers;


use App\Currency;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;

class CurrencyComposer
{
    public $currency;

    public function __construct()
    {
        $this->currency = Currency::getCur();
        $this->currency['amd'] = 1;
        if (Session::has('cur')) {
            $this->currency['currency'] = Session::get('cur');
        } else {
            $this->currency['currency'] = 'amd';
        }
    }

    public function compose(View $view)
    {
        $view->with('currency', $this->currency);
    }
}