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
                <h1 class="page-header text-center">Photo Gallery</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div id="sortables" class="col-md-10 col-md-offset-1">
                    <ul data-ajax="{{route('admin-photo-gallery-items-orders')}}" id="sortable-photo-gallery" class="connectedSortable col-md-12">
                        @foreach($images as $image)
                            <li data-page-id="{{ $image['id'] }}" class="ui-state-default clearfix">
                                <div class="col-md-6">
                                    <p>{{ $image['gallery_name_en'] }}</p>
                                    @if($image['main_image'])
                                        <div>
                                            <img style="max-height: 200px;width: auto;" src="{{ asset($image['main_image']) }}" alt="{{ $image['gallery_name_en'] }}">
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <div style="margin-top: 40px;">
                                        description en: {{ $image['gallery_desc_en'] ? $image['gallery_desc_en'] : '-- Not Set --' }}
                                    </div>
                                </div>
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