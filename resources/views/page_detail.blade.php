@extends('layouts.regular')
@section('title')
    {{$page['page_name_' . app()->getLocale()]}}
@endsection
@section('content')
    <div class="maincont">
        <div class="container insidepage">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="details-content">
                        <div class="white">
                            @if(isset($page['image']))
                            <div class="brand-adver"><img src="{{asset($page['image'])}}"></div>
                            @endif
                            {!! $page['desc_' .app()->getLocale()] !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
