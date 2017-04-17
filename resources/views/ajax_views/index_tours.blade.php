<div class="container">
    <h2>{{$tourCategory['category_name_' . app()->getLocale()]}}</h2>

    @foreach($tours as $tour)
        @if($tourCategory['property'] == 'basic')
            <div class="item">
                <a href="tours/{{$tour['tour_url']}}" class="tour-photo">
                    <img src="{{asset($tour['main_image'])}}">
                    <span class="tour-title">{{$tour['tour_name_en']}}</span>
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
                        {{--<span class="freq-day">T</span>--}}
                        {{--<span class="freq-day available">W</span>--}}
                        {{--<span class="freq-day available">T</span>--}}
                        {{--<span class="freq-day">F</span>--}}
                        {{--<span class="freq-day available">S</span>--}}
                        {{--<span class="freq-day">S</span>--}}
                    </div>
                    <div class="price">{{round($tour['basic_price_adult'] / $currency[$currency['currency']], 1)}}</div>
                </div>
            </div>

        @else
        @endif
    @endforeach
</div>
{{--<!--Tour Itwm-->--}}
{{--<div class="item">--}}
{{--<a href="tour-details.html" class="tour-photo">--}}
{{--<img src="images/tours/tour-test.jpg">--}}
{{--<span class="tour-title">Garni Monastery</span>--}}
{{--</a>--}}
{{--<div class="tour-data">--}}
{{--<div class="frequency">--}}
{{--<span class="freq-day available">M</span>--}}
{{--<span class="freq-day">T</span>--}}
{{--<span class="freq-day available">W</span>--}}
{{--<span class="freq-day available">T</span>--}}
{{--<span class="freq-day">F</span>--}}
{{--<span class="freq-day available">S</span>--}}
{{--<span class="freq-day">S</span>--}}
{{--</div>--}}
{{--<div class="price">$70.00</div>--}}
{{--</div>--}}
{{--</div>--}}

{{--<!--Tour Itwm-->--}}
{{--<div class="item">--}}
{{--<a href="tour-details.html" class="tour-photo">--}}
{{--<img src="images/tours/sevan.jpg">--}}
{{--<span class="tour-title">Sevan Lake</span>--}}
{{--</a>--}}
{{--<div class="tour-data">--}}
{{--<div class="frequency">--}}
{{--<span class="freq-day available">M</span>--}}
{{--<span class="freq-day">T</span>--}}
{{--<span class="freq-day available">W</span>--}}
{{--<span class="freq-day available">T</span>--}}
{{--<span class="freq-day">F</span>--}}
{{--<span class="freq-day available">S</span>--}}
{{--<span class="freq-day">S</span>--}}
{{--</div>--}}
{{--<div class="price">$70.00</div>--}}
{{--</div>--}}
{{--</div>--}}

{{--<!--Tour Itwm-->--}}
{{--<div class="item">--}}
{{--<a href="tour-details.html" class="tour-photo">--}}
{{--<img src="images/tours/tatev.jpg">--}}
{{--<span class="tour-title">Tatev Monastery</span>--}}
{{--</a>--}}
{{--<div class="tour-data">--}}
{{--<div class="frequency">--}}
{{--<span class="freq-day available">M</span>--}}
{{--<span class="freq-day">T</span>--}}
{{--<span class="freq-day available">W</span>--}}
{{--<span class="freq-day available">T</span>--}}
{{--<span class="freq-day">F</span>--}}
{{--<span class="freq-day available">S</span>--}}
{{--<span class="freq-day">S</span>--}}
{{--</div>--}}
{{--<div class="price">$70.00</div>--}}
{{--</div>--}}
{{--</div>--}}

{{--<!--Tour Itwm-->--}}
{{--<div class="item">--}}
{{--<a href="tour-details.html" class="tour-photo">--}}
{{--<img src="images/tours/history-museum.jpg">--}}
{{--<span class="tour-title">Armenian Historical Museum</span>--}}
{{--</a>--}}
{{--<div class="tour-data">--}}
{{--<div class="frequency">--}}
{{--<span class="freq-day available">M</span>--}}
{{--<span class="freq-day">T</span>--}}
{{--<span class="freq-day available">W</span>--}}
{{--<span class="freq-day available">T</span>--}}
{{--<span class="freq-day">F</span>--}}
{{--<span class="freq-day available">S</span>--}}
{{--<span class="freq-day">S</span>--}}
{{--</div>--}}
{{--<div class="price">$70.00</div>--}}
{{--</div>--}}
{{--</div>--}}


{{--<!--Tour Itwm-->--}}
{{--<div class="item">--}}
{{--<a href="tour-details.html" class="tour-photo">--}}
{{--<img src="images/tours/brandy.jpg">--}}
{{--<span class="tour-title">Yerevan Brandy Company</span>--}}
{{--</a>--}}
{{--<div class="tour-data">--}}
{{--<div class="frequency">--}}
{{--<span class="freq-day available">M</span>--}}
{{--<span class="freq-day">T</span>--}}
{{--<span class="freq-day available">W</span>--}}
{{--<span class="freq-day available">T</span>--}}
{{--<span class="freq-day">F</span>--}}
{{--<span class="freq-day available">S</span>--}}
{{--<span class="freq-day">S</span>--}}
{{--</div>--}}
{{--<div class="price">$70.00</div>--}}
{{--</div>--}}
{{--</div>--}}


{{--<!--Tour Itwm-->--}}
{{--<div class="item">--}}
{{--<a href="tour-details.html" class="tour-photo">--}}
{{--<img src="images/tours/zvartnots.jpg">--}}
{{--<span class="tour-title">Zvartnots Temple</span>--}}
{{--</a>--}}
{{--<div class="tour-data">--}}
{{--<div class="frequency">--}}
{{--<span class="freq-day available">M</span>--}}
{{--<span class="freq-day">T</span>--}}
{{--<span class="freq-day available">W</span>--}}
{{--<span class="freq-day available">T</span>--}}
{{--<span class="freq-day">F</span>--}}
{{--<span class="freq-day available">S</span>--}}
{{--<span class="freq-day">S</span>--}}
{{--</div>--}}
{{--<div class="price">$70.00</div>--}}
{{--</div>--}}
{{--</div>--}}

{{--<div class="more"><a href="tours.html">See More</a></div>--}}

{{--</div>--}}
