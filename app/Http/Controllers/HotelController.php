<?php

namespace App\Http\Controllers;

use App\Hotel;
use App\TourDay;
use App\TourHolel;
use Illuminate\Http\Request;
use App\Http\Requests;

class HotelController extends Controller
{

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

        $fields['visibility'] = !isset($fields['visibility']) ? 'off': 'on';

        if ($fields = $request->input()) {
            $fields['regions'] = $fieldsRegions;
            $hotel->fill($fields);
        }

        if ($hotel->save()) {
            if($request->hasFile('hotel_main_image')){
                $file = $request->file('hotel_main_image');
                $file_name = uniqid() .  $file->getClientOriginalName();
                $file->move('images/hotels', $file_name);
                $fields['hotel_main_image'] = 'images/hotels/'.$file_name;
            }
            $fieldsImages = $hotel->images;

            if($request->hasFile('files')){
                foreach($request->file('files') as $item){
                    $image = $item;
                    $image_name = uniqid() . config('const.' . $image->getMimeType());
                    $image->move('images/hotels', $image_name);
                    $fieldsImages .=  ($imageChecker)? 'images/hotels/'.$image_name: ',images/hotels/'.$image_name;
                    $imageChecker = false;
                }
            }
            $fields['images'] = $fieldsImages;
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
