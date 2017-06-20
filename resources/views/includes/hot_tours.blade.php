<div class="popular-tours hotels">
    <div class="container">
        <h2>{{trans('messages.hot_tours')}}</h2>
        @foreach($hotTours as $tour)
        @if($tour->isDaily())
        <div class="item">
            <a href="{{url('tours/'.$tour['tour_url'])}}" class="tour-photo">
                <img src="{{App\SimpleImage::image($tour['tour_main_image'])}}">
                <span class="tour-title">{{$tour['tour_name_'.app()->getLocale()]}}</span>
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
                @endif
            </div>
        </div>
        @else
        <div class="item">
            <a href="{{url('tours/'.$tour['tour_url'])}}" class="tour-photo">
                <img src="{{App\SimpleImage::image($tour['tour_main_image'], true)}}">
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
