@extends('admin.layouts.dashboard_layout')
@section('content')
    <div class="right_col" role="main">
        <div class="x_content">
            <form action="{{route('admin-post-new-gallery')}}" method="post" enctype="multipart/form-data">
                <div class="x_panel">
                    <div class="row">
                        <div class="form-horizontal form-label-left">
                            <div class="form-group">
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <label>Gallery URL <span class="required">*</span></label>
                                    <input type="text" class="form-control" placeholder="Gallry URL" name="gallery_url">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                    <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab"
                                                                  data-toggle="tab" aria-expanded="true">English</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab"
                                                            data-toggle="tab" aria-expanded="false">Russian</a>
                        </li>
                    </ul>
                    <div id="myTabContent" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1"
                             aria-labelledby="home-tab">

                            <!--tab content start-->
                            <div class="x_panel">
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                        <label>Gallery Name <span class="required">*</span></label>
                                        <input type="text" class="form-control" placeholder="Gallery Name"
                                               name="gallery_name_en">
                                    </div>
                                </div>
                                <div class="x_title no_border">
                                    <h2>Gallery Description
                                        <small>(English Version)</small> <span class="required">*</span>
                                    </h2>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="x-content">
                                    <textarea class="tinymce" name="gallery_desc_en"
                                              id="desc_en"></textarea>
                                </div>
                                <div class="x-content">
                                </div>
                            </div>
                            <!--tab content end-->
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

                            <!--tab content start-->
                            <div class="x_panel">
                                <div class="row">
                                    <div class="col-md-4 col-sm-4 col-xs-4">
                                        <label>Gallery Name <span class="required">*</span></label>
                                        <input type="text" class="form-control" placeholder="Gallery Name"
                                               name="gallery_name_ru">
                                    </div>
                                </div>
                                <div class="x_title no_border">
                                    <h2>Gallery Description
                                        <small>(Russian Version)</small> <span class="required">*</span>
                                    </h2>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x-content">
                                    <div class="x-content">
                                        <textarea class="tinymce" name="gallery_desc_ru" id="desc_ru"></textarea>
                                    </div>
                                </div>
                            </div>
                            <!--tab content end-->

                        </div>
                    </div>
                </div>

                <div class="x_panel">
                    <p>Drag multiple images to the box below for multi upload or click to select files. Required maximum
                        with for images should be 1000px.</p>

                    <p>
                        <label for="files" class="admin-image-label">
                            <input accept="image/*" type="file" name="files[]" multiple id="files" class="admin-image-upload">
                        </label>
                    </p>
                    <br/>
                    <div>
                        <h2>Uploaded images</h2>
                        <div class="clearfix"></div>
                    </div>
                    <br/>
                    <br/>
                    <br/>
                    <div>
                        <h2>Main images</h2>
                        <div class="clearfix"></div>
                    </div>
                    <p>
                        <input accept="image/*" type="file" name="main_image" size="chars" id="main_image">
                    </p>
                    <br/>
                    <br/>
                    <div class="row">
                        <div class="checkbox-custom">
                            <label class="">
                                <div class="icheckbox_flat-green" style="position: relative;">
                                    <input type="checkbox"
                                           class="flat"
                                           name="portfolio"
                                           id="visibility"
                                           style="position: absolute; opacity: 0;">
                                    <ins class="iCheck-helper"
                                         style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                </div>
                                <span>Portfolio</span> </label>
                        </div>
                        <div class="checkbox-custom">
                            <label class="">
                                <div class="icheckbox_flat-green" style="position: relative;">
                                    <input type="checkbox"
                                           class="flat"
                                           name="gallery"
                                           id="visibility"
                                           style="position: absolute; opacity: 0;">
                                    <ins class="iCheck-helper"
                                         style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: rgb(255, 255, 255); border: 0px; opacity: 0;"></ins>
                                </div>
                                <span>Gallery</span> </label>
                        </div>
                    </div>
                    <br/>
                    <br/>
                    <div class="">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <button type="button" class="btn btn-default" onclick="window.location.href='{{url()->previous()}}'">Cancel</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
