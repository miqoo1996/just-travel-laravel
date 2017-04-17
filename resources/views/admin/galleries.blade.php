@extends('admin.layouts.dashboard_layout')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="clearfix"></div>





            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <a href="{{route('admin-post-new-gallery')}}" class="btn btn-primary btn-md">Add New Gallery</a>
                    </div>
                </div>
            </div>





            <div class="row">

                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>Photo Galleries</h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            @if(null !== $galleries)
                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Photo Gallery Name</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>


                                <tbody>
                                @foreach($galleries as $gallery)
                                <tr id="cnt-{{$gallery->id}}">
                                    <td>{{$gallery->gallery_name}}</td>
                                    <td style="text-align:right;">
                                        <a href="{{route('admin-edit-gallery', ['gallery_id' => $gallery->id])}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                                        <a href="#" class="btn btn-danger btn-xs remove" id="{{$gallery->id}}/gallery" data-toggle="modal" data-target="#delete_modal"><i class="fa fa-trash-o"></i> Delete </a>
                                    </td>
                                </tr>
                                @endforeach
                                </tbody>
                            </table>
                                @else
                                <div><p>No Galleries</p></div>
                            @endif
                        </div>
                    </div>
                </div>






            </div>
        </div>
    </div>
    {{--MODAL FOR DELETE--}}

    <div class="modal fade" id="delete_modal" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Are you sure?</h4>
                </div>
                <div class="modal-body row text-center">
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    <button type="button" class="btn btn-success" id="confirm">Yes</button>
                </div>
            </div>

        </div>
    </div>
@endsection