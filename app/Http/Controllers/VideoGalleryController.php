<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Traits\VideoGalleryTrait;
use App\SimpleImage;
use App\VideoGallery;
use Illuminate\Http\Request;

class VideoGalleryController extends Controller
{
    use VideoGalleryTrait;

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

    public static function videoUrlOptimize($fields)
    {
        $change = [
            'embed_en' => 'video_url_en',
            'embed_ru' => 'video_url_ru'
        ];
        foreach ($change as $key => $item){
            $video = explode('watch?v=', $fields[$item]);
            $fields[$key] = count($video) > 1 ? $video[0]. 'embed/' . $video[1] : $video[0];
        }
       return $fields;
    }
    public function adminPostNewVideo(Request $request)
    {
        if($request->get('video_id')){
            $video = VideoGallery::find($request->get('video_id'));
            SimpleImage::setModel(clone $video);
            $video->scenario = 'update';
        } else {
            $video = new VideoGallery();
            $video->scenario = 'insert';
        }

        if ($fields = $request->input()) {
            $fields = self::videoUrlOptimize($fields);
            $this->setFile($request, $fields, 'video_thumbnail_en');
            $this->setFile($request, $fields, 'video_thumbnail_ru');
            $video->fill($fields);
        }

        if ($video->save()) {
            $this->setFile($request, $fields, 'video_thumbnail_en', true);
            $this->setFile($request, $fields, 'video_thumbnail_ru', true);
            return redirect()->route('admin-video-gallery');
        }

        return view('admin.edit_video', ['video' => $video, 'errors' => $video->getValidator()->errors()]);
    }

    public function adminGetEditVideo($video_id)
    {
        $video = VideoGallery::find($video_id);
        return view('admin.edit_video', ['video' => $video]);
    }

    public function getVideoGallery()
    {
        $model = new VideoGallery();
        $videos = $model->getVideos(true);
        return view('video_gallery', compact('videos'));
    }

    public function adminVideoOrders()
    {
        $model = new VideoGallery();
        $videos = $model->getVideos(true);
        return view('admin.video_orders', compact('videos'));
    }

    public function adminVideoOrdersSave(Request $request)
    {
        $model = new VideoGallery();
        $items = $request->get('items');
        $model->saveData($items);
    }

}
