@extends('admin.layouts.dashboard_layout')
@section('content')
    <div class="right_col" role="main">
        <div class="x_content">
            <form action="{{route('admin-post-new-gallery')}}" method="post" enctype="multipart/form-data">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Gallery Name</h2>
                        <div class="clearfix"></div>
                    </div>
                    <div class="row">
                        <div class="form-horizontal form-label-left">
                            <div class="form-group">
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <label>Gallery URL</label>
                                    <input type="text" class="form-control" placeholder="Gallry URL" name="gallery_url">
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <label>Gallery Name</label>
                                    <input type="text" class="form-control" placeholder="Gallery Name" name="gallery_name">
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
                <div class="x_panel">
                    <p>Drag multiple images to the box below for multi upload or click to select files. Required maximum with for images should be 1000px.</p>
                    {{--<div class="dropzone dz-clickable dz-started" id="hotel_images_dropzone"></div>--}}
                    {{--<div id="dropzone-hidden-area"></div>--}}
                    <p>
                        <input type="file" name="files[]" multiple id="files">
                    </p>
                    <br />
                    <div>
                        <h2>Uploaded images</h2>
                        <div class="clearfix"></div>
                    </div>
                    <br />
                    <br />
                    <br />
                    <div>
                        <h2>Main images</h2>
                        <div class="clearfix"></div>
                    </div>
                    <p>
                        <input type="file" name="main_image" size="chars" id="main_image">
                    </p>
                    <div class="">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <button type="button" class="btn btn-default">Cancel</button>
                        <button type="submit" class="btn btn-success">Save</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
