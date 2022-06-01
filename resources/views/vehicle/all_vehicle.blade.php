@extends('partials._layout')
@section('content')
<div class="card">
    <div class="card-header card-header-new card-header-dark">
        <h4 align="center"><span class="fa fa-truck"></span>&nbsp;Vehicle To Accomplish</h4>
    </div>
    <div class="card-body">
        <div class="row">
            <!-- 1st col -->
            <div class="col-sm">
                &nbsp;
                <div class="row">
                    <div class="col-sm-6">
                        <div class="input-group mb-3">
                            <span class="input-group-text bg-info" id="basic-addon3">
                                <span class="fa fa-search">&nbsp;</span>
                                Search
                            </span>
                            <input type="text" placeholder="Type here..." class="form-control text_search" id="basic-url" aria-describedby="basic-addon3">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <table class="table-sm table table-bordered table-striped searchTable no-footer" id="tickets_table" align="center" role="grid" aria-describedby="tickets_table_info">
                        <thead>
                            <tr class="text-center">
                                <th width="10%">Date Requested</th>
                                <th width="15%">Purpose of Trip</th>
                                <th width="10%">Date and Time Needed</th>
                                <th width="15%">Destination</th>
                                <th width="10%">Status</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($vehicle as $data)


                            <tr class="text-center">
                                <td>{{ $my_date_req = date('F j, Y g:i A', strtotime($data->created_at)) }}</td>
                                <td>{{$data->purpose}}</td>
                                <td>{{ $my_date_needed = date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
                                <td>{{$data->destination}}</td>
                                <td>
                                    @if($data->status=='Filing')
                                    <span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

                                    @elseif($data->status == "For CAO Approval" || $data->status == "For DC Approval")
                                    <span class="right badge badge-warning">{{ ucwords(strtoupper($data->status)) }}</span>

                                    @elseif($data->status == "Cancelled")
                                    <span class="right badge badge-danger">{{ ucwords(strtoupper($data->status)) }}</span>

                                    @elseif($data->status=='Approved')
                                    <span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>

                                    @elseif($data->status == "Out For Delivery")
                                    <span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

                                    @else
                                    <span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
                                    @endif
                                </td>
                                <td>
                                    @if($data->status!='Filing')
                                    <button onclick="_viewPassenger('{{$data->id}}', '{{$my_date_req}}', '{{$my_date_needed}}')" class="btn btn-sm btn-info">
                                        <span class="fa fa-users"></span>
                                    </button>
                                    @endif
                                    @if($data->status =='For Pickup')
                                    <button onclick="_otw_modal('{{$data->id}}')" class="btn btn-primary btn-sm">
                                        <span class="fa fa-truck"></span>
                                    </button>
                                    @endif

                                    @if($data->status=='On The Way')
                                    <button onclick="_markAccomplish('{{$data->id}}', '{{$data->subject}}')" class="btn btn-success btn-sm">
                                        <span class="fa fa-check"></span>
                                    </button>
                                    @endif

                                    @if($data->status =='Accomplished')
                                    <button class="btn btn-warning btn-sm" onclick="_attachmentAgent('{{$data->id}}')">
                                        <span class="fa fa-file"></span>
                                    </button>
                                    @endif
                                    <a href="{{URL::to('/vehicle_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
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
<div class="modal fade" id="passenger_modal" tabindex="-1" aria-labelledby="trip_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="trip_modalLabel">
                    <span class="fa fa-users"></span>
                    <span id="passenger_header">Passenger(s)</span>
                </h5>
            </div>

            <div class="modal-body">
                <div class="row">
                    <input type="hidden" id="psg_vehicle_id" name="psg_vehicle_id">
                    <div class="col-sm">
                        <table>
                            <tbody>

                                <tr>
                                    <td style="text-align:right"><b>DATE OF REQUEST:&nbsp;</b></td>
                                    <td id="td_date_req"></td>
                                </tr>
                                <tr>
                                    <td style="text-align:right"><b>PURPOSE:&nbsp;</b></td>
                                    <td id="td_purpose"></td>
                                </tr>
                                <tr>
                                    <td style="text-align:right"><b>DATE NEEDED:&nbsp;</b></td>
                                    <td id="td_date_needed"></td>
                                </tr>
                                <tr>
                                    <td style="text-align:right"><b>DESTINATION:&nbsp;</b></td>
                                    <td id="td_destination"></td>
                                </tr>
                                <tr>
                                    <td style="text-align:right"><b>STATUS:&nbsp;</b></td>
                                    <td id="td_status" style="color:blue"></td>
                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <label id="lbl_passenger">Add Passenger: &nbsp;</label>
                                <span id="asterisk" class="text-red">*</span>

                                <div class="input-group">
                                    <input type="text" placeholder="Type passenger name here..." class="form-control" name="passenger" id="passenger">
                                    <div class="input-group-append">
                                        <button class="btn btn-primary" name="btn_passenger" id="btn_passenger" type="button" onclick="add_psg_list($('#passenger').val())">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="row">
                            <div class="col-md-12">
                                <label>Passenger(s): </label>
                                <div class='scrolledTable' style='height:300px;'>
                                    <table class="table table-striped table-bordered table-sm">
                                        <tbody id="my_tbody">
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#passenger_modal">
                    Close
                </button>
                <form action="{{URL::to('/vehicle/submit')}}" method="POST">
                    @csrf

                    <input type="hidden" id="submit_psg_id" name="submit_psg_id">
                    <center><button type="submit" name="submit_button" id='submit_button' class="btn btn-success">
                            <span class="fa fa-check"></span>
                            Submit Request
                        </button>
                    </center>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Accomplish modal -->
<div class="modal fade" id="accomplish_modal" data-toggle="modal" data-dismiss="modal" tabindex="-1" aria-labelledby="accomplish_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="accomplish_modalLabel">
                    <span id="modal_header" class="fa fa-file"></span>&nbsp;
                    <span>Attachment/s for Request - </span>
                    <span id="header_destination"></span>
                </h5>
            </div>
            <input type="hidden" id="vehicle_id" name="vehicle_id">
            <div class="modal-body modal-lg">
                <div class="row">
                    
                    <br>
                    <div class="col-sm">
                        <label>Upload Documents </label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="file" name="file">
                            <label class="custom-file-label" for="file"></label>
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm">
                        <label>Remarks (optional)</label>
                        <textarea class="form-control" rows="5" id="remarks" name="remarks"></textarea>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-sm">
                        <button id="btn_editRequest" type="submit" onclick="_submitFile()" class="btn btn-info float-right">
                            <span class="fa fa-plus"></span>
                            <span>Add to List</span>
                        </button>
                    </div>
                </div>
                <br>

                <div class="row">
                    <div class="col-sm">
                        <small> <span class="fa fa-exclamation-circle text-red"></span>
                            <b>Note: </b>
                            Upload attachment/s as proof that vehicle request is completed.
                        </small>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm">
                        <table class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th width="25%">Trip</th>
                                    <th width="30%">File</th>
                                    <th width="40%">Remarks</th>
                                    <th width="5%"></th>
                                </tr>
                            </thead>
                            <tbody id="file_body">
                                <td></td>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection

@section('js')
<script src="{{ asset('js/table.js') }}"></script>
<script src="{{ asset('js/vehicle.js') }}"></script>
@endsection