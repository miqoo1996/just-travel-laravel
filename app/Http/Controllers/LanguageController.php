<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function setLanguage($lang)
    {
        if(in_array($lang, ['en', 'ru'])){
            Session::set('locale', $lang);
        }
        return redirect()->back();
    }
}
