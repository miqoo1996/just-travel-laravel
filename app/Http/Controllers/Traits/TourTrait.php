<?php

namespace App\Http\Controllers\Traits;

use App\SimpleImage;
use App\Tour;
use App\Hotel;
use App\TourCategory;
use App\TourHotel;
use Illuminate\Http\Request;

trait TourTrait
{
    private $images = [];
    private $imageName = '';

    public function __construct()
    {
        $this->imageName = uniqid();
    }

    public function getEditTour(Tour $tour)
    {
        $tour['tour_images'] = explode(',', $tour->tour_images);
        $tour['tour_dates'] = Tour::rewriteDates($tour->adminTourDates()->get()->pluck('date'));
        $data['tour_categories'] = TourCategory::all();
        $data['hotels'] = Hotel::select('hotel_name_en', 'id')->get();
        $basic_frequency = [];
        if (is_array($tour->basic_frequency)) {
            $basic_frequency = array_flip($tour->basic_frequency);
        } elseif ($tour->basic_frequency) {
            $basic_frequency = array_flip(explode(',', $tour->basic_frequency));
        }
        $tour['basic_frequency'] = $basic_frequency;
        if ($tour->id) {
            $data['tourHotels'] = TourHotel::where('tour_id', $tour->id)->get();
        }
        if (isset($data['tourHotels']) && !count($data['tourHotels'])) {
            $hotel['hotel_id'] = null;
            $hotel['tour_id'] = isset($tour->id) ? $tour->id : null;
            $hotel['single_adult'] = 0;
            $hotel['double_adult'] = 0;
            $hotel['triple_adult'] = 0;
            $hotel['child'] = 0;
            $hotel['infant'] = 0;
            $data['tourHotels'] = [$hotel];
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
        $tour->tour_category = isset($fields['tour_category']) ? $fields['tour_category'] : null;
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
        $images = [];
        if ($_file == 'tour_images') {
            if ($request->hasFile('tour_images')) {
//                if ($move) {
//                    if (strpos(',', SimpleImage::$model->tour_images) !== false) {
//                        $images += explode(',', SimpleImage::$model->tour_images);
//                    } else {
//                        $images[] = SimpleImage::$model->tour_images;
//                    }
//                }
                $fieldsImages = $request->get('tour_images');
                $imageChecker = $fieldsImages == '' ? true : false;
                foreach ($request->file('tour_images') as $key => $item) {
                    $image = $item;
                    if (null !== $image && in_array($item->getMimeType(), ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'])) {
                        $this->imageName = uniqid();
                        $this->images[$key] = isset($this->images[$key]) ? $this->images[$key] : $this->imageName  . config('const.' . $item->getMimeType());
                        $image_name = $this->images[$key];
                        if ($move) {
                            $image->move($imagePathName, $image_name);
                            SimpleImage::resize($imagePathName . $image_name, $imagePathName . 'thumbnail-' . $image_name, 754, 481, 280, 190);
                        }
                        $fieldsImages .= $imageChecker ? $imagePathName . $image_name : ',' . $imagePathName . $image_name;
                        $imageChecker = false;
                    }
                }
                $fields['tour_images'] = $fieldsImages;
            }
        } elseif ($request->hasFile($_file)) {
            $file = $request->file($_file);
            if (in_array($file->getMimeType(), ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'])) {
                $this->imageName = uniqid();
                $this->images[$_file] = isset($this->images[$_file]) ? $this->images[$_file] : $this->imageName . config('const.' . $file->getMimeType());
                $file_name = $this->images[$_file];
                if ($move) {
                    if (isset(SimpleImage::$model->$_file)) {
                        $images[] = SimpleImage::$model->$_file;
                    }
                    $file->move($imagePathName, $file_name);
                    if ($_file == 'hot_image') {
                        SimpleImage::setImages([
                            [
                                'path' => $imagePathName . 'slide-' . $file_name,
                                'width' => 1676,
                                'height' => 550
                            ]
                        ]);
                    }
                    SimpleImage::resize($imagePathName . $file_name, $imagePathName . 'thumbnail-' . $file_name, 570, 326, 450, 257);
                }
                $fields[$_file] = $imagePathName . $file_name;
            }
        }
        SimpleImage::deleteImages($images);
        return isset($fields[$_file]) ? $fields[$_file] : null;
    }

    public function isDaily($fields)
    {
        $isDaily = (bool)isset($fields['tour_category']) && ($fields['tour_category'] == 'Daily Tours' || $fields['tour_category'] == 'daily');
        return $isDaily;
    }

    public function makeDirectory($path)
    {
        $tourImagesPathName = $path . '/tour_images/';
        $mainImagePathName = $path . '/main_image/';
        $hotImagePathName = $path . '/hot_image/';

        if (!is_dir($path)) {
            mkdir($path);
        }
        if (!is_dir($tourImagesPathName)) {
            mkdir($tourImagesPathName);
        }
        if (!is_dir($mainImagePathName)) {
            mkdir($mainImagePathName);
        }
        if (!is_dir($hotImagePathName)) {
            mkdir($hotImagePathName);
        }
    }

}