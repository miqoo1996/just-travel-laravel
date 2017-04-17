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
                    <div class="count">2,500</div>
                    <span class="count_top">Tours</span>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                    <div class="count">123</div>
                    <span class="count_top">Hotels</span>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                    <div class="count">2,500</div>
                    <span class="count_top">Orders</span>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                    <div class="count">$4,567</div>
                    <span class="count_top">Turnover Tours</span>

                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                    <div class="count">0,00</div>
                    <span class="count_top">Turnover Hotels</span>
                </div>
                <div class="col-md-2 col-sm-4 col-xs-6 tile_stats_count">
                    <div class="count green">$4,567</div>
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
                                <tr>
                                    <td>Naira</td>
                                    <td>Khor Virap</td>
                                    <td>12.12.2017</td>
                                    <td>$500</td>
                                    <td>info@justtravel.am</td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-xs">Success</button>
                                    </td>
                                    <td align="right">
                                        <a href="#" class="btn btn-success btn-xs"><i class="fa fa-download"></i> Vaucher</a>
                                        <a href="#" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> View</a>
                                        <a href="#" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Edgar Darbinyan</td>
                                    <td>Geghard</td>
                                    <td>12.10.2016</td>
                                    <td>$470</td>
                                    <td>darbinyan@gmail.com</td>
                                    <td>
                                        <button type="button" class="btn btn-danger btn-xs">Error</button>
                                    </td>
                                    <td align="right">
                                        <a href="#" class="btn btn-success btn-xs"><i class="fa fa-download"></i> Vaucher</a>
                                        <a href="#" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> View</a>
                                        <a href="#" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>Poghos Poghosyan</td>
                                    <td>Ejmiadzin</td>
                                    <td>12.12.2017</td>
                                    <td>$70</td>
                                    <td>poghos.poghosyan@gmail.com</td>
                                    <td>
                                        <button type="button" class="btn btn-success btn-xs">Success</button>
                                    </td>
                                    <td align="right">
                                        <a href="#" class="btn btn-success btn-xs"><i class="fa fa-download"></i> Vaucher</a>
                                        <a href="#" class="btn btn-primary btn-xs"><i class="fa fa-folder"></i> View</a>
                                        <a href="#" class="btn btn-danger btn-xs"><i class="fa fa-trash-o"></i> Delete</a>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>






            </div>
        </div>
    </div>
@endsection