@extends('layouts.regular_nf')
@section('bodyStyle')
    Error Page
@endsection
@section('content')
    <div class="maincont">
        <div class="container">
            <div class="row">
                <br>
                <br>
                <div class="col-md-12 col-sm-12 col-xs-12 text-center">
                    <p><br><h2 class="alert alert-danger">{{$message}}</h2><br></p>
                    <a href="{{url('/')}}" class="btn btn-warning gotohome" role="button">{{trans('messages.go_to_home_page')}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection()
