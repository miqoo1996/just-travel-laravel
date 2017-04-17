@extends('admin.layouts.dashboard_layout')
@section('content')
    <div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>
        <div class="" role="tabpanel" data-example-id="togglable-tabs">
            <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">English</a>
                </li>
                <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Russian</a>
                </li>
            </ul>
            <form action="{{route('admin-post-new-pdf')}}" method="post" enctype="multipart/form-data">
                <input type="hidden" value="{{$file->id}}" name="file_id">
                <div id="myTabContent" class="tab-content">
                    <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                        <!--tab content start-->
                        <div class="x_panel">

                            <div class="x_title">
                                <h2>Add/Edit PDF</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pdf_name_en">PDF Name<span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="pdf_name_en" name="pdf_name_en" required="required" class="form-control col-md-7 col-xs-12" value="{{$file->pdf_name_en}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pdf_thumbnail_en">PDF Thumbnail<span class="required">*</span>
                                        </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="file" name="pdf_thumbnail_en" size="chars" id="pdf_thumbnail_en">
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                            (Required size is 200x350px)
                                        </div>
                                        <br />
                                        <div class="custom-image-viewer">
                                            <div class="custom-image-viewer-item"><img src="{{asset($file->pdf_thumbnail_en)}}" alt=""></div>
                                        </div>
                                        <br />


                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pdf_file_en">PDF File<span class="required">*</span>
                                        </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="file" name="pdf_file_en" size="chars" id="pdf_file_en">
                                        </div>
                                    </div>
                                    <a href="{{asset($file->pdf_file_en)}}" target="_blank" class="btn btn-default">File</a>
                                </div>
                            </div>

                        </div>
                        <!--tab content end-->
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                        <!--tab content start-->
                        <div class="x_panel">

                            <div class="x_title">
                                <h2>Add/Edit PDF</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pdf_name_ru">PDF Name<span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="pdf_name_ru" name="pdf_name_ru" required="required" class="form-control col-md-7 col-xs-12" value="{{$file->pdf_name_ru}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pdf_thumbnail_ru">PDF Thumbnail<span class="required">*</span>
                                        </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="file" name="pdf_thumbnail_ru" size="chars" id="pdf_thumbnail_ru" value="{{$file->pdf_thumbnail_ru}}">
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                            (Required size is 200x350px)
                                        </div>

                                        <br />
                                        <div class="custom-image-viewer">
                                            <div class="custom-image-viewer-item"><img src="{{asset($file->pdf_thumbnail_ru)}}" alt=""></div>
                                        </div>
                                        <br />

                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="pdf_file_ru">PDF File<span class="required">*</span>
                                        </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="file" name="pdf_file_ru" size="chars" id="pdf_file_ru">
                                        </div>
                                        <a href="{{asset($file->pdf_file_ru)}}" target="_blank" class="btn btn-default">File</a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!--tab content end-->
                    </div>

                    <div class="row">
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <div class="x_panel add_new">
                                <input type="hidden" name="_token" value="{{csrf_token()}}">
                                <button type="submit" class="btn btn-default">Cancel</button>
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
    </div>
@endsection