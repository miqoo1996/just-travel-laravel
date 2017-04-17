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
        <div class="carousel-inner" role="listbox">
            <div class="item active" style="background:url({{asset('images/backgrounds/bg1.jpg')}}) top center no-repeat; ">
                <div class="hottour">
                    <h1>Celebrating Easter in Yerevan</h1>
                    <h3>Ever wondered what it’s like to celebrate Easter in Armenia?<br />
                        Here’s a peek into what it’s like to celebrate the holiday in Yerevan, Armenia’s capital.</h3>
                    <a class="more" href="#">I'm interested in</a>
                </div>
                <div class="header-overlay"></div>
            </div>

            <div class="item" style="background:url({{asset('images/backgrounds/bg2.jpg')}}) top center no-repeat;">
                <div class="hottour">
                    <h1>Celebrating Easter in Yerevan</h1>
                    <h3>Ever wondered what it’s like to celebrate Easter in Armenia?<br />
                        Here’s a peek into what it’s like to celebrate the holiday in Yerevan, Armenia’s capital.</h3>
                    <a class="more" href="#">I'm interested in</a>
                </div>
                <div class="header-overlay"></div>
            </div>

            <div class="item" style="background:url({{asset('images/backgrounds/bg3.jpg')}}) top center no-repeat;">
                <div class="hottour">
                    <h1>Celebrating Easter in Yerevan</h1>
                    <h3>Ever wondered what it’s like to celebrate Easter in Armenia?<br />
                        Here’s a peek into what it’s like to celebrate the holiday in Yerevan, Armenia’s capital.</h3>
                    <a class="more" href="#">I'm interested in</a>
                </div>
                <div class="header-overlay"></div>
            </div>

        </div>


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
                                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">English
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
                            </div>            </div>
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
            <a href="index.html" class="logo-element"></a>
            <!-- /.container-fluid -->
        </div>


        <div class="mp-categories fixme">
            <div class="container">
                <ul>
                    @foreach($tourCategories as $tc)
                        <li><a id="{{'x_cat/' . $tc['id']}}" class="tc-viewer {{strtolower(str_replace(' ', '_', $tc['category_name_en']))}}">{{$tc['category_name_'.$locale]}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="popular-tours" id="tours_area">
            <div class="container">
                <h2>Daily Tours</h2>

                <!--Tour Itwm-->
                <div class="item">
                    <a href="tour-details.html" class="tour-photo">
                        <img src="images/tours/tour-test.jpg">
                        <span class="tour-title">Garni Monastery</span>
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
                    </div>
                </div>

                <!--Tour Itwm-->
                <div class="item">
                    <a href="tour-details.html" class="tour-photo">
                        <img src="images/tours/sevan.jpg">
                        <span class="tour-title">Sevan Lake</span>
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
                    </div>
                </div>


                <!--Tour Itwm-->
                <div class="item">
                    <a href="tour-details.html" class="tour-photo">
                        <img src="images/tours/brandy.jpg">
                        <span class="tour-title">Yerevan Brandy Company</span>
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
                    </div>
                </div>


                <!--Tour Itwm-->
                <div class="item">
                    <a href="tour-details.html" class="tour-photo">
                        <img src="images/tours/zvartnots.jpg">
                        <span class="tour-title">Zvartnots Temple</span>
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
                    </div>
                </div>

                <div class="more"><a href="tours.html">See More</a></div>

            </div>
        </div>






        <div class="popular-tours hotels">
            <div class="container">
                <h2>Top Hotels in Armenia</h2>


                <!--Tour Itwm-->
                <div class="item">
                    <a href="#" class="tour-photo">
                        <img src="images/hotels/hotel-1.jpg">
                        <span class="tour-title">Tufenkian Avan Dzoraget Hotel</span>
                    </a>
                    <div class="tour-data">
                        <div class="stars stars4"></div>
                        <div class="price">$70.00</div>
                    </div>
                </div>


                <!--Tour Itwm-->
                <div class="item">
                    <a href="#" class="tour-photo">
                        <img src="images/hotels/latar.jpg">
                        <span class="tour-title">Latar</span>
                    </a>
                    <div class="tour-data">
                        <div class="stars stars5"></div>
                        <div class="price">$70.00</div>
                    </div>
                </div>


                <!--Tour Itwm-->
                <div class="item">
                    <a href="#" class="tour-photo">
                        <img src="images/hotels/radisson.jpg">
                        <span class="tour-title">Radisson Blue</span>
                    </a>
                    <div class="tour-data">
                        <div class="stars">
                            <span class="hotel-star available"></span>
                            <span class="hotel-star available"></span>
                            <span class="hotel-star available"></span>
                            <span class="hotel-star available"></span>
                            <span class="hotel-star"></span>
                        </div>
                        <div class="price">$70.00</div>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection