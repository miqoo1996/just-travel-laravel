<?php

namespace App\Http\Controllers;

use App\Tour;
use App\Hotel;
use App\TourDate;
use App\TourHotel;
use App\TourCatRel;
use App\TourCategory;
use App\TourCustomDay;
use App\HotelCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminPostNewTour(Request $request)
    {
        $isBasic = false;
        if ($request->get('tour_id')) {
            $tour = Tour::find($request->get('tour_id'));
        } else {
            $tour = new Tour();
            $tour->code = substr(strtoupper(uniqid()), -7);
        }

        $tourCats = $tourDays = $tourHotels = [];
        if ($fields = $request->input()) {
            $tourCats = $this->setTourCategories($request, $tour, $fields, $isBasic);
            $tourDays = $this->setTourDays($request, $tour, $isBasic);
            $tourHotels = $this->setTourHotels($tour);
            $this->setTourFile($request, $fields, 'tour_images');
            $this->setTourFile($request, $fields, 'tour_main_image');
            $this->setTourFile($request, $fields, 'hot_image');
            $tour->fill($fields);
        }

        if ($tour->save()) {
            $tourCats = $this->setTourCategories($request, $tour, $fields, $isBasic);
            $tourDays = $this->setTourDays($request, $tour, $isBasic);
            $tourHotels = $this->setTourHotels($tour);

            TourCatRel::where('tour_id', $tour->id)->delete();
            if (!empty($tourCats)) TourCatRel::insert($tourCats);

            if($isBasic && !empty($request->specific_days)){
                $dates = explode(',', $request->specific_days);

            } elseif(!empty($request->custom_dates)){
                $dates = explode(',', $request->custom_dates);
            }
            if(isset($dates)) {
                foreach ($dates as $date) {
                    $tourDate['tour_id'] = $tour->id;
                    $tourDate['date'] = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
                    $tourDates[] = $tourDate;
                }
            }
            TourDate::where('tour_id', $tour->id)->delete();
            if (isset($tourDates)) TourDate::insert($tourDates);

            $path = 'images/tours/' . $tour->id;
            $tourImagesPathName = 'images/tours/' . $tour->id . '/tour_images/';
            $mainImagePathName = 'images/tours/' . $tour->id . '/main_image/';
            $hotImagePathName = 'images/tours/' . $tour->id . '/hot_image/';
            if (!isset($request->tour_id)) {
                Storage::makeDirectory($path);
                Storage::makeDirectory($tourImagesPathName);
                Storage::makeDirectory($mainImagePathName);
                Storage::makeDirectory($hotImagePathName);
            }

            $this->setTourFile($request, $fields, 'tour_images', $tourImagesPathName);
            $this->setTourFile($request, $fields, 'tour_main_image', $mainImagePathName);
            $this->setTourFile($request, $fields, 'hot_image', $hotImagePathName);

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

            if (!$isBasic && isset($tourHotels['hotel_id'])) {
                TourHotel::where('tour_id', $tour->id)->delete();
                if (!empty($tourHotels)) TourHotel::insert($tourHotels);
            }
            if (!$isBasic && isset($request->custom_day_desc_en)) {
                TourCustomDay::where('tour_id', $tour->id)->delete();
                if (!empty($tourDays)) TourCustomDay::insert($tourDays);
            }

            return redirect()->route('admin-tours-list');
        }
        $data = $this->getEditTour($tour);
        $data['tourCats'] = $tourCats;
        $data['tourDays'] = $tourDays;
        $data['tourHotels'] = $tourHotels;
        $data['errors'] = $tour->getValidator()->errors();
        return view('admin.edit_tour', $data);
    }

    public function adminGetEditTour($tour_id)
    {
        $tour = Tour::with(['categories', 'hotels', 'customDays','adminTourDates'])->find($tour_id);
        $data = $this->getEditTour($tour);
        return view('admin.edit_tour', $data);
    }

    public function getEditTour(Tour $tour)
    {
        $tour['tour_images'] = explode(',', $tour->tour_images);
        $tour['tour_dates'] = Tour::rewriteDates($tour->adminTourDates()->get()->pluck('date'));
        $tour['basic_frequency'] = array_flip(explode(',', $tour->basic_frequency));
        $data['tour_categories'] = TourCategory::all();
        $data['hotels'] = Hotel::select('hotel_name_en', 'id')->get();
        $data['tour'] = $tour;
        return $data;
    }

    public function setTourCategories(Request $request, Tour $tour, &$fields, &$isBasic)
    {
        $tourCats = [];
        $fields['tour_category'] = '';
        if (isset($request->tour_category_id)) {
            foreach ($request->tour_category_id as $item) {
                $item = explode('/', $item);
                $tourCat['tour_id'] = isset($tour->id) ? $tour->id : null;
                $tourCat['cat_id'] = $item[0];

                $fields['tour_category'] .= ($fields['tour_category'] == '') ? $item[2] : ', ' . $item[2];
                if ($item[1] == 'basic') {
                    $isBasic = true;
                }
                $tourCats[] = $tourCat;
            }
        }

        return $tourCats;
    }

    public function setTourDays(Request $request, Tour $tour, &$isBasic)
    {
        $tourDays = [];
        if (!$isBasic && isset($request->custom_day_desc_en)) {
            foreach ($request->custom_day_desc_en as $key => $value) {
                if (trim($value)) {
                    $tourDay['tour_id'] = $tour->id;
                    $tourDay['desc_en'] = $value;
                    $tourDay['desc_ru'] = isset($request->custom_day_desc_ru[$key]) ? $request->custom_day_desc_ru[$key] : '';
                    $tourDay['title_ru'] = isset($request->custom_day_title_ru[$key]) ? $request->custom_day_title_ru[$key] : '';
                    $tourDay['title_en'] = isset($request->custom_day_title_en[$key]) ? $request->custom_day_title_en[$key] : '';
                    $tourDays[] = $tourDay;
                }
            }
        }
        return $tourDays;
    }

    public function setTourHotels(Tour $tour)
    {
        $hotels = [];
        $tourHotels = isset($fields['hotel']) ? $fields['hotel'] : [];
        if (isset($tourHotels['hotel_id'])) {
            foreach ($tourHotels['hotel_id'] as $key => $value) {
                $hotel['hotel_id'] = $value;
                $hotel['tour_id'] = isset($tour->id) ? $tour->id : null;
                $hotel['single_adult'] = $tourHotels['single_adult'][$key];
                $hotel['double_adult'] = $tourHotels['double_adult'][$key];
                $hotel['triple_adult'] = $tourHotels['triple_adult'][$key];
                $hotel['child'] = $tourHotels['child'][$key];
                $hotel['infant'] = $tourHotels['infant'][$key];
                $hotels[] = $hotel;
            }
        }
        return $hotels;
    }

    public function setTourFile(Request $request, &$fields, $_file, $imagePathName = '', $move = false)
    {
        if ($_file == 'tour_images') {
            if ($request->hasFile('tour_images')) {
                $fieldsImages = $request->get('tour_images');

                $imageChecker = ($fieldsImages == '') ? true : false;
                foreach ($request->file('tour_images') as $item) {
                    $image = $item;
                    if (null !== $image) {
                        $image_name = uniqid() . config('const.' . $item->getMimeType());
                        if ($move) {
                            $image->move($imagePathName, $image_name);
                        }
                        $fieldsImages .= ($imageChecker) ? $imagePathName . $image_name : ',' . $imagePathName . $image_name;
                        $imageChecker = false;
                    }
                }
                $fields['tour_images'] = $fieldsImages;
            }
        } elseif ($request->hasFile($_file)) {
            $file = $request->file($_file);
            $file_name = uniqid() . config('const.' . $file->getMimeType());
            if ($move) {
                $file->move($imagePathName, $file_name);
            }
            $fields['tour_main_image'] = $imagePathName . $file_name;
        }
    }

    public function adminGetNewCustomTour()
    {
        $hotels = Hotel::select('id', 'hotel_name_en')->get();
        return view('admin.new_custom_tour', ['hotels' => $hotels]);
    }

    public function adminPostNewCustomTour(Request $request)
    {
        if ($request->get('tour_id')) {
            $tour = Tour::find($request->tour_id);
        } else {
            $tour = new Tour();
            $tour->type = 'custom';
        }

        $tourDays = $tourHotels = [];
        if ($fields = $request->input()) {
            $tourDays = $this->setTourDays($request, $tour, $isBasic);
            $tourHotels = $this->setTourHotels($tour);
            $tour->fill($fields);
        }

        if ($tour->save()) {
            $tourDays = $this->setTourDays($request, $tour, $isBasic);
            $tourHotels = $this->setTourHotels($tour);
            if (isset($tourHotels['hotel_id'])) {
                TourHotel::where('tour_id', $tour->id)->delete();
                if (!empty($tourHotels)) TourHotel::insert($tourHotels);
            }
            if (isset($request->custom_day_desc_en)) {
                TourCustomDay::where('tour_id', $tour->id)->delete();
                if (!empty($tourDays)) TourCustomDay::insert($tourDays);
            }
            return redirect()->route('admin-tours-list');
        }
        $data = $this->getEditTour($tour);
        $data['tourDays'] = $tourDays;
        $data['tourHotels'] = $tourHotels;
        $data['errors'] = $tour->getValidator()->errors();

        if ($tour->id) {
            $tour['custom_days'] = $tour->getCustomDays();
            $tour['hotels'] = $tour->getHotels();
            $tour['hotels'] = ($tour['hotels']->isEmpty()) ? false : $tour['hotels'];
            $tour['tour_images'] = explode(',', $tour->tour_images);
            $data['tour'] = $tour;
        }

        return view('admin.edit_custom_tour', $data);
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
        $data['tours'] = Tour::toursByCategory($category_id);
        $data['currentCategory'] = TourCategory::find($category_id);
        $data['currentCatId'] = $category_id;
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
                ->join('hotels', 'tour_hotels.hotel_id', '=', 'hotels.id')->groupBy('hotels.id')->get()->toArray();
            $data['days'] = TourCustomDay::where('tour_id', $tour['tour_id'])->get()->toArray();

            return view('tour_details_custom', $data);
        }
        $data['datesDisabled'] = explode(',',$tour->specific_days);
        $daysOfWeekDisabled = explode(',', $tour->basic_frequency);
        $bootstrapWeekDays = array_flip(config('const.bootstrap_week_days'));
        $difference = array_diff($bootstrapWeekDays, $daysOfWeekDisabled);
        $data['daysOfWeekDisabled'] = implode(",",array_flip($difference));

        return view('tour_details_basic', $data);
    }

    public function getTours()
    {
        $tour = TourCatRel::join('tour_categories', 'tour_cat_rels.cat_id', '=', 'tour_categories.id')->orderBy('tour_cat_rels.id', 'desc')->first();
        return redirect($tour->url);
    }

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
        $hotels = TourHotel::where('tour_id', $request->tour_id)
            ->join('hotels', 'tour_hotels.hotel_id', '=', 'hotels.id')->get()->toArray();
        foreach ($hotels as $key => $hotel){
            $hotels[$key]['price'] = HotelCalculator::calcHotelPrice($hotel, $adult, $child, $infant);
        }
        $data['hotels'] = $hotels;
        return View::make('ajax_views.tour_details_hotels', $data);
    }

    public function postSearchTours(Request $request)
    {
//        DB::enableQueryLog();
//        $searchTours = Tour::searchTours($request)->toArray();
        $searchTours = Tour::searchTours($request);
//        dd(DB::getQueryLog());
        return View::make('ajax_views.search_tours', compact('searchTours'));
    }
}
