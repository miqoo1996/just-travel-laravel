<?php

namespace App\Http\Controllers;

use App\Currency;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;

class CurrencyController extends Controller
{

    public function setCurrency($cur)
    {
        if (in_array($cur, config('const.currencies'))) {
            Session::set('cur', $cur);
        }
        return redirect()->back();
    }


}
