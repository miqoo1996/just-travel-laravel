<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function setLanguage($lang)
    {
        if(in_array($lang, ['en', 'ru'])){
            Session::set('locale', $lang);
            Cookie::queue('locale', $lang, 24 * 60);
        }
        return redirect()->back();
    }
}
