@extends('admin.layouts.dashboard_layout')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <a href="{{route('admin-new-pdf')}}" class="btn btn-primary btn-md add_new">Add New PDF</a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2>PDF Library</h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>PDF Name</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>


                                <tbody>
                                @if(null !== $files)
                                    @foreach($files as $file)
                                        <tr id="cnt-{{$file->id}}">
                                            <td>{{$file->pdf_name_en}}</td>
                                            <td style="text-align:right;">
                                                <a href="{{url('admin/edit-pdf/'.$file->id)}}"
                                                   class="btn btn-info btn-xs"><i class="fa fa-pencil"></i> Edit </a>
                                                <a href="#" class="btn btn-danger btn-xs remove" id="{{$file->id}}/pdf"
                                                   data-name="{{$file->pdf_name_en}}"
                                                   data-toggle="modal" data-target="#delete_modal"><i
                                                            class="fa fa-trash-o"></i> Delete </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
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
                    <h4 class="modal-title">Are you sure <span id="item-name"></span>?</h4>
                </div>
                <div class="modal-body row text-center">
                    <button type="button" class="btn btn-default" data-dismiss="modal" id="cancel">No</button>
                    <button type="button" class="btn btn-success" id="confirm">Yes</button>
                </div>
            </div>

        </div>
    </div>
@endsection