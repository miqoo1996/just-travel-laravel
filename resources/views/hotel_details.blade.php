@extends('layouts.regular')
@section('content')
    <div class="maincont whitebg">
        <div class="container hotel-details">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 tour-details-image">
                    <img src="{{asset($hotel['main_image'])}}">
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
                            {{$hotel['desc_'.app()->getLocale()]}}
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
                        <a href="#"><img src="{{'/'.$image}}" alt="Tour Name" width="300" height="190"></a>
                    </div>
                @endforeach
            </div>
        </div>


        <div class="popular-tours hotels">
            <div class="container">
                <h2>{{trans('messages.hot_tours')}}</h2>

                @foreach($hotTours as $tour)
                    @if(null !== $tour['basic_frequency'])
                        <div class="item">
                            <a href="{{url('tours/'.$tour['tour_url'])}}" class="tour-photo">
                                <img src="{{asset($tour['main_image'])}}">
                                <span class="tour-title">{{$tour['tour_name_'.app()->getLocale()]}}</span>
                            </a>
                            <div class="tour-data">
                                <div class="frequency">
                                    @foreach(config('const.week_days_'.app()->getLocale()) as $wd => $short)
                                        @if(strpos($tour['basic_frequency'], $wd) !== false)
                                            <span class="freq-day available">{{$short}}</span>
                                        @else
                                            <span class="freq-day">{{$short}}</span>
                                        @endif
                                    @endforeach
                                </div>
                                <div class="price {{$currency['currency']}}">{{round($tour['basic_price_adult'] / $currency[$currency['currency']], 2)}}</div>
                            </div>
                        </div>
                    @else
                        <div class="item">
                            <a href="{{url('tours/'.$tour['tour_url'])}}" class="tour-photo">
                                <img src="{{asset($tour['main_image'])}}">
                                <span class="tour-title">{{$tour['tour_name_'.app()->getLocale()]}}</span>
                            </a>
                            <div class="tour-data">
                                <div class="tourdate">{{str_replace('/','.',$tour['date'])}}</div>
                                <div class="price {{$currency['currency']}}">{{round($tour['single_adult'] / $currency[$currency['currency']], 2)}}</div>
                                <div class="clear"></div>
                            </div>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection