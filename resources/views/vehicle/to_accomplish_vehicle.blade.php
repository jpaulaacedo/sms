@extends('partials._layout')
@section('content')
<div class="card">
    <div class="card-header card-header-vhl">
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
                                <th width="10%">Date Needed</th>
                                <th width="15%">Requested By</th>
                                <th width="10%">Destination</th>
                                <th width="15%">Status</th>
                                <th width="10%">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vehicle as $data)
                            @if($data->status=='For Assignment')
                            <tr class="text-center">
                                <td>{{ $my_date_req = date('F j, Y g:i A', strtotime($data->created_at)) }}</td>
                                <td>{{$data->purpose}}</td>
                                <td>{{ $my_date_needed = date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
                                <td>{{App\User::get_user($data->user_id)}}</td>
                                <td>{{$data->destination}}</td>
                                <td>
                                    <span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>
                                </td>
                                <td>
                                    <button onclick="_viewPassenger('{{$data->id}}', '{{$my_date_req}}', '{{$my_date_needed}}')" class="btn btn-sm btn-info">
                                        <span class="fa fa-users"></span>
                                    </button> |
                                    <button onclick="_resched_modal('{{$data->id}}')" class="btn btn-primary btn-sm">
                                        <span class="fa fa-calendar"></span>
                                    </button>
                                    <button onclick="_assign_modal('{{$data->id}}')" class="btn btn-success btn-sm">
                                        <span class="fa fa-id-card"></span>
                                    </button>
                                    <a href="{{URL::to('/vehicle_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                            @foreach($vehicle as $data)
                            @if($data->status=='For CAO Approval')
                            <tr class="text-center">
                                <td>{{ $my_date_req = date('F j, Y g:i A', strtotime($data->created_at)) }}</td>
                                <td>{{$data->purpose}}</td>
                                <td>{{ $my_date_needed = date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
                                <td>{{App\User::get_user($data->user_id)}}</td>
                                <td>{{$data->destination}}</td>
                                <td>
                                    <span class="right badge badge-warning">{{ ucwords(strtoupper($data->status)) }}</span>
                                    <br>
                                    <small>Driver: {{$data->driver}} <br> Pickup date: {{ date('F j, Y g:i A', strtotime($data->assigned_pickupdate)) }}</small>
                                </td>
                                <td>
                                    <button onclick="_viewPassenger('{{$data->id}}', '{{$my_date_req}}', '{{$my_date_needed}}')" class="btn btn-sm btn-info">
                                        <span class="fa fa-users"></span>
                                    </button> |

                                    <a href="{{URL::to('/vehicle_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                            @foreach($vehicle as $data)
                            @if($data->status=='Confirmed')
                            <tr class="text-center">
                                <td>{{ $my_date_req = date('F j, Y g:i A', strtotime($data->created_at)) }}</td>
                                <td>{{$data->purpose}}</td>
                                <td>{{ $my_date_needed = date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
                                <td>{{App\User::get_user($data->user_id)}}</td>
                                <td>{{$data->destination}}</td>
                                <td>
                                    <span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
                                    <br>
                                    <small>Driver: {{$data->driver}} <br> Pickup date: {{ date('F j, Y g:i A', strtotime($data->assigned_pickupdate)) }}</small>
                                </td>
                                <td>
                                    <button onclick="_viewPassenger('{{$data->id}}', '{{$my_date_req}}', '{{$my_date_needed}}')" class="btn btn-sm btn-info">
                                        <span class="fa fa-users"></span>
                                    </button> |
                                    <button onclick="_otw_modal('{{$data->id}}')" class="btn btn-primary btn-sm">
                                        <span class="fa fa-truck"></span>
                                    </button>
                                    <a href="{{URL::to('/vehicle_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
                                </td>
                            </tr>
                            @endif
                            @endforeach

                            @foreach($vehicle as $data)
                            @if($data->status=='On The Way')
                            <tr class="text-center">
                                <td>{{ $my_date_req = date('F j, Y g:i A', strtotime($data->created_at)) }}</td>
                                <td>{{$data->purpose}}</td>
                                <td>{{ $my_date_needed = date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
                                <td>{{App\User::get_user($data->user_id)}}</td>
                                <td>{{$data->destination}}</td>
                                <td>
                                    <span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>
                                    <br>
                                    <small>Driver: {{$data->driver}} <br> Pickup date: {{ date('F j, Y g:i A', strtotime($data->otw_pickupdate)) }}</small>
                                </td>
                                <td>
                                    <button onclick="_viewPassenger('{{$data->id}}', '{{$my_date_req}}', '{{$my_date_needed}}')" class="btn btn-sm btn-info">
                                        <span class="fa fa-users"></span>
                                    </button> |
                                    <button onclick="mark_accomplish_modal('{{$data->id}}')" class="btn btn-success btn-sm">
                                        <span class="fa fa-check"></span>
                                    </button>

                                    <a href="{{URL::to('/vehicle_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
                                </td>
                            </tr>
                            @endif
                            @endforeach

                            @foreach($vehicle as $data)
                            @if($data->status=='Accomplished')

                            <tr class="text-center">
                                <td>{{ $my_date_req = date('F j, Y g:i A', strtotime($data->created_at)) }}</td>
                                <td>{{$data->purpose}}</td>
                                <td>{{ $my_date_needed = date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
                                <td>{{App\User::get_user($data->user_id)}}</td>
                                <td>{{$data->destination}}</td>
                                <td>
                                    <span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
                                    <br>
                                    <small>Driver: {{$data->driver}} <br> Pickup date: {{ date('F j, Y g:i A', strtotime($data->outfordel_pickupdate)) }}
                                        <br> Accomplished date: {{ date('F j, Y g:i A', strtotime($data->accomplished_date)) }}</small>
                                </td>
                                <td>
                                    <button onclick="_viewPassenger('{{$data->id}}', '{{$my_date_req}}', '{{$my_date_needed}}')" class="btn btn-sm btn-info">
                                        <span class="fa fa-users"></span>
                                    </button> |

                                    <button class="btn btn-warning btn-sm" onclick="_attachmentAgent('{{$data->id}}')">
                                        <span class="fa fa-file"></span>
                                    </button>
                                    <a href="{{URL::to('/vehicle_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
                                </td>
                            </tr>
                            @endif
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="passenger_modal" data-toggle="modal" data-dismiss="modal" tabindex="-1" aria-labelledby="passenger_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-md modal-dialog-centered">
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
                                <label id="lbl_passenger">Add Passenger:</label>
                                <span id="asterisk" class="text-red">*</span>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                &nbsp;&nbsp;
                                <small><label>Total:</label>
                                    <span id="psg_count"></span>
                                </small>
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
                                <div class='scrolledTable' style="height:300px; width:460px; overflow:auto;">
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
                <!-- <form action="{{URL::to('/vehicle/submit')}}" method="POST">
					@csrf

					<input type="hidden" id="submit_psg_id" name="submit_psg_id">
					<center><button type="submit" name="submit_button" id='submit_button' class="btn btn-success">
							<span class="fa fa-check"></span>
							Submit Request
						</button>
					</center>
				</form> -->
                @foreach($vehicle as $data)
                @if($data->status=='Filing')
                <button class="btn btn-success btn" ame="submit_button" id='submit_button' onclick="_submitVehicle()">
                    <span class="fa fa-check"></span> Submit
                </button>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</div>

<!-- resched modal -->
<div class="modal fade" id="resched_modal" tabindex="-1" aria-labelledby="resched_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="resched_modalLabel">
                    <span class="fa fa-truck"></span>
                    &nbsp;Reschedule Date Needed
                </h5>
            </div>
            <!-- BLADE TO AJAX -->
            <!-- use this id below in ajax -->
            <form action="{{URL::to('/vehicle/accomplish/reschedule')}}" method="POST">
                @csrf
                <input type="hidden" id="resched_vhl_id" name="resched_vhl_id">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-sm">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <label class="input-group-text" for="due_date">Change Date Needed:</label>
                                </div>
                                <input type="datetime-local" class="form-control" name="due_date" id="due_date" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm">
                            <label>Reason for Reschedule
                                <span class="text-red">*</span>
                            </label>
                            <textarea class="form-control" rows="3" id="resched_reason" name="resched_reason" required></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#resched_modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-primary">
                        <span class="fa fa-calendar"></span>
                        Reschedule
                    </button>

                </div>
            </form>
        </div>
    </div>
</div>
<!-- Assign modal -->
<div class="modal fade" id="assign_modal" tabindex="-1" aria-labelledby="assign_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="assign_modalLabel">
                    <span class="fa fa-truck"></span>
                    &nbsp;Assign Driver and Pickup Date
                </h5>
            </div>
            <!-- BLADE TO AJAX -->
            <!-- use this id below in ajax -->
            <input type="hidden" id="submit_vhl_id" name="submit_vhl_id">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="driver">Driver:</label>
                            </div>
                            <select class="custom-select" id="driver">
                                <option selected value="" disabled>-- select --</option>
                                <option value="Elmo">Elmo</option>
                                <option value="Ruben">Ruben</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="pickup_date">Pick-up Date:</label>
                            </div>
                            <input type="datetime-local" class="form-control" name="assigned_pickupdate" id="assigned_pickupdate" required>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#assig_modal">
                    Close
                </button>
                <button onclick="_assign()" class="btn btn-success">
                    <span class="fa fa-truck"></span>
                    Assign
                </button>
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
                    <span>Attachment/s for Trip - </span>
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
                            <input type="file" class="custom-file-input" id="attachment" name="attachment">
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
                        <button id="btn_editRequest" onclick="_submitFile()" class="btn btn-info float-right">
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
<!-- OTW  modal -->
<div class="modal fade" id="otw_modal" tabindex="-1" aria-labelledby="otw_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="otw_modalLabel">
                    <span class="fa fa-truck"></span>
                    &nbsp;Pickup Date
                </h5>
            </div>
            <!-- BLADE TO AJAX -->
            <!-- use this id below in ajax -->
            <input type="hidden" id="sub_vhl_id" name="sub_vhl_id">
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="pickup_date">Pick-up Date:</label>
                            </div>
                            <input type="datetime-local" class="form-control" name="otw_pickupdate" id="otw_pickupdate" required>

                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#otw_modal">
                    Close
                </button>
                <button onclick="_otw()" class="btn btn-success">
                    <span class="fa fa-truck"></span>
                    On The Way
                </button>
            </div>
        </div>
    </div>
</div>


<!-- Mark Accomplish modal -->
<div class="modal fade" id="mark_accomplish_modal" tabindex="-1" aria-labelledby="mark_accomplish_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="mark_accomplish_modalLabel">
                    <span class="fa fa-envelope"></span>
                    &nbsp;Mark Accomplished
                </h5>
            </div>
            <!-- BLADE TO AJAX -->
            <!-- use this id below in ajax -->
            <input type="hidden" id="markacc_vhl_id" name="markacc_vhl_id">
            <input type="hidden" id="mark_vhl_id" name="mark_vhl_id">
            <input type="hidden" id="destination" name="destination">
            <div class="modal-body">
                <div class="row">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="otw_pickup_date">Pickup Date &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        </div>
                        <input type="datetime-local" class="form-control" readonly name="otw_pickup_date" id="otw_pickup_date" required>

                    </div>

                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="accomplished_date">Accomplished Date</label>
                        </div>
                        <input type="datetime-local" class="form-control" name="accomplished_date" id="accomplished_date" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#mark_accomplish_modal">
                    Close
                </button>
                <button class="btn btn-success" onclick="_markAccomplish()" class="btn btn-success btn-sm">
                    <span class="fa fa-check"></span>
                    Accomplished
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/table.js') }}"></script>
<script src="{{ asset('js/vehicle.js') }}"></script>
@endsection