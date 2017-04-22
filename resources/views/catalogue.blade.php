@extends('layouts.regular')
@section('bodyStyle')
    pdf
@endsection
@section('content')
    <div class="maincont">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h1>{{trans('messages.pdf_catalogs')}}</h1>
                    @if(count($catalogs))
                        <div class="pdf-container">
                            @foreach($catalogs as $catalog)
                            <div class="item">
                                <h4>{{$catalog['pdf_name_'.app()->getLocale()]}}</h4>
                                <span class="poster"><img src="{{asset($catalog['pdf_thumbnail_'.app()->getLocale()])}}"></span>
                                <a href="{{url('/'.$catalog['pdf_file_'.app()->getLocale()])}}" target="_blank" class="btn btn-warning" role="button">{{trans('messages.download')}}</a>
                            </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection