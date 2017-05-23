@extends('layouts.regular')
@section('content')
    @if(Session::has('thx'))
        <div class="white">
            <h2 class="flash">{{trans('messages.sent_message')}}</h2>
        </div>
    @endif
    <div class="maincont">
        <div class="container">
            <div class="row contact-page">
                <h1>{{trans('messages.contacts')}}</h1>
                <p>
                   {!! trans('messages.address_text') !!}
                </p>
                <h2>{{trans('messages.feedback_form')}}</h2>
                <form action="{{url('/contacts')}}" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" id="name" placeholder="{{trans('messages.name')}}">
                    </div>
                    @if(!empty($errors->has('email')))
                        <div class="form-group message error">
                            <input type="email" class="form-control" name="email" id="email"
                                   placeholder="{{$errors->first('email')}}">
                        </div>
                    @else
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" id="email"
                                   placeholder="{{trans('messages.email_address') . ' *'}}">
                        </div>
                    @endif
                    @if(!empty($errors->has('message')))
                        <div class="form-group message error">
                        <textarea class="form-control" rows="5" name="message" id="comment"
                                  placeholder="{{$errors->first('message')}}"></textarea>
                        </div>
                    @else
                        <div class="form-group">
                        <textarea class="form-control" rows="5" name="message" id="comment"
                                  placeholder="{{trans('messages.message') . ' *'}}"></textarea>
                        </div>
                    @endif
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <button type="submit" class="btn btn-warning">{{trans('messages.submit')}}</button>
                </form>
            </div>
        </div>

        <div class="map">
            <iframe frameBorder="0" src="https://www.google.com/maps/d/embed?mid=1vof75kTxAL1ziYzEiPYckHtlps0"
                    width="100%" height="400"></iframe>
        </div>

    </div>
@endsection