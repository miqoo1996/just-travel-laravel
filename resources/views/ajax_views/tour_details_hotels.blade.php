<div class="container choosehotel-cont">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h3>{{trans('messages.accomodation')}}</h3>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12" id="">
            @foreach($hotels as $key => $hotel)
                <div class="choosehotel @if($key == 0) selected @endif ">
                    <div class="hotels-c">
                        <a href="{{url('hotels/'.$hotel['hotel_url'])}}" target="_blank" class="hotelavatar"
                           style="background:url({{App\SimpleImage::image($hotel['hotel_main_image'], true)}}) top center no-repeat;"></a>
                        <a href="{{url('hotels/'.$hotel['hotel_url'])}}" target="_blank"
                           class="hotelname">{{$hotel['hotel_name_'.app()->getLocale()]}}</a>
                    </div>
                    <div class="hotels-c">
                        {{$tour_date}}<br/>{{count($days)}} {{trans('nights to')}}: {{$tour_date_end}}
                    </div>
                    <div class="hotels-c">
                        {{$rooms}}-{{trans('messages.person_short')}}.
                        {{trans('messages.standard')}}, {{ucfirst($room_type)}}<br/>@if($adult > 0) {{$adult . ' ' . trans('messages.adult_short')}} @endif
                        @if($child > 0) {{$child . ' ' . trans('messages.child_short')}} @endif
                        @if($infant > 0) {{$infant . ' ' . trans('messages.infant_short')}} @endif
                    </div>
                    <div class="hotels-r">
                        <button class="btn btn-warning hotelpay hotel-payment-button" type="button" htdata="{{$hotel['id']}}" htr="{{$rooms}}">{{trans('messages.pay')}}</button>
                        <div class="price hotelprice">
                                <span class="maincurrency" data-toggle="tooltip" data-placement="top">
                                    <span class="{{$currency['currency']}}">{{round($hotel['price']/$currency[$currency['currency']], 2)}}</span>
                                </span>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            @endforeach
        </div>
    </div>
</div>
