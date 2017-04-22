@extends('layouts.regular')
@section('content')
    @if(Session::has('thx'))
        <div class="white">
            <h2 class="flash">{{trans('messages.sent_message')}}</h2>
        </div>
    @endif
    <div class="maincont">
        <div class="container">
            <div class="row contacts">
                <h1>Contacts</h1>
                <p>
                    Yerevan 0001, Armenia, 21a Sayat Nova ave.<br/>
                    +374 55 007 404 / 095 111 610 / info@justtravel.am
                </p>
                <h2>Feedback Form</h2>
                <form action="{{url('/contacts')}}" method="post">
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" id="name" placeholder="Name">
                    </div>
                    @if(!empty($errors->has('email')))
                        <div class="form-group message error">
                            <input type="email" class="form-control" name="email" id="email"
                                   placeholder="{{$errors->first('email')}}">
                        </div>
                    @else
                        <div class="form-group">
                            <input type="email" class="form-control" name="email" id="email"
                                   placeholder="Email Address *">
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
                                  placeholder="Message *"></textarea>
                        </div>
                    @endif
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <button type="submit" class="btn btn-warning">Submit</button>
                </form>
            </div>
        </div>

        <div class="map">
            <iframe frameBorder="0" src="https://www.google.com/maps/d/embed?mid=1vof75kTxAL1ziYzEiPYckHtlps0"
                    width="100%" height="400"></iframe>
        </div>

    </div>
@endsection