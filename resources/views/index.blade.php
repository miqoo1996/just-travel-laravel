@extends('layouts.basic')
@section('carousel')
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Wrapper for slides -->
        @if(count($hotTours) > 1)
            <!-- Indicators -->
            <ol class="carousel-indicators">
                @foreach($hotTours as $key => $hotTour)
                    <li data-target="#myCarousel" data-slide-to="{{$key}}" class="@if($key == 0) active @endif"></li>
                @endforeach
            </ol>
        @endif
        @if(count($hotTours))
            <div class="carousel-inner" role="listbox">
                @foreach($hotTours as $key => $hotTour)
                    <div class="item @if($key == 0) active @endif"
                         style="background:url({{asset($hotTour['hot_image'])}}) top center no-repeat; ">
                        <div class="hottour">
                            <h1>{{$hotTour['tour_name_'.app()->getLocale()]}}</h1>
                            <div class="hotdescr">{{$hotTour['short_desc_'.app()->getLocale()]}}</div>
                            <a class="more"
                               href="{{url('tours/'.$hotTour['tour_url'])}}">{{trans('messages.im_interested_in')}}</a>
                        </div>
                        <div class="header-overlay"></div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="filter-search">
            <div class="container search-cont">
                <div class="row">
                    <form id="tour_search_index">
                        <div class="input-daterange">
                            <div class="col-md-2 col-sm-6 col-xs-12 filteritem input-daterange">
                                <input type="text" id="date_start" class="input-sm form-control datepicker" name="start"
                                       placeholder="{{trans('messages.date_from')}}">
                            </div>
                            <div class="col-md-2 col-sm-6 col-xs-12 filteritem input-daterange">
                                <input type="text" id="date_end" class="input-sm form-control datepicker" name="end"
                                       placeholder="{{trans('messages.date_to')}}">
                            </div>
                        </div>
                        <div class="col-md-2 col-sm-6 col-xs-12 filteritem">
                            <div class="customselect">
                                <select name="tour_category" class="form-control" id="tour_category_selector">
                                    <option value="">{{trans('messages.all_categories')}}</option>
                                    @foreach($tourCategories as $tc)
                                        <option value="{{$tc['id'].'/'.$tc['property']}}">{{$tc['category_name_'.app()->getLocale()]}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12 filteritem searchfield">
                            <input class="search-field" type="text"
                                   placeholder="{{trans('messages.search_by_keywords')}}" name="tags" id="tags">
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-12 filteritem">
                            <input type="button" class="btn btn-warning" id="search_tours"
                                   value="{{trans('messages.search')}}">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if(count($hotTours) > 1)
            <!-- Left and right controls -->
            <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        @endif
    </div>
@endsection

@section('content')
    <div class="maincont">
        <div class="navbar navbar-default">
            <a href="{{url('/')}}" class="logo-element"></a>
            <!-- /.container-fluid -->
        </div>
        @if(count($tourCategories))
            <div class="mp-categories fixme">
                <div class="container">
                    <ul>
                        @foreach($tourCategories as $tc)
                            @if(isset($indexTours[0]['cat_id']) && $indexTours[0]['cat_id'] == $tc['id'])
                                <li class="active" id="cat_list_{{$currentCatId}}">
                            @else
                                <li id="cat_list_{{$currentCatId}}">
                                    @endif
                                    <a id="{{'x_cat/' . $tc['id']}}"
                                       class="tc-viewer {{strtolower(str_replace(' ', '_', trim($tc['category_name_en'])))}}">{{$tc['category_name_'.app()->getLocale()]}}</a>
                                </li>

                                @endforeach
                                <div class="clear"></div>
                    </ul>

                </div>
            </div>
        @endif
        @if($indexTours)
            <div class="popular-tours" id="tours_area">
                <div class="container">
                    <h2>{{$tourCategories->find($currentCatId)['category_name_'.app()->getLocale()]}}</h2>
                    <!--Tour Itwm-->
                    @foreach($indexTours as $tour)
                        @if($currentCatId == 1)
                            <div class="item">
                                <a href="tours/{{$tour['tour_url']}}" class="tour-photo">
                                    <img src="{{asset(isset($tour['tour_main_image']) ? $tour['tour_main_image'] : '/images/no_image.png')}}">
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
                                    <div class="price {{$currency['currency']}}"> {{round($tour['basic_price_adult'] / $currency[$currency['currency']], 2)}}</div>
                                </div>
                            </div>
                        @else
                            <div class="item">
                                <a href="tours/{{$tour['tour_url']}}" class="tour-photo">
                                    <img src="{{asset(isset($tour['tour_main_image']) ? $tour['tour_main_image'] : '/images/no_image.png')}}">
                                    <span class="tour-title">{{$tour['tour_name_'.app()->getLocale()]}}</span>
                                </a>
                                <div class="tour-data">
                                    <div class="tourdate">{{str_replace('/','.',$tour['date'])}}</div>
                                    <div class="price {{$currency['currency']}}">{{round($tour['double_adult'] / $currency[$currency['currency']], 2)}}</div>
                                    <div class="clear"></div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
        @if(count($topHotels))
            <div class="popular-tours hotels">
                <div class="container">
                    <h2>{{trans('messages.top_hotels_in_armenia')}}</h2>
                @foreach($topHotels as $hotel)
                    <!--Tour Itwm-->
                        <div class="item">
                            <a href="{{url('/hotels/'.$hotel['hotel_url'])}}" class="tour-photo">
                                <img src="{{asset(isset($hotel['hotel_main_image']) ? $hotel['hotel_main_image'] : '/images/no_image.png')}}">
                                <span class="tour-title">{{$hotel['hotel_name_'.app()->getLocale()]}}</span>
                            </a>
                            <div class="tour-data">
                                <div class="stars {{config('const.hotel_classes.'.$hotel['type'])}}"></div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
@endsection
@section('script')
    <script>
        $('.input-daterange').datepicker({
            format: "dd/mm/yyyy",
            startDate: "+3d",
            maxViewMode: 0,
            weekStart: 1,
            language: "{{app()->getLocale()}}",
            multidate: false
        });
       setTimeZone();
    </script>
    <link rel="stylesheet" href="{{asset("vendors/easy_autocomplete/easy-autocomplete.css")}}">
    <script src="{{asset("vendors/easy_autocomplete/jquery.easy-autocomplete.js")}}"></script>
    <script src="{{asset('/js/autofill.js')}}"></script>
@endsection
