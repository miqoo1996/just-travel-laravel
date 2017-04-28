@extends('admin.layouts.dashboard_layout')
@section('content')
<div class="right_col" role="main">
    <form action="{{route('admin-post-new-hotel')}}" method="post" enctype="multipart/form-data">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Add/Edit Hotel</h3>
                </div>
            </div>
            <div class="clearfix"></div>

            <div class="x_panel">
                <div class="row">
                    <div class="form-horizontal form-label-left">
                        <div class="form-group">
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <label>Tour URL</label>
                                <input type="text" class="form-control" placeholder="Hotel URL" name="hotel_url">
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-12 col-sm-12 col-xs-12 margin-t-20">
                                <label>Regions</label>
                                <div class="checkbox-custom region">
                                    <label>
                                        <input type="checkbox" class="flat" id="yerevan" name="yerevan" value="off">
                                        <span>Yerevan</span></label>
                                    <label>
                                        <input type="checkbox" class="flat" id="aragacotn" name="aragacotn">
                                        <span>Aragatsotn</span></label>
                                    <label>
                                        <input type="checkbox" class="flat" id="ararat" name="ararat">
                                        <span>Ararat</span></label>
                                    <label>
                                        <input type="checkbox" class="flat" id="armavir" name="armavir">
                                        <span>Armavir</span></label>
                                    <label>
                                        <input type="checkbox" class="flat" id="vayoc_dzor" name="vayoc_dzor">
                                        <span>Vayots dzor</span></label>
                                    <label>
                                        <input type="checkbox" class="flat" id="gegharkunik" name="gegharkunik">
                                        <span>Gegxahkunik</span></label>
                                    <label>
                                        <input type="checkbox" class="flat" id="kotayq" name="kotayq">
                                        <span>Kotayk</span></label>
                                    <label>
                                        <input type="checkbox" class="flat" id="lori" name="lori">
                                        <span>Lori</span></label>
                                    <label>
                                        <input type="checkbox" class="flat" id="syuniq" name="syuniq">
                                        <span>Siunik</span></label>
                                    <label>
                                        <input type="checkbox" class="flat" id="shirak" name="shirak">
                                        <span>Shirak</span></label>
                                    <label>
                                        <input type="checkbox" class="flat" id="tavush" name="tavush">
                                        <span>Tavush</span></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">English</a></li>
                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Russian</a></li>
            </ul>
            <div id="myTabContent" class="tab-content">
                <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                    <!--tab content start-->
                    <div class="x_panel">
                        <div class="x_title no_border">
                            <h2>Hotel Name</h2>
                            <div class="clearfix"></div>
                        </div>
                        <input type="text" class="form-control input-lg" placeholder="Hotel Name (English)" name="hotel_name_en" id="hotel_name_en">
                        <div class="x_title no_border">
                            <h2>Hotel Description</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div id="alerts"></div>
                            <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor-en">
                                <div class="btn-group"> <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                    </ul>
                                </div>
                                <div class="btn-group"> <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li> <a data-edit="fontSize 5">
                                                <p style="font-size:17px">Huge</p>
                                            </a> </li>
                                        <li> <a data-edit="fontSize 3">
                                                <p style="font-size:14px">Normal</p>
                                            </a> </li>
                                        <li> <a data-edit="fontSize 1">
                                                <p style="font-size:11px">Small</p>
                                            </a> </li>
                                    </ul>
                                </div>
                                <div class="btn-group"> <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a> <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a> <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a> <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a> </div>
                                <div class="btn-group"> <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a> <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a> <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a> <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a> </div>
                                <div class="btn-group"> <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a> <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a> <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a> <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a> </div>
                                <div class="btn-group"> <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link"></i></a>
                                    <div class="dropdown-menu input-append">
                                        <input class="span2" placeholder="URL" type="text" data-edit="createLink" name="dropdown-menu"/>
                                        <button class="btn" type="button">Add</button>
                                    </div>
                                    <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-cut"></i></a> </div>
                                <div class="btn-group"> <a class="btn" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="fa fa-picture-o"></i></a>
                                    <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
                                </div>
                                <div class="btn-group"> <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a> <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a> </div>
                            </div>
                            <div id="editor-en" class="editor-wrapper"></div>
                            <textarea id="descr" style="display:none;"></textarea>
                            <br />
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Short Description</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <textarea class="resizable_textarea form-control" placeholder="Short presentation of the tour" name="short_desc_en"></textarea>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="">
                            <div class="x_title">
                                <h2>Input Tags</h2>
                                <div class="clearfix"></div>
                            </div>
                            {{--<form>--}}
                                <div class="control-group">
                                    <input id="tags_1" type="text" class="tags form-control" value="social, adverts, sales" name="tags_en"/>
                                    <div id="suggestions-container" style="position: relative; float: left; width: 250px; margin: 10px;"></div>
                                </div>
                            {{--</form>--}}
                        </div>
                    </div>
                    <!--tab content end-->
                </div>
                <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                    <!--tab content start-->
                    <div class="x_panel">
                        <div class="x_title no_border">
                            <h2>Hotel Name</h2>
                            <div class="clearfix"></div>
                        </div>
                        <input type="text" class="form-control input-lg" placeholder="Hotel Name (Russian)" name="hotel_name_ru" id="hotel_name_ru">
                        <div class="x_title no_border">
                            <h2>Hotel Description</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div id="alerts"></div>
                            <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor-ru">
                                <div class="btn-group"> <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                    </ul>
                                </div>
                                <div class="btn-group"> <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
                                    <ul class="dropdown-menu">
                                        <li> <a data-edit="fontSize 5">
                                                <p style="font-size:17px">Huge</p>
                                            </a> </li>
                                        <li> <a data-edit="fontSize 3">
                                                <p style="font-size:14px">Normal</p>
                                            </a> </li>
                                        <li> <a data-edit="fontSize 1">
                                                <p style="font-size:11px">Small</p>
                                            </a> </li>
                                    </ul>
                                </div>
                                <div class="btn-group"> <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a> <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a> <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a> <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a> </div>
                                <div class="btn-group"> <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a> <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a> <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a> <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a> </div>
                                <div class="btn-group"> <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a> <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a> <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a> <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a> </div>
                                <div class="btn-group"> <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link"></i></a>
                                    <div class="dropdown-menu input-append">
                                        <input class="span2" placeholder="URL" type="text" data-edit="createLink" />
                                        <button class="btn" type="button">Add</button>
                                    </div>
                                    <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-cut"></i></a> </div>
                                <div class="btn-group"> <a class="btn" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="fa fa-picture-o"></i></a>
                                    <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" />
                                </div>
                                <div class="btn-group"> <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a> <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a> </div>
                            </div>
                            <div id="editor-ru" class="editor-wrapper"></div>
                            <textarea id="descr" style="display:none;"></textarea>
                            <br />
                            <div class="form-group">
                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Short Description</label>
                                <div class="col-md-9 col-sm-9 col-xs-12">
                                    <textarea class="resizable_textarea form-control" placeholder="Short presentation of the tour" name="short_desc_ru"></textarea>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                        <div class="">
                            <div class="x_title">
                                <h2>Input Tags</h2>
                                <div class="clearfix"></div>
                            </div>
                            {{--<form>--}}
                                <div class="control-group">
                                    <input id="tags_1" type="text" class="tags form-control" value="social, adverts, sales" name="tags_ru"/>
                                    <div id="suggestions-container" style="position: relative; float: left; width: 250px; margin: 10px;"></div>
                                </div>
                            {{--</form>--}}
                        </div>
                    </div>
                    <!--tab content end-->
                </div>
            </div>
        </div>
        <div class="x_panel">
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" style="margin:8px 0 0;">Stars/Type</label>
                <div class="col-md-3 col-sm-3 col-xs-3">
                    <select class="form-control" name="type" id="type">
                        <option value="1_star">1 Star</option>
                        <option value="2_star">2 stars</option>
                        <option value="3_star">3 Stars</option>
                        <option value="4_star">4 Stars</option>
                        <option value="5_star">5 Stars</option>
                        <option value="motel">Motel</option>
                        <option value="hostel">Hostel</option>
                    </select>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>


    <!-- page content -->
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Gallery multiple file uploader</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <p>Drag multiple images to the box below for multi upload or click to select files. Required maximum with for images should be 1000px.</p>

                        <p>
                            <label for="files" class="admin-image-label">
                                <input type="file" name="files[]" multiple id="files" class="admin-image-upload">
                            </label>
                        </p>
                        <br />
                        <h2>Main Image (Optimal size is 350x200px)</h2>
                        <p>
                            <input type="file" name="main_image" size="chars" id="main_image">
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->

        <div class="x_panel">
            <div class="x_content">
                <div class="checkbox-custom">
                    <label>
                        <input type="checkbox" class="flat" name="visibility" id="visibility">
                        <span>Visible on the site</span> </label>
                </div>
                <div class="clearfix"></div>
                <div class="ln_solid"></div>
                <div class="">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <button type="button" class="btn btn-default">Cancel</button>
                    <button class="btn btn-success" id="submit-hotel">Save</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@section('css')
    <link href={{asset("vendors/select2/dist/css/select2.min.css")}} rel="stylesheet">
    <!-- Switchery -->
    <link href={{asset("vendors/switchery/dist/switchery.min.css")}} rel="stylesheet">
    <!-- starrr -->
    <link href={{asset("vendors/starrr/dist/starrr.css")}} rel="stylesheet">
    <!-- bootstrap-daterangepicker -->
    <link href={{asset("vendors/bootstrap-daterangepicker/daterangepicker.css")}} rel="stylesheet">
    <!-- Dropzone.js -->
    {{--<link href={{asset("vendors/dropzone/dist/min/dropzone.min.css")}} rel="stylesheet">--}}
@endsection

@section('js')
    <!-- jQuery -->
    <script src={{asset("vendors/jquery/dist/jquery.min.js")}}></script>
    <!-- Bootstrap -->
    <script src={{asset("vendors/bootstrap/dist/js/bootstrap.min.js")}}></script>
    <!-- FastClick -->
    <script src={{asset("vendors/fastclick/lib/fastclick.js")}}></script>
    <!-- NProgress -->
    <script src={{asset("vendors/nprogress/nprogress.js")}}></script>
    <!-- bootstrap-progressbar -->
    <script src={{asset("vendors/bootstrap-progressbar/bootstrap-progressbar.min.js")}}></script>
    <!-- iCheck -->
    <script src={{asset("vendors/iCheck/icheck.min.js")}}></script>
    <!-- bootstrap-daterangepicker -->
    <script src={{asset("vendors/moment/min/moment.min.js")}}></script>
    <script src={{asset("vendors/bootstrap-daterangepicker/daterangepicker.js")}}></script>
    <!-- bootstrap-wysiwyg -->
    <script src={{asset("vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js")}}></script>
    <script src={{asset("vendors/jquery.hotkeys/jquery.hotkeys.js")}}></script>
    <script src={{asset("vendors/google-code-prettify/src/prettify.js")}}></script>
    <!-- jQuery Tags Input -->
    <script src={{asset("vendors/jquery.tagsinput/src/jquery.tagsinput.js")}}></script>
    <!-- Switchery -->
    <script src={{asset("vendors/switchery/dist/switchery.min.js")}}></script>
    <!-- Select2 -->
    <script src={{asset("vendors/select2/dist/js/select2.full.min.js")}}></script>
    <!-- Parsley -->
    <script src={{asset("vendors/parsleyjs/dist/parsley.min.js")}}></script>
    <!-- Autosize -->
    <script src={{asset("vendors/autosize/dist/autosize.min.js")}}></script>
    <!-- jQuery autocomplete -->
    <script src={{asset("vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js")}}></script>
    <!-- starrr -->
    <script src={{asset("vendors/starrr/dist/starrr.js")}}></script>
    <!-- Custom Theme Scripts -->
    <!-- Dropzone.js -->
    <script src={{asset("vendors/dropzone/dropzone.js")}}></script>
    <!-- Run Dropzone -->
    <script src={{asset("js/hotel-dropzone.js")}}></script>

@endsection