@extends('partials._layout')

@section('content')
<div class="card">
	<div class="card-header card-header-vhl">
		<h4 align="center"><span class="fa fa-truck"></span>&nbsp;My Vehicle Request</h4>
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

					<div class="col-sm">
						<button onclick="_addRequest()" class="btn btn-vhl float-right">
							<span class="fas fa-plus"></span>&nbsp;Create Request
						</button>
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
							@if((Auth::user()->user_type == 1) || ((Auth::user()->user_type == 2 && $data->status!='For DC Approval')) || (Auth::user()->user_type == 3 || $data->status!='Confirmed' || $data->status!='On The Way') || ((Auth::user()->user_type == 4 && $data->status!='For DC Approval')) || (Auth::user()->user_type == 5) || (Auth::user()->user_type == 6 && $data->status!='For CAO Approval' && $data->status!='For DC Approval'))

							@if(Auth::user()->user_type == 1 && (Auth::user()->id == $data->user_id))
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

									@elseif($data->status=='Confirmed')
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "On The Way")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For Assignment")
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>
									@elseif($data->status=='Accomplished')
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif
								</td>
								<td>
									@if($data->status!='Filing')
									<button onclick="_viewPassenger('{{$data->id}}', '{{$my_date_req}}', '{{$my_date_needed}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button> |
									@endif
									@if($data->status=='Filing')
									<button onclick="_addPassenger('{{$data->id}}', '{{$my_date_req}}', '{{$my_date_needed}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button> |

									<button name="edit" id="edit" onclick="_editVehicle('{{$data->id}}')" class="btn btn-sm btn-primary edit">
										<span class="fa fa-edit"></span>
									</button>
									<button class="btn btn-danger btn-sm" onclick="_deleteVehicle('{{$data->id}}','{{$data->purpose}}')">
										<span class="fa fa-trash"></span>
									</button>
									@endif
									@if($data->status!='Cancelled' && $data->status!='Filing' && $data->status!='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="_cancelVehicle('{{$data->id}}')">
										<span class="fa fa-times"></span>
									</button>
									@endif

									@if($data->status=='Cancelled')
									<button class="btn btn-warning btn-sm" onclick="_cancelReasonVehicle('{{$data->id}}')">
										<span class="fa fa-times"></span> reason
									</button>
									@endif

									@if($data->status =='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="_attachment('{{$data->id}}')">
										<span class="fa fa-file"></span>

									</button>
									@endif
									<a href="{{URL::to('/vehicle_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
								</td>
							</tr>
							@endif

							@if(Auth::user()->user_type == 2 && (Auth::user()->id == $data->user_id))
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

									@elseif($data->status=='Confirmed')
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "On The Way")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For Assignment")
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>
									@elseif($data->status=='Accomplished')
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif
								</td>
								<td>
									@if($data->status!='Filing')
									<button onclick="_viewPassenger('{{$data->id}}', '{{$my_date_req}}', '{{$my_date_needed}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button> |
									@endif
									@if($data->status=='Filing')
									<button onclick="_addPassenger('{{$data->id}}', '{{$my_date_req}}', '{{$my_date_needed}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button> |
									<button name="edit" id="edit" onclick="_editVehicle('{{$data->id}}')" class="btn btn-sm btn-primary edit">
										<span class="fa fa-edit"></span>
									</button>
									<button class="btn btn-danger btn-sm" onclick="_deleteVehicle('{{$data->id}}','{{$data->purpose}}')">
										<span class="fa fa-trash"></span>
									</button>
									@endif

									@if($data->status!='Cancelled' && $data->status!='Filing' && $data->status!='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="_cancelVehicle('{{$data->id}}')">
										<span class="fa fa-times"></span>
									</button>
									@endif

									@if($data->status=='Cancelled')
									<button class="btn btn-warning btn-sm" onclick="_cancelReasonVehicle('{{$data->id}}')">
										<span class="fa fa-times"></span> reason
									</button>
									@endif

									@if($data->status=='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="_attachment('{{$data->id}}')">
										<span class="fa fa-file"></span>

									</button>
									@endif
									<a href="{{URL::to('/vehicle_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>

								</td>
							</tr>
							@endif

							@if(Auth::user()->user_type == 3 && (Auth::user()->id == $data->user_id))
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

									@elseif($data->status=='Confirmed')
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "On The Way")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For Assignment")
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>
									@elseif($data->status=='Accomplished')
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif
								</td>
								<td>
									@if($data->status!='Filing')
									<button onclick="_viewPassenger('{{$data->id}}', '{{$my_date_req}}', '{{$my_date_needed}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button> |
									@endif
									@if($data->status=='Filing')
									<button onclick="_addPassenger('{{$data->id}}', '{{$my_date_req}}', '{{$my_date_needed}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button> |
									<button name="edit" id="edit" onclick="_editVehicle('{{$data->id}}')" class="btn btn-sm btn-primary edit">
										<span class="fa fa-edit"></span>
									</button>
									<button class="btn btn-danger btn-sm" onclick="_deleteVehicle('{{$data->id}}','{{$data->purpose}}')">
										<span class="fa fa-trash"></span>
									</button>
									@endif

									@if($data->status!='Filing')

									@endif

									@if($data->status!='Cancelled' && $data->status!='Filing' && $data->status!='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="_cancelVehicle('{{$data->id}}')">
										<span class="fa fa-times"></span>
									</button>
									@endif

									@if($data->status=='Cancelled')
									<button class="btn btn-warning btn-sm" onclick="_cancelReasonVehicle('{{$data->id}}')">
										<span class="fa fa-times"></span> reason
									</button>
									@endif

									@if($data->status=='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="_attachment('{{$data->id}}')">
										<span class="fa fa-file"></span>

									</button>
									@endif
									<a href="{{URL::to('/vehicle_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
								</td>

							</tr>
							@endif

							@if(Auth::user()->user_type == 4 && (Auth::user()->id == $data->user_id))
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

									@elseif($data->status=='Confirmed')
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "On The Way")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For Assignment")
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>
									@elseif($data->status=='Accomplished')
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif
								</td>
								<td>
									@if($data->status!='Filing')
									<button onclick="_viewPassenger('{{$data->id}}', '{{$my_date_req}}', '{{$my_date_needed}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button> |
									@endif
									@if($data->status=='Filing')
									<button onclick="_addPassenger('{{$data->id}}', '{{$my_date_req}}', '{{$my_date_needed}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button> |
									<button name="edit" id="edit" onclick="_editVehicle('{{$data->id}}')" class="btn btn-sm btn-primary edit">
										<span class="fa fa-edit"></span>
									</button>
									<button class="btn btn-danger btn-sm" onclick="_deleteVehicle('{{$data->id}}','{{$data->purpose}}')">
										<span class="fa fa-trash"></span>
									</button>
									@endif

									@if($data->status!='Cancelled' && $data->status!='Filing' && $data->status!='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="_cancelVehicle('{{$data->id}}')">
										<span class="fa fa-times"></span>
									</button>
									@endif

									@if($data->status=='Cancelled')
									<button class="btn btn-warning btn-sm" onclick="_cancelReasonVehicle('{{$data->id}}')">
										<span class="fa fa-times"></span> reason
									</button>
									@endif

									@if($data->status=='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="_attachment('{{$data->id}}')">
										<span class="fa fa-file"></span>

									</button>
									@endif
									<a href="{{URL::to('/vehicle_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
								</td>
							</tr>
							@endif

							@if(Auth::user()->user_type == 5 && (Auth::user()->id == $data->user_id))
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

									@elseif($data->status=='Confirmed')
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "On The Way")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For Assignment")
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>
									@elseif($data->status=='Accomplished')
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif
								</td>
								<td>
									@if($data->status!='Filing')
									<button onclick="_viewPassenger('{{$data->id}}', '{{$my_date_req}}', '{{$my_date_needed}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button> |
									@endif
									@if($data->status=='Filing')
									<button onclick="_addPassenger('{{$data->id}}', '{{$my_date_req}}', '{{$my_date_needed}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button> |
									<button name="edit" id="edit" onclick="_editVehicle('{{$data->id}}')" class="btn btn-sm btn-primary edit">
										<span class="fa fa-edit"></span>
									</button>
									<button class="btn btn-danger btn-sm" onclick="_deleteVehicle('{{$data->id}}','{{$data->purpose}}')">
										<span class="fa fa-trash"></span>
									</button>
									@endif
									@if($data->status!='Cancelled' && $data->status!='Filing' && $data->status!='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="_cancelVehicle('{{$data->id}}')">
										<span class="fa fa-times"></span>
									</button>
									@endif

									@if($data->status=='Cancelled')
									<button class="btn btn-warning btn-sm" onclick="_cancelReasonVehicle('{{$data->id}}')">
										<span class="fa fa-times"></span> reason
									</button>
									@endif

									@if($data->status=='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="_attachment('{{$data->id}}')">
										<span class="fa fa-file"></span>

									</button>
									@endif
									<a href="{{URL::to('/vehicle_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
								</td>
							</tr>
							@endif

							@if(Auth::user()->user_type == 6 && (Auth::user()->id == $data->user_id))
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

									@elseif($data->status=='Confirmed')
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "On The Way")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For Assignment")
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>
									@elseif($data->status=='Accomplished')
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif
								</td>
								<td>
									@if($data->status!='Filing')
									<button onclick="_viewPassenger('{{$data->id}}', '{{$my_date_req}}', '{{$my_date_needed}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button> |
									@endif
									@if($data->status=='Filing')
									<button onclick="_addPassenger('{{$data->id}}', '{{$my_date_req}}', '{{$my_date_needed}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button> |
									<button name="edit" id="edit" onclick="_editVehicle('{{$data->id}}')" class="btn btn-sm btn-primary edit">
										<span class="fa fa-edit"></span>
									</button>
									<button class="btn btn-danger btn-sm" onclick="_deleteVehicle('{{$data->id}}','{{$data->purpose}}')">
										<span class="fa fa-trash"></span>
									</button>
									@endif
									@if($data->status!='Cancelled' && $data->status!='Filing' && $data->status!='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="_cancelVehicle('{{$data->id}}')">
										<span class="fa fa-times"></span>
									</button>
									@endif

									@if($data->status=='Cancelled')
									<button class="btn btn-warning btn-sm" onclick="_cancelReasonVehicle('{{$data->id}}')">
										<span class="fa fa-times"></span> reason
									</button>
									@endif

									@if($data->status=='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="_attachment('{{$data->id}}')">
										<span class="fa fa-file"></span>

									</button>
									@endif
									<a href="{{URL::to('/vehicle_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
								</td>
							</tr>
							@endif

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
							@if($data->status=='Cancelled')
							<textarea id="cancel_reason" rows="4" class="form-control" name="cancel_reason" readonly></textarea>
							@else
							<textarea id="cancel_reason" rows="4" class="form-control" name="cancel_reason" placeholder="Type here..." required></textarea>
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


<!-- TRIP/VEHICLE Modal-->
<div class="modal fade" id="trip_modal" tabindex="-1" aria-labelledby="trip_modalLabel" aria-hidden="true">
	<div class="modal-dialog modal modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header bg-info">
				<h5 class="modal-title" id="trip_modalLabel">
					<span class="fa fa-truck"></span>
					<span id="trip_header">Vehicle Request/ Trip Ticket</span>

				</h5>
			</div>
			<form action="{{URL::to('/vehicle/store')}}" method="POST">
				<div class="modal-body">
					@csrf
					<div class="row">
						<input type="hidden" id="vehicle_id" name="vehicle_id">
						<div class="col-sm">
							<div class="row">
								<div class="col-sm-12">
									<div class="row">
										<div class="col-md-6">
											<label>Date and Time Needed
												<span class="text-red">*</span>
											</label>
											<input type="datetime-local" class="form-control" name="date_needed" id="date_needed" required>
										</div>

										<div class="col-md-12">
											<label>Purpose of Trip</label>
											<span class="text-red">*</span>
											<textarea placeholder="purpose of trip..." id="purpose" name="purpose" class="form-control" rows="4" required></textarea>
										</div>
										<div class="col-md-12">
											<label>Destination(Address)
												<span class="text-red">*</span>
											</label>
											<textarea placeholder="complete address..." class="form-control" rows="4" id="destination" required name="destination"></textarea>
										</div>
									</div>
								</div>
							</div>
							<br>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#trip_modal">
						Close
					</button>
					<button id="btn_add" type="submit" class="btn btn-success">
						<span id="icon_submit" class="fa fa-check"></span>
						<span id="btn_submit">Save</span>
					</button>
				</div>
			</form>
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
				<button ame="submit_button" id='submit_button' class="btn btn-success btn" onclick="_submitVehicle()">
					<span class="fa fa-check"></span> Submit
				</button>
				@endif
				@endforeach
			</div>
		</div>
	</div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/vehicle.js') }}"></script>
<script src="{{ asset('js/table.js') }}"></script>
@endsection