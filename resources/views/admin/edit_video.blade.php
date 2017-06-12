@extends('admin.layouts.dashboard_layout')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            @if(count($errors))
                <div class="x_panel">
                    @foreach($errors as $error)
                        {{$error}}<br>;
                    @endforeach
                </div>
                @endif
            <form action="{{route('admin-new-video')}}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="video_id" value={{$video->id}}>
            <div class="clearfix"></div>
                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">English</a>
                    </li>
                    <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Russian</a>
                    </li>
                </ul>
                <div id="myTabContent" class="tab-content">
                    <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">

                        <!--tab content start-->
                        <div class="x_panel">

                            <div class="x_title">
                                <h2>Add/Edit Video</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="video_title_en">Video Title<span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="video_title_en" name="video_title_en" required="required" class="form-control col-md-7 col-xs-12" placeholder="Title (English)" value="{{$video->video_title_en}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="video_url_en">Video URL form Youtube<span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="video_url_en" name="video_url_en" required="required" class="form-control col-md-7 col-xs-12"  value="{{$video->video_url_en}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Video Thumbnail <span class="required">*</span>
                                        </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="file" name="video_thumbnail_en">
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                            (Required size is 350x200px)
                                        </div>

                                    </div>
                                </div>
                                <div class="custom-image-viewer">
                                    <div class="custom-image-viewer-item"><img src="{{asset($video->video_thumbnail_en)}}" alt=""></div>
                                </div>
                            </div>

                        </div>
                        <!--tab content end-->
                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                        <!--tab content start-->
                        <div class="x_panel">

                            <div class="x_title">
                                <h2>Add/Edit Video</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Video Title<span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="video_title_ru" required="required" name="video_title_ru" class="form-control col-md-7 col-xs-12" placeholder="Title (Russian)"  value="{{$video->video_title_ru}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="video_url_ru">Video URL form Youtube<span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="video_url_ru" required="required" name="video_url_ru" class="form-control col-md-7 col-xs-12"  value="{{$video->video_url_ru}}">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Video Thumbnail <span class="required">*</span>
                                        </label>
                                        <div class="col-md-4 col-sm-4 col-xs-12">
                                            <input type="file" name="video_thumbnail_ru">
                                        </div>
                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                            (Required size is 350x200px)
                                        </div>
                                    </div>
                                    <div class="custom-image-viewer">
                                        <div class="custom-image-viewer-item"><img src="{{asset($video->video_thumbnail_ru)}}" alt=""></div>
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
                                <button type="button" class="btn btn-default" onclick="window.location.href='{{url()->previous()}}'">Cancel</button>
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>


            </form>



        </div>
    </div>
@endsection