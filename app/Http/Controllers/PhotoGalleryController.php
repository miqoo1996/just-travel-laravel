<?php

namespace App\Http\Controllers;

use App\PhotoGallery;
use Illuminate\Http\Request;

class PhotoGalleryController extends Controller
{
    public function adminGetPhotoGallery()
    {
        $images = PhotoGallery::all();
        $images = ($images->isEmpty())? false: $images;
        return view('admin.photo_gallery', ['images' => $images]);
    }

    public function adminPostPhotoGallery(Request $request)
    {
        if($request->hasFile('files')){
            foreach($request->file('files') as $item){
                $image = $item;
                $image_name = uniqid() . config('const.' . $image->getMimeType());
                $image_path = 'images/photo_gallery/' . $image_name;
                $image->move('images/photo_gallery', $image_name);
                $images['image_name'] = $image_name;
                $images['image_path'] = $image_path;
                $data[] = $images;
            }
        }

        if (isset($data)) PhotoGallery::insert($data);
        return redirect()->back();
    }

    public function adminPhotoOrders()
    {
        return view('admin.photo_orders', []);
    }

}
