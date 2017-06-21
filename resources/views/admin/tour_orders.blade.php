@extends('admin.layouts.dashboard_layout')
@yield('css')
<link rel="stylesheet" href="{{asset("vendors/jquery-ui/jquery-ui.css")}}">
<link rel="stylesheet" href="{{asset("css/page_orders.css")}}">

@section('title')
    Pages | JustTravel
@endsection
@section('content')
    <div class="right_col" role="main">
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h1 class="page-header text-center">Tour Orders</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div id="sortables" class="col-md-10 col-md-offset-1 tours">
                    <ul data-ajax="{{route('admin-tour-items-orders')}}" id="sortable-tour" class="col-md-12">
                        @foreach($tours as $tour)
                            @if($tour->isDaily())
                                <li data-page-id="{{ $tour['tour_id'] }}" class="item">
                                    <a href="javascript:void(0)">
                                        <img src="{{App\SimpleImage::image($tour['tour_main_image'], true)}}">
                                        <span class="tour-title">{{$tour['tour_name_en']}}</span>
                                    </a>
                                    <div class="tour-data">
                                        @if($tour['basic_frequency'])
                                            <div class="frequency">
                                                @foreach(config('const.week_days_'.app()->getLocale()) as $wd => $short)
                                                    @if(strpos($tour['basic_frequency'], $wd) !== false)
                                                        <span class="freq-day available">{{$short}}</span>
                                                    @else
                                                        <span class="freq-day">{{$short}}</span>
                                                    @endif
                                                @endforeach
                                            </div>
                                            <div class="price {{$currency['currency']}}"> {{round($tour['basic_price_adult'] / $currency[$currency['currency']], 2)}}</div>
                                        @else
                                            <div class="price {{$currency['currency']}}">{{round($tour['double_adult'] / $currency[$currency['currency']], 2)}}</div>
                                        @endif
                                    </div>
                                </li>
                            @else
                                <li data-page-id="{{ $tour['tour_id'] }}" class="item">
                                    <a href="tours/{{$tour['tour_url']}}" class="tour-photo">
                                        <img src="{{App\SimpleImage::image($tour['tour_main_image'], true)}}">
                                        <span class="tour-title">{{$tour['tour_name_en']}}</span>
                                    </a>
                                    <div class="tour-data">
                                        <div class="tourdate">{{str_replace('/','.',$tour['date'])}}</div>
                                        <div class="price {{$currency['currency']}}">{{round($tour['single_adult'] / $currency[$currency['currency']], 2)}}</div>
                                        <div class="clear"></div>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{asset('vendors/jquery-ui/jquery-ui.js')}}"></script>
    <script src="{{asset('js/page_orders.js')}}"></script>
@endsection