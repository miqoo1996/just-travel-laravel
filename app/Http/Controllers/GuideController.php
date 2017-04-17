<?php

namespace App\Http\Controllers;

use App\Guide;
use Illuminate\Http\Request;

use App\Http\Requests;

class GuideController extends Controller
{
    public function adminGetGuideList()
    {
        $guides = Guide::all();
        return view('admin.guide_list', ['guides' => $guides]);
    }

    public function adminGetNewGuide()
    {
        return view('admin.new_guide');
    }

    public function adminPostNewGuide(Request $request)
    {
        if(isset($request->guide_id)){
            $guide = Guide::find($request->guide_id);
        } else {
            $guide = new Guide();
        }

        $guide->fill($request->input());
        $guide->save();
        return redirect()->route('admin-guide-list');
    }

    public function adminGetEditGuide($guide_id)
    {
        $guide = Guide::find($guide_id);
        return view('admin.edit_guide', ['guide' => $guide]);
    }
}
