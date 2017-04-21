@extends('layouts.regular')
@section('content')
    <div class="maincont">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h1>{{trans('messages.video_gallery')}}</h1>
                    <div class="main-gallery">
                        @if(count($videos))
                            @foreach($videos as $video)
                                <div class="item">
                                    <a href="{{$video['video_url_'.app()->getLocale()]}}" target="iframe-player">
                                        <img src="{{$video['video_thumbnail_'.app()->getLocale()]}}"><span class="play"></span></a>
                                    <h4>{{$video['video_title_'.app()->getLocale()]}}</h4>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <iframe frameborder="0" name="iframe-player"></iframe>
@endsection