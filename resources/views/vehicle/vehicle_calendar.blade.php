@extends('partials._layout')

@section('content')
<div class="card">
	<div class="card-header card-header-new card-header-dark">
		<h4 align="center"><span class="fa fa-truck"></span>&nbsp;Vehicle Request</h4>
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
								<th width="15%">Destination</th>
								<th width="10%">Status</th>
								<th width="10%">Action</th>
							</tr>
						</thead>
						<tbody>

							@foreach($vehicle as $data)
							@if((Auth::user()->user_type == 1) || ((Auth::user()->user_type == 2 && $data->status!='For DC Approval')) || (Auth::user()->user_type == 3 || $data->status!='Approved' || $data->status!='Out For Delivery') || ((Auth::user()->user_type == 4 && $data->status!='For DC Approval')) || (Auth::user()->user_type == 5) || (Auth::user()->user_type == 6 && $data->status!='For CAO Approval' && $data->status!='For DC Approval'))

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

									@if($data->status =='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="_attachment('{{$data->id}}')">
										<span class="fa fa-file"></span>
									</button>
									@endif
									<a href="{{URL::to('/vehicle_form')}}/{{$data->id}}" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
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
									@if($data->status == "On The Way")
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
									@if($data->status=='Filing')
									<button onclick="_addPassenger('{{$data->id}}', '{{$my_date_req}}', '{{$my_date_needed}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button>
									<button name="edit" id="edit" onclick="_editVehicle('{{$data->id}}')" class="btn btn-sm btn-primary edit">
										<span class="fa fa-edit"></span>
									</button>
									<button class="btn btn-danger btn-sm" onclick="_deleteVehicle('{{$data->id}}','{{$data->purpose}}')">
										<span class="fa fa-trash"></span>
									</button>
									@endif

									@if($data->status!='Cancelled' && $data->status!='Filing' && $data->status!='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="_cancelVehicle('{{$data->id}}')">
										<span class="fa fa-times"></span> cancel
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
									<a href="{{URL::to('/vehicle_form')}}/{{$data->id}}" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>

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
									@if($data->status=='Filing')
									<button onclick="_addPassenger('{{$data->id}}', '{{$my_date_req}}', '{{$my_date_needed}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button>
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
										<span class="fa fa-times"></span> cancel
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
									<a href="{{URL::to('/vehicle_form')}}/{{$data->id}}" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
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
									@if($data->status=='Filing')
									<button onclick="_addPassenger('{{$data->id}}', '{{$my_date_req}}', '{{$my_date_needed}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button>
									<button name="edit" id="edit" onclick="_editVehicle('{{$data->id}}')" class="btn btn-sm btn-primary edit">
										<span class="fa fa-edit"></span>
									</button>
									<button class="btn btn-danger btn-sm" onclick="_deleteVehicle('{{$data->id}}','{{$data->purpose}}')">
										<span class="fa fa-trash"></span>
									</button>
									@endif

									@if($data->status!='Cancelled' && $data->status!='Filing' && $data->status!='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="_cancelVehicle('{{$data->id}}')">
										<span class="fa fa-times"></span> cancel
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
									<a href="{{URL::to('/vehicle_form')}}/{{$data->id}}" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
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
									@if($data->status=='Filing')
									<button onclick="_addPassenger('{{$data->id}}', '{{$my_date_req}}', '{{$my_date_needed}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button>
									<button name="edit" id="edit" onclick="_editVehicle('{{$data->id}}')" class="btn btn-sm btn-primary edit">
										<span class="fa fa-edit"></span>
									</button>
									<button class="btn btn-danger btn-sm" onclick="_deleteVehicle('{{$data->id}}','{{$data->purpose}}')">
										<span class="fa fa-trash"></span>
									</button>
									@endif
									@if($data->status!='Cancelled' && $data->status!='Filing' && $data->status!='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="_cancelVehicle('{{$data->id}}')">
										<span class="fa fa-times"></span> cancel
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
									@if($data->status=='Filing')
									<button onclick="_addPassenger('{{$data->id}}', '{{$my_date_req}}', '{{$my_date_needed}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button>
									<button name="edit" id="edit" onclick="_editVehicle('{{$data->id}}')" class="btn btn-sm btn-primary edit">
										<span class="fa fa-edit"></span>
									</button>
									<button class="btn btn-danger btn-sm" onclick="_deleteVehicle('{{$data->id}}','{{$data->purpose}}')">
										<span class="fa fa-trash"></span>
									</button>
									@endif
									@if($data->status!='Cancelled' && $data->status!='Filing' && $data->status!='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="_cancelVehicle('{{$data->id}}')">
										<span class="fa fa-times"></span> cancel
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
					<input type="hidden" id="vehicle_id" name="vehicle_id">
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
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								&nbsp;
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

			</div>
		</div>
	</div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/vehicle.js') }}"></script>
<script src="{{ asset('js/table.js') }}"></script>
@endsection