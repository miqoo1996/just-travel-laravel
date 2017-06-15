@extends('admin.layouts.dashboard_layout')
@section('content')
<div class="right_col" role="main">
    <form action="{{route('admin-post-new-hotel')}}" method="post" enctype="multipart/form-data">
        <input type="hidden" value="{{$hotel->id}}" name="hotel_id">
        <div class="">
            <div class="page-title">
                <div class="title_left">
                    <h3>Add/Edit Hotel</h3>
                </div>
            </div>
            <div class="clearfix"></div>
            @if ($errors->has())
                <div class="alert alert-danger">
                    <strong>Whoops!</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="x_panel">
                <div class="row">
                    <div class="form-horizontal form-label-left">
                        <div class="form-group">
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <label>Tour URL</label>
                                <input type="text" class="form-control" placeholder="Hotel URL" name="hotel_url" value="{{$hotel->hotel_url}}">
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-12 col-sm-12 col-xs-12 margin-t-20">
                                <label>Regions</label>
                                <div class="checkbox-custom region">
                                    <label>
                                        <input type="checkbox" class="flat" id="yerevan" name="yerevan" @if(array_key_exists('yerevan', $hotel->regions)) checked="checked" @endif>
                                        <span>Yerevan</span></label>
                                    <label>
                                        <input type="checkbox" class="flat" id="aragacotn" name="aragacotn"  @if(array_key_exists('aragacotn', $hotel->regions)) checked="checked" @endif >
                                        <span>Aragatsotn</span></label>
                                    <label>
                                        <input type="checkbox" class="flat" id="ararat" name="ararat" @if(array_key_exists('ararat', $hotel->regions)) checked="checked" @endif >
                                        <span>Ararat</span></label>
                                    <label>
                                        <input type="checkbox" class="flat" id="armavir" name="armavir" @if(array_key_exists('armavir', $hotel->regions)) checked="checked" @endif>
                                        <span>Armavir</span></label>
                                    <label>
                                        <input type="checkbox" class="flat" id="vayoc_dzor" name="vayoc_dzor" @if(array_key_exists('vayoc_dzor', $hotel->regions)) checked="checked" @endif>
                                        <span>Vayots dzor</span></label>
                                    <label>
                                        <input type="checkbox" class="flat" id="gegharkunik" name="gegharkunik" @if(array_key_exists('gegharkunik', $hotel->regions)) checked="checked" @endif>
                                        <span>Gegxahkunik</span></label>
                                    <label>
                                        <input type="checkbox" class="flat" id="kotayq" name="kotayq" @if(array_key_exists('kotayq', $hotel->regions)) checked="checked" @endif>
                                        <span>Kotayk</span></label>
                                    <label>
                                        <input type="checkbox" class="flat" id="lori" name="lori" @if(array_key_exists('lori', $hotel->regions)) checked="checked" @endif>
                                        <span>Lori</span></label>
                                    <label>
                                        <input type="checkbox" class="flat" id="syuniq" name="syuniq" @if(array_key_exists('syuniq', $hotel->regions)) checked="checked" @endif>
                                        <span>Siunik</span></label>
                                    <label>
                                        <input type="checkbox" class="flat" id="shirak" name="shirak" @if(array_key_exists('shirak', $hotel->regions)) checked="checked" @endif>
                                        <span>Shirak</span></label>
                                    <label>
                                        <input type="checkbox" class="flat" id="tavush" name="tavush" @if(array_key_exists('tavush', $hotel->regions)) checked="checked" @endif>
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
                        <input type="text" class="form-control input-lg" placeholder="Hotel Name (English)" name="hotel_name_en" id="hotel_name_en" value="{{$hotel->hotel_name_en}}">
                        <div class="x_title no_border">
                            <h2>Hotel Description</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <textarea class="tinymce" name="desc_en" id="desc_en">{{$hotel->desc_en}}</textarea>
                        </div>

                        <div class="clearfix"></div>
                        <div class="">
                            <div class="x_title">
                                <h2>Input Tags</h2>
                                <div class="clearfix"></div>
                            </div>
                            {{--<form>--}}
                                <div class="control-group">
                                    <input id="tags_1" type="text" class="tags form-control" value="{{$hotel->tags_en}}" name="tags_en"/>
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
                        <input type="text" class="form-control input-lg" placeholder="Hotel Name (Russian)" name="hotel_name_ru" id="hotel_name_ru" value="{{$hotel->hotel_name_ru}}">
                        <div class="x_title no_border">
                            <h2>Hotel Description</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x-content">
                            <textarea class="tinymce" name="desc_ru" id="desc_ru">{{$hotel->desc_ru}}</textarea>
                        </div>
                        <div class="clearfix"></div>
                        <div class="">
                            <div class="x_title">
                                <h2>Input Tags</h2>
                                <div class="clearfix"></div>
                            </div>
                            {{--<form>--}}
                                <div class="control-group">
                                    <input id="tags_1" type="text" class="tags form-control" value={{$hotel->tags_ru}} name="tags_ru"/>
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
                        <option value="1_star" @if($hotel->type == '1_star') selected="selected" @endif>1 Star</option>
                        <option value="2_star" @if($hotel->type == '2_star') selected="selected" @endif>2 stars</option>
                        <option value="3_star" @if($hotel->type == '3_star') selected="selected" @endif>3 Stars</option>
                        <option value="4_star" @if($hotel->type == '4_star') selected="selected" @endif>4 Stars</option>
                        <option value="5_star" @if($hotel->type == '5_star') selected="selected" @endif>5 Stars</option>
                        <option value="motel" @if($hotel->type == 'motel') selected="selected" @endif>Motel</option>
                        <option value="hostel" @if($hotel->type == 'hostel') selected="selected" @endif>Hostel</option>
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
                        <div>
                            <h2>Uploaded images</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @if(empty($hotel->images))
                                <div><p class="alert warning">No images</p></div>
                            @else
                            <ul class="list-unstyled custom-image-viewer">
                                @foreach($hotel->images as $image)
                                        <li class="col-lg-2 custom-image-viewer-item">
                                            <div>
                                                <span class="-remove custom-image-remove-button" id="{{'hotels?' .$hotel->id . '?hotels?' . $image}}"></span>
                                                <button type="button" class="cropper-modal" id="gallery" data-target="#cropper-modal" data-toggle="modal"></button>
                                                <img src="{{URL::asset('/' . $image)}}" alt="profile Pic">
                                            </div>
                                        </li>
                                @endforeach
                            </ul>
                            @endif
                        </div>
                        <h2>Main Image (Optimal size is 350x200px)</h2>
                        <p>
                            <input type="file" name="hotel_main_image" size="chars" id="main_image">
                        </p>
                        @if(null !== $hotel->hotel_main_image)
                            <h2>Main Image</h2>
                            <div class="custom-image-viewer">
                                <div class="custom-image-viewer-item">
                                    <button type="button" class="cropper-modal" id="main-image" data-target="#cropper-modal" data-toggle="modal"></button>
                                    <img src="{{asset($hotel->hotel_main_image)}}" alt="">
                                </div>
                            </div>
                        @else
                            <div><p class="alert warning">No image</p></div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <!-- /page content -->

        <div class="x_panel">
            <div class="x_content">
                <div class="checkbox-custom">
                    <label>
                        <input type="checkbox" class="flat" name="visibility" id="visibility" @if($hotel->visibility == 'on') checked="checked" @endif>
                        <span>Visible on the site</span> </label>
                </div>
                <div class="clearfix"></div>
                <div class="ln_solid"></div>
                <div class="">
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                    <button type="button" class="btn btn-default" onclick="window.location.href='{{url()->previous()}}'">Cancel</button>
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
    {{--<!-- jQuery -->--}}
    {{--<script src={{asset("vendors/jquery/dist/jquery.min.js")}}></script>--}}
    {{--<!-- Bootstrap -->--}}
    {{--<script src={{asset("vendors/bootstrap/dist/js/bootstrap.min.js")}}></script>--}}
    {{--<!-- FastClick -->--}}
    {{--<script src={{asset("vendors/fastclick/lib/fastclick.js")}}></script>--}}
    {{--<!-- NProgress -->--}}
    {{--<script src={{asset("vendors/nprogress/nprogress.js")}}></script>--}}
    {{--<!-- bootstrap-progressbar -->--}}
    {{--<script src={{asset("vendors/bootstrap-progressbar/bootstrap-progressbar.min.js")}}></script>--}}
    {{--<!-- iCheck -->--}}
    {{--<script src={{asset("vendors/iCheck/icheck.min.js")}}></script>--}}
    {{--<!-- bootstrap-daterangepicker -->--}}
    {{--<script src={{asset("vendors/moment/min/moment.min.js")}}></script>--}}
    {{--<script src={{asset("vendors/bootstrap-daterangepicker/daterangepicker.js")}}></script>--}}
    {{--<!-- bootstrap-wysiwyg -->--}}
    {{--<script src={{asset("vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js")}}></script>--}}
    {{--<script src={{asset("vendors/jquery.hotkeys/jquery.hotkeys.js")}}></script>--}}
    {{--<script src={{asset("vendors/google-code-prettify/src/prettify.js")}}></script>--}}
    {{--<!-- jQuery Tags Input -->--}}
    {{--<script src={{asset("vendors/jquery.tagsinput/src/jquery.tagsinput.js")}}></script>--}}
    {{--<!-- Switchery -->--}}
    {{--<script src={{asset("vendors/switchery/dist/switchery.min.js")}}></script>--}}
    {{--<!-- Select2 -->--}}
    {{--<script src={{asset("vendors/select2/dist/js/select2.full.min.js")}}></script>--}}
    {{--<!-- Parsley -->--}}
    {{--<script src={{asset("vendors/parsleyjs/dist/parsley.min.js")}}></script>--}}
    {{--<!-- Autosize -->--}}
    {{--<script src={{asset("vendors/autosize/dist/autosize.min.js")}}></script>--}}
    {{--<!-- jQuery autocomplete -->--}}
    <script src={{asset("vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js")}}></script>
    {{--<!-- starrr -->--}}
    {{--<script src={{asset("vendors/starrr/dist/starrr.js")}}></script>--}}
    <!-- Custom Theme Scripts -->


@endsection
