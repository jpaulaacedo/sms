@extends('partials._layout')
@section('content')
<div class="card">
	<div class="card-header card-header-new card-header-dark">
		<h4 align="center"><span class="fa fa-truck"></span>&nbsp;All Vehicle Requests</h4>
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
								<th width="15%">Destination</th>
								<th width="20%">Status</th>
								<th width="10%">Action</th>
							</tr>
						</thead>
						<tbody>

							@foreach($vehicle as $data)
							@if($data->status != "Filing")
							<tr class="text-center">
								<td>{{ $my_date_req = date('F j, Y g:i A', strtotime($data->created_at)) }}</td>
								<td>{{$data->purpose}}</td>
								<td>{{ $my_date_needed = date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								<td>{{App\User::get_user($data->user_id)}}</td>
								<td>{{$data->destination}}</td>
								<td>
									@if($data->status=='Filing')
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For CAO Approval" || $data->status == "For DC Approval")
									<span class="right badge badge-warning">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "Cancelled")
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status=='Confirmed')
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "On The Way")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For Assignment")
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>
									@elseif($data->status=='Accomplished')
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif
									@if($data->urgency == "urgent" && $data->status !='Accomplished')
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->urgency)) }}!</span>
									@endif
								</td>
								<td>
									<button onclick="_viewVehicle('{{$data->id}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button> |
									@if($data->status=='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="_attachment('{{$data->id}}')">
										<span class="fa fa-file"></span>
									</button>
									@endif
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

<!-- Accomplish modal -->
<div class="modal fade" id="accomplish_modal" data-toggle="modal" data-dismiss="modal" tabindex="-1" aria-labelledby="accomplish_modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-info">
				<h5 class="modal-title" id="accomplish_modalLabel">
					<span id="modal_header" class="fa fa-file"></span>&nbsp;
					<span>Attachment/s for Trip to&nbsp;</span>
					<span id="dest"></span>
				</h5>
			</div>
			<input type="hidden" id="acc_vehicle_id" name="acc_vehicle_id">
			<div class="modal-body modal-lg">

				<div class="row">
					<div class="col-sm">
						<table class="table table-sm table-bordered table-striped">
							<thead>
								<tr class="text-center">
									<th width="30%">File</th>
									<th width="40%">Remarks</th>

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

@endsection

@section('js')
<script src="{{ asset('js/table.js') }}"></script>
<script src="{{ asset('js/vehicle.js') }}"></script>
@endsection