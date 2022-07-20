@extends('partials._layout')
@section('css')
<style>
	.btn-right {
		text-align: right;
	}
</style>
@endsection

@section('content')
<div class="card">
	<div class="card-header card-header-new card-header-dark">
		<h4 align="center"><span class="fa fa-envelope"></span>&nbsp;All Messengerial Requests</h4>
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
								<th width="15%">Recipient</th>
								<th width="10%">Control Number</th>
								<th width="10%">Requested By</th>
								<th width="10%">Request Date</th>
								<th width="15%">Destination</th>
								<th width="10%">Date Needed</th>
								<th width="20%">Status</th>
								<th width="15%">Action</th>
							</tr>
						</thead>
						<tbody>

							@foreach($messengerial as $data)
							<tr class="text-center">
								<td>{{$data->recipient}}</td>
								<td>{{$data->control_num}}</td>
								<td>{{App\User::get_user($data->user_id)}}</td>
								<td>{{ date('F j, Y', strtotime($data->created_at)) }} <br> {{ date('g:i A', strtotime($data->created_at)) }}</td>
								<td>{{$data->destination}}</td>
								<td>{{ date('F j, Y', strtotime($data->date_needed)) }} <br> {{ date('g:i A', strtotime($data->date_needed)) }}</td>
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
									@if($data->urgency == "urgent" && $data->status !='Accomplished')
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->urgency)) }}!</span>
									@endif
								</td>
								<td>
									<button name="view" id="view" onclick="_viewMessengerial('{{$data->id}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button> |
									@if($data->status=='Accomplished')
									<button class="btn btn-warning btn-sm" onclick="acc_accomplish_modal('{{$data->id}}','{{$data->outfordel_date}}')">
										<span class="fa fa-file"></span>
									</button>
									@endif
									<a href="{{URL::to('/messengerial_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
								</td>
							</tr>
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
				@csrf
				<div class="row">
					<input type="hidden" id="view_messengerial_id" name="view_messengerial_id">
					<div class="col-sm">

						<div class="row">
							<div class="col-sm">
								<label>Recipient
									<span class="text-red">*</span>
								</label>
								<input readonly type="text" id="view_recipient" name="view_recipient" class="form-control" rows="5" required>
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
								<input readonly type="text" id="view_agency" name="view_agency" class="form-control" rows="5" required>
							</div>
							<div class="col-sm-4">
								<label>Contact #
									<span class="text-red">*</span>
								</label>
								<input readonly type="text" name="view_contact" id="view_contact" class="form-control" required />
							</div>
							<div class="col-sm-4">
								<label>Date Needed
									<span class="text-red">*</span>
								</label>
								<input type="datetime-local" class="form-control" readonly name="view_due_date" id="view_due_date" required>
							</div>
						</div>

						&nbsp;

						<div class="row">
							<div class="col-sm">
								<label>Destination(Address)
									<span class="text-red">*</span>
								</label>
								<textarea readonly class="form-control" rows="3" id="view_destination" required name="view_destination"></textarea>
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
								<textarea readonly class="form-control" required rows="3" id="view_delivery_item" name="view_delivery_item"></textarea>
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

<!-- View Accomplish modal -->
<div class="modal fade" id="acc_accomplish_modal" data-toggle="modal" data-dismiss="modal" tabindex="-1" aria-labelledby="acc_accomplish_modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-info">
				<h5 class="modal-title" id="acc_accomplish_modalLabel">
					<span id="modal_header" class="fa fa-file"></span>&nbsp;
					<span>Attachment for Recipient - </span>
					<span id="acc_recipient"></span>
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
							<tbody id="view_file_body">
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