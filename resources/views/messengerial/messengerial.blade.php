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
	<div class="card-header card-header-dark">
		<h4 align="center"><span class="fa fa-envelope"></span>&nbsp;My Messengerial Request</h4>
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
						<button onclick="_add()" class="btn btn-purple float-right" {{App\Messengerial::count_rate()}}>
							<span class="fas fa-plus"></span>&nbsp;Create Request
						</button>
					</div>
				</div>

				<div class="row">
					<table class="table-sm table table-bordered table-striped searchTable no-footer" id="tickets_table" align="center" role="grid" aria-describedby="tickets_table_info">
						<thead>
							<tr class="text-center">
								<th width="15%">Recipient</th>
								<th width="10%">Control Number</th>
								<th width="10%">Request Date</th>
								<th width="15%">Destination</th>
								<th width="10%">Date Needed</th>
								<th width="15%">Status</th>
								<th width="15%">Action</th>
							</tr>
						</thead>
						<tbody>

							@foreach($messengerial as $data)
							@if((Auth::user()->user_type == 1) || ((Auth::user()->user_type == 2 && $data->status!='For DC Approval')) || (Auth::user()->user_type == 3 || $data->status!='Confirmed' || $data->status!='Out For Delivery') || ((Auth::user()->user_type == 4 && $data->status!='For DC Approval')) || (Auth::user()->user_type == 5) || (Auth::user()->user_type == 6 && $data->status!='For CAO Approval' && $data->status!='For DC Approval'))

							@if(Auth::user()->user_type == 1 && (Auth::user()->id == $data->user_id))
							<tr class="text-center">
								<td>{{$data->recipient}}</td>
								<td>{{$data->control_num}}</td>
								<td>{{ date('F j, Y g:i A', strtotime($data->created_at)) }}</td>
								<td>{{$data->destination}}</td>
								@if($data->resched_reason == null)
								<td>{{ date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								@else
								<td><small><b>DATE RESCHEDULED to </b></small>{{ date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								@endif
								<td>
									@if($data->status=='Filing')
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For CAO Approval" || $data->status == "For DC Approval")
									<span class="right badge badge-warning">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "Cancelled")
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status=='Confirmed')
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "Out For Delivery")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For Assignment")
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For Rescheduling")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status=='Accomplished')
									<span class="right badge badge-default">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif

									@if($data->urgency == "urgent" && $data->status !='Accomplished' && $data->status !='Cancelled')
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->urgency)) }}!</span>
									@endif

									@if($data->status =='Accomplished' && $data->feedback == "")
									<span class="right badge badge-warning">TO RATE</span>
									@endif
								</td>
								<td>
									@if($data->status!='Filing')
									<button name="view" id="view" onclick="_viewMessengerial('{{$data->id}}')" class="btn btn-sm btn-info">
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
									<button class="btn btn-success btn-sm" onclick="_submitMessengerial('{{$data->id}}','{{$data->control_num}}')">
										<span class="fa fa-check"></span> Submit
									</button> |
									<button name="edit" id="edit" onclick="_editMessengerial('{{$data->id}}')" class="btn btn-sm btn-primary edit">
										<span class="far fa-edit"></span>
									</button>
									<button class="btn btn-danger btn-sm" onclick="_deleteMessengerial('{{$data->id}}','{{$data->recipient}}')">
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
									<button class="btn btn-warning btn-sm" onclick="_cancelMessengerial('{{$data->id}}')">
										<span class="fa fa-times"></span>
									</button>
									@endif

									@if($data->status=='Cancelled')
									<button class="btn btn-warning btn-sm" onclick="_cancelReasonMessengerial('{{$data->id}}')">
										<span class="fa fa-times"></span> reason
									</button>
									@endif

									@if($data->status =='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="acc_accomplish_modal('{{$data->id}}','{{$data->outfordel_date}}')">
										<span class="fa fa-file"></span>
									</button>
									@endif
									<a href="{{URL::to('/messengerial_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>

								</td>
							</tr>
							@endif

							@if(Auth::user()->user_type == 2 && (Auth::user()->id == $data->user_id))
							<tr class="text-center">
								<td>{{$data->recipient}}</td>
								<td>{{$data->control_num}}</td>
								<td>{{ date('F j, Y g:i A', strtotime($data->created_at)) }}</td>
								<td>{{$data->destination}}</td>
								@if($data->resched_reason == null)
								<td>{{ date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								@else
								<td><small><b>DATE RESCHEDULED to </b></small>{{ date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								@endif
								<td>
									@if($data->status=='Filing')
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For CAO Approval" || $data->status == "For DC Approval")
									<span class="right badge badge-warning">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "Cancelled")
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status=='Confirmed')
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "Out For Delivery")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For Rescheduling")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For Assignment")
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>
									@elseif($data->status=='Accomplished')
									<span class="right badge badge-default">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif

									@if($data->urgency == "urgent" && $data->status !='Accomplished' && $data->status !='Cancelled')
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->urgency)) }}!</span>
									@endif

									@if($data->status =='Accomplished' && $data->feedback == "")
									<span class="right badge badge-warning">TO RATE</span>
									@endif
								</td>

								<td>
									@if($data->status!='Filing')
									<button name="view" id="view" onclick="_viewMessengerial('{{$data->id}}')" class="btn btn-sm btn-info">
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
									<button class="btn btn-success btn-sm" onclick="_submitMessengerial('{{$data->id}}')">
										<span class="fa fa-check"></span> Submit
									</button> |
									<button name="edit" id="edit" onclick="_editMessengerial('{{$data->id}}')" class="btn btn-sm btn-primary edit">
										<span class="far fa-edit"></span>
									</button>
									<button class="btn btn-danger btn-sm" onclick="_deleteMessengerial('{{$data->id}}','{{$data->recipient}}')">
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
									<button class="btn btn-warning btn-sm" onclick="_cancelMessengerial('{{$data->id}}')">
										<span class="fa fa-times"></span>
									</button>
									@endif

									@if($data->status=='Cancelled')
									<button class="btn btn-warning btn-sm" onclick="_cancelReasonMessengerial('{{$data->id}}')">
										<span class="fa fa-times"></span> reason
									</button>
									@endif

									@if($data->status=='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="acc_accomplish_modal('{{$data->id}}','{{$data->outfordel_date}}')">
										<span class="fa fa-file"></span>
									</button>
									@endif
									<a href="{{URL::to('/messengerial_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
								</td>
							</tr>
							@endif

							@if(Auth::user()->user_type == 3 && (Auth::user()->id == $data->user_id))
							<tr class="text-center">
								<td>{{$data->recipient}}</td>
								<td>{{$data->control_num}}</td>
								<td>{{ date('F j, Y g:i A', strtotime($data->created_at)) }}</td>
								<td>{{$data->destination}}</td>
								@if($data->resched_reason == null)
								<td>{{ date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								@else
								<td><small><b>DATE RESCHEDULED to </b></small>{{ date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								@endif
								<td>
									@if($data->status=='Filing')
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For CAO Approval" || $data->status == "For DC Approval")
									<span class="right badge badge-warning">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "Cancelled")
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status=='Confirmed')
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For Rescheduling")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "Out For Delivery")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For Assignment")
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>
									@elseif($data->status=='Accomplished')
									<span class="right badge badge-default">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif

									@if($data->urgency == "urgent" && $data->status !='Accomplished' && $data->status !='Cancelled')
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->urgency)) }}!</span>
									@endif

									@if($data->status =='Accomplished' && $data->feedback == "")
									<span class="right badge badge-warning">TO RATE</span>
									@endif
								</td>
								<td>
									@if($data->status!='Filing')
									<button name="view" id="view" onclick="_viewMessengerial('{{$data->id}}')" class="btn btn-sm btn-info">
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
									<button class="btn btn-success btn-sm" onclick="_submitMessengerial('{{$data->id}}','{{$data->recipient}}')">
										<span class="fa fa-check"></span> Submit
									</button> |
									<button name="edit" id="edit" onclick="_editMessengerial('{{$data->id}}')" class="btn btn-sm btn-primary edit">
										<span class="far fa-edit"></span>
									</button>
									<button class="btn btn-danger btn-sm" onclick="_deleteMessengerial('{{$data->id}}','{{$data->recipient}}')">
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
									<button class="btn btn-warning btn-sm" onclick="_cancelMessengerial('{{$data->id}}')">
										<span class="fa fa-times"></span>
									</button>
									@endif

									@if($data->status=='Cancelled')
									<button class="btn btn-warning btn-sm" onclick="_cancelReasonMessengerial('{{$data->id}}')">
										<span class="fa fa-times"></span> reason
									</button>
									@endif

									@if($data->status=='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="acc_accomplish_modal('{{$data->id}}','{{$data->outfordel_date}}')">
										<span class="fa fa-file"></span>
									</button>
									@endif
									<a href="{{URL::to('/messengerial_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
								</td>
							</tr>
							@endif

							@if(Auth::user()->user_type == 4 && (Auth::user()->id == $data->user_id))
							<tr class="text-center">
								<td>{{$data->recipient}}</td>
								<td>{{$data->control_num}}</td>
								<td>{{ date('F j, Y g:i A', strtotime($data->created_at)) }}</td>
								<td>{{$data->destination}}</td>
								@if($data->resched_reason == null)
								<td>{{ date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								@else
								<td><small><b>DATE RESCHEDULED to </b></small>{{ date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								@endif
								<td>
									@if($data->status=='Filing')
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For CAO Approval" || $data->status == "For DC Approval")
									<span class="right badge badge-warning">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "Cancelled")
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status=='Confirmed')
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "Out For Delivery")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For Rescheduling")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For Assignment")
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>
									@elseif($data->status=='Accomplished')
									<span class="right badge badge-default">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif

									@if($data->urgency == "urgent" && $data->status !='Accomplished' && $data->status !='Cancelled')
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->urgency)) }}!</span>
									@endif

									@if($data->status =='Accomplished' && $data->feedback == "")
									<span class="right badge badge-warning">TO RATE</span>
									@endif
								</td>
								<td>
									@if($data->status!='Filing')
									<button name="view" id="view" onclick="_viewMessengerial('{{$data->id}}')" class="btn btn-sm btn-info">
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
									<button class="btn btn-success btn-sm" onclick="_submitMessengerial('{{$data->id}}','{{$data->recipient}}')">
										<span class="fa fa-check"></span> Submit
									</button> |
									<button name="edit" id="edit" onclick="_editMessengerial('{{$data->id}}')" class="btn btn-sm btn-primary edit">
										<span class="far fa-edit"></span>
									</button>
									<button class="btn btn-danger btn-sm" onclick="_deleteMessengerial('{{$data->id}}','{{$data->recipient}}')">
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
									@if($data->status=='For Rescheduling' && $data->pref_sched == "")
									<button onclick="resched_modal('{{$data->id}}')" class="btn btn-primary btn-sm">
										<span class="fa fa-calendar"></span>
									</button>
									@endif

									@if($data->status!='Cancelled' && $data->status!='Filing' && $data->status!='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="_cancelMessengerial('{{$data->id}}')">
										<span class="fa fa-times"></span>
									</button>
									@endif

									@if($data->status=='Cancelled')
									<button class="btn btn-warning btn-sm" onclick="_cancelReasonMessengerial('{{$data->id}}')">
										<span class="fa fa-times"></span> reason
									</button>
									@endif

									@if($data->status=='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="acc_accomplish_modal('{{$data->id}}','{{$data->outfordel_date}}')">
										<span class="fa fa-file"></span>
									</button>
									@endif
									<a href="{{URL::to('/messengerial_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
								</td>
							</tr>
							@endif

							@if(Auth::user()->user_type == 5 && (Auth::user()->id == $data->user_id))
							<tr class="text-center">
								<td>{{$data->recipient}}</td>
								<td>{{$data->control_num}}</td>
								<td>{{ date('F j, Y g:i A', strtotime($data->created_at)) }}</td>
								<td>{{$data->destination}}</td>
								@if($data->resched_reason == null)
								<td>{{ date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								@else
								<td><small><b>DATE RESCHEDULED to </b></small>{{ date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								@endif
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

									@elseif($data->status == "Out For Delivery")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For Assignment")
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>
									@elseif($data->status=='Accomplished')
									<span class="right badge badge-default">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif

									@if($data->urgency == "urgent" && $data->status !='Accomplished' && $data->status !='Cancelled')
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->urgency)) }}!</span>
									@endif

									@if($data->status =='Accomplished' && $data->feedback == "")
									<span class="right badge badge-warning">TO RATE</span>
									@endif
								</td>
								<td>
									@if($data->status!='Filing')
									<button name="view" id="view" onclick="_viewMessengerial('{{$data->id}}')" class="btn btn-sm btn-info">
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
									<button class="btn btn-success btn-sm" onclick="_submitMessengerial('{{$data->id}}','{{$data->recipient}}')">
										<span class="fa fa-check"></span> Submit
									</button> |
									<button name="edit" id="edit" onclick="_editMessengerial('{{$data->id}}')" class="btn btn-sm btn-primary edit">
										<span class="far fa-edit"></span>
									</button>
									<button class="btn btn-danger btn-sm" onclick="_deleteMessengerial('{{$data->id}}','{{$data->recipient}}')">
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
									<button class="btn btn-warning btn-sm" onclick="_cancelMessengerial('{{$data->id}}')">
										<span class="fa fa-times"></span>
									</button>
									@endif

									@if($data->status=='Cancelled')
									<button class="btn btn-warning btn-sm" onclick="_cancelReasonMessengerial('{{$data->id}}')">
										<span class="fa fa-times"></span> reason
									</button>
									@endif

									@if($data->status=='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="acc_accomplish_modal('{{$data->id}}','{{$data->outfordel_date}}')">
										<span class="fa fa-file"></span>
									</button>
									@endif
									<a href="{{URL::to('/messengerial_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
								</td>
							</tr>
							@endif

							@if(Auth::user()->user_type == 6 && (Auth::user()->id == $data->user_id))
							<tr class="text-center">
								<td>{{$data->recipient}}</td>
								<td>{{$data->control_num}}</td>
								<td>{{ date('F j, Y g:i A', strtotime($data->created_at)) }}</td>
								<td>{{$data->destination}}</td>
								@if($data->resched_reason == null)
								<td>{{ date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								@else
								<td><small><b>DATE RESCHEDULED to </b></small>{{ date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								@endif
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

									@elseif($data->status == "Out For Delivery")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For Assignment")
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>
									@elseif($data->status=='Accomplished')
									<span class="right badge badge-default">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif

									@if($data->urgency == "urgent" && $data->status !='Accomplished' && $data->status !='Cancelled')
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->urgency)) }}!</span>
									@endif

									@if($data->status =='Accomplished' && $data->feedback == "")
									<span class="right badge badge-warning">TO RATE</span>
									@endif
								</td>
								<td>
									@if($data->status!='Filing')
									<button id="view" onclick="_viewMessengerial('{{$data->id}}')" class="btn btn-sm btn-info">
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
									<button class="btn btn-success btn-sm" onclick="_submitMessengerial('{{$data->id}}','{{$data->recipient}}')">
										<span class="fa fa-check"></span> Submit
									</button> |
									<button name="edit" id="edit" onclick="_editMessengerial('{{$data->id}}')" class="btn btn-sm btn-primary edit">
										<span class="far fa-edit"></span>
									</button>
									<button class="btn btn-danger btn-sm" onclick="_deleteMessengerial('{{$data->id}}','{{$data->recipient}}')">
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
									<button class="btn btn-warning btn-sm" onclick="_cancelMessengerial('{{$data->id}}')">
										<span class="fa fa-times"></span>
									</button>
									@endif

									@if($data->status=='Cancelled')
									<button class="btn btn-warning btn-sm" onclick="_cancelReasonMessengerial('{{$data->id}}')">
										<span class="fa fa-times"></span> reason
									</button>
									@endif

									@if($data->status=='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="acc_accomplish_modal('{{$data->id}}','{{$data->outfordel_date}}')">
										<span class="fa fa-file"></span>
									</button>
									@endif
									<a href="{{URL::to('/messengerial_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
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
<!-- Recipient Modal-->
<div class="modal fade" id="recipient_modal" tabindex="-1" aria-labelledby="recipient_modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header bg-info">
				<h5 class="modal-title" id="recipient_modalLabel">
					<span class="fa fa-user"></span>
					<span id="recipient_title">&nbsp;Create Messengerial Request</span>
				</h5>
			</div>
			<div class="modal-body">
				<form action="{{URL::to('/messengerial/store')}}" method="POST">
					@csrf
					<div class="row">
						<input type="hidden" id="msg_id" name="msg_id">
						<div class="col-sm">

							<div class="row">
								<div class="col-sm">
									<label>Recipient
										<span class="text-red">*</span>
									</label>
									<input placeholder="....." placeholder="....." type="text" id="recipient" name="recipient" class="form-control" rows="5" required>
								</div>
								<div class="col-sm">
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
							&nbsp;

							<div class="row">
								<div class="col-sm-4">
									<label>Agency/Office
										<span class="text-red">*</span>
									</label>
									<input placeholder="....." type="text" id="agency" name="agency" class="form-control" rows="5" required>
								</div>
								<div class="col-sm-4">
									<label>Contact #
										<span class="text-red">*</span>
									</label>
									<input placeholder="....." type="text" name="contact" id="contact" class="form-control" required />
								</div>
								<div class="col-sm-4">
									<label>Date Needed
										<span class="text-red">*</span>
									</label>
									<input type="datetime-local" class="form-control" name="due_date" id="due_date" required>
								</div>
							</div>

							&nbsp;

							<div class="row">
								<div class="col-sm">
									<label>Destination(Address)
										<span class="text-red">*</span>
									</label>
									<textarea placeholder="complete address..." class="form-control" rows="3" id="destination" required name="destination"></textarea>
								</div>
							</div>
							&nbsp;

							<div class="row">
								<div class="col-sm">
									<label>What to Deliver
										<span class="text-red">*</span>
										<small>
											If multiple items, separate using comma(,).
										</small>
									</label>
									<textarea placeholder="eg. documents, checks, etc..." class="form-control" required rows="3" id="delivery_item" name="delivery_item"></textarea>
								</div>
								<div class="col-sm">
									<label>Instruction</label>
									<textarea placeholder="if any..." id="instruction" name="instruction" class="form-control" rows="3"></textarea>
								</div>
							</div>

							&nbsp;

							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#recipient_modal">
									Close
								</button>
								<button id="btn_add" type="submit" class="btn btn-info">
									<span id="icon_submit" class="fa fa-plus"></span>
									<span id="btn_submit">Create</span>
								</button>
							</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

<!-- rate Modal-->
<div class="modal fade" id="rate_modal" tabindex="-1" aria-labelledby="rate_modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-md modal-dialog-centered">
		<div class="modal-content">

			<form action="{{URL::to('/messengerial/rate')}}" method="POST">
				<div class="modal-body bg-dark">
					@csrf
					<div class="row">
						<input type="hidden" id="rate_msg_id" name="rate_msg_id">
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

<!-- View Messengerial Modal-->
<div class="modal fade" id="view_msg_modal" tabindex="-1" aria-labelledby="view_msg_modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header bg-info">
				<h5 class="modal-title" id="view_msg_modalLabel">
					<span class="fa fa-user"></span>
					&nbsp;Recipient Details
				</h5>
			</div>
			<div class="modal-body">
				<div class="row">
					<input type="hidden" id="view_messengerial_id" name="view_messengerial_id">
					<div class="col-sm">

						<div class="row">
							<div class="col-sm">
								<label>Recipient
									<span class="text-red">*</span>
								</label>
								<input readonly type="text" id="view_recipient" name="view_recipient" class="form-control" rows="5">
							</div>
							<div class="col-sm">
								<div class="form-group">
									<div class="form-check">
										<input class="form-check-input" type="radio" name="view_urgency" id="view_urgency" value="not_urgent">
										<label class="form-check-label" for="view_urgency">
											Not Urgent
										</label>
									</div>
									<div class="form-check">
										<input class="form-check-input" type="radio" name="view_urgency" id="view_urgency" value="urgent">
										<label class="form-check-label" for="view_urgency">
											Urgent
										</label>
									</div>
								</div>
							</div>
						</div>
						&nbsp;

						<div class="row">
							<div class="col-sm-4">
								<label>Agency/Office
									<span class="text-red">*</span>
								</label>
								<input readonly type="text" id="view_agency" name="view_agency" class="form-control" rows="5">
							</div>
							<div class="col-sm-4">
								<label>Contact #
									<span class="text-red">*</span>
								</label>
								<input readonly type="text" name="view_contact" id="view_contact" class="form-control" />
							</div>
							<div class="col-sm-4">
								<label>Date Needed
									<span class="text-red">*</span>
								</label>
								<input type="datetime-local" class="form-control" readonly name="view_due_date" id="view_due_date">
							</div>
						</div>

						&nbsp;

						<div class="row">
							<div class="col-sm">
								<label>Destination(Address)
									<span class="text-red">*</span>
								</label>
								<textarea readonly class="form-control" rows="3" id="view_destination" name="view_destination"></textarea>
							</div>
						</div>
						&nbsp;

						<div class="row">
							<div class="col-sm">
								<label>What to Deliver
									<span class="text-red">*</span>
									<small>
										If multiple items, separate using comma(,).
									</small>
								</label>
								<textarea readonly class="form-control" rows="3" id="view_delivery_item" name="view_delivery_item"></textarea>
							</div>
							<div class="col-sm">
								<label>Instruction</label>
								<textarea readonly id="view_instruction" name="view_instruction" class="form-control" rows="3"></textarea>
							</div>
						</div>

						&nbsp;

						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#view_msg_modal">
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

<!-- View Accomplish modal -->
<div class="modal fade" id="acc_accomplish_modal" data-toggle="modal" data-dismiss="modal" tabindex="-1" aria-labelledby="acc_accomplish_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="acc_accomplish_modalLabel">
                    <span id="modal_header" class="fa fa-file"></span>&nbsp;
                    <span>Attachment - </span>
                    <span id="acc_control_num"></span>
                </h5>
            </div>
            <input type="hidden" id="acc_msg_id" name="acc_msg_id">
            <div class="modal-body modal-lg">
                <div class="row">
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="acc_outfordel_date">Departure Time</label>
                        </div>
                        <input type="datetime-local" class="form-control" readonly name="acc_outfordel_date" id="acc_outfordel_date">

                        &nbsp;&nbsp;
                        <div class="input-group-prepend">
                            <label class="input-group-text" for="acc_accomplished_date">Accomplished Date</label>
                        </div>
                        <input type="datetime-local" class="form-control" name="acc_accomplished_date" readonly id="acc_accomplished_date">
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm">
                        <label>Remarks</label>
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
			<input type="hidden" id="resched_msg_id" name="resched_msg_id">
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
				<hr>
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
				@if(isset($data))
				<button onclick="submitResched('{{$data->id}}')" class="btn btn-info float-right">
					<span class="fa fa-calendar"></span>
					<span>Reschedule</span>
				</button>
				@endif
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
			<input type="hidden" id="view_resched_msg_id" name="view_resched_msg_id">
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
				<hr>
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

@endsection

@section('js')
<script src="{{ asset('js/messengerial.js') }}"></script>
<script src="{{ asset('js/table.js') }}"></script>
@endsection