@extends('admin.layouts.dashboard_layout')
@section('content')
    <div class="right_col" role="main">
    <div class="">
        <div class="clearfix"></div>



        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <a href="{{route('admin-new-tour')}}" class="btn btn-primary btn-md add_new">Add New Tour </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title">

                        <h2>Tour List</h2>

                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        @if($tours)
                        <table id="datatable-buttons" class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Tour name</th>
                                <th>Tour Category</th>
                                <th>Price</th>
                                <th>Hot</th>
                                <th>Tour Type</th>
                                <th>Actions</th>
                            </tr>
                            </thead>


                            <tbody>
                            @foreach($tours as $tour)
                                <tr id="cnt-{{$tour->id}}">
                                    <td>{{$tour->tour_name_en}}</td>
                                    <td>{{$tour->tour_category}}</td>


                                    @if((null == $tour->price) && ($tour->type !== 'custom'))
                                        <td>{{$tour->basic_price_adult}}</td>
                                    @elseif ($tour->type == 'custom')
                                        <td>{{$tour->tour_price}}</td>
                                    @else
                                        <td>{{$tour->price->single_adult}}</td>
                                    @endif
                                    <td>{{$tour->hot}}</td>
                                    <td>{{$tour->type}}</td>
                                    <td style="text-align:right;">
                                        <a href="{{$tour->tour_url}}" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i>  </a>
                                        @if($tour->type == 'custom')
                                            <a href="{{url('admin/edit-custom-tour/'.$tour->id)}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                                        @else
                                            <a href="{{url('admin/edit-tour/'.$tour->id)}}" class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                                        @endif
                                            <a href="#" class="btn btn-danger btn-xs remove" id="{{$tour->id}}/tour" data-toggle="modal" data-target="#delete_modal"><i class="fa fa-trash-o"></i> Delete </a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                            @else
                            <h1>NO Tours</h1>
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