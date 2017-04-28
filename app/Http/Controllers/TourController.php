<?php

namespace App\Http\Controllers;

use App\HotelCalculator;
use App\TourCatRel;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Tour;
use App\Hotel;
use App\TourCategory;
use App\TourCustomDay;
use App\TourHotel;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\View;


class TourController extends Controller
{
    public function adminGetToursList()
    {
        $tours = Tour::select('id', 'tour_category', 'tour_name_en', 'hot', 'tour_url', 'type', 'basic_price_adult')->get();


        foreach ($tours as $key => $tour) {
            $tour['price'] = $tour->getFirstHotelAdultPrice();
            $data[] = $tour;
        }
        $data = (isset($data)) ? $data : false;
        return view('admin.tours_list', ['tours' => $data]);
    }

    public function adminGetNewTour()
    {
        $data['tour_categories'] = TourCategory::all();
        $data['hotels'] = Hotel::select('hotel_name_en', 'id')->get();
        return view('admin.new_tour', $data);
    }

    /**
     * @param Request $request
     */
    public function adminPostNewTour(Request $request)
    {

        $fields = $request->input();
        $isBasic = false;
        if (isset($request->tour_id)) {
            $tour = Tour::find($request->tour_id);
        } else {
            $tour = new Tour();
            $tour->code = substr(strtoupper(uniqid()), -7);
            $tour->save();
        }

        $fields['tour_category'] = '';
        if (isset($request->tour_category_id)) {
            foreach ($request->tour_category_id as $item) {
                $item = explode('/', $item);
                $tourCat['tour_id'] = $tour->id;
                $tourCat['cat_id'] = $item[0];

                $fields['tour_category'] .= ($fields['tour_category'] == '') ? $item[2] : ', ' . $item[2];
                if ($item[1] == 'basic') {
                    $isBasic = true;
                }
                $tourCats[] = $tourCat;
            }
        }
        TourCatRel::where('tour_id', $tour->id)->delete();
        if (isset($tourCats)) TourCatRel::insert($tourCats);


        $path = 'images/tours/' . $tour->id;
        $tourImagesPath = 'images/tours/' . $tour->id . '/tour_images';
        $mainImagePath = 'images/tours/' . $tour->id . '/main_image';
        $hotImagePath = 'images/tours/' . $tour->id . '/hot_image';
        if (!isset($request->tour_id)) {
            File::makeDirectory($path);
            File::makeDirectory($tourImagesPath);
            File::makeDirectory($mainImagePath);
            File::makeDirectory($hotImagePath);
        }
        $tourImagesPathName = 'images/tours/' . $tour->id . '/tour_images/';
        $mainImagePathName = 'images/tours/' . $tour->id . '/main_image/';
        $hotImagePathName = 'images/tours/' . $tour->id . '/hot_image/';

        if ($request->hasFile('tour_images')) {
            $fieldsImages = $tour->tour_images;

            $imageChecker = ($fieldsImages == '') ? true : false;
            foreach ($request->file('tour_images') as $item) {
                $image = $item;
                if (null !== $image) {
                    $image_name = uniqid() . config('const.' . $item->getMimeType());
                    $image->move($tourImagesPathName, $image_name);
                    $fieldsImages .= ($imageChecker) ? $tourImagesPathName . $image_name : ',' . $tourImagesPathName . $image_name;
                    $imageChecker = false;
                }
            }
            $fields['tour_images'] = $fieldsImages;
        }

        if ($request->hasFile('main_image')) {
            $file = $request->file('main_image');
            $file_name = uniqid() . config('const.' . $file->getMimeType());
            $file->move($mainImagePathName, $file_name);
            $fields['main_image'] = $mainImagePathName . $file_name;
        }
        if ($request->hasFile('hot_image')) {
            $file = $request->file('hot_image');
            $file_name = uniqid() . config('const.' . $file->getMimeType());
            $file->move($hotImagePathName, $file_name);
            $fields['hot_image'] = $hotImagePathName . $file_name;
        }
        if ($isBasic) {
            if (isset($request->basic_frequency)) {
                $fields['basic_frequency'] = '';
                $BFChecker = true;
                foreach ($request->basic_frequency as $BF) {
                    $fields['basic_frequency'] .= ($BFChecker) ? $BF : ',' . $BF;
                    $BFChecker = false;
                }
            }
        } else {
            unset($fields['basic_frequency']);
        }

        if (!isset($request->visibility)) {
            $fields['visibility'] = 'off';
        }
        if (!isset($request->hot)) {
            $fields['hot'] = 'off';
        }

        $tour->fill($fields);
        $tour->save();
        if (!$isBasic) {
            $tourHotels = $fields['hotel'];
            foreach ($tourHotels['hotel_id'] as $key => $value) {
                $hotel['hotel_id'] = $value;
                $hotel['tour_id'] = $tour->id;
                $hotel['single_adult'] = $tourHotels['single_adult'][$key];
                $hotel['double_adult'] = $tourHotels['double_adult'][$key];
                $hotel['triple_adult'] = $tourHotels['triple_adult'][$key];
                $hotel['child'] = $tourHotels['child'][$key];
                $hotel['infant'] = $tourHotels['infant'][$key];
                $hotels[] = $hotel;
            }

            TourHotel::where('tour_id', $tour->id)->delete();
            if (isset($hotels)) TourHotel::insert($hotels);
        }
        if (!$isBasic && isset($request->custom_day_desc_en)) {
            foreach ($request->custom_day_desc_en as $key => $value) {
                $tourDay['tour_id'] = $tour->id;
                $tourDay['desc_en'] = $value;
                $tourDay['desc_ru'] = $request->custom_day_desc_ru[$key];
                $tourDay['title_en'] = $request->custom_day_title_en[$key];
                $tourDay['title_ru'] = $request->custom_day_title_ru[$key];
                $tourDays[] = $tourDay;
            }
            TourCustomDay::where('tour_id', $tour->id)->delete();
            if (isset($tourDays)) TourCustomDay::insert($tourDays);
        }
        return redirect()->route('admin-tours-list');
    }

    public function adminGetEditTour($tour_id)
    {
        $data['tour_categories'] = TourCategory::all();
        $data['hotels'] = Hotel::select('hotel_name_en', 'id')->get();

        $tour = Tour::find($tour_id);
        $tour['categories'] = $tour->getCategories();
        $tour['hotels'] = $tour->getHotels();
        $tour['custom_days'] = $tour->getCustomDays();
        $tour['tour_images'] = explode(',', $tour->tour_images);
        $tour['basic_frequency'] = array_flip(explode(',', $tour->basic_frequency));
        $data['tour'] = $tour;
        return view('admin.edit_tour', $data);
    }

    public function adminGetNewCustomTour()
    {
        $hotels = Hotel::select('id', 'hotel_name_en')->get();
        return view('admin.new_custom_tour', ['hotels' => $hotels]);
    }

    public function adminPostNewCustomTour(Request $request)
    {
        $fields = $request->input();
        if (isset($request->tour_id)) {
            $tour = Tour::find($request->tour_id);
        } else {
            $tour = new Tour();
            $tour->type = 'custom';
        }
        $tour->fill($fields);
        $tour->save();

        $tourHotels = $fields['hotel'];
        foreach ($tourHotels['hotel_id'] as $key => $value) {
            $hotel['hotel_id'] = $value;
            $hotel['tour_id'] = $tour->id;
            $hotel['single_adult'] = $tourHotels['single_adult'][$key];
            $hotel['double_adult'] = $tourHotels['double_adult'][$key];
            $hotel['triple_adult'] = $tourHotels['triple_adult'][$key];
            $hotel['child'] = $tourHotels['child'][$key];
            $hotel['infant'] = $tourHotels['infant'][$key];
            $hotels[] = $hotel;
        }

        TourHotel::where('tour_id', $tour->id)->delete();
        if (isset($hotels)) TourHotel::insert($hotels);

        if (isset($request->custom_day_desc_en)) {
            foreach ($request->custom_day_desc_en as $key => $value) {
                $tourDay['tour_id'] = $tour->id;
                $tourDay['desc_en'] = $value;
                $tourDay['desc_ru'] = $request->custom_day_desc_ru[$key];
                $tourDays[] = $tourDay;
            }
            TourCustomDay::where('tour_id', $tour->id)->delete();
            if (isset($tourDays)) TourCustomDay::insert($tourDays);
        }
        return redirect()->route('admin-tours-list');
    }

    public function adminGetEditCustomTour($tour_id)
    {
        $data['hotels'] = Hotel::select('id', 'hotel_name_en')->get();
        $tour = Tour::find($tour_id);
        $tour['custom_days'] = $tour->getCustomDays();
        $tour['hotels'] = $tour->getHotels();
        $tour['hotels'] = ($tour['hotels']->isEmpty()) ? false : $tour['hotels'];
        $tour['tour_images'] = explode(',', $tour->tour_images);
        $data['tour'] = $tour;
        return view('admin.edit_custom_tour', $data);

    }

    public function ajaxGetToursByCategory($category_id)
    {
        $data = Tour::ToursByCategory($category_id);
        Session::set('cat_id', $category_id);
        return view('ajax_views.index_tours', $data);
    }

    public function getTourByUrl($tour_url)
    {
        $tour = Tour::where('tour_url', $tour_url)
            ->join('tour_cat_rels', 'tours.id', '=', 'tour_cat_rels.tour_id')
            ->join('tour_categories', 'tour_cat_rels.cat_id', '=', 'tour_categories.id')
            ->first();
        $tour->tour_images = explode(',', $tour->tour_images);
        $data['tour'] = $tour->toArray();
        if($tour['property'] !== 'basic'){
            $data['hotels'] = TourHotel::where('tour_id', $tour['tour_id'])
                ->join('hotels', 'tour_hotels.hotel_id', '=', 'hotels.id')->get()->toArray();
            $data['days'] = TourCustomDay::where('tour_id', $tour['tour_id'])->get()->toArray();
            return view('tour_details_custom', $data);
        }
        return view('tour_details_basic', $data);
    }

    public function getTours()
    {
        $tour = TourCatRel::join('tour_categories', 'tour_cat_rels.cat_id', '=', 'tour_categories.id')->orderBy('tour_cat_rels.id', 'desc')->first();
        return redirect($tour->url);
    }

//    public function postSearchTours(Request $request)
//    {
//       if(empty($request->category){
//           $tours =
//       }
//    }

    public function postSearchCustomTour(Request $request)
    {
        $adult = (intval($request->adult) < 1)? 1 : intval($request->adult);
        $child = (intval($request->child) < 0)? 0 : intval($request->child);
        $infant = (intval($request->infant) < 0)? 0 : intval($request->infant);
        $hotelCalculator = HotelCalculator::calc($adult, $child, $infant);
        if(null == $hotelCalculator){
            return View::make('ajax_views.many_adults_form');
        }
        $data['adult'] = $adult;
        $data['child'] = $child;
        $data['infant'] = $infant;
        $data['rooms'] = $hotelCalculator;
        $data['days'] = TourCustomDay::where('tour_id', $request->tour_id)->get()->toArray();
        $data['hotels'] = TourHotel::where('tour_id', $request->tour_id)
            ->join('hotels', 'tour_hotels.hotel_id', '=', 'hotels.id')->get()->toArray();
        return View::make('ajax_views.tour_details_hotels', $data);
    }
}
