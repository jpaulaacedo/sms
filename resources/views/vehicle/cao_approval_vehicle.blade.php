@extends('partials._layout')

@section('content')
<div class="card">
	<div class="card-header card-header-new card-header-dark">
		<h4 align="center"><span class="fa fa-truck"></span>&nbsp;For My Approval</h4>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-sm">
				&nbsp;
				<div class="row">
					<div class="col-sm-6">
						<div class="input-group mb-3">
							<span class="input-group-text bg-info" id="basic-addon3">
								<span class="fa fa-search">&nbsp;</span> Search
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
								<th width="10%">Requested By</th>
								<th width="15%">Destination</th>
								<th width="15%">Status</th>
								<th width="10%">Action</th>
							</tr>
						</thead>
						<tbody>

							@foreach($vehicle as $data)
							@if(Auth::user()->user_type == 6 && $data->status=='For CAO Approval')
							<tr class="text-center">
								<td>{{ $my_date_req = date('F j, Y g:i A', strtotime($data->created_at)) }}</td>
								<td>{{$data->purpose}}</td>
								<td>{{ $my_date_needed = date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								<td>{{App\User::get_user($data->user_id)}}</td>
								<td>{{$data->destination}}</td>
								<td>
									<span class="right badge badge-warning">{{ ucwords(strtoupper($data->status)) }}</span>
									<br>
									<small>Driver: {{$data->driver}}</small>
								</td>
								<td>
									<button onclick="_viewVehicle('{{$data->id}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button> |
									<button type="submit" onclick="_approveCAO('{{$data->id}}')" class="btn btn-success btn-sm">
										<span class="fa fa-thumbs-up"></span>
									</button>

									<a href="{{URL::to('/vehicle_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
								</td>
							</tr>
							@endif
							@endforeach

							@foreach($vehicle as $data)
							@if(Auth::user()->user_type == 6 && $data->status=='Cancelled')
							<tr class="text-center">
								<td>{{ $my_date_req = date('F j, Y g:i A', strtotime($data->created_at)) }}</td>
								<td>{{$data->purpose}}</td>
								<td>{{ $my_date_needed = date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								<td>{{App\User::get_user($data->user_id)}}</td>
								<td>{{$data->destination}}</td>
								<td>
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->status)) }}</span>
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
							@if(Auth::user()->user_type == 6 && $data->status=='Confirmed')
							<tr class="text-center">
								<td>{{ $my_date_req = date('F j, Y g:i A', strtotime($data->created_at)) }}</td>
								<td>{{$data->purpose}}</td>
								<td>{{ $my_date_needed = date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								<td>{{App\User::get_user($data->user_id)}}</td>
								<td>{{$data->destination}}</td>
								<td>
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
									<br>
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
							@if(Auth::user()->user_type == 6 && $data->status=='On The Way')
							<tr class="text-center">
								<td>{{ $my_date_req = date('F j, Y g:i A', strtotime($data->created_at)) }}</td>
								<td>{{$data->purpose}}</td>
								<td>{{ $my_date_needed = date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								<td>{{App\User::get_user($data->user_id)}}</td>
								<td>{{$data->destination}}</td>
								<td>
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>
									<br>
									<small>Driver: {{$data->driver}} <br> Time Departure: {{ date('F j, Y g:i A', strtotime($data->otw_pickupdate)) }}</small>
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
							@if(Auth::user()->user_type == 6 && $data->status=='Accomplished')
							<tr class="text-center">
								<td>{{ $my_date_req = date('F j, Y g:i A', strtotime($data->created_at)) }}</td>
								<td>{{$data->purpose}}</td>
								<td>{{ $my_date_needed = date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								<td>{{App\User::get_user($data->user_id)}}</td>
								<td>{{$data->destination}}</td>
								<td>
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
									<br>
									<small>Driver: {{$data->driver}} <br> Time Departure: {{ date('F j, Y g:i A', strtotime($data->outfordel_pickupdate)) }}
										<br> Accomplished date: {{ date('F j, Y g:i A', strtotime($data->accomplished_date)) }}</small>
								</td>
								<td>
									<button onclick="_viewVehicle('{{$data->id}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button> |
									<button class="btn btn-warning btn-sm" onclick="_attachment('{{$data->id}}')">
										<span class="fa fa-file"></span>
									</button>
									<a href="{{URL::to('/vehicle_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
								</td>
							</tr>
							@endif
							@endforeach
						</tbody>
					</table>
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

<!-- cancel modal -->
<div class="modal fade" id="cancel_modal" data-toggle="modal" data-dismiss="modal" tabindex="-1" aria-labelledby="request_modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header bg-info">
				<h5 class="modal-title" id="request_modalLabel">
					<span class="fa fa-times"></span>&nbsp;
					<span id="cancel_header"> Request </span>
				</h5>
			</div>
			<form action="{{URL::to('/vehicle/cancel')}}" method="post">
				@csrf
				<input type="hidden" id="vcl_cancel_id" name="vehicle_id">

				<div class="modal-body">
					<div class="row">
						<div class="col-sm">
							<label id="lbl_reason">Reason for Cancellation </label>
							@if(isset($data))
							@if($data->status=='Cancelled')
							<textarea id="cancel_reason" rows="4" class="form-control" name="cancel_reason" readonly></textarea>
							@else
							<textarea id="cancel_reason" rows="4" class="form-control" name="cancel_reason" placeholder="Type here..." required></textarea>
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
					<button id="btn_cancelRequest" type="submit" class="btn btn-warning">
						<span id="icon_submit" class="fa fa-times"></span>
						<span>Cancel</span>
					</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/vehicle.js') }}"></script>
<script src="{{ asset('js/table.js') }}"></script>
@endsection