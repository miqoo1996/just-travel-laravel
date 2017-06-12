<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PriceFree</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="icon" href="images/favicon.png" type="image/x-icon" />
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/default.css">

</head>
<body class="error404">


<div class="maincont">

    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <h1>404 ERROR</h1>
                <div class="error-descr">{{trans('messages.page_not_found')}}</div>
                <a href="{{url('/')}}" class="btn btn-warning gotohome" role="button">{{trans('messages.go_to_home_page')}}</a>
            </div>
        </div>
    </div>


</div>






<!-- / FOOTER -->
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/jquery-1.11.3.min.js"></script>
<script src="js/bootstrap.js"></script>
<script>
    //Header
    $(window).scroll(function() {
        var scroll = $(window).scrollTop();
        if (scroll >= 70) {
            $(".navbar").addClass("dark-header");
        }
        if (scroll <= 69) {
            $(".navbar").removeClass("dark-header");
        }
    });
    //Burger Menu
    $(document).ready(function () {
        $(".burger").click(function () {
            $("#mobile-menu").addClass("display-menu");
            $("#overley").addClass("display-overley");
            $("#close-menu").addClass("display-close-menu");
            $("#image-list").addClass("fixed-il");
            $('.pagination').css('display','none');
        });
        $("#close-menu, #overley").click(function () {
            $("#close-menu").attr('class', '');
            $("#mobile-menu").attr('class', '');
            $("#overley").attr('class', '');
            $("#image-list").attr('class', '');
            $('.pagination').css('display','block');
        });
    });
</script>

<!--maincont-->


</body>
</html>