@extends('partials._layout')

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
						<button onclick="_add()" class="btn btn-purple float-right">
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
								<th width="10%">Status</th>
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
									@elseif($data->status=='Accomplished')
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif
								</td>
								<td>
									@if($data->status!='Filing')
									<button name="view" id="view" onclick="_viewMessengerial('{{$data->id}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button> |
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
									<button class="btn btn-warning btn-sm" onclick="_attachment('{{$data->id}}')">
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

									@elseif($data->status == "For Assignment")
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>
									@elseif($data->status=='Accomplished')
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif
								</td>

								<td>
									@if($data->status!='Filing')
									<button name="view" id="view" onclick="_viewMessengerial('{{$data->id}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button> |
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
									<button class="btn btn-warning btn-sm" onclick="_attachment('{{$data->id}}')">
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

									@elseif($data->status == "Out For Delivery")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For Assignment")
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>
									@elseif($data->status=='Accomplished')
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif
								</td>
								<td>
									@if($data->status!='Filing')
									<button name="view" id="view" onclick="_viewMessengerial('{{$data->id}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button> |
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
									<button class="btn btn-warning btn-sm" onclick="_attachment('{{$data->id}}')">
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

									@elseif($data->status == "For Assignment")
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>
									@elseif($data->status=='Accomplished')
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif
								</td>
								<td>
									@if($data->status!='Filing')
									<button name="view" id="view" onclick="_viewMessengerial('{{$data->id}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button> |
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
									<button class="btn btn-warning btn-sm" onclick="_attachment('{{$data->id}}')">
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

									@elseif($data->status == "Cancelled")
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status=='Confirmed')
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "Out For Delivery")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For Assignment")
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>
									@elseif($data->status=='Accomplished')
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif
								</td>
								<td>
									@if($data->status!='Filing')
									<button name="view" id="view" onclick="_viewMessengerial('{{$data->id}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button> |
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
									<button class="btn btn-warning btn-sm" onclick="_attachment('{{$data->id}}')">
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

									@elseif($data->status == "Cancelled")
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status=='Confirmed')
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "Out For Delivery")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For Assignment")
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>
									@elseif($data->status=='Accomplished')
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif
								</td>
								<td>
									@if($data->status!='Filing')
									<button id="view" onclick="_viewMessengerial('{{$data->id}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button> |
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
									<button class="btn btn-warning btn-sm" onclick="_attachment('{{$data->id}}')">
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
							@if($data->status=='Cancelled')
							<textarea id="cancel_reason" rows="4" class="form-control" name="cancel_reason" readonly></textarea>
							@else
							<textarea id="cancel_reason" rows="4" class="form-control" name="cancel_reason" placeholder="Type here..."></textarea>
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
					@if($data->status!='Cancelled' || $data->status!='Filing')
					<button id="btn_cancelRequest" type="submit" class="btn btn-warning">
						<span id="icon_submit" class="fa fa-times"></span>
						<span id="btn_cancel">Cancel</span>
					</button>
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
					<span>Attachment/s for Recipient - </span>
					<span id="recipient"></span>
				</h5>
			</div>
			<input type="hidden" id="messengerial_id" name="messengerial_id">
			<div class="modal-body modal-lg">

				<div class="row">
					<div class="col-sm">
						<table class="table table-sm table-bordered table-striped">
							<thead>
								<tr class="text-center">
									<th width="30%">File</th>
									<th width="50%">Remarks</th>

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
<script src="{{ asset('js/messengerial.js') }}"></script>
<script src="{{ asset('js/table.js') }}"></script>
@endsection