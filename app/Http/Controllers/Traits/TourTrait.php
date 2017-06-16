<?php

namespace App\Http\Controllers\Traits;

use App\Tour;
use App\Hotel;
use App\TourCategory;
use App\TourHotel;
use Illuminate\Http\Request;

trait TourTrait
{
    public function getEditTour(Tour $tour)
    {
        $tour['tour_images'] = explode(',', $tour->tour_images);
        $tour['tour_dates'] = Tour::rewriteDates($tour->adminTourDates()->get()->pluck('date'));
        $tour['basic_frequency'] = array_flip($tour->basic_frequency);
        $data['tour_categories'] = TourCategory::all();
        $data['hotels'] = Hotel::select('hotel_name_en', 'id')->get();
        if ($tour->id) {
            $data['tourHotels'] = TourHotel::where('tour_id', $tour->id)->get();
        }
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
                $tourDay['tour_id'] = $tour->id;
                $tourDay['desc_en'] = $value;
                $tourDay['desc_ru'] = isset($request->custom_day_desc_ru[$key]) ? $request->custom_day_desc_ru[$key] : '';
                $tourDay['title_ru'] = isset($request->custom_day_title_ru[$key]) ? $request->custom_day_title_ru[$key] : '';
                $tourDay['title_en'] = isset($request->custom_day_title_en[$key]) ? $request->custom_day_title_en[$key] : '';
                $tourDays[] = $tourDay;
            }
        }
        return $tourDays;
    }

    public function setTourHotels(Tour $tour, $fields)
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

    public function isDaily($fields)
    {
        $isDaily = (bool)isset($fields['tour_category']) && ($fields['tour_category'] == 'Daily Tours' || $fields['tour_category'] == 'daily');
        return $isDaily;
    }
}