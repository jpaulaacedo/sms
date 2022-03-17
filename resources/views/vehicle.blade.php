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
	<div class="card-header card-header-new">
		<h4 align="center"><span class="fa fa-truck"></span>&nbsp;Vehicle Requests</h4>
	</div>
	<div class="card-body">
		<div class="row">
			<!-- 1st col -->
			<div class="col-sm">
				&nbsp;
				<div class="row">
					<div class="col-sm-6">
						<div class="input-group mb-3">
							<span class="input-group-text bg-info" id="basic-addon3"><span class="fa fa-search">&nbsp;</span> Search</span>
							<input type="text" placeholder="Type here..." class="form-control text_search" id="basic-url" aria-describedby="basic-addon3">
						</div>
					</div>
					<div class="col-sm">
						<button name="add" id="add" class="btn btn-outline-primary  float-right" data-toggle="modal" data-target="#request_modal">
							<span class="fas fa-user-plus"></span>&nbsp;Create Request
						</button>
					</div>
				</div>

				<div class="row">
					<table class="table-sm table table-bordered table-striped searchTable no-footer" id="tickets_table" align="center" role="grid" aria-describedby="tickets_table_info">
						<thead>
							<tr class="text-center">
								<th width="20%">Subject</th>
								<th width="20%">Control Number</th>
								<th width="10%">Request Date</th>
								<th width="20%">Status</th>
								<th width="20%">Action</th>
							</tr>
						</thead>
						<tbody>


							<tr class="text-center">
								<td></td>
								<td> <i class="fas fa-paperclip"></i><a href="#"></a></td>
								<td></td>
								<td></td>
								<td>
									<button onclick="" class="btn btn-info btn-sm"><span class="fa fa-users"></span> recipient portion</button> |
									<button class="btn btn-danger btn-sm"><span class="fa fa-trash"></span> delete</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Recipient Modal -->
<div class="modal fade" id="recipient_modal" tabindex="-1" aria-labelledby="recipient_modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-secondary">
				<h5 class="modal-title" id="recipient_modalLabel"><span class="fa fa-pen"></span>&nbsp;Request Details</h5>
			</div>
			<div class="modal-body">
				<form action="" method="POST">
					<div class="row">
						<!-- 1st col -->
						<div class="col-sm">
							<div class="row">
								<div class="col-sm">
									<table width="100%">
										<tr>
											<td class="text-right" width="20%"><b>Request Date:</b></td>
											<td>&nbsp;</td>
											<td><span id="r_date"></span> </td>
										</tr>
										<tr>
											<td class="text-right"><b>Control Number:</b></td>
											<td>&nbsp;</td>
											<td><span id="control_num"></span> </td>
										</tr>
										<tr>
											<td class="text-right"><b>Remarks:</b></td>
											<td>&nbsp;</td>
											<td><span id="remarks"></span> </td>
										</tr>
									</table>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-sm">
									<label>Agency/Office <span class="text-red">*</span></label>
									<input placeholder="....." placeholder="....." type="text" id="agency" name="agency" class="form-control" rows="5" required>
								</div>
							</div>
							&nbsp;

							<div class="row">
								<div class="col-sm-8">
									<label>Recipient Name <span class="text-red">*</span></label>
									<input placeholder="....." type="text" id="r_name" name="r_name" class="form-control" rows="5" required>
								</div>
								<div class="col-sm-4">
									<label>Contact # <span class="text-red">*</span></label>
									<input placeholder="....." type="text" name="contact" id="contact" class="form-control" required />
								</div>
							</div>

							&nbsp;

							<div class="row">
								<div class="col-sm">
									<label>Destination(Address) <span class="text-red">*</span></label>
									<textarea placeholder="Complete Address..." class="form-control" rows="3" id="destination" required name="destination"></textarea>
								</div>
							</div>
							&nbsp;

							<div class="row">
								<div class="col-sm">
									<label>What to Deliver <span class="text-red">*</span></label>
									<textarea placeholder="eg. documents, checks, etc..." class="form-control" required rows="3" id="delivery_item" name="delivery_item"></textarea>
								</div>
								<div class="col-sm">
									<label>Instruction</label>
									<textarea placeholder="If any..." class="form-control" rows="3"></textarea>
								</div>
							</div>

							&nbsp;
							<div class="btn-right">
								<button type="submit" class="btn btn-info"><span class="fa fa-plus"></span> Add to List</button>
							</div>
						</div>
					</div>

					<hr>
					<!-- request items -->
					<div class="row">
						<div class="col-sm-6">
							<div class="input-group mb-3">
								<span class="input-group-text bg-info" id="basic-addon3"><span class="fa fa-search">&nbsp;</span> Search</span>
								<input type="text" placeholder="Type here..." class="form-control text_search" id="basic-url" aria-describedby="basic-addon3">
							</div>
						</div>
					</div>
					<div class="row">
						<table class="table-sm table table-bordered table-striped searchTable no-footer" id="req_table" align="center" role="grid" aria-describedby="tickets_table_info">
							<thead>
								<tr class="text-center">
									<th width="10%">Agency</th>
									<th width="20%">Recipient</th>
									<th width="20%">Contact #</th>
									<th width="20%">Destination</th>
									<th width="20%">Instruction</th>
									<th width="20%">Action</th>
								</tr>
							</thead>
							<tbody>
								<tr class="text-center">
									<td></td>
									<td> <i class="fas fa-paperclip"></i><a href="http://192.168.137.5/ticketing/agent/view/243"></a></td>
									<td></td>
									<td></td>
									<td></td>
									<td>
										<button class="btn btn-danger btn-sm"><span class="fa fa-trash"></span> delete</button>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-primary"><span class="fa fa-check"></span> Submit</button>
			</div>
		</div>
	</div>
</div>

<!-- Request modal -->
<div class="modal fade" id="request_modal" tabindex="-1" aria-labelledby="request_modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header bg-secondary">
				<h5 class="modal-title" id="request_modalLabel"><span class="fa fa-pen"></span>&nbsp; Create Request</h5>
			</div>
			<form action="{{URL::to('/messengerial/store')}}" method="post">
				@csrf
				<div class="modal-body">
					<div class="row">
						<div class="col-sm">
							<label>Subject</label>
							<input type="text" id="subject" class="form-control" name="subject" placeholder="Enter subject here..." required>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-sm">
							<small> <span class="fa fa-exclamation-circle text-red"></span> <b>Note:</b> The "subject" will serve as the requestor's unique indicator.</small>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-success"><span class="fa fa-plus"></span> Create</button>
				</div>
			</form>
		</div>
	</div>
</div>
@endsection

@section('js')
<script src="{{ asset('js/messengerial.js') }}"></script>
<script src="{{ asset('js/table.js') }}"></script>
@endsection