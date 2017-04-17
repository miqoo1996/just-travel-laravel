<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>JustTravel | Admin Login</title>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="{{asset('vendors/bootstrap/dist/css/bootstrap.min.css')}}" rel="stylesheet">
    <!-- Font Awesome -->
    <link href={{ asset('vendors/font-awesome/css/font-awesome.min.css') }} rel="stylesheet">
    <!-- NProgress -->
    <link href={{asset('vendors/nprogress/nprogress.css')}} rel="stylesheet">
    <!-- Animate.css -->
    <link href={{asset('vendors/animate.css/animate.min.css')}} rel="stylesheet">
    <!-- Custom Theme Style -->
    <link href="{{ asset('css/custom.min.css') }}" rel="stylesheet">

</head>

<body class="login">
<div>
    <a class="hiddenanchor" id="signup"></a>
    <a class="hiddenanchor" id="signin"></a>

    <div class="login_wrapper">
        <div class="animate form login_form">
            <section class="login_content">
                <form method="post" action="{{route('login')}}">
                    <h1>ADMIN PANEL</h1>
                    <div>
                        <input name="email" type="text" class="form-control" placeholder="Email" required="" />
                    </div>
                    <div>
                        <input name="password" type="password" class="form-control" placeholder="Password"  />
                    </div>
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <div>
                        <button type="submit" class="btn btn-default submit loginbtn">Log in</button>
                    </div>

                    <div class="clearfix"></div>
                    <div class="separator">
                        <div class="clearfix"></div>
                        <br />
                        <div>
                            <h1>JustTravel</h1>
                            <p>©2017 All Rights Reserved.</p>
                        </div>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
</body>
</html>
