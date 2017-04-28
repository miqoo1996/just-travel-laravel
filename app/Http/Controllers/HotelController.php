<?php

namespace App\Http\Controllers;

use App\Hotel;
use App\Tour;
use App\TourCategory;
use App\TourDay;
use App\TourHolel;
use App\TourHotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

use App\Http\Requests;
use Illuminate\Support\Facades\Storage;

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
        $fields = $request->input();
        $imageChecker = true;

        if(isset($request->hotel_id)){
            $hotel = Hotel::find($request->hotel_id);
            if(null !== $hotel->images) $imageChecker = false;

        } else {
            $hotel = new Hotel();
            $hotel->save();
        }
        $checker = true;

        $fieldsRegions = '';
        foreach (config('regions.fields') as $region){
            if(isset($request->$region)){
                $fieldsRegions .= ($checker)? $region: ','.$region;
                $checker = false;
            }
        }

        $fields['regions'] = $fieldsRegions;
        if($request->hasFile('main_image')){
            $file = $request->file('main_image');
            $file_name = uniqid() .  $file->getClientOriginalName();
            $file->move('images/hotels', $file_name);
            $fields['main_image'] = 'images/hotels/'.$file_name;
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
        $fields['visibility'] = (!isset($fields['visibility']))? 'off': 'on';
        $fields['images'] = $fieldsImages;
        $hotel->fill($fields);
        $hotel->save();
        return ($request->ajax())? route('admin-hotels') : redirect()->route('admin-hotels');
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
