<?php

namespace App\Http\Controllers;

use App\Gallery;
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

    public function adminPhotoGalleryOrders()
    {
        $model = new Gallery();
        $images = $model->getImages(true, ['gallery', 'on']);
        $title = 'Photo Gallery';
        return view('admin.photo_orders', compact('images', 'title'));
    }

    public function adminPortfolioOrders()
    {
        $model = new Gallery();
        $images = $model->getImages(true, ['portfolio', 'on']);
        $title = 'Portfolio';
        return view('admin.photo_orders', compact('images', 'title'));
    }

    public function adminPhotoOrdersSave(Request $request)
    {
        $model = new Gallery();
        $items = $request->get('items');
        $model->saveData($items);
    }

}
