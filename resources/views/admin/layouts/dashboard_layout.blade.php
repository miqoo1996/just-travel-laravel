<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>@yield('title')</title>
    <link href={{asset("css/custom.css")}} rel="stylesheet">
    <link href={{asset("css/admin.css")}} rel="stylesheet">
    <link rel="icon" href={{asset("images/favicon.png")}} type="image/x-icon">

    <!-- Bootstrap -->
    <link rel="stylesheet" href={{asset("vendors/bootstrap/dist/css/bootstrap.min.css")}} >
    <!-- Font Awesome -->
    <link rel="stylesheet" href={{asset("vendors/font-awesome/css/font-awesome.min.css")}} >
    <!-- NProgress -->
    <link rel="stylesheet" href={{asset("vendors/nprogress/nprogress.css")}} >
    <!-- iCheck -->
    <link rel="stylesheet" href={{asset("vendors/iCheck/skins/flat/green.css")}} >
    <!-- Datatables -->
    <link rel="stylesheet" href={{asset("vendors/datatables.net-bs/css/dataTables.bootstrap.min.css")}} >
    <link rel="stylesheet" href={{asset("vendors/datatables.net-buttons-bs/css/buttons.bootstrap.min.css")}} >
    <link rel="stylesheet" href={{asset("vendors/datatables.net-fixedheader-bs/css/fixedHeader.bootstrap.min.css")}} >
    <link rel="stylesheet" href={{asset("vendors/datatables.net-responsive-bs/css/responsive.bootstrap.min.css")}} >
    <link rel="stylesheet" href={{asset("vendors/datatables.net-scroller-bs/css/scroller.bootstrap.min.css")}} >
    <link rel="stylesheet" href={{asset("vendors/crop/dist/cropper.css")}}>

@yield('css')
    <!-- Custom Theme Style -->
    <link href={{asset("build/css/custom.min.css")}} rel="stylesheet">
</head>

<body class="nav-md">
<div class="container body">
    <div class="main_container">
        <div class="col-md-3 left_col">
            <div class="left_col scroll-view">

                <div class="clearfix"></div>

                <!-- menu profile quick info -->
                <div class="profile clearfix">
                    <div class="profile_pic">
                        <img src={{asset("images/jt_logo.png")}} alt="..." class="img-circle profile_img">
                    </div>
                    <div class="profile_info">
                        <span>JustTravel Admin</span>
                        <h2>{{Auth::user()->first_name}} {{Auth::user()->last_name}}</h2>
                    </div>
                </div>
                <!-- /menu profile quick info -->

                <br />

                <!-- sidebar menu -->
                <div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
                    <div class="menu_section">
                        <ul class="nav side-menu">
                            <li>
                                <a href={{url("/admin/dashboard")}}><i class="fa fa-home"></i>Home</a>
                            </li>
                            <li><a><i class="fa fa-briefcase"></i>Tours<span class="fa fa-chevron-down"></span></a>
                                <ul class="nav child_menu">
                                    <li><a href={{url("/admin/tours-categories")}}>Tours Categories</a></li>
                                    <li><a href={{route("admin-tours-list")}}>Tours</a></li>
                                    <li><a href={{route("admin-new-custom-tour")}}>Create Custom Tour</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="{{route("admin-hotels")}}"><i class="fa fa-coffee"></i>Hotels</a>
                            </li>
                            {{--<li><a><i class="fa fa-clipboard"></i>Pages<span class="fa fa-chevron-down"></span></a>--}}
                                {{--<ul class="nav child_menu">--}}
                                    {{--<li><a href="{{route('admin-new-page')}}">Add New Page</a></li>--}}
                                    {{--<li><a href="page.html">Page 1</a></li>--}}
                                    {{--<li><a href="page.html">Page 2</a></li>--}}
                                {{--</ul>--}}
                            {{--</li>--}}
                            <li>
                                <a href="{{route('admin-pages-list')}}"><i class="fa fa-clipboard"></i>Pages</a>
                            </li>
                            <li>
                                <a href="{{route('admin-get-galleries')}}"><i class="fa fa-photo"></i>Photo Gallery</a>
                            </li>
                            <li>
                                <a href="{{route('admin-video-gallery')}}"><i class="fa fa-video-camera"></i>Video Gallery</a>
                            </li>
                            <li>
                                <a href="{{route('admin-pdf-list')}}"><i class="fa fa-file-pdf-o"></i>Download PDF's</a>
                            </li>
                            {{--<li>--}}
                                {{--<a href="{{route('admin-guide-list')}}"><i class="fa fa-bullhorn"></i>Guides</a>--}}
                            {{--</li>--}}
                            <li>
                                <a href="{{route('admin-settings')}}"><i class="fa fa-gears"></i>Settings</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- /sidebar menu -->
            </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <nav>
                    <div class="nav toggle">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>

                    <ul class="nav navbar-nav navbar-right">
                        <li class="">
                            <a href="javascript:;" class="user-profile dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <img src={{asset("images/jt_logo.png")}} alt="">{{Auth::user()->first_name}} {{Auth::user()->last_name}}
                                <span class=" fa fa-angle-down"></span>
                            </a>
                            <ul class="dropdown-menu dropdown-usermenu pull-right">
                                <li>
                                    <a href="{{route('admin-settings')}}"><span><i class="fa fa-gears pull-right"></i>Settings</span></a>
                                </li>
                                <li><a href={{route('admin-logout')}}><i class="fa fa-sign-out pull-right"></i>Log Out</a></li>
                            </ul>
                        </li>

                        <li role="presentation" class="dropdown">
                            <a href="javascript:;" class="dropdown-toggle info-number" data-toggle="dropdown" aria-expanded="false">
                                <i class="fa fa-envelope-o"></i>
                                <span class="badge bg-green">6</span>
                            </a>
                            <ul id="menu1" class="dropdown-menu list-unstyled msg_list" role="menu">
                                <li>
                                    <a>

                        <span>
                          <span>Edgar Smith</span>
                          <span class="time">Today</span>
                        </span>
                                        <span class="message">
                          Tour Name...
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                        <span>
                          <span>Edgar Smith</span>
                          <span class="time">Today</span>
                        </span>
                                        <span class="message">
                          Tour Name...
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                        <span>
                          <span>Edgar Smith</span>
                          <span class="time">Today</span>
                        </span>
                                        <span class="message">
                          Tour Name...
                        </span>
                                    </a>
                                </li>
                                <li>
                                    <a>
                        <span>
                          <span>Edgar Smith</span>
                          <span class="time">Today</span>
                        </span>
                                        <span class="message">
                          Tour Name...
                        </span>
                                    </a>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- /top navigation -->





        <!-- page content -->
        @yield('content')
        <!-- /page content -->
        <div class="modal fade" id="cropper-modal" aria-labelledby="modalLabel" role="dialog" tabindex="-1">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalLabel">Crop the image</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="image-container">
                            <img id="image" src="http://justtravel.dev/images/gallery/1/content/58ff118e14ce1.jpg" alt="Picture">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-success" id="save_cropped">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <!-- footer content -->
        <footer>
            <div class="pull-right">
                Admin Panel by <a href="https://colorlib.com">JustTravel</a>
            </div>
            <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
    </div>
</div>

<!-- jQuery -->
<script src={{asset("vendors/jquery/dist/jquery.min.js")}}></script>

<!-- Bootstrap -->
<script src={{asset("vendors/bootstrap/dist/js/bootstrap.min.js")}}></script>
<!-- FastClick -->
<script src={{asset("vendors/fastclick/lib/fastclick.js")}}></script>
<!-- NProgress -->
<script src={{asset("vendors/nprogress/nprogress.js")}}></script>
<!-- iCheck -->
<script src={{asset("vendors/iCheck/icheck.min.js")}}></script>
<!-- Datatables -->
<script src={{asset("vendors/datatables.net/js/jquery.dataTables.min.js")}}></script>
<script src={{asset("vendors/datatables.net-bs/js/dataTables.bootstrap.min.js")}}></script>
<script src={{asset("vendors/datatables.net-buttons/js/dataTables.buttons.min.js")}}></script>
<script src={{asset("vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js")}}></script>
<script src={{asset("vendors/datatables.net-buttons/js/buttons.flash.min.js")}}></script>
<script src={{asset("vendors/datatables.net-buttons/js/buttons.html5.min.js")}}></script>
<script src={{asset("vendors/datatables.net-buttons/js/buttons.print.min.js")}}></script>
<script src={{asset("vendors/jquery.tagsinput/src/jquery.tagsinput.js")}}></script>
<script src={{asset("vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js")}}></script>
<script src={{asset("vendors/datatables.net-keytable/js/dataTables.keyTable.min.js")}}></script>
<script src={{asset("vendors/datatables.net-responsive/js/dataTables.responsive.min.js")}}></script>
<script src={{asset("vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js")}}></script>
<script src={{asset("vendors/datatables.net-scroller/js/dataTables.scroller.min.js")}}></script>
<script src={{asset("vendors/jszip/dist/jszip.min.js")}}></script>
<script src={{asset("vendors/pdfmake/build/pdfmake.min.js")}}></script>
<script src={{asset("vendors/pdfmake/build/vfs_fonts.js")}}></script>
<script src={{asset("vendors/crop/dist/cropper.js")}}></script>
<script src="{{asset("js/cropper.js")}}"></script>
<script type="text/javascript" src="{{ asset('vendors/tinymce/tinymce.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('vendors/tinymce/init-tinymce.js') }}"></script>
@yield('js')

<!-- Custom Theme Scripts -->
<script src={{asset("build/js/custom.min.js")}}></script>
<script src={{asset("js/functions.js")}}></script>

@yield('script')
</body>
</html>