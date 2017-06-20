@extends('layouts.regular')
@section('bodyStyle')
    pdf
@endsection
@section('content')
    <div class="maincont">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h1>{{trans('messages.' . $type)}}</h1>
                    @if(count($galleries))
                        <div class="main-gallery">
                            @foreach($galleries as $gallery)
                                <div class="item">
                                    <a href="{{url($type . '/' .$gallery['gallery_url'])}}">
                                        <img src="{{App\SimpleImage::image($gallery['main_image'], true)}}"></a>
                                    <h4>{{$gallery['gallery_name_' . app()->getLocale()]}}</h4>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection