@extends('partials._layout')
@section('css')
<style>
	.rating {
		display: flex;
		flex-direction: row-reverse;
		justify-content: center;
	}

	.rating>input {
		display: none;
	}

	.rating>label {
		position: relative;
		width: 1em;
		font-size: 3vw;
		color: #FFD600;
		cursor: pointer;
	}

	.rating>label::before {
		content: "\2605";
		position: absolute;
		opacity: 0;
	}

	.rating>label:hover:before,
	.rating>label:hover~label:before {
		opacity: 1 !important;
	}

	.rating>input:checked~label:before {
		opacity: 1;
	}

	.rating:hover>input:checked~label:before {
		opacity: 0.4;
	}
</style>
@endsection
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
						<button onclick="_addRequest()" class="btn btn-vhl float-right" {{App\Vehicle::count_rate()}}>
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
								<th width="10%">Date Needed</th>
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
								@if($data->resched_reason == null)
								<td>{{ $my_date_needed = date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								@else
								<td><small><b>DATE RESCHEDULED to </b></small>{{ $my_date_needed = date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								@endif
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

									@elseif($data->status == "For Rescheduling")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For Assignment")
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>
									@elseif($data->status=='Accomplished')
									<span class="right badge badge-default">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif

									@if($data->urgency == "urgent" && $data->status !='Accomplished')
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->urgency)) }}!</span>
									@endif
									@if($data->status =='Accomplished' && $data->feedback == "")
									<span class="right badge badge-warning">TO RATE</span>
									@endif
								</td>
								<td>
									@if($data->status!='Filing')
									<button onclick="_viewVehicle('{{$data->id}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button> |
									@endif
									@if($data->status=='Accomplished' && $data->feedback != "")
									<button class="btn btn-default btn-sm" onclick="view_rate_modal('{{$data->id}}', '{{$data->feedback}}', '{{$data->star}}')">
										<span class="fa fa-star"></span>
									</button>
									@elseif($data->status=='Accomplished' && $data->feedback == "")
									<button class="btn btn-success btn-sm" onclick="rate_modal('{{$data->id}}')">
										<span class="fa fa-star"></span> Rate
									</button>
									@endif
									@if($data->status=='Filing')
									<button class="btn btn-success btn-sm" onclick="_submitVehicle('{{$data->id}}')">
										<span class="fa fa-check"></span> Submit
									</button> |

									<button name="edit" id="edit" onclick="_editVehicle('{{$data->id}}')" class="btn btn-sm btn-primary edit">
										<span class="fa fa-edit"></span>
									</button>
									<button class="btn btn-danger btn-sm" onclick="_deleteVehicle('{{$data->id}}','{{$data->purpose}}')">
										<span class="fa fa-trash"></span>
									</button>
									@endif

									@if($data->status=='For Rescheduling' && $data->view_edit == "view")
									<button onclick="resched_modal('{{$data->id}}')" class="btn btn-primary btn-sm">
										<span class="fa fa-calendar"></span>
									</button>
									@elseif($data->status=='For Rescheduling' && $data->view_edit == "edit")
									<button onclick="view_resched_modal('{{$data->id}}')" class="btn btn-primary btn-sm">
										<span class="fa fa-calendar"></span>
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
								@if($data->resched_reason == null)
								<td>{{ date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								@else
								<td><small><b>DATE RESCHEDULED to </BR> </b></small>{{ date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								@endif
								<td>{{$data->destination}}</td>
								<td>
									@if($data->status=='Filing')
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For CAO Approval" || $data->status == "For DC Approval")
									<span class="right badge badge-warning">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For Rescheduling")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "Cancelled")
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status=='Confirmed')
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "On The Way")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For Assignment")
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status=='Accomplished')
									<span class="right badge badge-default">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif

									@if($data->urgency == "urgent" && $data->status !='Accomplished')
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->urgency)) }}!</span>
									@endif
									@if($data->status =='Accomplished' && $data->feedback == "")
									<span class="right badge badge-warning">TO RATE</span>
									@endif
								</td>
								<td>
									@if($data->status!='Filing')
									<button onclick="_viewVehicle('{{$data->id}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button> |
									@endif
									@if($data->status=='Accomplished' && $data->feedback != "")
									<button class="btn btn-default btn-sm" onclick="view_rate_modal('{{$data->id}}', '{{$data->feedback}}', '{{$data->star}}')">
										<span class="fa fa-star"></span>
									</button>
									@elseif($data->status=='Accomplished' && $data->feedback == "")
									<button class="btn btn-success btn-sm" onclick="rate_modal('{{$data->id}}')">
										<span class="fa fa-star"></span> Rate
									</button>
									@endif
									@if($data->status=='Filing')
									<button class="btn btn-success btn-sm" onclick="_submitVehicle('{{$data->id}}')">
										<span class="fa fa-check"></span> Submit
									</button> |
									<button name="edit" id="edit" onclick="_editVehicle('{{$data->id}}')" class="btn btn-sm btn-primary edit">
										<span class="fa fa-edit"></span>
									</button>
									<button class="btn btn-danger btn-sm" onclick="_deleteVehicle('{{$data->id}}','{{$data->purpose}}')">
										<span class="fa fa-trash"></span>
									</button>
									@endif

									@if($data->status=='For Rescheduling' && $data->view_edit == "view")
									<button onclick="resched_modal('{{$data->id}}')" class="btn btn-primary btn-sm">
										<span class="fa fa-calendar"></span>
									</button>
									@elseif($data->status=='For Rescheduling' && $data->view_edit == "edit")
									<button onclick="view_resched_modal('{{$data->id}}')" class="btn btn-primary btn-sm">
										<span class="fa fa-calendar"></span>
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
								@if($data->resched_reason == null)
								<td>{{ $my_date_needed = date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								@else
								<td><small><b>DATE RESCHEDULED to </b></small>{{ $my_date_needed = date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								@endif
								<td>{{$data->destination}}</td>
								<td>
									@if($data->status=='Filing')
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For CAO Approval" || $data->status == "For DC Approval")
									<span class="right badge badge-warning">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For Rescheduling")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "Cancelled")
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status=='Confirmed')
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "On The Way")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For Assignment")
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>
									@elseif($data->status=='Accomplished')
									<span class="right badge badge-default">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif

									@if($data->urgency == "urgent" && $data->status !='Accomplished')
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->urgency)) }}!</span>
									@endif
									@if($data->status =='Accomplished' && $data->feedback == "")
									<span class="right badge badge-warning">TO RATE</span>
									@endif

								</td>
								<td>
									@if($data->status!='Filing')
									<button onclick="_viewVehicle('{{$data->id}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button> |
									@endif
									@if($data->status=='Accomplished' && $data->feedback != "")
									<button class="btn btn-default btn-sm" onclick="view_rate_modal('{{$data->id}}', '{{$data->feedback}}', '{{$data->star}}')">
										<span class="fa fa-star"></span>
									</button>
									@elseif($data->status=='Accomplished' && $data->feedback == "")
									<button class="btn btn-success btn-sm" onclick="rate_modal('{{$data->id}}')">
										<span class="fa fa-star"></span> Rate
									</button>
									@endif
									@if($data->status=='Filing')
									<button class="btn btn-success btn-sm" onclick="_submitVehicle('{{$data->id}}')">
										<span class="fa fa-check"></span> Submit
									</button> |
									<button name="edit" id="edit" onclick="_editVehicle('{{$data->id}}')" class="btn btn-sm btn-primary edit">
										<span class="fa fa-edit"></span>
									</button>
									<button class="btn btn-danger btn-sm" onclick="_deleteVehicle('{{$data->id}}','{{$data->purpose}}')">
										<span class="fa fa-trash"></span>
									</button>
									@endif

									@if($data->status=='For Rescheduling' && $data->view_edit == "view")
									<button onclick="resched_modal('{{$data->id}}')" class="btn btn-primary btn-sm">
										<span class="fa fa-calendar"></span>
									</button>
									@elseif($data->status=='For Rescheduling' && $data->view_edit == "edit")
									<button onclick="view_resched_modal('{{$data->id}}')" class="btn btn-primary btn-sm">
										<span class="fa fa-calendar"></span>
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

							@if(Auth::user()->user_type == 4 && (Auth::user()->id == $data->user_id))
							<tr class="text-center">
								<td>{{ $my_date_req = date('F j, Y g:i A', strtotime($data->created_at)) }}</td>
								<td>{{$data->purpose}}</td>
								@if($data->resched_reason == null)
								<td>{{ $my_date_needed = date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								@else
								<td><small><b>DATE RESCHEDULED to </b></small>{{ $my_date_needed = date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								@endif
								<td>{{$data->destination}}</td>
								<td>
									@if($data->status=='Filing')
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For CAO Approval" || $data->status == "For DC Approval")
									<span class="right badge badge-warning">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "Cancelled")
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For Rescheduling")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status=='Confirmed')
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "On The Way")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For Assignment")
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>
									@elseif($data->status=='Accomplished')
									<span class="right badge badge-default">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif

									@if($data->urgency == "urgent" && $data->status !='Accomplished')
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->urgency)) }}!</span>
									@endif
									@if($data->status =='Accomplished' && $data->feedback == "")
									<span class="right badge badge-warning">TO RATE</span>
									@endif

								</td>
								<td>
									@if($data->status!='Filing')
									<button onclick="_viewVehicle('{{$data->id}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button> |
									@endif
									@if($data->status=='Accomplished' && $data->feedback != "")
									<button class="btn btn-default btn-sm" onclick="view_rate_modal('{{$data->id}}', '{{$data->feedback}}', '{{$data->star}}')">
										<span class="fa fa-star"></span>
									</button>
									@elseif($data->status=='Accomplished' && $data->feedback == "")
									<button class="btn btn-success btn-sm" onclick="rate_modal('{{$data->id}}')">
										<span class="fa fa-star"></span> Rate
									</button>
									@endif
									@if($data->status=='Filing')
									<button class="btn btn-success btn-sm" onclick="_submitVehicle('{{$data->id}}')">
										<span class="fa fa-check"></span> Submit
									</button> |
									<button name="edit" id="edit" onclick="_editVehicle('{{$data->id}}')" class="btn btn-sm btn-primary edit">
										<span class="fa fa-edit"></span>
									</button>
									<button class="btn btn-danger btn-sm" onclick="_deleteVehicle('{{$data->id}}','{{$data->purpose}}')">
										<span class="fa fa-trash"></span>
									</button>
									@endif

									@if($data->status=='For Rescheduling' && $data->view_edit == "view")
									<button onclick="resched_modal('{{$data->id}}')" class="btn btn-primary btn-sm">
										<span class="fa fa-calendar"></span>
									</button>
									@elseif($data->status=='For Rescheduling' && $data->view_edit == "edit")
									<button onclick="view_resched_modal('{{$data->id}}')" class="btn btn-primary btn-sm">
										<span class="fa fa-calendar"></span>
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
								@if($data->resched_reason == null)
								<td>{{ $my_date_needed = date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								@else
								<td><small><b>DATE RESCHEDULED to </b></small>{{ $my_date_needed = date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								@endif
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

									@elseif($data->status == "For Rescheduling")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status=='Accomplished')
									<span class="right badge badge-default">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif

									@if($data->urgency == "urgent" && $data->status !='Accomplished')
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->urgency)) }}!</span>
									@endif
									@if($data->status =='Accomplished' && $data->feedback == "")
									<span class="right badge badge-warning">TO RATE</span>
									@endif

								</td>
								<td>
									@if($data->status!='Filing')
									<button onclick="_viewVehicle('{{$data->id}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button> |
									@endif
									@if($data->status=='Accomplished' && $data->feedback != "")
									<button class="btn btn-default btn-sm" onclick="view_rate_modal('{{$data->id}}', '{{$data->feedback}}', '{{$data->star}}')">
										<span class="fa fa-star"></span>
									</button>
									@elseif($data->status=='Accomplished' && $data->feedback == "")
									<button class="btn btn-success btn-sm" onclick="rate_modal('{{$data->id}}')">
										<span class="fa fa-star"></span> Rate
									</button>
									@endif
									@if($data->status=='Filing')
									<button class="btn btn-success btn-sm" onclick="_submitVehicle('{{$data->id}}')">
										<span class="fa fa-check"></span> Submit
									</button> |
									<button name="edit" id="edit" onclick="_editVehicle('{{$data->id}}')" class="btn btn-sm btn-primary edit">
										<span class="fa fa-edit"></span>
									</button>
									<button class="btn btn-danger btn-sm" onclick="_deleteVehicle('{{$data->id}}','{{$data->purpose}}')">
										<span class="fa fa-trash"></span>
									</button>
									@endif

									@if($data->status=='For Rescheduling' && $data->view_edit == "view")
									<button onclick="resched_modal('{{$data->id}}')" class="btn btn-primary btn-sm">
										<span class="fa fa-calendar"></span>
									</button>
									@elseif($data->status=='For Rescheduling' && $data->view_edit == "view")if($data->status=='For Rescheduling' && $data->view_edit == "edit")
									<button onclick="view_resched_modal('{{$data->id}}')" class="btn btn-primary btn-sm">
										<span class="fa fa-calendar"></span>
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
								@if($data->resched_reason == null)
								<td>{{ $my_date_needed = date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								@else
								<td><small><b>DATE RESCHEDULED to </b></small>{{ $my_date_needed = date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								@endif
								<td>{{$data->destination}}</td>
								<td>
									@if($data->status=='Filing')
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For CAO Approval" || $data->status == "For DC Approval")
									<span class="right badge badge-warning">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For Rescheduling")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "Cancelled")
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status=='Confirmed')
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "On The Way")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For Assignment")
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>
									@elseif($data->status=='Accomplished')
									<span class="right badge badge-default">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif

									@if($data->urgency == "urgent" && $data->status !='Accomplished')
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->urgency)) }}!</span>
									@endif
									@if($data->status =='Accomplished' && $data->feedback == "")
									<span class="right badge badge-warning">TO RATE</span>
									@endif

								</td>
								<td>
									@if($data->status!='Filing')
									<button onclick="_viewVehicle('{{$data->id}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button> |
									@endif
									@if($data->status=='Accomplished' && $data->feedback != "")
									<button class="btn btn-default btn-sm" onclick="view_rate_modal('{{$data->id}}', '{{$data->feedback}}', '{{$data->star}}')">
										<span class="fa fa-star"></span>
									</button>
									@elseif($data->status=='Accomplished' && $data->feedback == "")
									<button class="btn btn-success btn-sm" onclick="rate_modal('{{$data->id}}')">
										<span class="fa fa-star"></span> Rate
									</button>
									@endif
									@if($data->status=='Filing')
									<button class="btn btn-success btn-sm" onclick="_submitVehicle('{{$data->id}}')">
										<span class="fa fa-check"></span> Submit
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

									@if($data->status=='For Rescheduling' && $data->view_edit == "view")
									<button onclick="resched_modal('{{$data->id}}')" class="btn btn-primary btn-sm">
										<span class="fa fa-calendar"></span>
									</button>
									@elseif($data->status=='For Rescheduling' && $data->view_edit == "view")
									<button onclick="view_resched_modal('{{$data->id}}')" class="btn btn-primary btn-sm">
										<span class="fa fa-calendar"></span>
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
	<div class="modal-dialog modal modal-lg modal-dialog-centered">
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
						<div class="col-sm-12">
							<div class="row">
								<div class="col-sm-12">
									<div class="row">
										<div class="col-sm-6">
											<label>Date and Time Needed
												<span class="text-red">*</span>
											</label>
											<input type="datetime-local" class="form-control" name="date_needed" id="date_needed" required>
										</div>
										<div class="col-sm-6">
											<div class="form-group">
												<div class="form-check">
													<input class="form-check-input" type="radio" name="urgency" id="urgency" value="not_urgent" required>
													<label class="form-check-label" for="urgency">
														Not Urgent
													</label>
												</div>
												<div class="form-check">
													<input class="form-check-input" type="radio" name="urgency" id="urgency" value="urgent" required>
													<label class="form-check-label" for="urgency">
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
											<textarea placeholder="....." id="purpose" name="purpose" class="form-control" rows="4" required></textarea>
											<br>
											<label>Destination(Address)
												<span class="text-red">*</span>
											</label>
											<textarea placeholder="....." class="form-control" rows="4" id="destination" required name="destination"></textarea>
										</div>
										<div class="col-sm-6">
											<div class="row">
												<label id="lbl_passenger">&nbsp; Add Passenger:</label>
												<span id="asterisk" class="text-red">*</span>
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
													<input type="text" placeholder="Type passenger name here ..." class="form-control" name="passenger" id="passenger">
													<div class="input-group-append">
														<button class="btn btn-primary" name="btn_passenger" id="btn_passenger" type="button" onclick="add_psg_list($('#passenger').val(), $('#vehicle_id').val())">+</button>
													</div>
												</div>
												<br>
												<div class='scrolledTable' style="height:300px; width:460px; overflow:auto;">
													<table class="table table-striped table-bordered table-sm" id="my_passenger_table">
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
								<button type="button" class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#trip_modal">
									Close
								</button>
								<button id="btn_add" type="submit" class="btn btn-success">
									<span id="icon_submit" class="fa fa-check"></span>
									<span id="btn_submit">Save</span>
								</button>
							</div>
						</div>
					</div>
				</div>
			</form>
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
					<input type="hidden" id="view_vehicle_id" name="view_vehicle_id">
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

<!--resched modal -->
<div class="modal fade" id="resched_modal" tabindex="-1" aria-labelledby="resched_modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-info">
				<h5 class="modal-title" id="resched_modalLabel">
					<span class="fa fa-calendar"></span>
					&nbsp;For Rescheduling
				</h5>
			</div>
			<input type="hidden" id="resched_vhl_id" name="resched_vhl_id">
			<div class="modal-body">
				<b>Agent Portion</b>
				<div class="row">
					<div class="col-sm">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<label class="input-group-text" for="resched_due_date">Date Needed:</label>
							</div>
							<input type="datetime-local" class="form-control" name="resched_due_date" id="resched_due_date" readonly>
						</div>
					</div>
					<div class="col-sm">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<label class="input-group-text" for="suggest_due_date">Suggested Date:</label>
							</div>
							<input type="datetime-local" class="form-control" readonly name="suggest_due_date" id="suggest_due_date">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm">
						<label>Reason for Rescheduling:
						</label>
						<textarea class="form-control" rows="3" id="resched_reason" readonly name="resched_reason"></textarea>
					</div>
				</div>
				<br>
				<b>Requestor Portion</b>
				<div class="row">
					<div class="col-sm">
						<div class="input-group mb-3">
							<select id="pref_sched" class="custom-select">
								<option selected value="none">Select from dropdown.</option>
								<option value="by_agent">Proceed with the schedule set by Agent.</option>
								<option value="by_requestor">Set preferred schedule.</option>
							</select>
						</div>
					</div>
					<div class="col-sm">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<label class="input-group-text" for="pref_date">Preferred Date:</label>
							</div>
							<input type="datetime-local" class="form-control" name="pref_date" id="pref_date">
						</div>
					</div>
				</div>
				<br>
				<br>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#resched_modal">
					Close
				</button>
				<button onclick="submitResched('{{$data->id}}')" class="btn btn-info float-right">
					<span class="fa fa-calendar"></span>
					<span>Reschedule</span>
				</button>
			</div>
		</div>
	</div>
</div>

<!--view_resched modal -->
<div class="modal fade" id="view_resched_modal" tabindex="-1" aria-labelledby="view_resched_modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-info">
				<h5 class="modal-title" id="view_resched_modalLabel">
					<span class="fa fa-calendar"></span>
					@if(isset($data))
					@if($data->status == "For Assignment" && $data->pref_date == $data->date_needed)
					&nbsp;Preferred Date Accepted
					@elseif($data->status == "For Assignment" && $data->pref_sched == "by_agent")
					&nbsp;Suggested Date Accepted
					@else
					&nbsp;For Rescheduling
					@endif
					@endif
				</h5>
			</div>
			<input type="hidden" id="view_resched_vhl_id" name="view_resched_vhl_id">
			<div class="modal-body">
				<b>Agent Portion</b>
				<div class="row">
					<div class="col-sm">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<label class="input-group-text" for="view_resched_due_date">Date Needed:</label>
							</div>
							<input type="datetime-local" class="form-control" name="view_resched_due_date" id="view_resched_due_date" readonly>
						</div>
					</div>
					<div class="col-sm">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<label class="input-group-text" for="view_suggest_due_date">Suggested Date:</label>
							</div>
							<input type="datetime-local" class="form-control" readonly name="view_suggest_due_date" id="view_suggest_due_date">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm">
						<label>Reason for Rescheduling:
						</label>
						<textarea class="form-control" rows="3" readonly id="view_resched_reason" name="view_resched_reason"></textarea>
					</div>
				</div>
				<br>
				<b>Requestor Portion</b>
				<div class="row">
					<div class="col-sm">
						<div class="input-group mb-3">
							<select id="view_pref_sched" disabled class="custom-select" aria-label="view_pref_sched">
								<option value="by_agent">Proceed with the schedule set by Agent.</option>
								<option value="by_requestor">Set preferred schedule.</option>
							</select>
						</div>
					</div>
					<div class="col-sm">
						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<label class="input-group-text" for="view_pref_date">Preferred Date:</label>
							</div>
							<input type="datetime-local" class="form-control" name="view_pref_date" id="view_pref_date" readonly>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#view_resched_modal">
					Close
				</button>
			</div>
		</div>
	</div>
</div>


<!-- rate Modal-->
<div class="modal fade" id="rate_modal" tabindex="-1" aria-labelledby="rate_modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md modal-dialog-centered">
		<div class="modal-content">

			<form action="{{URL::to('/vehicle/rate')}}" method="POST">
				<div class="modal-body bg-dark">
					@csrf
					<div class="row">
						<input type="hidden" id="rate_vhl_id" name="rate_vhl_id">
						<div class="col-sm">
							<center>
								<h4>Add Rating</h4>
							</center>
							<div class="rating form-group">
								<input type="radio" required name="rating" id="5" value="5"><label for="5">☆</label>
								<input type="radio" required name="rating" id="4" value="4"><label for="4">☆</label>
								<input type="radio" required name="rating" id="3" value="3"><label for="3">☆</label>
								<input type="radio" required name="rating" id="2" value="2"><label for="2">☆</label>
								<input type="radio" required name="rating" id="1" value="1"><label for="1">☆</label>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-sm">
							<b>Feedback</b>
							<span class="text-red">*</span>
							<textarea placeholder="Type your feedback here..." class="form-control" rows="5" id="feedback" required name="feedback"></textarea>
						</div>
					</div>
					&nbsp;
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal" data-toggle="modal" data-target="#rate_modal">
							Close
						</button>
						<button id="btn_rate" type="submit" class="btn btn-success">
							<span id="icon_rate" class="fa fa-star"></span>
							<span>Rate</span>
						</button>
					</div>
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