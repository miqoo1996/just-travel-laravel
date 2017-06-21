<?php

namespace App\Http\Controllers;

use App\Hotel;
use App\Http\Controllers\Traits\HotelTrait;
use App\SimpleImage;
use App\TourDay;
use App\TourHolel;
use Illuminate\Http\Request;

class HotelController extends Controller
{
    use HotelTrait;

    public function adminGetHotels()
    {
        $hotels = Hotel::all();
        return view('admin.hotels', ['hotels' => $hotels]);
    }

    public function adminGetNewHotel()
    {
        return view('admin.new_hotel');
    }

    /**
     * @param Request $request
     *
     * creating new hotel
     */

    public function adminPostNewHotel(Request $request)
    {
        $imageChecker = true;
        if($request->get('hotel_id')){
            $hotel = Hotel::find($request->get('hotel_id'));
            SimpleImage::setModel(clone $hotel);
            if(null !== $hotel->images) $imageChecker = false;
        } else {
            $hotel = new Hotel();
        }

        $checker = true;
        $fieldsRegions = '';
        foreach (config('regions.fields') as $region){
            if(isset($request->$region)){
                $fieldsRegions .= ($checker)? $region: ','.$region;
                $checker = false;
            }
        }

        $images = [];

        if ($fields = $request->input()) {
            $fields['visibility'] = $request->get('visibility', 'off');
            $fields['regions'] = $fieldsRegions;

            $this->setFile($request, $fields, 'images/hotels/hotel_main_image/', 'hotel_main_image');

            $fieldsImages = $hotel->images;
            if($request->hasFile('files')){
                foreach($request->file('files') as $key => $item){
                    if (in_array($item->getMimeType(), ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'])) {
                        $imageName = uniqid();
                        $images[$key] = isset($images[$key]) ? $images[$key] : $imageName . config('const.' . $item->getMimeType());
                        $image_name = $images[$key];
                        $fieldsImages .=  ($imageChecker)? 'images/hotels/'.$image_name: ',images/hotels/'.$image_name;
                        $imageChecker = false;
                    }
                }
            }
            $fields['images'] = $fieldsImages;

            $hotel->fill($fields);
        }

        if ($hotel->save()) {
            $this->setFile($request, $fields, 'images/hotels/hotel_main_image/', 'hotel_main_image', true);
            if($request->hasFile('files')){
                foreach($request->file('files') as $key => $item){
                    if (in_array($item->getMimeType(), ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'])) {
                        if (isset($image_name)) {
                            $imageName = uniqid();
                            $images[$key] = isset($images[$key]) ? $images[$key] : $imageName . config('const.' . $item->getMimeType());
                            $image_name = $images[$key];
                            $item->move('images/hotels', $image_name);
                            SimpleImage::resize('images/hotels/' . $image_name, 'images/hotels/thumbnail-' . $image_name, 848, 488, 450, 257);
                        }
                    }
                }
            }
            return ($request->ajax())? route('admin-hotels') : redirect()->route('admin-hotels');
        }
        if (!$request->ajax()) {
            $hotel['images'] = explode(',', $hotel->images);
            $hotel['regions'] = isset($fields['regions']) && !empty($fields['regions']) ? array_flip(explode(',', $fields['regions'])) : [];
            return view('admin.edit_hotel', ['hotel' => $hotel, 'errors' => $hotel->getValidator()->errors()]);
        }
    }

    public function adminGetEditHotel($hotel_id)
    {
        $hotel = Hotel::find($hotel_id);
        $hotel['regions'] = array_flip(explode(',', $hotel->regions));
        $hotel['images'] = explode(',', $hotel->images);

        return view('admin.edit_hotel', ['hotel' => $hotel]);
    }

    public function getHotels()
    {
        $hotels = Hotel::all()->toArray();
        return view('hotels', compact('hotels'));
    }

    public function getHotelByUrl($hotel_url)
    {
        $hotel = Hotel::where('hotel_url', $hotel_url)->first();
            if(null == $hotel){
            return view('errors.404');
            }
            $hotel = $hotel->toArray();
            $hotel['images'] = explode(',', $hotel['images']);
        return view('hotel_details', compact('hotel', 'hotTours'));
    }
}
