@extends('layouts.regular')
@section('bodyStyle')
    page-tours-details
@endsection
@section('content')
    <div class="maincont whitebg">
        <div class="container tour-details">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 tour-details-image">
                    <img src="{{asset(isset($tour['tour_main_image']) ? $tour['tour_main_image'] : '/images/no_image.png')}}">
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <h1>{{$tour['tour_name_'.app()->getLocale()]}}</h1>
                    <span class="tour-id">{{trans('messages.tour_code')}}: {{$tour['code']}}</span>
                    <span class="price {{$currency['currency']}}">
            	        <span class="{{$currency['currency']}}">{{round($tour['basic_price_adult']/$currency[$currency['currency']] * 2, 2) }}</span>
                        <span class="othercurrency">
                            @foreach($currency  as $key => $value)
                                @if(($key !== 'currency') && ($key !== $currency['currency']))
                                    <span class="{{$key}}">{{round($tour['basic_price_adult']/$value * 2, 2)}}</span>
                                @endif
                            @endforeach
                        </span>

                    </span>
                    <div class="clearfix"></div>
                    <div class="pricebyperson">
                        <span class="item"><span class="{{$currency['currency']}}">{{round($tour['basic_price_adult']/$currency[$currency['currency']], 2)}}</span>{{trans('messages.adults')}} (12-99)</span>
                        <span class="item"><span class="{{$currency['currency']}}">{{round($tour['basic_price_child']/$currency[$currency['currency']], 2)}}</span>{{trans('messages.children')}} (4-11)</span>
                        <span class="item"><span class="{{$currency['currency']}}">{{round($tour['basic_price_infant']/$currency[$currency['currency']], 2)}}</span>{{trans('messages.infants')}} (0-4)</span>
                    </div>
                    <h3 class="frequency">Frequency</h3>
                    <div class="frequency">
                        @foreach(config('const.week_days_'.app()->getLocale()) as $wd => $short)
                            @if(strpos($tour['basic_frequency'], $wd) !== false)
                                <span class="freq-day available">{{$short}}</span>
                            @else
                                <span class="freq-day">{{$short}}</span>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>


        <div class="container">
            <div class="filter-search filter-details">
                <form method="post" action="{{url('/order_tour')}}">
                    <div class="row" id="custom_deatils_search">
                        <div class="col-md-2 col-sm-6 col-xs-12">
                            <label for="example-text-input" class="col-form-label">{{trans('messages.date')}}</label>
                            <input class="datepicker" type="text" id="date_from"
                                   placeholder="{{trans('messages.date_from')}}" name="date_from">
                        </div>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                            <label for="example-text-input" class="col-form-label">{{trans('messages.adults')}}
                                (12-99)</label>
                            <input class="" type="number" name="adults_count" id="adult" placeholder="" value="2">
                        </div>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                            <label for="example-text-input" class="col-form-label">{{trans('messages.children')}}
                                (5-11)</label>
                            <input class="" type="number" name="children_count" id="child" placeholder="">
                        </div>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                            <label for="example-text-input" class="col-form-label">{{trans('messages.infants')}}
                                (0-4)</label>
                            <input class="" type="number" name="infants_count" id="infant" placeholder="">
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <label for="example-text-input" class="col-form-label">&nbsp;</label>
                            <input type="hidden" id="tour_id" name="tour_id" value="{{$tour['tour_id']}}">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <input type="submit" value="Book">
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <div class="container tour-description-container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h3>{{trans('messages.tour_description')}}</h3>
                    <div class="tour-description">
                        <p>
                            {!! $tour['desc_'. app()->getLocale()] !!}
                        </p>
                    </div>
                </div>
            </div>
        </div>

        @if(!empty($tour['tour_images']))
        <div class="greybg gallery-container">
            <div class="container">
                <h1>{{trans('messages.gallery')}}</h1>
                @foreach($tour['tour_images'] as $image)
                    <div class="item">
                        <a href="{{url($image)}}" data-lightbox="gallery_trip">
                            <img src="{{'/'.$image}}" alt="{{$tour['tour_name_' . app()->getLocale()]}}" width="300" height="190">
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
        @endif
        @include('includes.hot_tours')
    </div>
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('css/lightbox.min.css')}}">
@endsection

@section('script')
    <script type="text/javascript">
        $('.datepicker').datepicker({
            startDate: '+3d',
            daysOfWeekDisabled: "{{$daysOfWeekDisabled}}",
            weekStart: 1,
            format: 'dd/mm/yyyy',
            datesDisabled: [
                @foreach($datesDisabled as $day)
                "{{$day}}" ,
                @endforeach
            ]
        })
    </script>
    <script src="{{asset('js/lightbox.min.js')}}"></script>

@endsection
