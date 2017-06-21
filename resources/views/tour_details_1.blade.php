@extends('layouts.regular')
@section('content')
    <div class="maincont whitebg">
        <div class="container tour-details">
            <div class="row">
                <div class="col-md-6 col-sm-6 col-xs-12 tour-details-image">
                    <img src="{{App\SimpleImage::image($tour['tour_main_image'])}}">
                </div>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <h1>{{$tour['tour_name_'.app()->getLocale()]}}</h1>
                    <span class="tour-id">{{trans('messages.tour_code')}}: {{$tour['code']}}</span>
                    <span class="price {{$currency['currency']}}">
                        @if($tour['property'] == 'basic')
                            <span class="{{$currency['currency']}}">{{$tour['basic_price_adult']/$currency[$currency['currency']]}}</span>
                            <span class="othercurrency">
                                @foreach($currency  as $key => $value)
                                    @if(($key !== 'currency') && ($key !== $currency['currency']))
                                        <span class="icon_{{$key}}">{{round($tour['basic_price_adult']/$value, 2)}}</span>
                                    @endif
                                @endforeach
                            </span>
                        @else
                            <span class="{{$currency['currency']}}">{{$hotels[0]['single_adult']/$currency[$currency['currency']]}}</span>
                            <span class="othercurrency">
                                @foreach($currency  as $key => $value)
                                    @if(($key !== 'currency') && ($key !== $currency['currency']))
                                        <span class="icon_{{$key}}">{{round($hotels[0]['single_adult']/$value, 2)}}</span>
                                    @endif
                                @endforeach
                            </span>
                        @endif
                    </span>
                    <div class="clearfix"></div>
                    @if($tour['property'] == 'basic')
                        <div class="pricebyperson">
                            <span class="item"><span>{{$tour['basic_price_adult']/$currency[$currency['currency']]}}</span>Adults (12-99)</span>
                            <span class="item"><span>{{$tour['basic_price_child']/$currency[$currency['currency']]}}</span>Child (4-11)</span>
                            <span class="item"><span>{{$tour['basic_price_infant']/$currency[$currency['currency']]}}</span>Infants (0-4)</span>
                        </div>


                        <h3 class="frequency">Frequency</h3>
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
                        @endif
                    @endif
                </div>
            </div>
        </div>
        @if($tour['property'] == 'basic')
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
        @endif
        <div class="container tour-description-container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h3>{{trans('messages.tour_description')}}</h3>
                    <div class="tour-description">
                        <p>
                            {!! $tour['desc_'.app()->getLocale()]!!}
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @if($tour['property'] == 'custom')

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
                                <input class="" type="text" placeholder="Date to" value="2">
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
                                <input type="submit" class="btn btn-warning" value="Search">
                            </div>
                        </div>

                    </form>
                </div>
            </div>


            <div class="container choosehotel-cont">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h3>Accomodation</h3>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">

                        <div class="choosehotel selected">
                            <div class="hotels-l">
                                <a href="hotel-details.html" target="_blank" class="hotelavatar"
                                   style="background:url(images/hotels/latar.jpg) top center no-repeat;"></a>
                                <a href="hotel-details.html" target="_blank" class="hotelname">Shirak</a>
                            </div>
                            <div class="hotels-c">
                                12.12.2017<br/>4 ночи до: 04.05, чт
                            </div>
                            <div class="hotels-c">
                                1-мест. Стандарт<br/>1 Взр
                            </div>
                            <div class="hotels-r">
                                <a href="tour-details-2.html" class="btn btn-warning hotelpay disable" role="button"
                                   data-toggle="tooltip" data-placement="top"
                                   title="Please choose the date before">PAY</a>
                                <div class="price hotelprice">
                                <span class="maincurrency" data-toggle="tooltip" data-placement="top"
                                      title="241.110 &#1423; / 26.300 &#8381; / 400 &euro;">$470</span>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>

                        <div class="choosehotel">
                            <div class="hotels-l">
                                <a href="hotel-details.html" target="_blank" class="hotelavatar"
                                   style="background:url(images/hotels/congress.jpg) top center no-repeat;"></a>
                                <a href="hotel-details.html" target="_blank" class="hotelname">Congress</a>
                            </div>
                            <div class="hotels-c">
                                12.12.2017<br/>4 ночи до: 04.05, чт
                            </div>
                            <div class="hotels-c">
                                1-мест. Стандарт<br/>1 Взр
                            </div>
                            <div class="hotels-r">
                                <a href="tour-details-2.html" class="btn btn-warning hotelpay disable" role="button"
                                   data-toggle="tooltip" data-placement="top"
                                   title="Please choose the date before">PAY</a>
                                <div class="price hotelprice">
                                <span class="maincurrency" data-toggle="tooltip" data-placement="top"
                                      title="241.110 &#1423; / 26.300 &#8381; / 400 &euro;">$470</span>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>


                        <div class="choosehotel">
                            <div class="hotels-l">
                                <a href="hotel-details.html" target="_blank" class="hotelavatar"
                                   style="background:url(images/hotels/marriott.jpg) top center no-repeat;"></a>
                                <a href="hotel-details.html" target="_blank" class="hotelname">Marriott Yerevan</a>
                            </div>
                            <div class="hotels-c">
                                12.12.2017<br/>4 ночи до: 04.05, чт
                            </div>
                            <div class="hotels-c">
                                1-мест. Стандарт<br/>1 Взр
                            </div>
                            <div class="hotels-r">
                                <a href="tour-details-2.html" class="btn btn-warning hotelpay" role="button">PAY</a>
                                <div class="price hotelprice">
                                <span class="maincurrency" data-toggle="tooltip" data-placement="top"
                                      title="241.110 &#1423; / 26.300 &#8381; / 400 &euro;">$470</span>
                                </div>
                            </div>
                            <div class="clear"></div>
                        </div>


                    </div>
                </div>
            </div>

            <div class="tour-description-container daily">
                <div class="container">
                    <div class="row">
                        <div class="col-md-1 col-sm-1 col-xs-12 day">
                            Day 1
                        </div>
                        <div class="col-md-11 col-sm-11 col-xs-12 day-sep">
                            <h3>Visiting Khor Virap Monastery</h3>
                            <div class="tour-description">
                                <p>
                                    The Khor Virap is an Armenian monastery located in the Ararat plain in Armenia, near
                                    the
                                    closed border with Turkey, about 8 kilometres (5.0 mi) south of Artashat, Ararat
                                    Province, within the territory of ancient Artaxata. The monastery was host to a
                                    theological seminary and was the residence of Armenian Catholicos.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1 col-sm-1 col-xs-12 day">
                            Day 2
                        </div>
                        <div class="col-md-11 col-sm-11 col-xs-12 day-sep">
                            <h3>Visiting Tatev Monastery by Wings of Tatev</h3>
                            <div class="tour-description">
                                <p>
                                    Wings of Tatev is a 5.7 km (3.5 mi) cableway between Halidzor and the Tatev
                                    monastery in
                                    Armenia. It is the longest reversible aerial tramway built in only one section, and
                                    holds the record for Longest non-stop double track cable car. Construction was
                                    finished
                                    on 16 October 2010.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1 col-sm-1 col-xs-12 day">
                            Day 3
                        </div>
                        <div class="col-md-11 col-sm-11 col-xs-12 day-sep">
                            <h3>Visiting Hell's Bridge and Sisian's bells, Going to Stepanakert</h3>
                            <div class="tour-description">
                                <p>
                                    The tour starts at 7am early in the morning. You will have breakfast on the road.
                                    The
                                    first stop is Khor Virap, which is the closest place to mount Ararat. You will then
                                    continue to Areni wine factory where you can enjoy wine tasting. After tasting why
                                    not
                                    buy some of the local produce.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1 col-sm-1 col-xs-12 day">
                            Day 4
                        </div>
                        <div class="col-md-11 col-sm-11 col-xs-12 day-sep">
                            <h3>Visiting Gandzasar</h3>
                            <div class="tour-description">
                                <p>
                                    The tour starts at 7am early in the morning. You will have breakfast on the road.
                                    The
                                    first stop is Khor Virap, which is the closest place to mount Ararat. You will then
                                    continue to Areni wine factory where you can enjoy wine tasting. After tasting why
                                    not
                                    buy some of the local produce.
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-1 col-sm-1 col-xs-12 day">
                            Day 5
                        </div>
                        <div class="col-md-11 col-sm-11 col-xs-12 day-sep">
                            <h3>Tour Description</h3>
                            <div class="tour-description">
                                <p>
                                    The tour starts at 7am early in the morning. You will have breakfast on the road.
                                    The
                                    first stop is Khor Virap, which is the closest place to mount Ararat. You will then
                                    continue to Areni wine factory where you can enjoy wine tasting. After tasting why
                                    not
                                    buy some of the local produce.
                                </p>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        @endif

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
                        <div class="price">$70.00</div>
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
                        <div class="price">$70.00</div>
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
                        <div class="price">$70.00</div>
                        <div class="clear"></div>
                    </div>
                </div>

            </div>
        </div>


        <div class="whitebg footer">
            <footer class="text-center">
                <div class="container">

                    <div class="footer-logo"></div>

                    <div class="footer-menu">
                        <ul>
                            <li><a href="about-company.html">About Company</a></li>
                            <li><a href="about-country.html">About Country</a></li>
                            <li><a href="hotels.html">Terms and Conditions</a></li>
                            <li><a href="cataloge.html">Cataloge</a></li>
                            <li><a href="contacts.html">Contacts</a></li>
                        </ul>
                    </div>

                    <div class="row">

                        <div class="col-xs-12">
                            <div class="social">
                                <a href="#"><i class="demo-icon just-facebook">&#xf30c;</i></a>
                                <a href="#"><i class="demo-icon just-twitter">&#xf099;</i></a>
                                <a href="#"><i class="demo-icon just-youtube">&#xe801;</i></a>
                                <a href="#"><i class="demo-icon just-linkedin">&#xe802;</i></a>
                                <a href="#"><i class="demo-icon just-pinterest">&#xf231;</i></a>
                                <a href="#"><i class="demo-icon just-gplus">&#xf30f;</i></a>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 copyright">
                        <p>+374 55 007 404 <span class="sep">/</span> +374 95 111 610 <span class="sep">/</span> <a
                                    href="mailto:info@justtravel.am">info@justtravel.am</a></p>
                    </div>
                    <div class="clear"></div>
                    <p class="copyright">&copy; 2017 JustTravel. All rights reserved.</p>
                </div>
            </footer>
        </div>

    </div>
@endsection
