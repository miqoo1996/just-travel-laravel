@extends('layouts.regular')
@section('bodyStyle')
    page-tours-details
@endsection
@section('content')
    <div class="maincont whitebg">
        <div class="container hotel-details">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 tour-details-image">
                    <img src="{{App\SimpleImage::image($hotel['hotel_main_image'], true)}}">
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <h1>{{$hotel['hotel_name_'.app()->getLocale()]}}</h1>
                    <div class="tour-data">
                        <div class="stars {{config('const.hotel_classes.'.$hotel['type'])}}"></div>
                    </div>
                    <div class="clear"></div>
                    <div class="tour-description">
                        <h3>{{trans('messages.hotel_description')}}</h3>
                        <p>
                            {!!$hotel['desc_'.app()->getLocale()]!!}
                        </p>
                    </div>
                </div>
            </div>
        </div>


        <div class="greybg gallery-container">
            <div class="container">
                <h1>{{trans('messages.gallery')}}</h1>
                @foreach($hotel['images'] as $image)
                    <div class="item">
                        <a href="{{App\SimpleImage::image(trim($image) ? '/'.$image : '-', true)}}" data-lightbox="gallery_trip"><img src="{{App\SimpleImage::image(trim($image) ? '/'.$image : '-', true)}}"alt="Tour Name"></a>
                    </div>
                @endforeach
            </div>
        </div>
        @include('includes.hot_tours')
    </div>
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('css/lightbox.min.css')}}">
@endsection

@section('script')
    <script src="{{asset('js/lightbox-plus-jquery.min.js')}}"></script>
@endsection
