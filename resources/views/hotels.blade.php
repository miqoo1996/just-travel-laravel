@extends('layouts.regular')
@section('content')
    <div class="maincont">
        <div class="popular-tours hotels-list">
            <div class="container">
                <h2>{{trans('messages.hotels_in_armenia')}}</h2>

                <!--Tour Itwm-->

                @foreach($hotels as $hotel)
                    <div class="item">
                        <a href="{{url('hotels/'. $hotel['hotel_url'])}}" class="tour-photo">
                            <img src="{{App\SimpleImage::image($hotel['main_image'], true)}}">
                            <span class="tour-title">{{$hotel['hotel_name_'.app()->getLocale()]}}</span>
                        </a>
                        <div class="tour-data">
                            <div class="stars {{config('const.hotel_classes.'.$hotel['type'])}}"></div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection