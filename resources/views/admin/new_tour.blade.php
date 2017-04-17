@extends('admin.layouts.dashboard_layout')
@section('content')
    <div class="right_col" role="main">
        <form action="" method="post" enctype="multipart/form-data">
            <div class="page-title">
                <div class="title_left">
                    <h3>Add/Edit Tour</h3>
                </div>
            </div>
            <div class="clearfix"></div>




            <div class="x_panel">
                <div class="row">
                    <div class="form-horizontal form-label-left">
                        <div class="form-group">
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <label>Tour URL</label>
                                <input type="text" class="form-control" name="tour_url" id="tour_url" placeholder="Tour URL">
                            </div>
                            <div class="clearfix"></div>

                            <div class="col-md-8 col-sm-8 col-xs-12 margin-t-20">
                                <label>Tour Category</label>
                                <div class="checkbox-custom tour-category-checkboxes">
                                    @foreach($tour_categories as $tour_category)
                                        <label>
                                            <input type="checkbox" class="{{$tour_category->property}}" name="tour_category_id[]" value="{{$tour_category->id . '/' . $tour_category->property . '/' . $tour_category->category_name_en}}">
                                            <span>{{$tour_category->category_name_en}}</span>
                                        </label>
                                    @endforeach
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
                                <h2>Tour Name</h2>
                                <div class="clearfix"></div>
                            </div>
                            <input type="text" class="form-control input-lg" placeholder="Tour Name (English)" name="tour_name_en">

                            <div class="x_title no_border">
                                <h2>Tour Description</h2>
                                <div class="clearfix"></div>
                            </div>

                            <div class="x-content">
                                <textarea class="tinymce" name="desc_en" id="desc_en">

                                 </textarea>
                            </div>

                            <div class="margin-b-10 custom-field">
                                <div class="x_title">
                                    <h2>Program by days</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 margin-b-10">
                                    <div class="form-group">
                                        <div id="custom_day_container_en">
                                            <div class="custom_day">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Day 1</label>
                                                <div class="col-md-9 col-sm-9 col-xs-12 margin-b-10">
                                                    <textarea class="resizable_textarea form-control" placeholder="" name=custom_day_desc_en[]"></textarea>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>

                                            <div class="custom_day">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Day 2</label>
                                                <div class="col-md-9 col-sm-9 col-xs-12 margin-b-10">
                                                    <textarea class="resizable_textarea form-control" placeholder="" name="custom_day_desc_en[]"></textarea>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <a class="btn add_day"><span><i class="fa fa-plus"></i> Add Day</span></a>
                                            <a class="btn remove_day" style="float:right;"><span><i class="fa fa-remove"></i> Remove Last Day</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <div class="">

                                <div class="x_title">
                                    <h2>Input Tags</h2>
                                    <div class="clearfix"></div>
                                </div>
                                {{--<form>--}}
                                    <div class="control-group">
                                        <input id="tags_en" name="tags_en" type="text" class="tags form-control" value="social, adverts, sales" />
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
                                <h2>Tour Name</h2>
                                <div class="clearfix"></div>
                            </div>
                            <input type="text" class="form-control input-lg" name="tour_name_ru" id="tour_name_ru" placeholder="Tour Name (Russian)">

                            <div class="x_title no_border">
                                <h2>Tour Description</h2>
                                <div class="clearfix"></div>
                            </div>

                            <div class="x_content">
                                <textarea class="tinymce" name="desc_ru" id="desc_ru">

                                 </textarea>
                            </div>

                            <div class="margin-b-10 custom-field">
                                <div class="x_title">
                                    <h2>Program by days</h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12 margin-b-10">
                                    <div class="form-group">
                                        <div id="custom_day_container_ru">
                                            <div class="custom_day">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Day 1</label>
                                                <div class="col-md-9 col-sm-9 col-xs-12 margin-b-10">
                                                    <textarea class="resizable_textarea form-control" placeholder="" name="custom_day_desc_ru[]"></textarea>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>

                                            <div class="custom_day">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Day 2</label>
                                                <div class="col-md-9 col-sm-9 col-xs-12 margin-b-10">
                                                    <textarea class="resizable_textarea form-control" placeholder="" name="custom_day_desc_ru[]"></textarea>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <a class="btn add_day"><span><i class="fa fa-plus"></i> Add Day</span></a>
                                            <a style="float:right;" class="btn remove_day"><span><i class="fa fa-remove"></i> Remove Last Day</span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                            <div class="">

                                <div class="x_title">
                                    <h2>Input Tags</h2>
                                    <div class="clearfix"></div>
                                </div>
                                {{--<form>--}}
                                    <div class="control-group">
                                        <input id="tags_ru" name="tags_ru" type="text" class="tags form-control" value="social, adverts, sales" />
                                        <div id="suggestions-container" style="position: relative; float: left; width: 250px; margin: 10px;"></div>
                                    </div>
                                {{--</form>--}}

                            </div>


                        </div>
                        <!--tab content end-->
                    </div>
                </div>
            </div>

            <div class="x_panel basic-field" style="display: none">
                <div class="form-group" style="margin:10px 0 0;">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Price</label>
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <input type="text" class="form-control" placeholder="Price for Adult" name="basic_price_adult">
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <input type="text" class="form-control" placeholder="Price for Child" name="basic_price_child">
                    </div>
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <input type="text" class="form-control" placeholder="Price for Infant" name="basic_price_infant">
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group" style="margin:20px 0 0;">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Frequency</label>
                    <div class="col-md-9 col-sm-9 col-xs-12 checkbox-custom">
                        <label><div class="icheckbox_flat-green" style="position: relative;"><input type="checkbox" name="basic_frequency[]" value="mon" class="flat" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div> <span>M</span></label>
                        <label><div class="icheckbox_flat-green" style="position: relative;"><input type="checkbox" name="basic_frequency[]" value="tue" class="flat" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div> <span>T</span></label>
                        <label><div class="icheckbox_flat-green" style="position: relative;"><input type="checkbox" name="basic_frequency[]" value="wed" class="flat" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div> <span>W</span></label>
                        <label><div class="icheckbox_flat-green" style="position: relative;"><input type="checkbox" name="basic_frequency[]" value="thu" class="flat" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div> <span>T</span></label>
                        <label><div class="icheckbox_flat-green" style="position: relative;"><input type="checkbox" name="basic_frequency[]" value="fri" class="flat" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div> <span>F</span></label>
                        <label><div class="icheckbox_flat-green" style="position: relative;"><input type="checkbox" name="basic_frequency[]" value="sat" class="flat" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div> <span>S</span></label>
                        <label><div class="icheckbox_flat-green" style="position: relative;"><input type="checkbox" name="basic_frequency[]" value="sun" class="flat" style="position: absolute; opacity: 0;"><ins class="iCheck-helper" style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins></div> <span>S</span></label>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="form-group" style="margin:15px 0 0;">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12" style="margin:8px 0 0;">Calendar (select specific days)</label>
                    <div class="col-md-3 col-sm-3 col-xs-3">
                        <input type="text" name="specific_days" class="form-control calendar tour-datepicker" placeholder="DatePicker" name="basic_dates">
                    </div>
                </div>

            </div>


            <div class="x_panel custom-field">
                <div class="form-group" style="margin:10px 0 0;">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12">Date</label>
                    <div class="col-md-9 col-sm-9 col-xs-12 checkbox-custom">
                        <label><input type="radio" name="custom_day_prp"  id="custom_day_radio" checked value="custom" onchange="toggleDatepicker()"> <span>Custom Days</span></label>
                        <label><input type="radio" name="custom_day_prp"  id="any_day_radio" value="any" onchange="toggleDatepicker()"> <span>Any Day</span></label>
                    </div>
                </div>
                <div class="clearfix"></div>
                <div class="datepicker-container">
                    <div class="form-group" style="margin:20px 0 0;">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Calendar</label>
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <input type="text" class="form-control calendar tour-datepicker" placeholder="DatePicker" name="custom_dates">
                        </div>
                    </div>
                    <div class="form-group" style="margin:27px 0 0;">
                        Multiselection datepicker
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel custom-field">
                        <div class="x_title">
                            <h2>Add Hotels</h2>
                            <ul class="nav navbar-right panel_toolbox panel_toolbox_custom">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="row">


                                <div class="col-md-12 col-sm-12 col-xs-12 margin-b-10">
                                    <div class="form-group">

                                        <div class="custom_day">
                                            <div class="hotel-container">
                                                <div class="new_hotel">
                                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                                        Hotel
                                                        <select class="form-control" name="hotel[hotel_id][]">
                                                            @foreach($hotels as $hotel)
                                                                <option value="{{$hotel->id}}">{{$hotel->hotel_name_en}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                                        Single Adult (12-99)
                                                        <input type="text" class="form-control" placeholder="Price" name="hotel[single_adult][]">
                                                    </div>
                                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                                        Double Adult (12-99)
                                                        <input type="text" class="form-control" placeholder="Price" name="hotel[double_adult][]">
                                                    </div>
                                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                                        Tripple Adult (12-99)
                                                        <input type="text" class="form-control" placeholder="Price" name="hotel[triple_adult][]">
                                                    </div>



                                                    <div class="col-md-3 col-sm-3 col-xs-12">

                                                    </div>
                                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                                        Child (4-11)
                                                        <input type="text" class="form-control" placeholder="Price" name="hotel[child][]">
                                                    </div>
                                                    <div class="col-md-3 col-sm-3 col-xs-12">
                                                        Infant (0-4)
                                                        <input type="text" class="form-control" placeholder="Price" name="hotel[infant][]">
                                                    </div>



                                                    <div class="clearfix margin-b-10"></div>
                                                </div>
                                            </div>
                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                <a type="button" id="add_hotel" class="btn"><span><i class="fa fa-plus"></i> Add Hotel</span></a>
                                                <a type="button" id="remove_hotel" class="btn" style="float:right"><span><i class="fa fa-remove"></i> Remove Hotel</span></a>
                                            </div>
                                            <div class="clearfix margin-b-10"></div>
                                        </div>





                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
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
                            <input type="file" name="tour_images[]" id="tour_images" multiple="multiple">
                            <br />
                            <h2>Main Image (Optimal size is 350x200px)</h2>
                            <p><input type="file" name="main_image" size="chars"></p>
                            <h2>Hot Tour Image (Optimal size is 1920x400px)</h2>
                            <p><input type="file" name="hot_image" size="chars"></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /page content -->
            <div class="x_panel">
                <div class="x_content">

                    <div class="checkbox-custom">
                        <label>
                            <input type="checkbox" class="flat" name="visibility"> <span>Visible on the site</span>
                        </label>
                    </div>
                    <div class="checkbox-custom">
                        <label>
                            <input type="checkbox" class="flat" name="hot"> <span>Hot Tour</span>
                        </label>
                    </div>

                    <div class="clearfix"></div>

                    <div class="ln_solid"></div>
                    <div class="">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <button type="button" class="btn btn-default">Cancel</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </div>


        </form>
    </div>
@endsection
@section('css')
    <!-- bootstrap-daterangepicker -->
    <link href={{asset("vendors/bootstrap-datepicker/css/bootstrap-datepicker.css")}} rel="stylesheet">
    <!-- Dropzone.js -->
@endsection
@section('js')
    <!--Dropzone Part-->
    <script src="{{asset("vendors/bootstrap-datepicker/js/bootstrap-datepicker.js")}}"></script>
@endsection
@section('script')
    <script>
        $('.tour-datepicker').datepicker({
            orientation: "auto right",
            multidate: true
        });

    </script>
@endsection