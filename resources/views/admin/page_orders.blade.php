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
                <div class="col-md-10 col-md-offset-1">
                    <h1 class="page-header col-md-6">Right Menu</h1>
                    <h1 class="page-header col-md-6">Footer Menu</h1>
                </div>
            </div>
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div id="sortables" class="col-md-10 col-md-offset-1">
                    @if($pagesRightMenu)
                        <ul data-ajax="{{route('admin-right-menu-items-orders')}}" id="sortable-right-menu-pages" class="connectedSortable col-md-6">
                            @foreach($pagesRightMenu as $pageRMenu)
                                <li data-page-id="{{ $pageRMenu['id'] }}" class="ui-state-highlight">{{ $pageRMenu['page_name_en'] }}</li>
                            @endforeach
                        </ul>
                    @endif

                    @if($pagesFooterMenu)
                        <ul data-ajax="{{route('admin-footer-items-orders')}}" id="sortable-footer-pages" class="connectedSortable col-md-6">
                            @foreach($pagesFooterMenu as $pageFMenu)
                                <li data-page-id="{{ $pageFMenu['id'] }}" class="ui-state-default">{{ $pageFMenu['page_name_en'] }}</li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{asset('vendors/jquery-ui/jquery-ui.js')}}"></script>
    <script src="{{asset('js/page_orders.js')}}"></script>
@endsection