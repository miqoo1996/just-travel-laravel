@extends('layouts.regular')
@section('bodyStyle')
    page-tours-details
@endsection
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
                        @if(isset($hotels[0]['double_adult']))
                            <span class="{{$currency['currency']}}">{{round($hotels[0]['double_adult']/$currency[$currency['currency']])}}</span>
                        @else
                            <span class="{{$currency['currency']}}">0</span>
                        @endif
                        <span class="othercurrency">
                            @foreach($currency  as $key => $value)
                                @if(($key !== 'currency') && ($key !== $currency['currency']))
                                    @if(isset($hotels[0]['double_adult']))
                                        <span class="{{$key}}">{{round($hotels[0]['double_adult']/$value, 2)}}{{$key!='rur' ? ' &nbsp; /' : ''}}</span>
                                    @else
                                        <span class="{{$currency['currency']}}">0</span>
                                    @endif
                                @endif
                            @endforeach
                        </span>
                    </span>
                    <div class="clearfix"></div>
                    <h3>Tour Description</h3>
                    <div class="tour-description">
                        <p>
                            {!! $tour['desc_'.app()->getLocale()] !!}
                        </p>
                    </div>

                </div>
            </div>
        </div>


        <div class="container">
            <div class="filter-search filter-details">
                <form>

                    <div class="row" id="custom_deatils_search">
                        <div class="col-md-2 col-sm-6 col-xs-12">
                            <label for="example-text-input" class="col-form-label">{{trans('messages.date')}}</label>
                            <input class="datepicker" type="text" id="date_from"
                                   placeholder="{{trans('messages.date_from')}}">
                        </div>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                            <label for="example-text-input" class="col-form-label">{{trans('messages.adults')}}
                                (12-99)</label>
                            <input class="" type="number" id="adult" name="adults_count" placeholder="" min="0" value="2">
                        </div>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                            <label for="example-text-input" class="col-form-label">{{trans('messages.children')}}
                                (5-11)</label>
                            <input class="" type="number" id="child" name="children_count" placeholder="" min="0">
                        </div>
                        <div class="col-md-2 col-sm-6 col-xs-12">
                            <label for="example-text-input" class="col-form-label">{{trans('messages.infants')}}
                                (0-4)</label>
                            <input class="" type="number" id="infant" name="infants_count"  placeholder="" min="0">
                        </div>
                        <div class="col-md-4 col-sm-12 col-xs-12">
                            <label for="example-text-input" class="col-form-label">&nbsp;</label>
                            <input type="hidden" id="tour_id" value="{{$tour['tour_id']}}">
                            <input type="button" class="btn btn-warning" value="{{trans('messages.search')}}"
                                   id="detail_search">
                        </div>
                    </div>

                </form>
            </div>
        </div>
        <div id="search_res_container">
            <div class="container choosehotel-cont">
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <h3>{{trans('messages.accomodation')}}</h3>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12" id="">
                        @foreach($hotels as $key => $hotel)
                            <div class="choosehotel @if($key == 0) selected @endif">
                                <div class="hotels-c">
                                    <a href="{{url('hotels/'.$hotel['hotel_url'])}}" target="_blank" class="hotelavatar"
                                       style="background:url({{App\SimpleImage::image($hotel['hotel_main_image'], true)}}) top center no-repeat;"></a>
                                    <a href="{{url('hotels/'.$hotel['hotel_url'])}}" target="_blank"
                                       class="hotelname">{{$hotel['hotel_name_'.app()->getLocale()]}}</a>
                                </div>
                                <div class="hotels-c">
                                    12.12.2017<br/>4 ночи до: 04.05, чт
                                </div>
                                <div class="hotels-c">
                                    1-{{trans('messages.person_short')}}. {{trans('messages.standard')}}<br/>1 {{trans('messages.adult_short')}}
                                </div>
                                <div class="hotels-r">
                                    <a href="#!" class="btn btn-warning hotelpay disable" role="button"
                                       data-toggle="tooltip" data-placement="top"
                                       title="Please choose the date before">{{trans('messages.pay')}}</a>
                                    <div class="price hotelprice">
                                <span class="maincurrency" data-toggle="tooltip" data-placement="top"
                                      title="@foreach ($currency as $key => $value)
                                      @if (($key !== 'currency') && ($key !== $currency['currency']))
                                      <?php $res[] = round($hotel['double_adult'] / $value, 2) . config('const.currency_' . $key)?>
                                      @endif
                                      @endforeach {{$res[0] . '/' . $res[1] . '/' . $res[2]}}">
                                    <span class="{{$currency['currency']}}"><?php $result = round($hotel['double_adult'] / $currency[$currency['currency']], 2)?>{{$result}}</span>
                                </span>
                                    </div>
                                </div>
                                <div class="clear"></div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="tour-description-container daily">
            <div class="container">
                @foreach($days as $key => $day)
                    <div class="row">
                        <div class="col-md-1 col-sm-1 col-xs-12 day">
                            {{trans('messages.day') . ' ' .  ($key + 1)}}
                        </div>
                        <div class="col-md-11 col-sm-11 col-xs-12 day-sep">
                            <h3>{{$day['title_' .app()->getLocale()]}}</h3>
                            <div class="tour-description">
                                <p>
                                    {{$day['desc_' . app()->getLocale()]}}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @if(!empty($tour['tour_images']))
            <div class="greybg gallery-container">
                <div class="container">
                    <?php $isImage=false; ?>
                    @foreach($tour['tour_images'] as $image)
                        @if($image)
                            @if(!$isImage)
                                <h1>{{trans('messages.gallery')}}</h1>
                            @endif
                            <?php $isImage=true; ?>
                            <div class="item">
                                <a href="{{App\SimpleImage::image($image)}}" data-lightbox="gallery_trip">
                                    <img src="{{App\SimpleImage::image($image, true)}}" alt="{{$tour['tour_name_' . app()->getLocale()]}}" width="300"
                                         height="190">
                                </a>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>
        @endif
        @include('includes.hot_tours')
    </div>
@endsection
@section('style')
    <link rel="stylesheet" href="{{asset('css/lightbox.min.css')}}">
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#date_from').on('input', function () {
                this.value = '';
                return false
            });
            $('#date_from').datepicker({
                format: "dd/mm/yyyy",
                startDate: "+3d",
                maxViewMode: 0,
                weekStart: 1,
                language: "{{app()->getLocale()}}",
                multidate: false
            });
        });
    </script>
    <script src="{{asset('js/lightbox.min.js')}}"></script>

@endsection
