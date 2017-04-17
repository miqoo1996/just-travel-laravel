@extends('admin.layouts.dashboard_layout')
@section('title')
    Tour Categories | JustTravel
@endsection
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="clearfix"></div>


            <form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left" action="{{route('admin-post-new-category')}}" method="post">
                <input type="hidden" name="category_id" value="{{$category->id}}">
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
                                <h2>Add/Edit Category</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">


                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Category Name<span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="cat_name_en" name="category_name_en" value="{{$category->category_name_en}}" required="required" class="form-control col-md-7 col-xs-12 category-holder" placeholder="Category Name (English)">
                                        </div>
                                    </div>

                            </div>

                        </div>
                        <!--tab content end-->



                    </div>
                    <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">
                        <!--tab content start-->
                        <div class="x_panel">

                            <div class="x_title">
                                <h2>Add/Edit Category</h2>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Category Name<span class="required">*</span>
                                        </label>
                                        <div class="col-md-6 col-sm-6 col-xs-12">
                                            <input type="text" id="cat_name_ru" name="category_name_ru" value="{{$category->category_name_ru}}" required="required" class="form-control col-md-7 col-xs-12 category-holder" placeholder="Category Name (Russian)">
                                        </div>
                                    </div>

                            </div>

                        </div>
                        <!--tab content end-->
                    </div>
                    <div class="x_panel">

                        <div class="x_title">
                            <h2>Tour Category URL</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">


                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="text" id="cat_name_en" name="url" required="required" class="form-control col-md-7 col-xs-12 category-holder" value="{{$category->url}}">
                                </div>
                            </div>

                        </div>

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
            </div>
            </form>
        </div>
    </div>
@endsection