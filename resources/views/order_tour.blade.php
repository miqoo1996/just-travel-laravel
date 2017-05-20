@extends('layouts.regular')
@section('content')
<form method="post" action="{{url('/post_ordered_custom_tour')}}">
    <div class="greybg tour-details">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-4 col-xs-12 tour-details-image">
                    <img src="{{asset($order['tour']['main_image'])}}">
                </div>
                <div class="col-md-8 col-sm-8 col-xs-12">
                    <h1>{{$order['tour']['tour_name_'.app()->getLocale()]}}</h1>
                    <span class="tour-id">{{trans('messages.tour_code') . ' : ' . $order['tour']['code'] }}</span>
                    <div class="col-1">
                        <span class="hint">{{trans('messages.total_price')}}</span>
                        <span class="{{$currency['currency']}}">
                        {{round($totalPrice / $currency[$currency['currency']], 2)}}
                        </span>
                <span class="othercurrency">
                    @foreach ($currency as $key => $value)
                        @if (($key !== 'currency') && ($key !== $currency['currency']))
                            <span class="{{$key}}">{{round($totalPrice / $value, 2)}}</span>
                        @endif
                    @endforeach
                </span>
                    </div>
                    <div class="col">
                        <span class="hint">{{trans('messages.travel_date')}}</span>
                        <span class="price">{{str_replace('/', '.', $order['date_from'])}}</span>
                    </div>
                    <span class="choosedhotel">{{$order['hotel']['hotel_name_' . app()->getLocale()] .
                    ' ' . str_replace('_star', '*', $order['hotel']['type']) .
                    ' (' . trans('messages.room_' . config('const.adult_key_' . $rooms)) . ' ' . trans('messages.standard') . '), '.
                    trans('messages.travelers') . ' - ' . ($order['adult'] + $order['child'] + $order['infant'])}}</span>
                </div>
            </div>
        </div>
    </div>
    <div class="maincont whitebg">
    <div class="container enter-travelers-data">
        <h3>{{trans('messages.adult_travelers')}}</h3>
        @for ($i = 1; $i <= $order['adult']; $i++)
            <div class="row">
                <div class="form-group col-md-5 col-sm-5 col-xs-12">
                    <label for="example-text-input" class="col-form-label">{{trans('messages.traveler_name')}}</label>
                    @if($errors->has('adult_name.'.$i))
                    <input class="form-control error" name="adult_name[{!! $i !!}]" value="{{ old('adult_name.'.$i) }}" type="text" placeholder="{{$errors->get('adult_name.'.$i)[0]}}">
                    @else
                    <input class="form-control" name="adult_name[{!! $i !!}]" value="{{ old('adult_name.'.$i) }}" type="text" placeholder="{{trans('messages.traveler_name')}}">
                    @endif
                </div>
                <div class="form-group col-md-5 col-sm-5 col-xs-12">
                    <label for="example-text-input" class="col-form-label">{{trans('messages.traveler_surname')}}</label>
                    @if($errors->has('adult_surname.'.$i))
                    <input class="form-control error" name="adult_surname[{!! $i !!}]" value="{{ old('adult_surname.'.$i) }}" type="text" placeholder="{{$errors->get('adult_surname.'.$i)[0]}}">
                    @else
                    <input class="form-control" name="adult_surname[{!! $i !!}]" value="{{ old('adult_surname.'.$i) }}" type="text" placeholder="{{trans('messages.traveler_surname')}}">
                    @endif
                </div>
                <div class="form-group col-md-2 col-sm-2 col-xs-12">
                    <label for="example-text-input" class="col-form-label">{{trans('messages.birth_date')}}</label>
                    @if($errors->has('adult_birth_date.'.$i))
                    <input class="form-control dob adult error" name="adult_birth_date[{!! $i !!}]" value="{{ old('adult_birth_date.'.$i) }}" type="text" placeholder="{{$errors->get('adult_birth_date.'.$i)[0]}}">
                    @else
                    <input class="form-control dob adult" name="adult_birth_date[{!! $i !!}]" value="{{ old('adult_birth_date.'.$i) }}" type="text" placeholder="{{trans('messages.birth_date')}}">
                    @endif
                </div>
            </div>
        @endfor
    </div>
    @if($order['child'] > 0)
    <div class="container enter-travelers-data">
        <h3>{{trans('messages.children')}}</h3>
        @for ($i = 1; $i <= $order['child']; $i++)
            <div class="row">
                <div class="form-group col-md-5 col-sm-5 col-xs-12">
                    <label for="example-text-input" class="col-form-label">{{trans('messages.traveler_name')}}</label>
                    @if($errors->has('child_name.'.$i))
                    <input class="form-control error" name="child_name[{!! $i !!}]" value="{{ old('child_name.'.$i) }}" type="text" placeholder="{{$errors->get('child_name.'.$i)[0]}}">
                    @else
                    <input class="form-control" name="child_name[{!! $i !!}]" value="{{ old('child_name.'.$i) }}" type="text" placeholder="{{trans('messages.traveler_name')}}">
                    @endif
                </div>
                <div class="form-group col-md-5 col-sm-5 col-xs-12">
                    <label for="example-text-input" class="col-form-label">{{trans('messages.traveler_surname')}}</label>
                    @if($errors->has('child_surname.'.$i))
                    <input class="form-control error" name="child_surname[{!! $i !!}]" value="{{ old('child_surname.'.$i) }}" type="text" placeholder="{{$errors->get('child_surname.'.$i)[0]}}">
                    @else
                    <input class="form-control" name="child_surname[{!! $i !!}]" value="{{ old('child_surname.'.$i) }}" type="text" placeholder="{{trans('messages.traveler_surname')}}">
                    @endif
                </div>
                <div class="form-group col-md-2 col-sm-2 col-xs-12">
                    <label for="example-text-input" class="col-form-label">{{trans('messages.birth_date')}}</label>
                    @if($errors->has('child_birth_date.'.$i))
                    <input class="form-control dob child error" name="child_birth_date[{!! $i !!}]" value="{{ old('child_birth_date.'.$i) }}" type="text" placeholder="{{$errors->get('child_birth_date.'.$i)[0]}}">
                    @else
                    <input class="form-control dob child" name="child_birth_date[{!! $i !!}]" value="{{ old('child_birth_date.'.$i) }}" type="text" placeholder="{{trans('messages.birth_date')}}">
                    @endif
                </div>
            </div>
        @endfor
    </div>
    @endif
    @if($order['infant'] > 0)
        <div class="container enter-travelers-data">
            <h3>{{trans('messages.infants')}}</h3>
            @for ($i = 1; $i <= $order['infant']; $i++)
                <div class="row">
                    <div class="form-group col-md-5 col-sm-5 col-xs-12">
                        <label for="example-text-input" class="col-form-label">{{trans('messages.traveler_name')}}</label>
                        @if($errors->has('infant_name.'.$i))
                        <input class="form-control error" name="infant_name[{!! $i !!}]" value="{{ old('infant_name.'.$i) }}" type="text" placeholder="{{$errors->get('infant_name.'.$i)[0]}}">
                        @else
                        <input class="form-control" name="infant_name[{!! $i !!}]" value="{{ old('infant_name.'.$i) }}" type="text" placeholder="{{trans('messages.traveler_name')}}">
                        @endif
                    </div>
                    <div class="form-group col-md-5 col-sm-5 col-xs-12">
                        <label for="example-text-input" class="col-form-label">{{trans('messages.traveler_surname')}}</label>
                        @if($errors->has('infant_surname.'.$i))
                        <input class="form-control error" name="infant_surname[{!! $i !!}]" value="{{ old('infant_surname.'.$i) }}" type="text" placeholder="{{$errors->get('infant_surname.'.$i)[0]}}">
                        @else
                        <input class="form-control" name="infant_surname[{!! $i !!}]" value="{{ old('infant_surname.'.$i) }}" type="text" placeholder="{{trans('messages.traveler_surname')}}">
                        @endif
                    </div>
                    <div class="form-group col-md-2 col-sm-2 col-xs-12">
                        <label for="example-text-input" class="col-form-label">{{trans('messages.birth_date')}}</label>
                        @if($errors->has('infant_birth_date.'.$i))
                        <input class="form-control dob infant error" name="infant_birth_date[{!! $i !!}]" value="{{ old('infant_birth_date.'.$i) }}" type="text" placeholder="{{$errors->get('infant_birth_date.'.$i)[0]}}">
                        @else
                        <input class="form-control dob infant" name="infant_birth_date[{!! $i !!}]" value="{{ old('infant_birth_date.'.$i) }}" type="text" placeholder="{{trans('messages.birth_date')}}">
                        @endif
                    </div>
                </div>
            @endfor
        </div>
    @endif
    </div>
    <div class="greybg comments-and-contact">
        <div class="container">
            <h2>{{trans('messages.cc_info')}}</h2>
            <div class="row">
                <div class="form-group col-md-8 col-sm-8 col-xs-12">
                    <label for="example-text-input" class="col-form-label">{{trans('messages.comments')}}</label>
                    <textarea class="form-control" name="comment" type="text">{{ old('comment') }}</textarea>
                </div>

                <div class="form-group col-md-4 col-sm-4 col-xs-12">
                    <label for="example-text-input" class="col-form-label">{{trans('messages.lead_email')}}</label>
                    @if($errors->has('lead_email'))
                        <input class="form-control error" name="lead_email" type="text" value="" placeholder="{{$errors->get('lead_email')[0]}}">
                    @else
                        <input class="form-control" name="lead_email" type="text" value="{{ old('lead_email') }}" placeholder="{{trans('messages.email_address')}}">
                    @endif
                    <span class="hint">{{trans('messages.vaucher_gen_text')}}</span>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-md-4 col-sm-4 col-xs-12">
                    <button type="submit" class="btn btn-warning">{{trans('messages.submit')}}</button>
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <input type="hidden" name="order_id" value="{{$order['order_id']}}">
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $('.dob.adult').datepicker({
               format: "dd/mm/yyyy",
               startDate: "-100y",
               endDate: "-12y",
               changeYear: true,
               language: "{{app()->getLocale()}}",
               multidate: false
           });
            $('.dob.child').datepicker({
                format: "dd/mm/yyyy",
                changeYear: true,
                startDate: "-12y",
                endDate: "-4y",
                language: "{{app()->getLocale()}}",
                multidate: false,

            });
            $('.dob.infant').datepicker({
                format: "dd/mm/yyyy",
                changeYear: true,
                startDate: "-4y",
                endDate: "-d",
                language: "{{app()->getLocale()}}",
                multidate: false,
            });
        });
    </script>
@endsection