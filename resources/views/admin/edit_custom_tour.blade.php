@extends('admin.layouts.dashboard_layout')
@section('content')
    <div class="right_col" role="main">
        <div class="">
            <form action="{{route('admin-post-new-custom-tour')}}" method="post">
                <input type="hidden" value="{{$tour->id}}" name="tour_id">
                <div class="page-title">
                    <div class="title_left">
                        <h3>Add/Edit Custom Tour</h3>
                    </div>
                </div>
                <div class="clearfix"></div>
                @if ($errors->has())
                    <div class="alert alert-danger">
                        <strong>Whoops!</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="x_panel">
                    <div class="row">
                        <div class="form-horizontal form-label-left">
                            <div class="form-group">
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label>Tour Name <span class="required">*</span></label>
                                    <input type="text" class="form-control" placeholder="Tour Name" name="tour_name_en" value="{{$tour->tour_name_en}}">
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <label>Traveler Email Address</label>
                                    <input type="text" class="form-control" placeholder="Traveler Email Address" name="traveler_email" value="{{$tour->traveler_email}}">
                                </div>
                                <div class="clearfix"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!--tab content start-->
                <div class="x_panel">
                    <div class="x_title no_border">
                        <h2>Tour Description <span class="required">*</span></h2>
                        <div class="clearfix"></div>
                    </div>
                    <textarea class="tinymce" name="desc_en" id="desc_en">{{$tour->desc_en}}</textarea>

                    <div class="margin-b-10">
                        <div class="x_title">
                            <h2>Program by days</h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 margin-b-10">
                            <div class="form-group">
                                <div id="custom_day_container_en">
                                    @if(isset($tourDays) && !empty($tourDays))
                                        @foreach($tourDays as $key => $custom_day)
                                            <div class="custom_day">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Day {{$key+1}}</label>
                                                <div class="col-md-9 col-sm-9 col-xs-12 margin-b-10">
                                                    <input type="text" class="form-control input-medium"
                                                           name="custom_day_title_en[]"
                                                           placeholder="title" value="{{$custom_day['title_en']}}">
                                                </div>
                                                <div class="col-md-9 col-sm-9 col-xs-12 margin-b-10 col-md-offset-3 col-sm-offset-3">
              <textarea rows="4" class="resizable_textarea form-control"
                        placeholder="description"
                        name=custom_day_desc_en[]">{{$custom_day['desc_en']}}</textarea>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        @endforeach
                                    @elseif(isset($tour->customDays) && !empty($tour->customDays))
                                        @foreach($tour->customDays as $key => $custom_day)
                                            <div class="custom_day">
                                                <label class="control-label col-md-3 col-sm-3 col-xs-12">Day {{$key+1}}</label>
                                                <div class="col-md-9 col-sm-9 col-xs-12 margin-b-10">
                                                    <input type="text" class="form-control input-medium"
                                                           name="custom_day_title_en[]"
                                                           placeholder="title" value="{{$custom_day->title_en}}">
                                                </div>
                                                <div class="col-md-9 col-sm-9 col-xs-12 margin-b-10 col-md-offset-3 col-sm-offset-3">
          <textarea rows="4" class="resizable_textarea form-control"
                    placeholder="description"
                    name=custom_day_desc_en[]">{{$custom_day->desc_en}}</textarea>
                                                </div>
                                                <div class="clearfix"></div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="col-md-12 col-sm-12 col-xs-12">
                                    <a class="btn add_day"><span><i class="fa fa-plus"></i> Add Day</span></a>
                                    <a class="btn remove_day" style="float:right;"><span><i class="fa fa-remove"></i> Remove Last Day</span></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <!--tab content end-->

                <div class="x_panel">
                    <div class="form-group" style="margin:10px 0 0;">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Price</label>
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <input type="text" class="form-control" placeholder="" name="tour_price" value="{{$tour->tour_price}}">
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3" style="line-height:34px;"></div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="form-group" style="margin:20px 0 20px;">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tour Day</label>
                        <div class="col-md-3 col-sm-3 col-xs-3">
                            <input type="text" class="form-control" placeholder="" name="tour_day" value="{{$tour->tour_day}}">
                        </div>
                        <div class="col-md-3 col-sm-3 col-xs-3" style="line-height:34px;"></div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2>Add Hotels</h2>
                                <ul class="nav navbar-right panel_toolbox panel_toolbox_custom">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                </ul>
                                <div class="clearfix"></div>
                            </div>
                            <div class="x_content">
                                <div class="row">
                                    <div class="col-md-12 col-sm-12 col-xs-12 margin-b-10">
                                        <div class="form-group">
                                            <div class="custom_day">
                                                @if(isset($tourHotels) && !empty($tourHotels))
                                                    @foreach($tourHotels as $tourHotel)
                                                        <div class="hotel-container">
                                                            <div class="new_hotel">
                                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                                    Hotel
                                                                    <select class="form-control" name="hotel[hotel_id][]">
                                                                        @foreach($hotels as $hotel)
                                                                            @if($tourHotel['hotel_id'] == $hotel->id)
                                                                                <option value="{{$hotel->id}}" selected>{{$hotel->hotel_name_en}}</option>
                                                                            @else
                                                                                <option value="{{$hotel->id}}">{{$hotel->hotel_name_en}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                                    Single Adult (12-99) <span class="required">*</span>
                                                                    <input type="text" class="form-control" placeholder="Price" name="hotel[single_adult][]" value="{{$tourHotel['single_adult']}}">
                                                                </div>
                                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                                    Double Adult (12-99) <span class="required">*</span>
                                                                    <input type="text" class="form-control" placeholder="Price" name="hotel[double_adult][]" value="{{$tourHotel['double_adult']}}">
                                                                </div>
                                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                                    Tripple Adult (12-99) <span class="required">*</span>
                                                                    <input type="text" class="form-control" placeholder="Price" name="hotel[triple_adult][]" value="{{$tourHotel['triple_adult']}}">
                                                                </div>



                                                                <div class="col-md-3 col-sm-3 col-xs-12">

                                                                </div>
                                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                                    Child (4-11) <span class="required">*</span>
                                                                    <input type="text" class="form-control" placeholder="Price" name="hotel[child][]" value="{{$tourHotel['child']}}">
                                                                </div>
                                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                                    Infant (0-4) <span class="required">*</span>
                                                                    <input type="text" class="form-control" placeholder="Price" name="hotel[infant][]" value="{{$tourHotel['infant']}}">
                                                                </div>



                                                                <div class="clearfix margin-b-10"></div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @elseif($tour->hotels)
                                                    @foreach($tour->hotels as $tourHotel)
                                                        <div class="hotel-container">
                                                            <div class="new_hotel">
                                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                                    Hotel
                                                                    <select class="form-control" name="hotel[hotel_id][]">
                                                                        @foreach($hotels as $hotel)
                                                                            @if($tourHotel->id == $hotel->id)
                                                                                <option value="{{$hotel->id}}" selected>{{$hotel->hotel_name_en}}</option>
                                                                            @else
                                                                                <option value="{{$hotel->id}}">{{$hotel->hotel_name_en}}</option>
                                                                            @endif
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                                    Single Adult (12-99) <span class="required">*</span>
                                                                    <input type="text" class="form-control" placeholder="Price" name="hotel[single_adult][]" value="{{$tourHotel->single_adult}}">
                                                                </div>
                                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                                    Double Adult (12-99) <span class="required">*</span>
                                                                    <input type="text" class="form-control" placeholder="Price" name="hotel[double_adult][]" value="{{$tourHotel->double_adult}}">
                                                                </div>
                                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                                    Tripple Adult (12-99) <span class="required">*</span>
                                                                    <input type="text" class="form-control" placeholder="Price" name="hotel[triple_adult][]" value="{{$tourHotel->triple_adult}}">
                                                                </div>



                                                                <div class="col-md-3 col-sm-3 col-xs-12">

                                                                </div>
                                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                                    Child (4-11) <span class="required">*</span>
                                                                    <input type="text" class="form-control" placeholder="Price" name="hotel[child][]" value="{{$tourHotel->child}}">
                                                                </div>
                                                                <div class="col-md-3 col-sm-3 col-xs-12">
                                                                    Infant (0-4) <span class="required">*</span>
                                                                    <input type="text" class="form-control" placeholder="Price" name="hotel[infant][]" value="{{$tourHotel->infant}}">
                                                                </div>



                                                                <div class="clearfix margin-b-10"></div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <div class="hotel-container">
                                                        <div class="new_hotel">
                                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                                Hotel
                                                                <select class="form-control" name="hotel[hotel_id][]">
                                                                    @foreach($hotels as $hotel)
                                                                        <option value="{{$hotel->id}}">{{$hotel->hotel_name_en}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                                Single Adult (12-99) <span class="required">*</span>
                                                                <input type="text" class="form-control" placeholder="Price" name="hotel[single_adult][]">
                                                            </div>
                                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                                Double Adult (12-99) <span class="required">*</span>
                                                                <input type="text" class="form-control" placeholder="Price" name="hotel[double_adult][]">
                                                            </div>
                                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                                Tripple Adult (12-99) <span class="required">*</span>
                                                                <input type="text" class="form-control" placeholder="Price" name="hotel[triple_adult][]">
                                                            </div>



                                                            <div class="col-md-3 col-sm-3 col-xs-12">

                                                            </div>
                                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                                Child (4-11) <span class="required">*</span>
                                                                <input type="text" class="form-control" placeholder="Price" name="hotel[child][]">
                                                            </div>
                                                            <div class="col-md-3 col-sm-3 col-xs-12">
                                                                Infant (0-4) <span class="required">*</span>
                                                                <input type="text" class="form-control" placeholder="Price" name="hotel[infant][]">
                                                            </div>



                                                            <div class="clearfix margin-b-10"></div>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="col-md-12 col-sm-12 col-xs-12">
                                                    <a type="button" id="add_hotel" class="btn"><span><i class="fa fa-plus"></i> Add Hotel</span></a>
                                                    <a type="button" id="remove_hotel" class="btn" style="float:right"><span><i class="fa fa-remove"></i> Remove Hotel</span></a>
                                                </div>
                                                <div class="clearfix margin-b-10"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="x_panel">
                    <div class="x_content">
                        <div class="add_new">
                            <input type="hidden" name="_token" value="{{csrf_token()}}">
                            <button type="button" class="btn btn-default" onclick="window.location.href='{{url()->previous()}}'">Cancel</button>
                            <button type="submit" class="btn btn-success">Generate and Send to Traveler</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection