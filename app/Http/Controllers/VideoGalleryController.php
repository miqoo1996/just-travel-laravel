<?php

namespace App\Http\Controllers;

use App\VideoGallery;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Validator;

class VideoGalleryController extends Controller
{
    public function adminGetVideoGallery()
    {
        $videos = VideoGallery::all();
        $videos = ($videos->isEmpty())? false : $videos;
        return view('admin.video_gallery', ['videos' => $videos]);
    }

    public function adminGetNewVideo()
    {
        return view('admin.new_video');
    }

    public function adminPostNewVideo(Request $request)
    {
        $rules = [
            'video_url_en' => 'required',
            'video_url_ru' => 'required',
            'video_title_en' => 'required',
            'video_title_ru' => 'required',
        ];
        $this->validate($request, $rules);
        $fields = $request->input();
        if(isset($request->video_id)){
            $video = VideoGallery::find($request->video_id);
        } else {
            $video = new VideoGallery();
        }

        if($request->hasFile('video_thumbnail_en')){
            $image = $request->file('video_thumbnail_en');
            $image_name = uniqid() . config('const.' . $image->getMimeType());
            $image_path = 'images/video_thumbnails/en/' . $image_name;
            $image->move('images/video_thumbnails/en', $image_name);
            $fields['video_thumbnail_en'] = $image_path;
        }

        if($request->hasFile('video_thumbnail_ru')){
            $image = $request->file('video_thumbnail_ru');
            $image_name = uniqid() . config('const.' . $image->getMimeType());
            $image_path = 'images/video_thumbnails/ru/' . $image_name;
            $image->move('images/video_thumbnails/ru', $image_name);
            $fields['video_thumbnail_ru'] = $image_path;
        }

        $video->fill($fields);
        $video->save();
        return redirect()->route('admin-video-gallery');
    }

    public function adminGetEditVideo($video_id)
    {
        $video = VideoGallery::find($video_id);
        return view('admin.edit_video', ['video' => $video]);
    }

    public function getVideoGallery()
    {
        $videos = VideoGallery::all()->toArray();
        return view('video_gallery', compact('videos'));
    }

}
