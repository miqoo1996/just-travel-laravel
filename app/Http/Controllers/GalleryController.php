<?php

namespace App\Http\Controllers;

use App\Gallery;
use App\GalleryPhotos;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function adminGetGalleries()
    {
        $galleries = Gallery::all();
        return view('admin.galleries', ['galleries' => $galleries]);
    }

    public function adminGetNewGallery()
    {
        return view('admin.new_gallery');
    }

    public function adminPostNewGallery(Request $request)
    {
        if(isset($request->gallery_id)){
            $gallery = Gallery::find($request->gallery_id);
            if(!$request->has('gallery')){
                $gallery->gallery = 'off';
            }
            if(!$request->has('portfolio')){
                $gallery->portfolio = 'off';
            }
            $gallery->fill($request->input());
            $gallery->save();
        } else {
            $gallery = new Gallery();
            $gallery->fill($request->input());
            $gallery->save();
        }

        if($request->hasFile('main_image')){
                $image = $request->file('main_image');
                $image_name = uniqid() . config('const.' . $image->getMimeType());
                $image_path = 'images/gallery/' . $gallery->id. '/' . $image_name;
                $image->move('images/gallery/'. $gallery->id, $image_name);
                $gallery->main_image = $image_path;
        }
        $gallery->fill($request->input());
        if(isset($image_path)) $gallery->main_image = $image_path;
        $gallery->save();
        if($request->hasFile('files')){
            foreach($request->file('files') as $item){
                $image = $item;
                $image_name = uniqid() . config('const.' . $image->getMimeType());
                $image_path = 'images/gallery/' . $gallery->id. '/content/' . $image_name;
                $image->move('images/gallery/'. $gallery->id .'/content', $image_name);
                $images['image_name'] = $image_name;
                $images['image_path'] = $image_path;
                $images['gallery_id'] = $gallery->id;
                $data[] = $images;
            }
        }



        if (isset($data)) GalleryPhotos::insert($data);
        return redirect()->route('admin-get-galleries');
    }

    public function adminGetEditGallery($gallery_id)
    {
        $gallery = Gallery::find($gallery_id);
        $gallery['images'] = $gallery->images();
        return view('admin.edit_gallery', ['gallery' => $gallery]);
    }

    public function getGalleries()
    {
        $model = new Gallery();
        $galleries = $model->getImages(true, ['gallery', 'on']);
        $type = 'gallery';
        return view('galleries', compact('galleries', 'type'));
    }

    public function getPortfolios()
    {
        $galleries = Gallery::where('portfolio', 'on')->get()->toArray();
        $type = 'portfolio';
        return view('galleries', compact('galleries', 'type'));
    }

    public function getGalleryByUrl($url)
    {
        $gallery = Gallery::where('gallery', 'on')->where('gallery_url', $url)->first();
        if(null !== $gallery){
            $gallery = $gallery->toArray();
            $images = GalleryPhotos::where('gallery_id', $gallery['id'])->get()->toArray();
            $backUrl = '/galleries';
            $backName= 'photo_gallery';
            return view('gallery_details', compact('images', 'backUrl', 'backName', 'gallery'));
        }
        return view('errors.404');
    }

    public function getPortfolioByUrl($url)
    {
        $gallery = Gallery::where('portfolio', 'on')->where('gallery_url', $url)->first();
        if(null !== $gallery){
            $gallery = $gallery->toArray();
            $images = GalleryPhotos::where('gallery_id', $gallery['id'])->get()->toArray();
            $backUrl = '/portfolio';
            $backName= 'portfolio';
            return view('gallery_details', compact('images', 'backUrl', 'backName', 'gallery'));
        }
        return view('errors.404');
    }
}
