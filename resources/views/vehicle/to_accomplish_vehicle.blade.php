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
                                    @if($data->urgency == "urgent")
                                    <span class="right badge badge-warning">{{ ucwords(strtoupper($data->urgency)) }}!</span> <br>
                                    <span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>
                                    @else
                                    <span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <button onclick="_viewVehicle('{{$data->id}}')" class="btn btn-sm btn-info">
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
                            @if($data->status=='For Rescheduling')
                            <tr class="text-center">
                                <td>{{ $my_date_req = date('F j, Y g:i A', strtotime($data->created_at)) }}</td>
                                <td>{{$data->purpose}}</td>
                                <td>{{ $my_date_needed = date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
                                <td>{{App\User::get_user($data->user_id)}}</td>
                                <td>{{$data->destination}}</td>
                                <td>
                                    @if($data->urgency == "urgent")
                                    <span class="right badge badge-warning">{{ ucwords(strtoupper($data->urgency)) }}!</span> <br>
                                    <span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>
                                    @else
                                    <span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <button onclick="_viewVehicle('{{$data->id}}')" class="btn btn-sm btn-info">
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
                                    @if($data->urgency == "urgent")
                                    <span class="right badge badge-warning">{{ ucwords(strtoupper($data->urgency)) }}!</span> <br>
                                    <span class="right badge badge-warning">{{ ucwords(strtoupper($data->status)) }}</span>
                                    @else
                                    <span class="right badge badge-warning">{{ ucwords(strtoupper($data->status)) }}</span>
                                    @endif<br>
                                    <small>Driver: {{$data->driver}}</small>
                                </td>
                                <td>
                                    <button onclick="_viewVehicle('{{$data->id}}')" class="btn btn-sm btn-info">
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
                                    @if($data->urgency == "urgent")
                                    <span class="right badge badge-warning">{{ ucwords(strtoupper($data->urgency)) }}!</span> <br>
                                    <span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
                                    @else
                                    <span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
                                    @endif<br>
                                    <small>Driver: {{$data->driver}} <br></small>
                                </td>
                                <td>
                                    <button onclick="_viewVehicle('{{$data->id}}')" class="btn btn-sm btn-info">
                                        <span class="fa fa-users"></span>
                                    </button> |
                                    <button onclick="_otw('{{$data->id}}')" class="btn btn-primary btn-sm">
                                        <span class="fa fa-truck"></span>
                                    </button>
                                    <a href="{{URL::to('/vehicle_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
                                </td>
                            </tr>
                            @endif
                            @endforeach

                            @foreach($vehicle as $data)
                            @if($data->status=='Cancelled')
                            <tr class="text-center">
                                <td>{{ $my_date_req = date('F j, Y g:i A', strtotime($data->created_at)) }}</td>
                                <td>{{$data->purpose}}</td>
                                <td>{{ $my_date_needed = date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
                                <td>{{App\User::get_user($data->user_id)}}</td>
                                <td>{{$data->destination}}</td>
                                <td>
                                    @if($data->urgency == "urgent")
                                    <span class="right badge badge-warning">{{ ucwords(strtoupper($data->urgency)) }}!</span> <br>
                                    <span class="right badge badge-danger">{{ ucwords(strtoupper($data->status)) }}</span>
                                    @else
                                    <span class="right badge badge-danger">{{ ucwords(strtoupper($data->status)) }}</span>
                                    @endif
                                </td>
                                <td>
                                    <button onclick="_viewVehicle('{{$data->id}}')" class="btn btn-sm btn-info">
                                        <span class="fa fa-users"></span>
                                    </button> |
                                    <button class="btn btn-warning btn-sm" onclick="_cancelReasonVehicle('{{$data->id}}')">
                                        <span class="fa fa-times"></span> reason
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
                                    @if($data->urgency == "urgent")
                                    <span class="right badge badge-warning">{{ ucwords(strtoupper($data->urgency)) }}!</span> <br>
                                    <span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>
                                    @else
                                    <span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>
                                    @endif
                                    <br>
                                    <small>Driver: {{$data->driver}} <br> Time Departure: {{ date('F j, Y g:i A', strtotime($data->otw_date)) }}</small>
                                </td>
                                <td>
                                    <button onclick="_viewVehicle('{{$data->id}}')" class="btn btn-sm btn-info">
                                        <span class="fa fa-users"></span>
                                    </button> |
                                    <button onclick="accomplish_modal('{{$data->id}}', '{{$data->otw_date}}')" class="btn btn-success btn-sm">
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
                                    @if($data->urgency == "urgent")
                                    <span class="right badge badge-warning">{{ ucwords(strtoupper($data->urgency)) }}!</span> <br>
                                    <span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
                                    @else
                                    <span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
                                    @endif<br>
                                    <small>Driver: {{$data->driver}} <br> Time Departure: {{ date('F j, Y g:i A', strtotime($data->otw_date)) }}
                                        <br> Accomplished date: {{ date('F j, Y g:i A', strtotime($data->accomplished_date)) }}</small>
                                </td>
                                <td>
                                    <button onclick="_viewVehicle('{{$data->id}}')" class="btn btn-sm btn-info">
                                        <span class="fa fa-users"></span>
                                    </button> |
                                    <button class="btn btn-warning btn-sm" onclick="acc_accomplish_modal('{{$data->id}}','{{$data->otw_date}}')">
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


<!-- VIEW TRIP/VEHICLE Modal-->
<div class="modal fade" id="view_trip_modal" tabindex="-1" aria-labelledby="view_trip_modalLabel" aria-hidden="true">
	<div class="modal-dialog modal modal-lg modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header bg-info">
				<h5 class="modal-title" id="view_trip_modalLabel">
					<span class="fa fa-truck"></span>
					<span id="view_trip_header">Vehicle Request/ Trip Ticket</span>
				</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<input type="hidden" id="vehicle_id" name="vehicle_id">
					<div class="col-sm-12">
						<div class="row">
							<div class="col-sm-12">
								<div class="row">
									<div class="col-sm-6">
										<label>Date and Time Needed
											<span class="text-red">*</span>
										</label>
										<input type="datetime-local" class="form-control" name="view_date_needed" id="view_date_needed" readonly>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<div class="form-check">
												<input class="form-check-input" type="radio" name="view_urgency" id="view_urgency" value="not_urgent" readonly>
												<label class="form-check-label" for="view_urgency">
													Not Urgent
												</label>
											</div>
											<div class="form-check">
												<input class="form-check-input" type="radio" name="view_urgency" id="view_urgency" value="urgent" readonly>
												<label class="form-check-label" for="view_urgency">
													Urgent
												</label>
											</div>
										</div>
									</div>
								</div>
								<br>
								<div class="row">
									<div class="col-sm-6">
										<label>Purpose of Trip</label>
										<span class="text-red">*</span>
										<textarea id="view_purpose" name="view_purpose" class="form-control" rows="4" readonly></textarea>
										<br>
										<label>Destination(Address)
											<span class="text-red">*</span>
										</label>
										<textarea class="form-control" rows="4" id="view_destination" readonly name="view_destination"></textarea>
									</div>
									<div class="col-sm-6">
										<div class="row">
											<label id="view_lbl_passenger">&nbsp; Passenger(s):</label>
											<span id="asterisk" class="text-red">*</span>
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
												<span id="view_psg_count"></span>
											</small>
											<br>
											<div class='scrolledTable' style="height:300px; width:460px; overflow:auto;">
												<table class="table table-striped table-bordered table-sm" id="view_my_passenger_table">
													<tbody id="view_my_tbody">
													</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#view_trip_modal">
								Close
							</button>
						</div>
					</div>
				</div>
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
                    &nbsp;Assign Driver
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
                <!-- <div class="row">
                    <div class="col-sm">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="pickup_date">Pick-up Date:</label>
                            </div>
                            <input type="datetime-local" class="form-control" name="assigned_pickupdate" id="assigned_pickupdate" required>

                        </div>
                    </div>
                </div> -->
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#assign_modal">
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

<!-- cancel modal -->
<div class="modal fade" id="cancel_modal" data-toggle="modal" data-dismiss="modal" tabindex="-1" aria-labelledby="cancel_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="cancel_modalLabel">
                    <span class="fa fa-times"></span>&nbsp;
                    <span id="cancel_header"> Cancel Request </span>
                </h5>
            </div>
            <form action="{{URL::to('/messengerial/cancel')}}" method="POST">
                @csrf
                <input type="hidden" id="msg_cancel_id" name="msg_cancel_id">

                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm">
                            <label id="lbl_reason">Reason for Cancellation </label>
                            @if(isset($data))
                            @if($data->status=='Cancelled')
                            <textarea id="cancel_reason" rows="4" class="form-control" name="cancel_reason" readonly></textarea>
                            @else
                            <textarea id="cancel_reason" rows="4" class="form-control" name="cancel_reason" placeholder="Type here..."></textarea>
                            @endif
                            @endif
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div id="cancel_note" class="col-sm">
                            <small>
                                <span class="fa fa-exclamation-circle text-red"></span>
                                <span><b>Note:</b> Make sure to provide reason if you want to cancel your request.</span>
                            </small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    @if(isset($data))
                    @if($data->status!='Cancelled' || $data->status!='Filing')
                    <button id="btn_cancelRequest" type="submit" class="btn btn-warning">
                        <span id="icon_submit" class="fa fa-times"></span>
                        <span id="btn_cancel">Cancel</span>
                    </button>
                    @endif
                    @endif
                </div>
            </form>
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
                    <span>Mark "</span>
                    <span id="destination"></span>
                    <span>" as Accomplished</span>
                </h5>
            </div>
            <input type="hidden" id="vehicle_id" name="vehicle_id">
            <div class="modal-body modal-lg">
                <div class="row">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="otw_date">Departure Time</label>
                        </div>
                        <input type="datetime-local" class="form-control" readonly name="otw_date" id="otw_date">

                        &nbsp;&nbsp;
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="accomplished_date">Accomplished Date</label>
                        </div>
                        <input type="datetime-local" class="form-control" name="accomplished_date" id="accomplished_date" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <label>Remarks <small>(optional)</small></label>
                        <textarea class="form-control" rows="4" id="remarks" name="remarks"></textarea>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm">
                        <label>Upload Documents <small> &nbsp;<span class="fa fa-exclamation-circle text-red"></span>
                                <b>Note: </b>
                                Upload documents as proof that messengerial request is accomplished.
                            </small></label>
                        <div class="custom-file">
                            <input type="file" class="custom-file-input" id="attachment" name="attachment">
                            <label class="custom-file-label" for="attachment"></label>
                        </div>
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
                        <table class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th width="30%">File</th>
                                    <th width="5%"></th>
                                </tr>
                            </thead>
                            <tbody id="file_body">
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button class="btn btn-success" onclick="_markAccomplish('{{$data->id}}','{{$data->destination}}')" class="btn btn-success btn-sm">
                        <span class="fa fa-check"></span>
                        Submit
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- View Accomplish modal -->
<div class="modal fade" id="acc_accomplish_modal" data-toggle="modal" data-dismiss="modal" tabindex="-1" aria-labelledby="acc_accomplish_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="acc_accomplish_modalLabel">
                    <span id="modal_header" class="fa fa-file"></span>&nbsp;
                    <span>Attachment for Destination - </span>
                    <span id="acc_destination"></span>
                </h5>
            </div>
            <input type="hidden" id="acc_vhl_id" name="acc_vhl_id">
            <div class="modal-body modal-lg">
                <div class="row">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="acc_otw_date">Departure Time</label>
                        </div>
                        <input type="datetime-local" class="form-control" readonly name="acc_otw_date" id="acc_otw_date">

                        &nbsp;&nbsp;
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="acc_accomplished_date">Accomplished Date</label>
                        </div>
                        <input type="datetime-local" class="form-control" name="acc_accomplished_date" id="acc_accomplished_date" readonly>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <label>Remarks <small>(optional)</small></label>
                        <textarea class="form-control" rows="4" id="acc_remarks" name="acc_remarks" readonly></textarea>
                    </div>
                </div>
                <br>
                <br>
                <div class="row">
                    <div class="col-sm">
                        <table class="table table-sm table-bordered table-striped">
                            <thead>
                                <tr class="text-center">
                                    <th width="30%">File</th>
                                </tr>
                            </thead>
                            <tbody id="acc_file_body">
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
                            <label class="input-group-text" for="otw_date">Time Departure &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                        </div>
                        <input type="datetime-local" class="form-control" readonly name="otw_date" id="otw_date" required>

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