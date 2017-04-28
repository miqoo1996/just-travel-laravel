@extends('admin.layouts.dashboard_layout')
@section('content')
    <div class="right_col" role="main">
        <form action="{{route('admin-post-new-page')}}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="page_id" value="{{$page->id}}">
            <div class="">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Add/Edit Page</h3>
                    </div>
                </div>
                <div class="clearfix"></div>


                <div class="x_panel">
                    <div class="row">
                        <div class="form-horizontal form-label-left">
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label>Page URL</label>
                                    <input type="text" class="form-control" placeholder="Page URL" name="page_url"
                                           value="{{$page->page_url}}">
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

                                <div class="x_title no_border">
                                    <h2>Page Name
                                        <small>(English Version)</small>
                                    </h2>
                                    <div class="clearfix"></div>
                                </div>
                                <input type="text" class="form-control input-lg" placeholder="Page Name"
                                       name="page_name_en" value="{{$page->page_name_en}}">

                                <br/>

                                <div class="x_title no_border">
                                    <h2>Tour Description
                                        <small>(English Version)</small>
                                    </h2>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="x-content">
                                    <textarea class="tinymce" name="desc_en" id="desc_en">{{$page->desc_en}}</textarea>
                                </div>
                            </div>
                            <!--tab content end-->
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

                            <!--tab content start-->
                            <div class="x_panel">

                                <div class="x_title no_border">
                                    <h2>Page Name
                                        <small>(Russian Version)</small>
                                    </h2>
                                    <div class="clearfix"></div>
                                </div>
                                <input type="text" class="form-control input-lg" placeholder="Page Name"
                                       name="page_name_ru" value="{{$page->page_name_ru}}">

                                <br/>

                                <div class="x_title no_border">
                                    <h2>Tour Description
                                        <small>(Russian Version)</small>
                                    </h2>
                                    <div class="clearfix"></div>
                                </div>


                                <div class="x_content">
                                    <textarea class="tinymce" name="desc_ru" id="desc_ru">{{$page->desc_ru}}</textarea>
                                </div>
                            </div>
                            <!--tab content end-->

                        </div>
                    </div>
                </div>


                <div class="x_panel">
                    <div class="x_title">
                        <h2>Page Header Image</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <div id="alerts"></div>
                        <div class="form-group">
                            <h2>Page Image (Optimal size is 1920x400px)</h2>
                            <p><input type="file" name="image" size="chars"></p>
                        </div>
                    </div>
                </div>
                <div class="custom-image-viewer">
                    <div class="custom-image-viewer-item"><img src="{{asset($page->image)}}" alt=""></div>
                </div>


                <div class="x_panel">
                    <div class="x_content">

                        <div class="checkbox-custom">
                            <label>
                                <input type="checkbox" class="flat" name="visibility" @if($page->visibility == 'on') checked="checked" @endif> Visible on Right menu
                            </label>
                        </div>
                        <br>
                        <div class="checkbox-custom">
                            <label>
                                <input type="checkbox" class="flat" name="footer" @if($page->footer == 'on') checked="checked" @endif> Visible on Footer menu
                            </label>
                        </div>

                        <div class="clearfix"></div>

                        <div class="ln_solid"></div>
                        <div class="">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <button type="button" class="btn btn-danger">Delete</button>
                            <button type="button" class="btn btn-default">Cancel</button>
                            <button type="submit" class="btn btn-success">Save</button>
                        </div>

                    </div>
                </div>


            </div>
        </form>
    </div>
@endsection