@extends('layouts.regular')
@section('content')
    <div class="maincont whitebg">
        <div class="container tour-details">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 tour-details-image">
                    <img src="{{asset($tour['main_image'])}}">
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <h1>{{$tour['tour_name_'.app()->getLocale()]}}</h1>
                    <span class="tour-id">{{trans('messages.tour_code')}}: {{$tour['code']}}</span>
                    <span class="price {{$currency['currency']}}">
            	        <span class="{{$currency['currency']}}">{{$tour['basic_price_adult']/$currency[$currency['currency']]}}</span>
                        <span class="othercurrency">
                            @foreach($currency  as $key => $value)
                                @if(($key !== 'currency') && ($key !== $currency['currency']))
                                    <span class="icon_{{$key}}">{{round($tour['basic_price_adult']/$value, 2)}}</span>
                                @endif
                            @endforeach
                        </span>

                    </span>
                    <div class="clearfix"></div>
                    <div class="pricebyperson">
                        <span class="item"><span>{{$tour['basic_price_adult']/$currency[$currency['currency']]}}</span>Adults (12-99)</span>
                        <span class="item"><span>{{$tour['basic_price_child']/$currency[$currency['currency']]}}</span>Child (4-11)</span>
                        <span class="item"><span>{{$tour['basic_price_infant']/$currency[$currency['currency']]}}</span>Infants (0-4)</span>
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
                <form>

                    <div class="row">
                        <div class="col-md-2 col-sm-6 col-xs-12">
                            <label for="example-text-input" class="col-form-label">Date</label>
                            <input class="datepicker" type="text" placeholder="Date from">
                        </div>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                            <label for="example-text-input" class="col-form-label">Adults (12-99)</label>
                            <input class="" type="text" placeholder="Date to" value="1">
                        </div>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                            <label for="example-text-input" class="col-form-label">Child (5-11)</label>
                            <input class="" type="text" placeholder="Date to">
                        </div>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                            <label for="example-text-input" class="col-form-label">Infants (0-4)</label>
                            <input class="" type="text" placeholder="Date to">
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <label for="example-text-input" class="col-form-label">&nbsp;</label>
                            <input type="submit" value="Book">
                        </div>
                    </div>

                </form>
            </div>
        </div>


        <div class="container tour-description-container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h3>Tour Description</h3>
                    <div class="tour-description">
                        <p>
                            The tour starts at 7am early in the morning. You will have breakfast on the road. The first
                            stop is Khor Virap, which is the closest place to mount Ararat. You will then continue to
                            Areni wine factory where you can enjoy wine tasting. After tasting why not buy some of the
                            local produce.
                        </p>
                    </div>
                </div>
            </div>
        </div>


        <div class="greybg gallery-container">
            <div class="container">
                <h1>Gallery</h1>
                <div class="item">
                    <a href="#"><img src="images/tours/gallery-tatev/01.jpg" alt="Tour Name" width="300"
                                     height="190"></a>
                </div>
                <div class="item">
                    <a href="#"><img src="images/tours/gallery-tatev/02.jpg" alt="Tour Name" width="300"
                                     height="190"></a>
                </div>
                <div class="item">
                    <a href="#"><img src="images/tours/gallery-tatev/03.jpg" alt="Tour Name" width="300"
                                     height="190"></a>
                </div>
                <div class="item">
                    <a href="#"><img src="images/tours/gallery-tatev/04.jpg" alt="Tour Name" width="300"
                                     height="190"></a>
                </div>
                <div class="item">
                    <a href="#"><img src="images/tours/gallery-tatev/05.jpg" alt="Tour Name" width="300"
                                     height="190"></a>
                </div>
                <div class="item">
                    <a href="#"><img src="images/tours/gallery-tatev/06.jpg" alt="Tour Name" width="300"
                                     height="190"></a>
                </div>
            </div>
        </div>


        <div class="popular-tours hotels">
            <div class="container">
                <h2>Hot Tours</h2>

                <!--Tour Itwm-->
                <div class="item">
                    <a href="tour-details.html" class="tour-photo">
                        <img src="images/tours/sevan.jpg"/>
                        <span class="tour-title">Sevan Lake</span>
                    </a>
                    <div class="tour-data">
                        <div class="tourdate">12.12.2017</div>
                        <div class="price" data-toggle="tooltip" data-placement="top"
                             title="241.110 &#1423; / 26.300 &#8381; / 400 &euro;">$70.00
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>

                <!--Tour Itwm-->
                <div class="item">
                    <a href="tour-details.html" class="tour-photo">
                        <img src="images/tours/tatev.jpg">
                        <span class="tour-title">Tatev Monastery</span>
                    </a>
                    <div class="tour-data">
                        <div class="frequency">
                            <span class="freq-day available">M</span>
                            <span class="freq-day">T</span>
                            <span class="freq-day available">W</span>
                            <span class="freq-day available">T</span>
                            <span class="freq-day">F</span>
                            <span class="freq-day available">S</span>
                            <span class="freq-day">S</span>
                        </div>
                        <div class="price" data-toggle="tooltip" data-placement="top"
                             title="241.110 &#1423; / 26.300 &#8381; / 400 &euro;">$70.00
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>

                <!--Tour Itwm-->
                <div class="item">
                    <a href="tour-details.html" class="tour-photo">
                        <img src="images/tours/history-museum.jpg">
                        <span class="tour-title">Armenian Historical Museum</span>
                    </a>
                    <div class="tour-data">
                        <div class="frequency">
                            <span class="freq-day available">M</span>
                            <span class="freq-day">T</span>
                            <span class="freq-day available">W</span>
                            <span class="freq-day available">T</span>
                            <span class="freq-day">F</span>
                            <span class="freq-day available">S</span>
                            <span class="freq-day">S</span>
                        </div>
                        <div class="price" data-toggle="tooltip" data-placement="top"
                             title="241.110 &#1423; / 26.300 &#8381; / 400 &euro;">$70.00
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection