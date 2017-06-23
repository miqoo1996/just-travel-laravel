@extends('admin.layouts.dashboard_layout')
@yield('css')
<link rel="stylesheet" href="{{asset("vendors/jquery-ui/jquery-ui.css")}}">
<link rel="stylesheet" href="{{asset("css/page_orders.css")}}">

@section('title')
    Pages | JustTravel
@endsection
@section('content')
    <div class="right_col" role="main">
        <div class="clearfix"></div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h1 class="page-header text-center">{{ $title }}</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div id="sortables" class="col-md-10 col-md-offset-1 main-gallery">
                    <ul data-ajax="{{url('/admin/photo-orders-save?type=' . $type)}}" id="sortable-photo-gallery" class="col-md-12">
                        @foreach($images as $image)
                            <li data-page-id="{{ $image['id'] }}" class="item">
                                <a href="javascript:void(0)">
                                    <img src="{{App\SimpleImage::image($image['main_image'], true)}}" alt="{{ $image['gallery_name_en'] }}">
                                </a>
                                <h4>{{ $image['gallery_name_en'] }}</h4>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{asset('vendors/jquery-ui/jquery-ui.js')}}"></script>
    <script src="{{asset('js/page_orders.js')}}"></script>
@endsection