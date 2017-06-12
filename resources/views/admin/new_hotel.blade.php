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
                            <textarea  class="tinymce" name="desc_en" id="desc_en"></textarea>
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
                            <textarea class="tinymce" name="desc_ru" id="desc_ru"></textarea>
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
                            <input type="file" name="hotel_main_image" size="chars" id="main_image">
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
                    <button type="button" class="btn btn-default" onclick="window.location.href='{{url()->previous()}}'">Cancel</button>
                    <button class="btn btn-success" id="submit-hotel">Save</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection
