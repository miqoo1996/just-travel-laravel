@extends('layouts.regular')
@section('bodyStyle')
    pdf
@endsection
@section('content')
    <div class="maincont">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h1><a href="{{url($backUrl)}}">{{trans($backName)}}</a>
                        / {{$gallery['gallery_name_'.app()->getLocale()]}}</h1>
                    @if(!empty($gallery['gallery_desc_'.app()->getLocale()]))
                        <div class="fortfolio-info">{!!$gallery['gallery_desc_'.app()->getLocale()]!!}</div>
                    @endif

                    <div class="main-gallery">
                        @foreach($images as $image)
                            <div class="item">
                                <a href="{{url($image['image_path'])}}" data-lightbox="gallery_trip"><img src="{{'/'.$image['image_path']}}"></a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('css/lightbox.min.css')}}">
@endsection

@section('script')
    <script src="{{asset('js/lightbox-plus-jquery.min.js')}}"></script>
@endsection