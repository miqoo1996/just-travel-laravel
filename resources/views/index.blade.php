@extends('layouts.basic')
@section('carousel')
    <div id="myCarousel" class="carousel slide" data-ride="carousel">
        <!-- Indicators -->
        <ol class="carousel-indicators">
            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
            <li data-target="#myCarousel" data-slide-to="1"></li>
            <li data-target="#myCarousel" data-slide-to="2"></li>
        </ol>

        <!-- Wrapper for slides -->
        @if(count($hotTours))
            <div class="carousel-inner" role="listbox">
                @foreach($hotTours as $key => $hotTour)
                    <div class="item @if($key == 0) active @endif"
                         style="background:url({{asset($hotTour['hot_image'])}}) top center no-repeat; ">
                        <div class="hottour">
                            <h1>{{$hotTour['tour_name_'.app()->getLocale()]}}</h1>
                            <h3>{{$hotTour['short_desc_'.app()->getLocale()]}}</h3>
                            <a class="more" href="#">{{trans('messages.im_interested_in')}}</a>
                        </div>
                        <div class="header-overlay"></div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="filter-search">
            <div class="container search-cont">
                <div class="row">
                    <form>
                        <div class="col-md-2 col-sm-6 col-xs-12 filteritem">
                            <input class="datepicker" type="text" placeholder="Date from">
                        </div>
                        <div class="col-md-2 col-sm-6 col-xs-12 filteritem">
                            <input class="datepicker" type="text" placeholder="Date from">
                        </div>
                        <div class="col-md-2 col-sm-6 col-xs-12 filteritem">
                            <div class="dropdown">
                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                                    English
                                    <span class="caret"></span></button>
                                <ul class="dropdown-menu">
                                    <li><a href="#">Excursion tours</a></li>
                                    <li class="active"><a href="#">Daily tours</a></li>
                                    <li><a href="#">Holiday tours</a></li>
                                    <li><a href="#">Ski tours</a></li>
                                    <li><a href="#">Health & SPA tours</a></li>
                                    <li><a href="#">Hot tours</a></li>
                                    <li><a href="#">Gastronomic tours</a></li>
                                    <li><a href="#">Cultural tours</a></li>
                                    <li><a href="#">Active holidays</a></li>
                                    <li><a href="#">Religious tours</a></li>
                                    <li><a href="#">Children tours</a></li>
                                    <li><a href="#">Wedding tours</a></li>
                                    <li><a href="#">Family tours</a></li>
                                    <li><a href="#">VIP tours</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-12 filteritem">
                            <input class="search-field" type="text" placeholder="Search by keywords">
                        </div>
                        <div class="col-md-2 col-sm-12 col-xs-12 filteritem">
                            <input type="submit" value="Search">
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>
        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>
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
                            @if($indexTours['tourCategory']['id'] == $tc['id'])
                                <li class="active" id="cat_list_{{$indexTours['tourCategory']['id']}}">
                            @else
                                <li id="cat_list_{{$indexTours['tourCategory']['id']}}">
                                    @endif
                                    <a id="{{'x_cat/' . $tc['id']}}"
                                       class="tc-viewer {{strtolower(str_replace(' ', '_', $tc['category_name_en']))}}">{{$tc['category_name_'.$locale]}}</a>
                                </li>
                                @endforeach
                    </ul>
                </div>
            </div>
        @endif
        @if($indexTours)
            <div class="popular-tours" id="tours_area">
                <div class="container">
                    <h2>{{$indexTours['tourCategory']['category_name_'.app()->getLocale()]}}</h2>
                    <!--Tour Itwm-->
                    @foreach($indexTours['tours'] as $tour)
                        @if($indexTours['tourCategory']['property'] == 'basic')
                            <div class="item">
                                <a href="tours/{{$tour['tour_url']}}" class="tour-photo">
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
                                <a href="tours/{{$tour['tour_url']}}" class="tour-photo">
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
        @endif
        @if(count($topHotels))
            <div class="popular-tours hotels">
                <div class="container">
                    <h2>{{trans('messages.top_hotels_in_armenia')}}</h2>
                @foreach($topHotels as $hotel)
                    <!--Tour Itwm-->
                        <div class="item">
                            <a href="{{url('/hotels/'.$hotel['hotel_url'])}}" class="tour-photo">
                                <img src="{{asset($hotel['main_image'])}}">
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