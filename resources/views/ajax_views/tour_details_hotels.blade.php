<div class="container choosehotel-cont">
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <h3>Accomodation</h3>
        </div>
        <div class="col-md-12 col-sm-12 col-xs-12" id="">
            @foreach($hotels as $key => $hotel)
                <div class="choosehotel @if($key == 0) selected @endif">
                    <div class="hotels-c">
                        <a href="{{url('hotels/'.$hotel['hotel_url'])}}" target="_blank" class="hotelavatar"
                           style="background:url({{asset($hotel['main_image'])}}) top center no-repeat;"></a>
                        <a href="{{url('hotels/'.$hotel['hotel_url'])}}" target="_blank"
                           class="hotelname">{{$hotel['hotel_name_'.app()->getLocale()]}}</a>
                    </div>
                    <div class="hotels-c">
                        12.12.2017<br/>4 ночи до: 04.05, чт
                    </div>
                    <div class="hotels-c">
                        {{$rooms}}-мест.
                        Стандарт<br/>@if($adult > 0) {{$adult . ' ' . trans('messages.adult_short')}} @endif
                        @if($child > 0) {{$child . ' ' . trans('messages.child_short')}} @endif
                        @if($infant > 0) {{$infant . ' ' . trans('messages.infant_short')}} @endif
                    </div>
                    <div class="hotels-r">
                        <a href="#!" class="btn btn-warning hotelpay disable" role="button"
                           data-toggle="tooltip" data-placement="top"
                           title="Please choose the date before">PAY</a>
                        <div class="price hotelprice">
                                <span class="maincurrency" data-toggle="tooltip" data-placement="top"
                                      title="@foreach ($currency as $key => $value)
                                                  @if (($key !== 'currency') && ($key !== $currency['currency']))
                                                           <?php $res[] = round($hotel[config('const.adult_key_' . strval($adult)) . '_adult'] / $value, 2) * count($days)
                                                                  + (round(($hotel['child'] / $value), 2) * count($days) * $child) +
                                                                  (round(($hotel['infant'] / $value), 2) * count($days) * $infant) . config('const.currency_' . $key)?>
                                                  @endif
                                             @endforeach {{$res[0] . '/' . $res[1] . '/' . $res[2]}}">
                                    <span class="{{$currency['currency']}}"><?php $result = round($hotel[config('const.adult_key_' . strval($adult)) . '_adult'] / $currency[$currency['currency']], 2) * count($days)
                                            + (round(($hotel['child'] / $currency[$currency['currency']]), 2) * count($days) * $child) +
                                            (round(($hotel['infant'] / $currency[$currency['currency']]), 2) * count($days) * $infant)?>{{$result}}</span>
                                </span>
                        </div>
                    </div>
                    <div class="clear"></div>
                </div>
            @endforeach
        </div>
    </div>
</div>