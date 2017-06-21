<?php

namespace App\Http\ViewComposers;

use App\Currency;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;

class CurrencyComposer
{
    public $currency;

    public function __construct()
    {
        $this->currency = Currency::getCur();
        $this->currency['amd'] = 1;
        if (Cookie::has('cur')) {
            $this->currency['currency'] = Cookie::get('cur');
        } else {
            $this->currency['currency'] = 'amd';
        }
    }

    public function compose(View $view)
    {
        $view->with('currency', $this->currency);
    }

}
