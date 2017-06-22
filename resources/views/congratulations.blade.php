@extends('layouts.regular_nf')
@section('bodyStyle')
congratulations
@endsection
@section('content')
    <div class="maincont">
        <div class="container">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <h1>{{trans('messages.congratulations')}}</h1>
                    <h2>{{trans('messages.you_paid_for')
                    . ' "' . $order->tour['tour_name_' . app()->getLocale()]
                    . '" ' . trans('messages.in') . ' ' . str_replace('/', '.',$order->date_from)}}</h2>
                    <div class="ordered-overview">
                        {{trans('messages.vaucher_sent_text')}} {{$order->lead_email}}
                    </div>
                    <a href="{{url('/')}}" class="btn btn-warning gotohome" role="button">{{trans('messages.go_to_home_page')}}</a>
                </div>
            </div>
        </div>
    </div>
@endsection()