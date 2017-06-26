<?php

namespace App\Http\Controllers;

use App\Currency;
use App\DownloadPDF;
use App\GalleryPhotos;
use App\Gallery;
use App\Guide;
use App\OrderTour;
use App\Page;
use App\SimpleImage;
use App\Tour;
use App\TourCategory;
use App\Hotel;
use App\VideoGallery;
use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getLogin()
    {
        if (Auth::user() !== null) {
            return redirect()->route('admin-dashboard');
        }
        return view('admin.login');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postLogin(Request $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->intended('admin/dashboard');
        }
        return redirect()->back();
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function getDashboard(Request $request)
    {
        $orders = OrderTour::select(['*', 'order_tours.created_at as created_at'])
            ->rightJoin('payments', 'payments.order_tour_id', '=', 'order_tours.id')
            ->leftJoin('tours', 'tours.id', '=', 'order_tours.tour_id')
            ->orderBy('order_tours.created_at', 'asc')
            ->get();
        $successOrders = $orders->where('OrderStatus', '2');
        $totalAmount = 0;
        foreach ($successOrders as $successOrder) {
            $totalAmount += $successOrder->Amount;
        }
        $data['hotels_count'] = Hotel::all()->count();
        $data['tours_count'] = Tour::all()->count();
        $data['orders'] = $orders;
        $data['success_orders'] = $successOrders;
        $data['total_amount'] = $totalAmount / 100;
        $data['nots'] = $request->get('nots');
        if ($data['nots'] == 'show') {
            $data['readedNots'] = true;
        }
        return view('admin.dashboard', $data);
    }

    /**
     * @param Request $request
     * @return string
     */
    public function adminAjaxDeleteImage(Request $request)
    {
        $object = null;
        switch ($request->type) {
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
                $object->images = self::imageRemove($object->images, $request->image_position);
                $object->delete();
                $object = null;
                break;
            default:
                return 'false';
                break;
        }
        if ($object !== null) $object->save();
        return 'true';
    }

    private static function imageRemove($imageField, $imagePosition)
    {
        $imageField = explode(',', $imageField);
        $check = true;
        $data = '';
        foreach ($imageField as $item) {
            if ($item !== $imagePosition) {
                $data .= ($check) ? $item : ',' . $item;
                $check = false;
            }
        }

        $imageThumb = SimpleImage::getImagePath($imagePosition, 'thumbnail');
        File::delete($imagePosition);
        File::delete($imageThumb);

        return $data;
    }

    public function adminAjaxRemoveData(Request $request)
    {
        $status = true;
        switch ($request->param) {
            case 'tour_category':
                $obj = TourCategory::find($request->id);
                if (null == $obj) {
                    $status = false;
                    break;
                }
                if ($obj->property !== 'basic') {
                    $obj->delete();
                } else {
                    $status = false;
                }
                break;

            case 'tour':
                $obj = Tour::find($request->id);
                $images = [];
                if (isset($obj->tour_images)) {
                    if (strpos($obj->tour_images, ',') !== false) {
                        $images += explode(',', $obj->tour_images);
                    } else {
                        $images[] = $obj->tour_images;
                    }
                }
                if (isset($obj->tour_main_image)) {
                    $images[] = $obj->tour_main_image;
                }
                if (isset($obj->hot_image)) {
                    $images[] = $obj->hot_image;
                }
                if (null == $obj) {
                    $status = false;
                    break;
                }
                SimpleImage::deleteImages($images);
                $obj->delete();
                break;
            case 'hotel':
                $obj = Hotel::find($request->id);
                $images = [];
                if (isset($obj->images)) {
                    if (strpos($obj->images, ',') !== false) {
                        $images += explode(',', $obj->images);
                    } else {
                        $images[] = $obj->images;
                    }
                }
                if (isset($obj->hotel_main_image)) {
                    $images[] = $obj->hotel_main_image;
                }
                if (null == $obj) {
                    $status = false;
                    break;
                }
                SimpleImage::deleteImages($images);
                $obj->delete();
                break;
            case 'video':
                $obj = VideoGallery::find($request->id);
                $images = [];
                if (isset($obj->video_thumbnail_en)) {
                    $images[] = $obj->video_thumbnail_en;
                }
                if (isset($obj->video_thumbnail_ru)) {
                    $images[] = $obj->video_thumbnail_ru;
                }
                if (null == $obj) {
                    $status = false;
                    break;
                }
                SimpleImage::deleteImages($images);
                $obj->delete();
                break;
            case 'gallery' :
                $obj = Gallery::find($request->id);
                $images = [];
                if (isset($obj->main_image)) {
                    $images[] = $obj->main_image;
                }
                if (null == $obj) {
                    $status = false;
                    break;
                }
                File::deleteDirectory('images/gallery/' . $obj->id);
                SimpleImage::deleteImages($images);
                $obj->delete();
                break;
            case 'pdf' :
                $obj = DownloadPDF::find($request->id);
                $files = [];
                if (null == $obj) {
                    $status = false;
                    break;
                }
                if (isset($obj->pdf_thumbnail_en)) {
                    $files[] = $obj->pdf_thumbnail_en;
                }
                if (isset($obj->pdf_thumbnail_ru)) {
                    $files[] = $obj->pdf_thumbnail_ru;
                }
                if (isset($obj->pdf_file_en)) {
                    $files[] = $obj->pdf_file_en;
                }
                if (isset($obj->pdf_file_ru)) {
                    $files[] = $obj->pdf_file_ru;
                }
                SimpleImage::deleteImages($files);
                $obj->delete();
                break;
            case 'guide' :
                $obj = Guide::find($request->id);
                if (null == $obj) {
                    $status = false;
                    break;
                }
                $obj->delete();
                break;
            case 'page' :
                $obj = Page::find($request->id);
                $images = [];
                if (isset($obj->image)) {
                    $images[] = $obj->image;
                }
                if (null == $obj) {
                    $status = false;
                    break;
                }
                SimpleImage::deleteImages($images);
                $obj->delete();
                break;
        }

        return $status ? 'true' : 'false';
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
        $image = $request->file('data');
        $source = str_replace(URL::to('/') . '/', '', $request->source);
        $image_name = array_reverse(explode('/', $source))[0];
        $image_path = str_replace('/' . $image_name, '', $source);
        File::deleteDirectory($source);
        $image->move($image_path, $image_name);
        return $source;
    }

    public function adminPostUpdateCurrencies(Request $request)
    {
        $cur = Currency::first();

        if (null == $cur) {
            $cur = new Currency();
        }

        $cur->fill($request->input());

        if (!$cur->save()) {
            return redirect()->back()->with('errors', $cur->getValidator()->errors());
        }
        return redirect()->back();
    }

    public function adminLogout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->back();
    }

    public function adminGetVoucher($orderTourId)
    {
        $path = Storage::disk('voucher')->getDriver()->getAdapter()->applyPathPrefix($orderTourId . '.pdf');

        return response()->make(file_get_contents($path), 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $orderTourId . '.pdf' . '"'
        ]);
    }
}
