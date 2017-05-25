{{--{{dd($searchTours)}}--}}
@if(!count($searchTours))
    <h1>{{trans('messages.no_tours')}}</h1>
@else
    @foreach($searchTours as $tour)
        @if($tour['property'] == 'basic')
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
                    <div class="tourdate">{{$tour['date']}}</div>
                    <div class="price {{$currency['currency']}}">{{round($tour['single_adult'] / $currency[$currency['currency']], 2)}}</div>
                    <div class="clear"></div>
                </div>
            </div>
        @endif
    @endforeach
@endif