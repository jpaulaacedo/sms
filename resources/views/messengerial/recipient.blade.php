@extends('partials._layout')
@section('css')
<style>
	.btn-right {
		text-align: right;
	}
</style>
@endsection

@section('content')
<div>
	@if(Auth::user()->user_type == 1 || Auth::user()->user_type == 4)
	<a class="btn btn-primary" href="{{URL::to('/messengerial')}}"><span class="fa fa-reply"></span> Back</a>
	@endif

	@if(Auth::user()->user_type == 2)
	@if($messengerial->status=='For DC Approval' || $messengerial->status=='For CAO Approval')
	<a class="btn btn-primary" href="{{URL::to('/messengerial/dc/approval')}}">
		<span class="fa fa-reply"></span> Back
	</a>
	@elseif(Auth::user()->id == $messengerial->user_id)
	<a class="btn btn-primary" href="{{URL::to('/messengerial')}}">
		<span class="fa fa-reply"></span> Back
	</a>
	@endif
	@endif

	@if(Auth::user()->user_type == 3)
	@if(Auth::user()->id == $messengerial->user_id)
	<a class="btn btn-primary" href="{{URL::to('/messengerial')}}">
		<span class="fa fa-reply"></span> Back
	</a>
	@elseif(Auth::user()->id != $messengerial->user_id || $messengerial->status=='For Pickup' && $messengerial->status=='Out For Delivery' && $messengerial->status=='Accomplished')
	<a class="btn btn-primary" href="{{URL::to('/messengerial/accomplish')}}">
		<span class="fa fa-reply"></span> Back
	</a>
	@endif
	@endif

	@if(Auth::user()->user_type == 5 && Auth::user()->id == $messengerial->user_id)
	<a class="btn btn-primary" href="{{URL::to('/messengerial')}}">
		<span class="fa fa-reply"></span> Back
	</a>
	@elseif(Auth::user()->user_type == 5 && Auth::user()->id != $messengerial->user_id)
	<a class="btn btn-primary" href="{{URL::to('/messengerial/all')}}">
		<span class="fa fa-reply"></span> Back
	</a>
	@endif

	@if(Auth::user()->user_type == 6)
	@if(Auth::user()->id != $messengerial->user_id && $messengerial->status=='For CAO Approval' || $messengerial->status=='For Pickup')
	<a class="btn btn-primary" href="{{URL::to('/messengerial/cao/approval')}}">
		<span class="fa fa-reply"></span> Back
	</a>
	@elseif(Auth::user()->id == $messengerial->user_id && $messengerial->status!='For CAO Approval' || $messengerial->status!='For Pickup')
	<a class="btn btn-primary" href="{{URL::to('/messengerial')}}">
		<span class="fa fa-reply"></span> Back
	</a>
	@endif
	@endif

</div>
<br>
<div class="card">
	<div class="card-header card-header-new card-header-dark">
		<h4 align="center">
			<span class="fa fa-users"></span>
			&nbsp;Recipient/s
		</h4>
	</div>

	<div class="card-body">
		<div class="row">
			<div class="col-sm">
				<table>
					<tbody>
						<tr>
							<td style="text-align:right">SUBJECT: &nbsp;</td>
							<td><b>{{$messengerial->subject}}</b></td>
						</tr>
						<tr>
							<td style="text-align:right">CONTROL #:&nbsp;</td>
							<td><b>{{$messengerial->control_num}}</b></td>
						</tr>
						<tr>
							<td style="text-align:right">DATE OF REQUEST:&nbsp;</td>
							<td><b>{{ date('F j, Y g:i A', strtotime($messengerial->created_at)) }}</b></td>
						</tr>
						@if($messengerial->status == "Accomplished")
						<tr>
							<td style="text-align:right">DATE ACCOMPLISHED:&nbsp;</td>
							<td><b>{{ date('F j, Y g:i A', strtotime($messengerial->updated_at)) }}</b></td>
						</tr>
						@endif
						<tr>
							<td style="text-align:right">STATUS:&nbsp;</td>
							<td style="color:blue"><b>{{$messengerial->status}}</b></td>
						</tr>
					</tbody>
				</table>
				<br>
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

					<div class="col-sm">
						@if($messengerial->status=='Filing')
						<button onclick="_add()" class="btn btn-outline-primary float-right">
							<span class="fas fa-user-plus"></span>
							&nbsp;Add Recipient
						</button>
						@endif
					</div>
				</div>

				<div class="row">
					<table class="table-sm table table-bordered table-striped searchTable no-footer" id="tickets_table" align="center" role="grid" aria-describedby="tickets_table_info">
						<thead>
							<tr class="text-center">
								<th width="15%">Recipient</th>
								<th width="15%">Agency</th>
								<th width="10%">Contact #</th>
								<th width="15%">Destination</th>
								<th width="10%">What to Deliver</th>
								<th width="15%">Instruction</th>
								<th width="15%">Due Date</th>
								@if($messengerial->status=='Filing')
								<th width="15%">Action</th>
								@endif


							</tr>
						</thead>
						<tbody>

							@foreach($recipient as $data)

							<tr class="text-center">
								<td>{{$data->recipient}}</td>
								<td>{{$data->agency}}</td>
								<td>{{$data->contact}}</td>
								<td>{{$data->destination}}</td>
								<td>{{$data->delivery_item}}</td>
								<td>{{$data->instruction}}</td>
								<td>
									@if($messengerial->status=='For Pickup' || $messengerial->status=='Out For Delivery')
									<b><span class="text-red">{{ date('F j, Y g:i A', strtotime($data->due_date)) }}</span></b>
									@else
									{{ date('F j, Y g:i A', strtotime($data->due_date)) }}
									@endif
								</td>
								@if($messengerial->status=='Filing')
								<td>
									<button name="edit" id="edit" onclick="_edit('{{$data->id}}')" class="btn btn-sm btn-primary edit">
										<span class="far fa-edit"></span>
									</button>
									<button class="btn btn-danger btn-sm" onclick="_delete('{{$data->id}}','{{$messengerial->id}}','{{$data->recipient}} - {{$data->agency}}')">
										<span class="fa fa-trash"></span>
									</button>
								</td>
								@endif
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>
@if($messengerial->status=='Filing')
<div class="card">
	<div class="card-body">
		<form action="{{URL::to('/messengerial/submit')}}" method="POST">
			@csrf

			<input type="hidden" id="submit_msg_id" name="submit_msg_id" value="{{$messengerial->id}}">
			<center><button type="submit" name="submit_button" id='submit_button' class="btn btn-success">
					<span class="fa fa-check"></span>
					Submit Request
				</button>
			</center>
		</form>
	</div>
</div>
@endif

<!-- Recipient Modal-->
<div class="modal fade" id="recipient_modal" tabindex="-1" aria-labelledby="recipient_modalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header bg-info">
				<h5 class="modal-title" id="recipient_modalLabel">
					<span class="fa fa-user"></span>
					&nbsp;Recipient
				</h5>
			</div>
			<div class="modal-body">
				<form action="{{URL::to('/messengerial/recipient/store')}}" method="POST">
					@csrf
					<div class="row">
						<input type="hidden" value="{{$messengerial->id}}" id="messengerial_id" name="messengerial_id">
						<input type="hidden" id="messengerial_item_id" name="messengerial_item_id">
						<div class="col-sm">
							<div class="row">
								<div class="col-sm">
									<table width="100%">
										<tr>
											<td class="text-right">
												SUBJECT:
											</td>
											<td>&nbsp;</td>
											<td><span id="remarks"></span>
												<b>{{$messengerial->subject}}</b>
											</td>
										</tr>
										<tr>
											<td class="text-right" width="20%">
												REQUEST DATE:
											</td>
											<td>&nbsp;</td>
											<td><span id="r_date"></span>
												<b>{{$messengerial->created_at}}</b>
											</td>
										</tr>
										<tr>
											<td class="text-right">
												CONTROL #:
											</td>
											<td>&nbsp;</td>
											<td>
												<span id="control_num"></span>
												<b> {{$messengerial->control_num}}</b>
											</td>
										</tr>

									</table>
								</div>
							</div>
							<hr>
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
									<span id="btn_submit">Add to List</span>
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
<script src="{{ asset('js/messengerial.js') }}"></script>
<script src="{{ asset('js/table.js') }}"></script>
@endsection