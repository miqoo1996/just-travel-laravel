<?php

namespace App\Http\Controllers;

use App\Currency;
use App\DownloadPDF;
use App\GalleryPhotos;
use App\Gallery;
use App\Guide;
use App\Tour;
use App\TourCategory;
use App\User;
use App\Hotel;
use App\VideoGallery;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
/**
 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
 */
    public function getLogin(){
        if(Auth::user() !== null){
            return redirect()->route('admin-dashboard');
        }
    	return view('admin.login');
    }

/**
 * @param Request $request
 * @return \Illuminate\Http\RedirectResponse
 */
    public function postLogin(Request $request){
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended('admin/dashboard');
        }
        return redirect()->back();
    }
    // TODO delete this after created needed user
/**
 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
 */
    public function getRegister(){
        return view('admin.register');
    }

/**
 * @param Request $request
 */
    public function postRegister(Request $request){
        $user = new User();
        $user->email = $request->email;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->password = bcrypt($request->password);
        $user->save();
    }
    // TODO here is end of this shit

    public function getDashboard()
    {
        return view('admin.dashboard');
    }

    /**
     * @param Request $request
     * @return string
     */
    public function adminAjaxDeleteImage(Request $request){
        $object = null;
        switch ($request->type){
            case 'tours':
                $object = Tour::find($request->id);
                $object->tour_images = self::imageRemove($object->tour_images, $request->image_position);
                break;
            case 'hotels' :
                $object = Hotel::find($request->id);
                $object->images = self::imageRemove($object->images, $request->image_position);
                break;
            case 'gallery' :
                $object = GalleryPhotos::find($request->id);
                $object->delete();
                $object = null;
                break;

            default:
                return 'false';
                break;
        }
        if($object !== null) $object->save();
        return 'true';
    }

    private static function imageRemove($imageField, $imagePosition)
    {
        $imageField = explode(',', $imageField);
        $check = true;
        $data = '';
        foreach ($imageField as $item) {
            if($item !== $imagePosition){
                $data .= ($check)? $item: ',' . $item;
                $check = false;
            }
        }

        File::delete($imagePosition);

        return $data;
    }

    public function adminAjaxRemoveData(Request $request)
    {
        $status = true;
        switch ($request->param){
            case 'tour_category':
                $obj = TourCategory::find($request->id);
                if(null == $obj){
                    $status = false;
                    break;
                }
                if($obj->property !== 'basic') {
                    $obj->delete();
                } else {
                    $status = false;
                }
                break;

            case 'tour':
                $obj = Tour::find($request->id);
                File::deleteDirectory('images/tours/'.$obj->id);
                if(null == $obj){
                    $status = false;
                    break;
                }
                $obj->delete();
                break;
            case 'hotel':
                $obj = Hotel::find($request->id);
                if(null == $obj){
                    $status = false;
                    break;
                }
                $obj->delete();
                break;
            case 'video':
                $obj = VideoGallery::find($request->id);
                if(null == $obj){
                    $status = false;
                    break;
                }
                $obj->delete();
                break;
            case 'gallery' :
                $obj = Gallery::find($request->id);
                if(null == $obj){
                    $status = false;
                    break;
                }
                File::deleteDirectory('images/gallery/'.$obj->id);
                $obj->delete();
                break;
            case 'pdf' :
                $obj = DownloadPDF::find($request->id);
                if (null == $obj){
                    $status = false;
                    break;
                }
                File::deleteDirectory('files/pdf/'.$obj->id);
                File::deleteDirectory('images/pdf/'.$obj->id);
                $obj->delete();

                break;
            case 'guide' :
                $obj = Guide::find($request->id);
                if(null == $obj){
                    $status = false;
                    break;
                }
                $obj->delete();
                break;
        }

        return ($status)? 'true': 'false';
    }

    public function adminGetSettings()
    {
        $currency = Currency::first();
        return view('admin.settings', ['admin_currency' => $currency]);
    }

    public function adminPostResetPassword(Request $request)
    {
        $rules = [
            'pswd' => 'min:6|required',
            'new_pswd' => 'min:6|required',
            'new_pswd_conf' => 'required|same:new_pswd'
        ];
        $validator = Validator::make($request->input(), $rules);
        $messages = $validator->messages();
        if ($validator->fails()) {
            return redirect()->back()->withErrors($messages);
        }

        $user = Auth::user();
        $user->password = bcrypt($request->new_pswd);
        $user->save();
        return redirect()->back();
    }

    public function postUpdateCropped(Request $request)
    {
        dd($request);
    }
    public function adminPostUpdateCurrencies(Request $request)
    {
        $cur = Currency::first();
        if(null == $cur){
            $cur = new Currency();
        }
        $cur->fill($request->input());
        $cur->save();
        return redirect()->back();
    }

    public function adminLogout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->back();
    }
}
