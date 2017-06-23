<?php

namespace App\Http\Controllers;

use App\Gallery;
use App\GalleryPhotos;
use App\SimpleImage;
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
        $oldImg = '';
        if($request->get('gallery_id')){
            $gallery = Gallery::find($request->gallery_id);
            if(!$request->has('gallery')){
                $gallery->gallery = 'off';
            }
            if(!$request->has('portfolio')){
                $gallery->portfolio = 'off';
            }
            $oldImg = $gallery->main_image;
            $gallery->save();

        } else {
            $gallery = new Gallery();
        }

        $gallery->fill($request->input());

        $uniqid = uniqid();
        if($request->hasFile('main_image')){
            $image = $request->file('main_image');
            if (in_array($image->getMimeType(), ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'])) {
                $image_name = $uniqid . config('const.' . $image->getMimeType());
                $image_path = 'images/gallery/main_image/';
                $gallery->main_image = $image_path . $image_name;
            }
        }

        if ($gallery->save()) {
            $delImages = [];
            if (isset($image, $image_path, $image_name)) {
                $delImages[] = $oldImg;
                $image->move($image_path, $image_name);
                SimpleImage::resize($image_path . $image_name, $image_path . 'thumbnail-' . $image_name, 500, 350, 280, 160);
            }

            if($request->hasFile('files')){
                foreach($request->file('files') as $item){
                    $image = $item;
                    if (in_array($image->getMimeType(), ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'])) {
                        $uniqid = uniqid();
                        $image_name = $uniqid . config('const.' . $image->getMimeType());
                        $image_path = 'images/gallery/' . $gallery->id. '/content/' . $image_name;
                        $image->move('images/gallery/'. $gallery->id .'/content', $image_name);
                        $images['image_name'] = $image_name;
                        $images['image_path'] = $image_path;
                        $images['gallery_id'] = $gallery->id;
                        $data[] = $images;
                        SimpleImage::resize($image_path, 'images/gallery/' . $gallery->id. '/content/thumbnail-' . $image_name, 570, 326, 280, 160);
                    }
                }
            }

            if (isset($data)) GalleryPhotos::insert($data);
            SimpleImage::deleteImages($delImages);
            return redirect()->route('admin-get-galleries');
        }

        $gallery['images'] = $gallery->images();
        return view('admin.edit_gallery', ['gallery' => $gallery, 'errors' => $gallery->getValidator()->errors()]);
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
        $model = new Gallery();
        $galleries = $model->getImages(true, ['portfolio', 'on']);
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
