<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>@yield('title')</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="icon" href="{{asset('images/favicon.png')}}" type="image/x-icon"/>
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('css/default.css')}}">
    <link rel="stylesheet" href={{asset("vendors/bootstrap-datepicker/css/bootstrap-datepicker.css")}}>

    @yield('style')
</head>
<body class="page-inside @yield('bodyStyle')">
<span class="burger"></span>
<span id="overley"></span>
<div id="mobile-menu">
    <span id="close-menu"></span>
    @include('includes.menu')
</div>
<div class="header-dd">
    <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">{{strtoupper($currency['currency'])}}
            <span class="caret"></span></button>
        <ul class="dropdown-menu">
            @foreach(config('const.currencies') as $cur)
                @if($currency['currency'] !== $cur)
                    <li><a href="{{url('set_cur/'.$cur)}}">{{strtoupper($cur)}}</a></li>
                @endif
            @endforeach
        </ul>
    </div>
    <div class="dropdown">
        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
            @if(app()->getLocale() == 'ru')
                Русский
            @else
                English
            @endif
            <span class="caret"></span></button>
        <ul class="dropdown-menu">
            @if(app()->getLocale() == 'ru')
                <li><a href="{{url('set_lang/en')}}">English</a></li>
                <li class="active"><a href="{{url('set_lang/ru')}}">Русский</a></li>
            @else
                <li class="active"><a href="{{url('set_lang/en')}}">English</a></li>
                <li><a href="{{url('set_lang/ru')}}">Русский</a></li>
            @endif
        </ul>
    </div>
</div>
@yield('search_block')
    <div class="navbar navbar-default">
        <a href="{{url('/')}}" class="logo-element"></a>
        <!-- /.container-fluid -->
    </div>
@yield('content')
<!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="{{asset('js/jquery-1.11.3.min.js')}}"></script>
    <script src="{{asset('js/bootstrap.js')}}"></script>
    <script src="{{asset("vendors/bootstrap-datepicker/js/bootstrap-datepicker.js")}}"></script>
    <script src="{{asset('js/custom.js')}}"></script>
    <script src="{{asset('js/script.js')}}"></script>
@yield('script')
<!--maincont-->


</body>
</html>