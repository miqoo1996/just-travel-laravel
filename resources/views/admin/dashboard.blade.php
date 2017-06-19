@extends('admin.layouts.dashboard_layout')
@section('title')
    Tours | JustTravel
@endsection
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <div class="clearfix"></div>

            <!-- top tiles -->
            <div class="row tile_count">
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                    <div class="count">{{$tours_count}}</div>
                    <span class="count_top">Tours</span>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                    <div class="count">{{$hotels_count}}</div>
                    <span class="count_top">Hotels</span>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                    <div class="count">{{count($success_orders)}}</div>
                    <span class="count_top">Orders</span>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                    <div class="count">{{$total_amount}}</div>
                    <span class="count_top">Turnover Tours</span>

                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                    <div class="count green">{{$total_amount}}</div>
                    <span class="count_top">Total</span>
                </div>
            </div>
            <!-- /top tiles -->

            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">

                            <h2>Tour List</h2>

                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">

                            <table id="datatable-buttons" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <th>Traveler Name</th>
                                    <th>Tour Name</th>
                                    <th>Purchase date</th>
                                    <th>Price</th>
                                    <th>Contact</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>


                                <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{$order->lead_name . ' ' . $order->lead_surname}}</td>
                                        <td>{{$order->tour_name_en}}</td>
                                        <td>{{$order->date_from}}</td>
                                        <td>{{$order->Amount / 100}}</td>
                                        <td>{{$order->lead_email}}</td>
                                        <td>
                                        @if($order->OrderStatus == 2)

                                            <button type="button" class="btn btn-success btn-xs">Success</button>

                                        @else
                                            <button type="button" class="btn btn-danger btn-xs">Error</button>
                                        @endif
                                        </td>
                                        <td align="right">
                                            <a href="{{url('/admin/voucher/'.$order->order_tour_id)}}" target="_blank" class="btn btn-success btn-xs"><i class="fa fa-download"></i> Vaucher</a>
                                            <a href="{{url('admin/edit-custom-tour/'.$order->order_tour_id)}}" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> View</a>
                                            <a href="#" class="btn btn-danger btn-xs remove" data-name="{{$order->tour_name_en}}" id="{{$order->order_tour_id}}/tour" data-toggle="modal" data-target="#delete_modal"><i class="fa fa-trash-o"></i> Delete </a>
                                        </td>
                                    </tr>
                                @endforeach
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