@extends('layouts.regular')
@section('bodyStyle')
    pdf
@endsection
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
                                    <a data-video="{{$video['embed_'.app()->getLocale()]}}" class="video_player" target="iframe-player" data-toggle="modal" data-target="#video_modal">
                                        <img src="{{App\SimpleImage::image($video['video_thumbnail_'.app()->getLocale()], true)}}"><span
                                                class="play"></span></a>
                                    <h4>{{$video['video_title_'.app()->getLocale()]}}</h4>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade white" id="video_modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-body row text-center">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <iframe src="" frameborder="0"></iframe>
            </div>
        </div>
    </div>
@endsection