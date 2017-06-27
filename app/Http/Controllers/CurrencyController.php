<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CurrencyController extends Controller
{

    public function setCurrency($cur)
    {
        if (in_array($cur, config('const.currencies'))) {
            Cookie::queue('cur', $cur, 24 * 60);
        }
        return redirect()->back();
    }

    public function setGuestTimezone(Request $request)
    {
        if($request->has('tz')){
            $tz = (-1) * $request->tz / 60;
            Cookie::set('tz', $tz);
        }
        return Cookie::get('tz');
    }

}
