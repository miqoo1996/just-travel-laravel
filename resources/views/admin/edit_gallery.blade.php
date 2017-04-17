@extends('admin.layouts.dashboard_layout')
@section('content')
    <div class="right_col" role="main">
        <div class="x_content">
            <form action="{{route('admin-post-new-gallery')}}" method="post" enctype="multipart/form-data">
                <input type="hidden" name="gallery_id" value="{{$gallery->id}}">
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
                                    <input type="text" class="form-control" placeholder="Gallry URL" name="gallery_url" value="{{$gallery->gallery_url}}">
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <label>Gallery Name</label>
                                    <input type="text" class="form-control" placeholder="Gallery Name" name="gallery_name" value="{{$gallery->gallery_name}}">
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
                        <ul class="list-unstyled custom-image-viewer">
                            @foreach($gallery['images'] as $image)
                                @if(empty($image))
                                    <div><p class="alert warning">No images</p></div>
                                @else
                                    <li class="col-lg-2 custom-image-viewer-item">
                                        <div>
                                            <span class="-remove custom-image-remove-button" id={{'gallery?' .$image->id . '?gallery?' . $image->image_path}}></span>
                                            <img src="{{URL::asset('/' . $image->image_path)}}" alt="profile Pic">
                                        </div>
                                    </li>
                                @endif

                            @endforeach
                        </ul>
                    </div>
                    <div>
                        <h2>Gallery main image</h2>
                        <div class="clearfix"></div>
                    </div>
                    <p>
                        <input type="file" name="main_image" size="chars" id="main_image">
                    </p>
                    @if(null !== $gallery->main_image)
                        <div class="custom-image-viewer-item"><img src="{{URL::asset('/' . $gallery->main_image)}}" alt="profile Pic" width="400"></div>
                    @else
                        <div><p class="alert warning">No image</p></div>
                    @endif
                    <br>
                    <br>
                    <br>
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
