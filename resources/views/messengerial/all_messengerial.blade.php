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
								<th width="20%">Subject</th>
								<th width="10%">Control Number</th>
								<th width="15%">Request Date</th>
								<th width="15%">Requested By</th>
								<th width="10%">Status</th>
								<th width="10%">No. of Recipients</th>
								<th width="15%">Action</th>
							</tr>
						</thead>
						<tbody>

							@foreach($messengerial as $data)

							<tr class="text-center">
								<td>{{$data->subject}}</td>
								<td>{{$data->control_num}}</td>
								<td>{{ date('F j, Y g:i A', strtotime($data->created_at)) }}</td>
								<td>{{App\User::get_user($data->user_id)}}</td>
								<td>
									@if($data->status=='Filing')
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For CAO Approval" || $data->status == "For DC Approval")
									<span class="right badge badge-warning">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "Cancelled")
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status=='For Pickup')
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "Out For Delivery")
									<span class="right badge badge-secondary">{{ ucwords(strtoupper($data->status)) }}</span>

									@else
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif
								</td>
								<td>{{$data->count_rec}}</td>
								<td>
									<a href="{{URL::to('/messengerial/recipient')}}/{{$data->id}}" class="btn btn-info btn-sm"><span class="fa fa-users"></span></a>

									<button class="btn btn-secondary btn-sm" onclick="">
										<span class="fa fa-print"></span>
									</button>

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