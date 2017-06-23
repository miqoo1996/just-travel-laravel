<?php

namespace App\Http\Controllers;

use App\Tour;
use App\Hotel;
use App\TourDate;
use App\TourHotel;
use App\TourCatRel;
use App\SimpleImage;
use App\TourCategory;
use App\TourCustomDay;
use App\HotelCalculator;
use App\Http\Controllers\Traits\TourTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;

class TourController extends Controller
{
    use TourTrait;

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
            SimpleImage::setModel(clone $tour);
        } else {
            $tour = new Tour();
            $tour->code = substr(strtoupper(uniqid()), -7);
        }

        $tourCats = $tourDays = $tourHotels = [];
        if ($fields = $request->input()) {
            $tourDays = $this->setTourDays($request, $tour, $isBasic);
            $tourHotels = $this->setTourHotels($tour, $fields);

            $tourCats = $this->setTourCategories($request, $tour, $fields, $isBasic);
            $this->setTourFile($request, $fields, 'tour_images', 'images/tours/tour_images/');
            $this->setTourFile($request, $fields, 'tour_main_image', 'images/tours/main_image/');
            $this->setTourFile($request, $fields, 'hot_image', 'images/tours/hot_image/');

            if ($isBasic) {
                $tour->tour_dates = $request->get('specific_days');
            } else {
                $tour->tour_dates = $request->get('custom_dates');
            }

            $fields['basic_frequency'] = '';
            if ($isBasic) {
                if (isset($request->basic_frequency)) {
                    $BFChecker = true;
                    foreach ($request->basic_frequency as $BF) {
                        $fields['basic_frequency'] .= ($BFChecker) ? $BF : ',' . $BF;
                        $BFChecker = false;
                    }
                }
            }

            $fields['visibility'] = $request->get('visibility', 'off');
            $fields['hot'] = $request->get('hot', 'off');
            $tour->isBasic = $isBasic;
            $tour->fill($fields);
        }

        if ($tour->save()) {
            $this->setTourFile($request, $fields, 'tour_images', 'images/tours/tour_images/', true);
            $this->setTourFile($request, $fields, 'tour_main_image', 'images/tours/main_image/', true);
            $this->setTourFile($request, $fields, 'hot_image', 'images/tours/hot_image/', true);

            $tourCats = $this->setTourCategories($request, $tour, $fields, $isBasic);
            $tourDays = $this->setTourDays($request, $tour, $isBasic);
            $tourHotels = $this->setTourHotels($tour, $fields);

            TourCatRel::where('tour_id', $tour->id)->delete();
            if (!empty($tourCats)) TourCatRel::insert($tourCats);

            if ($isBasic && isset($request->specific_days) && $request->specific_days) {
                $dates = strpos($request->specific_days,',') !== false ? explode(',', $request->specific_days) : [$request->specific_days];
            }
            if (!$isBasic && isset($request->custom_dates) && $request->custom_dates) {
                $dates = strpos($request->custom_dates,',') !== false ? explode(',', $request->custom_dates) : [$request->custom_dates];
            }
            if (isset($dates)) {
                foreach ($dates as $date) {
                    $tourDate['tour_id'] = $tour->id;
                    $tourDate['date'] = Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
                    $tourDates[] = $tourDate;
                }
            }
            TourDate::where('tour_id', $tour->id)->delete();
            if (isset($tourDates)) TourDate::insert($tourDates);

            $path = 'images/tours/' . $tour->id;

            $this->makeDirectory($path);

            TourHotel::where('tour_id', $tour->id)->delete();
            if (!$isBasic) {
                if (!empty($tourHotels)) TourHotel::insert($tourHotels);
            }
            TourCustomDay::where('tour_id', $tour->id)->delete();
            if (!$isBasic && isset($request->custom_day_desc_en)) {
                if (!empty($tourDays)) TourCustomDay::insert($tourDays);
            }

            return redirect()->route('admin-tours-list');
        }
        $data = $this->getEditTour($tour);
        if ($isBasic) {
            $tour->tour_dates = $request->get('specific_days');
        } else {
            $tour->tour_dates = $request->get('custom_dates');
        }
        $tour->basic_price_adult = $request->get('basic_price_adult');
        $tour->basic_price_child = $request->get('basic_price_child');
        $tour->basic_price_infant = $request->get('basic_price_infant');
        $data['tourCats'] = $tourCats;
        $data['tourDays'] = $tourDays;
        $data['tourHotels'] = $tourHotels;
        $data['errors'] = $tour->getValidator()->errors();
        return view('admin.edit_tour', $data);
    }

    public function adminGetEditTour($tour_id)
    {
        $tour = Tour::with(['categories', 'hotels', 'customDays', 'adminTourDates'])->find($tour_id);
        $data = $this->getEditTour($tour);
        return view('admin.edit_tour', $data);
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

        $tour->setIsCustom(true);

        $tourDays = $tourHotels = [];
        if ($fields = $request->input()) {
            $tourDays = $this->setTourDays($request, $tour, $isBasic);
            $tourHotels = $this->setTourHotels($tour, $fields);
            $tour->fill($fields);
        }

        if ($tour->save()) {
            $tourDays = $this->setTourDays($request, $tour, $isBasic);
            $tourHotels = $this->setTourHotels($tour, $fields);

            TourHotel::where('tour_id', $tour->id)->delete();
            if (!empty($tourHotels)) TourHotel::insert($tourHotels);

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
        //$tour['custom_days'] = $tour->getCustomDays();
        $tour['custom_days'] = $tour->customDays;
        //$tour['hotels'] = $tour->getHotels();
        $tour['hotels'] = $tour->hotels;
        $tour['hotels'] = ($tour['hotels']->isEmpty()) ? false : $tour['hotels'];
        $tour['tour_images'] = explode(',', $tour->tour_images);
        $data['tour'] = $tour;
        return view('admin.edit_custom_tour', $data);

    }

    public function ajaxGetToursByCategory($category_id)
    {
        $data['tours'] = Tour::toursByCategory($category_id, 6);
        $data['currentCategory'] = TourCategory::find($category_id);
        $data['countTours'] = Tour::getTourCountByCategory($category_id);
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
        if (!$tour) {
            return redirect('/404');
        }
        $tour->tour_images = explode(',', $tour->tour_images);
        $data['tour'] = $tour->toArray();
        if ($tour['property'] !== 'basic') {
            $data['hotels'] = TourHotel::where('tour_id', $tour['tour_id'])
                ->join('hotels', 'tour_hotels.hotel_id', '=', 'hotels.id')->groupBy('hotels.id')->get()->toArray();
            $data['days'] = TourCustomDay::where('tour_id', $tour['tour_id'])->get()->toArray();

            return view('tour_details_custom', $data);
        }
        $data['datesDisabled'] = explode(',', $tour->specific_days);
        $daysOfWeekDisabled = explode(',', $tour->basic_frequency);
        $bootstrapWeekDays = array_flip(config('const.bootstrap_week_days'));
        $difference = array_diff($bootstrapWeekDays, $daysOfWeekDisabled);
        $data['daysOfWeekDisabled'] = implode(",", array_flip($difference));

        return view('tour_details_basic', $data);
    }

    public function getTours()
    {
        $tour = TourCatRel::join('tour_categories', 'tour_cat_rels.cat_id', '=', 'tour_categories.id')->orderBy('tour_cat_rels.id', 'desc')->first();
        return redirect($tour->url);
    }

    public function postSearchCustomTour(Request $request)
    {
        $adult = (intval($request->adult) < 1) ? 1 : intval($request->adult);
        $child = (intval($request->child) < 0) ? 0 : intval($request->child);
        $infant = (intval($request->infant) < 0) ? 0 : intval($request->infant);
        $hotelCalculator = HotelCalculator::calc($adult, $child, $infant);
        if (null == $hotelCalculator) {
            return View::make('ajax_views.many_adults_form');
        }
        $data['adult'] = $adult;
        $data['child'] = $child;
        $data['infant'] = $infant;
        $data['rooms'] = $hotelCalculator;
        $data['days'] = TourCustomDay::where('tour_id', $request->tour_id)->get()->toArray();
        $hotels = TourHotel::where('tour_id', $request->tour_id)
            ->join('hotels', 'tour_hotels.hotel_id', '=', 'hotels.id')
            ->get()
            ->toArray();
        foreach ($hotels as $key => $hotel) {
            $hotels[$key]['price'] = HotelCalculator::calcHotelPrice($hotel, $adult, $child, $infant);
        }
        $data['hotels'] = $hotels;
        return View::make('ajax_views.tour_details_hotels', $data);
    }

    public function postSearchTours(Request $request)
    {
        $searchTours = Tour::searchTours($request);
        return View::make('ajax_views.search_tours', compact('searchTours'));
    }

    public function adminTourOrders()
    {
        $model = new Tour();
        $tours = $model->getTours(true);
        return view('admin.tour_orders', compact('tours'));
    }

    public function adminTourOrdersSave(Request $request)
    {
        $model = new Tour();
        $items = $request->get('items');
        $model->saveData($items);
    }

}
