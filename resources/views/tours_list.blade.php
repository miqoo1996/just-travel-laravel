@extends('layouts.regular')
@section('bodyStyle')
    page-tours
@endsection
@section('search_block')
    @if(count($tourCategories))
        <div class="mp-categories">
            <div class="container">
                <ul>
                @foreach($tourCategories as $tc)
                    @if(isset($tourCategory) && $tourCategory['id'] == $tc['id'])
                            <li class="active">
                        @else
                            <li>
                                @endif
                                <a href="{{url($tc['url'])}}"
                                   class="{{strtolower(str_replace(' ', '_', $tc['category_name_en']))}}">{{$tc['category_name_'.app()->getLocale()]}}</a>
                            </li>
                            @endforeach
                            <div class="clear"></div>
                </ul>
            </div>
        </div>
    @endif
    <div class="filter-search">
        <div class="container search-cont">
            <div class="row">
                <form>
                    <div class="input-daterange">
                        <div class="col-md-2 col-sm-6 col-xs-12 filteritem">
                            <input type="text" id="date_start" class="input-sm form-control datepicker" name="start"
                                   placeholder="{{trans('messages.date_from')}}">
                        </div>
                        <div class="col-md-2 col-sm-6 col-xs-12 filteritem">
                            <input type="text" id="date_end" class="input-sm form-control datepicker" name="end"
                                   placeholder="{{trans('messages.date_to')}}">
                        </div>
                    </div>
                    <div class="col-md-2 col-sm-6 col-xs-12 filteritem">
                        <div class="customselect">
                            <select class="form-control" id="tour_category_selector">
                                <option value="">{{trans('messages.all_categories')}}</option>
                                @foreach($tourCategories as $key => $item)
                                    <option value="{{$item['id'].'/'.$item['property']}}">{{$item['category_name_'.app()->getLocale()]}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-6 col-xs-12 filteritem searchfield">
                        <input class="search-field" type="text" placeholder="{{trans('messages.search_by_keywords')}}" name="tags" id="tags">
                    </div>
                    <div class="col-md-2 col-sm-12 col-xs-12 filteritem">
                        <input type="button" id="search_tours" class="btn btn-warning" value="{{trans('messages.search')}}">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('content')
    <div class="maincont">
        <div class="popular-tours" id="tours_area">
            <div class="container">
                @if(isset($tourCategory))
                    <h2>{{$tourCategory['category_name_'.app()->getLocale()]}}</h2>
                @endif
                @if(isset($tours))
                        @foreach($tours as $tour)
                            @if($tour->isDaily())
                                <div class="item">
                                    <a href="tours/{{$tour['tour_url']}}" class="tour-photo">
                                        <img src="{{App\SimpleImage::image($tour['tour_main_image'], true)}}">
                                        <span class="tour-title">{{$tour['tour_name_'.app()->getLocale()]}}</span>
                                    </a>
                                    <div class="shortdescr">{{$tour['short_desc_'.app()->getLocale()]}}</div>
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
                                        @else
                                            <div class="price {{$currency['currency']}}">{{round($tour['double_adult'] / $currency[$currency['currency']], 2)}}</div>
                                        @endif
                                    </div>
                                </div>
                            @else
                                <div class="item">
                                    <a href="tours/{{$tour['tour_url']}}" class="tour-photo">
                                        <img src="{{App\SimpleImage::image($tour['tour_main_image'], true)}}">
                                        <span class="tour-title">{{$tour['tour_name_'.app()->getLocale()]}}</span>
                                    </a>
                                    <div class="shortdescr">{{$tour['short_desc_'.app()->getLocale()]}}</div>
                                    <div class="tour-data">
                                        <div class="tourdate">{{str_replace('/','.',$tour['date'])}}</div>
                                        <div class="price {{$currency['currency']}}">{{round($tour['single_adult'] / $currency[$currency['currency']], 2)}}</div>
                                        <div class="clear"></div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                @endif
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script>
        $('.input-daterange').on('input', function () {
            this.value = '';
            return false
        });
        $('.input-daterange').datepicker({
            format: "dd/mm/yyyy",
            startDate: "+3d",
            maxViewMode: 0,
            weekStart: 1,
            language: "{{app()->getLocale()}}",
            multidate: false
        });
    </script>
    <link rel="stylesheet" href="{{asset("vendors/easy_autocomplete/easy-autocomplete.css")}}">
    <script src="{{asset("vendors/easy_autocomplete/jquery.easy-autocomplete.js")}}"></script>
    <script src="{{asset('/js/autofill.js')}}"></script>
@endsection
