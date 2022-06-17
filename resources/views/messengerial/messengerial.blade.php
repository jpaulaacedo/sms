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
								<th width="10%">Agency</th>
								<th width="10%">Control Number</th>
								<th width="10%">Request Date</th>
								<th width="10%">Destination</th>
								<th width="10%">Contact No.</th>
								<th width="10%">What to Deliver</th>
								<th width="10%">Instruction</th>
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
								<td>{{$data->agency}}</td>
								<td>{{$data->control_num}}</td>
								<td>{{ date('F j, Y g:i A', strtotime($data->created_at)) }}</td>
								<td>{{$data->destination}}</td>
								<td>{{$data->contact}}</td>
								<td>{{ date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								<td>
									@if($data->status=='Filing')
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For CAO Approval" || $data->status == "For DC Approval")
									<span class="right badge badge-warning">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "Cancelled")
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status=='Confirmed')
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "Out For Delivery")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@else
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif
								</td>
								<td>
									<a href="{{URL::to('/messengerial/recipient')}}/{{$data->id}}" class="btn btn-info btn-sm"><span class="fa fa-users"></span></a> |

									@if($data->status=='Filing')
									<button name="edit" id="edit" onclick="_editMessengerial('{{$data->id}}')" class="btn btn-sm btn-primary edit">
										<span class="fa fa-edit"></span>
									</button>
									<button class="btn btn-danger btn-sm" onclick="_deleteMessengerial('{{$data->id}}','{{$data->recipient}}')">
										<span class="fa fa-trash"></span>
									</button>
									@endif
									@if($data->status!='Cancelled' && $data->status!='Filing' && $data->status!='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="_cancelMessengerial('{{$data->id}}')">
										<span class="fa fa-times"></span> cancel
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
								<td>{{ date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								<td>
									@if($data->status=='Filing')
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For CAO Approval" || $data->status == "For DC Approval")
									<span class="right badge badge-warning">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "Cancelled")
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status=='Confirmed')
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "Out For Delivery")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@else
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif
								</td>

								<td>
									<a href="{{URL::to('/messengerial/recipient')}}/{{$data->id}}" class="btn btn-info btn-sm"><span class="fa fa-users"></span></a> |

									@if($data->status=='Filing')
									<button name="edit" id="edit" onclick="_editMessengerial('{{$data->id}}')" class="btn btn-sm btn-primary edit">
										<span class="fa fa-edit"></span>
									</button>
									<button class="btn btn-danger btn-sm" onclick="_deleteMessengerial('{{$data->id}}','{{$data->recipient}}')">
										<span class="fa fa-trash"></span>
									</button>
									@endif

									@if($data->status!='Cancelled' && $data->status!='Filing' && $data->status!='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="_cancelMessengerial('{{$data->id}}')">
										<span class="fa fa-times"></span> cancel
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
									<a href="{{URL::to('/messengerial_form')}}/{{$data->id}}" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
								</td>
							</tr>
							@endif

							@if(Auth::user()->user_type == 3 && (Auth::user()->id == $data->user_id))
							<tr class="text-center">
								<td>{{$data->recipient}}</td>
								<td>{{$data->control_num}}</td>
								<td>{{ date('F j, Y g:i A', strtotime($data->created_at)) }}</td>
								<td>{{$data->destination}}</td>
								<td>{{ date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								<td>
									@if($data->status=='Filing')
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For CAO Approval" || $data->status == "For DC Approval")
									<span class="right badge badge-warning">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "Cancelled")
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status=='Confirmed')
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "Out For Delivery")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@else
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif
								</td>
								<td>
									<a href="{{URL::to('/messengerial/recipient')}}/{{$data->id}}" class="btn btn-info btn-sm"><span class="fa fa-users"></span></a> |

									@if($data->status=='Filing')
									<button name="edit" id="edit" onclick="_editMessengerial('{{$data->id}}')" class="btn btn-sm btn-primary edit">
										<span class="fa fa-edit"></span>
									</button>
									<button class="btn btn-danger btn-sm" onclick="_deleteMessengerial('{{$data->id}}','{{$data->recipient}}')">
										<span class="fa fa-trash"></span>
									</button>
									@endif

									@if($data->status!='Cancelled' && $data->status!='Filing' && $data->status!='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="_cancelMessengerial('{{$data->id}}')">
										<span class="fa fa-times"></span> cancel
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
								<td>
									@if($data->status=='Filing')
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For CAO Approval" || $data->status == "For DC Approval")
									<span class="right badge badge-warning">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "Cancelled")
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status=='Confirmed')
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "Out For Delivery")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@else
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif
								</td>
								<td>{{$data->destination}}</td>
								<td>{{ date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								<td>
									<a href="{{URL::to('/messengerial/recipient')}}/{{$data->id}}" class="btn btn-info btn-sm"><span class="fa fa-users"></span></a> |

									@if($data->status=='Filing')
									<button name="edit" id="edit" onclick="_editMessengerial('{{$data->id}}')" class="btn btn-sm btn-primary edit">
										<span class="fa fa-edit"></span>
									</button>
									<button class="btn btn-danger btn-sm" onclick="_deleteMessengerial('{{$data->id}}','{{$data->recipient}}')">
										<span class="fa fa-trash"></span>
									</button>
									@endif

									@if($data->status!='Cancelled' && $data->status!='Filing' && $data->status!='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="_cancelMessengerial('{{$data->id}}')">
										<span class="fa fa-times"></span> cancel
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
								<td>{{ date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								<td>
									@if($data->status=='Filing')
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For CAO Approval" || $data->status == "For DC Approval")
									<span class="right badge badge-warning">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "Cancelled")
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status=='Confirmed')
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "Out For Delivery")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@else
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif
								</td>
								<td>
									<a href="{{URL::to('/messengerial/recipient')}}/{{$data->id}}" class="btn btn-info btn-sm"><span class="fa fa-users"></span></a> |

									@if($data->status=='Filing')
									<button name="edit" id="edit" onclick="_editMessengerial('{{$data->id}}')" class="btn btn-sm btn-primary edit">
										<span class="fa fa-edit"></span>
									</button>
									<button class="btn btn-danger btn-sm" onclick="_deleteMessengerial('{{$data->id}}','{{$data->recipient}}')">
										<span class="fa fa-trash"></span>
									</button>
									@endif
									@if($data->status!='Cancelled' && $data->status!='Filing' && $data->status!='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="_cancelMessengerial('{{$data->id}}')">
										<span class="fa fa-times"></span> cancel
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
								<td>{{ date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								<td>
									@if($data->status=='Filing')
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For CAO Approval" || $data->status == "For DC Approval")
									<span class="right badge badge-warning">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "Cancelled")
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status=='Confirmed')
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "Out For Delivery")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@else
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif
								</td>
								<td>
									<a href="{{URL::to('/messengerial/recipient')}}/{{$data->id}}" class="btn btn-info btn-sm"><span class="fa fa-users"></span></a> |

									@if($data->status=='Filing')
									<button name="edit" id="edit" onclick="_editMessengerial('{{$data->id}}')" class="btn btn-sm btn-primary edit">
										<span class="fa fa-edit"></span>
									</button>
									<button class="btn btn-danger btn-sm" onclick="_deleteMessengerial('{{$data->id}}','{{$data->recipient}}')">
										<span class="fa fa-trash"></span>
									</button>
									@endif
									@if($data->status!='Cancelled' && $data->status!='Filing' && $data->status!='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="_cancelMessengerial('{{$data->id}}')">
										<span class="fa fa-times"></span> cancel
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
					&nbsp;Create Messengerial Request
				</h5>
			</div>
			<div class="modal-body">
				<form action="{{URL::to('/messengerial/store')}}" method="POST">
					@csrf
					<div class="row">
						<input type="hidden" id="messengerial_id" name="messengerial_id">
						<div class="col-sm">
							
							<div class="row">
								<div class="col-sm">
									<label>Agency/Office
										<span class="text-red">*</span>
									</label>
									<input placeholder="....." placeholder="....." type="text" id="agency" name="agency" class="form-control" rows="5" required>
								</div>
							</div>
							&nbsp;

							<div class="row">
								<div class="col-sm-4">
									<label>Recipient Name
										<span class="text-red">*</span>
									</label>
									<input placeholder="....." type="text" id="recipient" name="recipient" class="form-control" rows="5" required>
								</div>
								<div class="col-sm-4">
									<label>Contact #
										<span class="text-red">*</span>
									</label>
									<input placeholder="....." type="text" name="contact" id="contact" class="form-control" required />
								</div>
								<div class="col-sm-4">
									<label>Due Date
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
			</div>
		</div>
	</div>
</div>

<!-- Request modal
<div class="modal fade" id="request_modal" data-toggle="modal" data-dismiss="modal" tabindex="-1" aria-labelledby="request_modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header bg-info">
				<h5 class="modal-title" id="request_modalLabel">
					<span class="fa fa-pen"></span>&nbsp;
					<span id="request_header"> Create Request</span>
				</h5>
			</div>
			<form action="{{URL::to('/messengerial/store')}}" method="post">
				@csrf
				<input type="hidden" id="messengerial_id" name="messengerial_id">

				<div class="modal-body">
					<div class="row">
						<div class="col-sm">
							<label>Recipient</label>
							<input type="text" id="recipient" class="form-control" name="recipient" placeholder="Enter recipient here..." required>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-sm">
							<small>
								<span class="fa fa-exclamation-circle text-red"></span>
								<b>Note:</b> The "recipient" will serve as the requestor's unique indicator.
							</small>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button id="btn_editRequest" type="submit" class="btn btn-success">
						<span id="icon_submit" class="fa fa-plus"></span>
						<span id="btn_submit">Create</span>
					</button>
				</div>
			</form>
		</div>
	</div>
</div> -->

<!-- cancel modal
<div class="modal fade" id="cancel_modal" data-toggle="modal" data-dismiss="modal" tabindex="-1" aria-labelledby="cancel_modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header bg-info">
				<h5 class="modal-title" id="cancel_modalLabel">
					<span class="fa fa-times"></span>&nbsp;
					<span id="cancel_header"> Cancel Request </span>
				</h5>
			</div>
			<form action="{{URL::to('/messengerial/cancel')}}" method="post">
				@csrf
				<input type="hidden" id="msg_cancel_id" name="messengerial_id">

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
						<span id="btn_submit">Cancel</span>
					</button>
				</div>
			</form>
		</div>
	</div>
</div> -->

<!-- Accomplish modal -->
<div class="modal fade" id="accomplish_modal" data-toggle="modal" data-dismiss="modal" tabindex="-1" aria-labelledby="accomplish_modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-info">
				<h5 class="modal-title" id="accomplish_modalLabel">
					<span id="modal_header" class="fa fa-file"></span>&nbsp;
					<span>Attachment/s for Request - </span>
					<span id="ctrl_num"></span>
				</h5>
			</div>
			<input type="hidden" id="messengerial_id" name="messengerial_id">
			<div class="modal-body modal-lg">

				<div class="row">
					<div class="col-sm">
						<table class="table table-sm table-bordered table-striped">
							<thead>
								<tr class="text-center">
									<th width="30%">Recipient</th>
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
@endsection

@section('js')
<script src="{{ asset('js/messengerial.js') }}"></script>
<script src="{{ asset('js/table.js') }}"></script>
@endsection