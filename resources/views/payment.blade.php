@extends('layouts.regular_nf')
@section('content')
<div class="greybg tour-details">


    <div class="preview">
        <div class="preview-container">
            <h1>{{$orderTour['tour']['tour_name_'.app()->getLocale()]}}</h1>
            <h4>{!! trans('messages.tour_code') .' : ' . $orderTour['tour']['code'].' / ' .trans('messages.tour_date') .' / ' .$orderTour['date_from']!!}
                <br />
                {{$orderTour['hotel']['short_desc_'.app()->getLocale()] .
                str_replace('_star', '*', $orderTour['hotel']['type']) .
                ' (' . trans('messages.room_' . config('const.adult_key_' . $orderTour['rooms'])) . ' ' . trans('messages.standard') . '), '.
                trans('messages.travelers').' - ' . ($orderTour['adult'] + $orderTour['child'] + $orderTour['infant'])}}</h4>
            <div class="tourshortdescr">
                {{$orderTour['tour']['short_desc_'.app()->getLocale()]}}
            </div>
            <div class="tourtravelers">
                @foreach ($orderTour['members'] as $member)
                <div class="item">
                    <span class="name">{{$member['member_name'] . ' ' .$member['member_surname']}}</span>
                    <span class="date">{{str_replace('/', '.', $member['member_dob'])}}</span>
                </div>
                @endforeach
            </div>
            <div class="tourstatement">
                <span><span class="date">{{$orderTour['adult'] + $orderTour['child'] + $orderTour['infant']}}</span>{{trans('messages.total_travelers')}}</span>
                <span><span class="date {{$currency['currency']}}">{{round($orderTour['amount'] / $currency[$currency['currency']], 2)}}</span>{{trans('messages.total_price')}}</span>
            </div>
            <div class="hint">{{trans('messages.contact_person') . ' : ' . $orderTour['members'][0]['member_name'] . ' ' .
            $orderTour['members'][0]['member_surname'] . ' ' .
            ' / Email: '.$orderTour['lead_email']}}</div>            <form action="{{url('pay')}}">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="order_id" value="{{$orderTour['order_id']}}">
                <button type="submit" class="btn btn-warning">{{trans('approve_and_pay')}}</button>
            </form>
        </div>
    </div>
</div>
@endsection