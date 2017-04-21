<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>PriceFree</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="icon" href="images/favicon.png" type="image/x-icon" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{asset('css/default.css')}}">

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
        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">USD
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

<div class="whitebg footer">
    <footer class="text-center">
        <div class="container">

            <div class="footer-logo"></div>
            @include('includes.footer_menu')
            <div class="row">

                <div class="col-xs-12">
                    <div class="social">
                        <a href="#"><i class="demo-icon just-facebook">&#xf30c;</i></a>
                        <a href="#"><i class="demo-icon just-twitter">&#xf099;</i></a>
                        <a href="#"><i class="demo-icon just-youtube">&#xe801;</i></a>
                        <a href="#"><i class="demo-icon just-linkedin">&#xe802;</i></a>
                        <a href="#"><i class="demo-icon just-pinterest">&#xf231;</i></a>
                        <a href="#"><i class="demo-icon just-gplus">&#xf30f;</i></a>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 copyright">
                <p>+374 55 007 404  <span class="sep">/</span>  +374 95 111 610  <span class="sep">/</span>  <a href="mailto:info@justtravel.am">info@justtravel.am</a></p>
            </div>
            <div class="clear"></div>
            <p class="copyright">&copy; 2017 JustTravel. All rights reserved.</p>
        </div>
    </footer>
</div>

<!-- / FOOTER -->
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="{{asset('js/jquery-1.11.3.min.js')}}"></script>
<script src="{{asset('js/bootstrap.js')}}"></script>
<script src="{{asset('js/custom.js')}}"></script>
<script src="{{asset('js/script.js')}}"></script>
@yield('script')
<!--maincont-->


</body>
</html>