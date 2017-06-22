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
                <h1 class="page-header text-center">Pdf</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div id="sortables" class="col-md-10 col-md-offset-1 pdf-container">
                    <ul data-ajax="{{route('admin-pdf-items-orders')}}" id="sortable-video-gallery" class="connectedSortable col-md-12">
                        @foreach($pdfs as $pdf)
                            @if($pdf['pdf_thumbnail_en'])
                            <li data-page-id="{{ $pdf['id'] }}" class="item">
                                <a href="javascript:void(0)">
                                    <img src="{{ App\SimpleImage::image($pdf['pdf_thumbnail_en'], true) }}" alt="{{ $pdf['pdf_name_en'] }}">
                                </a>
                                <h4>{{ $pdf['pdf_name_en'] }}</h4>
                            </li>
                            @endif
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