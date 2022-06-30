@extends('partials._layout')
@section('content')


<div class="card">
	<div class="card-header card-header-new card-header-dark">
		<h4 align="center"><span class="fa fa-envelope"></span>&nbsp;For My Approval</h4>
	</div>
	<div class="card-body">
		<div class="row">
			<!-- 1st col -->
			<div class="col-sm">
				&nbsp;
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

				</div>

				<div class="row">
					<table class="table-sm table table-bordered table-striped searchTable no-footer" id="tickets_table" align="center" role="grid" aria-describedby="tickets_table_info">
						<thead>
							<tr class="text-center">
								<th width="15%">Recipient</th>
								<th width="10%">Control Number</th>
								<th width="15%">Requested By</th>
								<th width="10%">Request Date</th>
								<th width="15%">Destination</th>
								<th width="10%">Date Needed</th>
								<th width="15%">Status</th>
								<th width="20%">Action</th>
							</tr>
						</thead>
						<tbody>

							@foreach($messengerial as $data)

							@if((Auth::user()->user_type == 2 && $data->status=='For DC Approval') && (App\User::get_division($data->user_id) == Auth::user()->division) && App\User::get_user($data->user_id) != Auth::user()->name)
							<tr class="text-center">
								<td>{{$data->recipient}}</td>
								<td>{{$data->control_num}}</td>
								<td>{{App\User::get_user($data->user_id)}}</td>
								<td>{{ date('F j, Y', strtotime($data->created_at)) }} <br> {{ date('g:i A', strtotime($data->created_at)) }}</td>
								<td>{{$data->destination}}</td>
								<td>{{ date('F j, Y', strtotime($data->date_needed)) }} <br> {{ date('g:i A', strtotime($data->date_needed)) }}</td>
								<td>
									<span class="right badge badge-warning">{{ ucwords(strtoupper($data->status)) }}</span>
								</td>
								<td>
									<button name="view" id="view" onclick="_viewMessengerial('{{$data->id}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button> |
									<button type="submit" onclick="_approveDC('{{$data->id}}')" class="btn btn-success btn-sm">
										<span class="fa fa-thumbs-up"></span>
									</button>
									<a href="{{URL::to('/messengerial_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>

								</td>
							</tr>
							@endif
							@endforeach
							@foreach($messengerial as $data)
							@if($data->status=='For Assignment' && (App\User::get_division($data->user_id) == Auth::user()->division) && App\User::get_user($data->user_id) != Auth::user()->name)
							<tr class="text-center">
								<td>{{$data->recipient}}</td>
								<td>{{$data->control_num}}</td>
								<td>{{App\User::get_user($data->user_id)}}</td>
								<td>{{ date('F j, Y', strtotime($data->created_at)) }} <br> {{ date('g:i A', strtotime($data->created_at)) }}</td>
								<td>{{$data->destination}}</td>
								<td>{{ date('F j, Y', strtotime($data->date_needed)) }} <br> {{ date('g:i A', strtotime($data->date_needed)) }}</td>
								<td>
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>
								</td>
								<td>
									<button name="view" id="view" onclick="_viewMessengerial('{{$data->id}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button>|
									<a href="{{URL::to('/messengerial_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>

								</td>
							</tr>
							@endif
							@endforeach
							@foreach($messengerial as $data)
							@if($data->status=='For CAO Approval' && (App\User::get_division($data->user_id) == Auth::user()->division) && App\User::get_user($data->user_id) != Auth::user()->name)
							<tr class="text-center">
								<td>{{$data->recipient}}</td>
								<td>{{$data->control_num}}</td>
								<td>{{App\User::get_user($data->user_id)}}</td>
								<td>{{ date('F j, Y', strtotime($data->created_at)) }} <br> {{ date('g:i A', strtotime($data->created_at)) }}</td>
								<td>{{$data->destination}}</td>
								<td>{{ date('F j, Y', strtotime($data->date_needed)) }} <br> {{ date('g:i A', strtotime($data->date_needed)) }}</td>
								<td>
									<span class="right badge badge-warning">{{ ucwords(strtoupper($data->status)) }}</span>
								</td>
								<td>
									<button name="view" id="view" onclick="_viewMessengerial('{{$data->id}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button>|
									<a href="{{URL::to('/messengerial_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>

								</td>
							</tr>
							@endif
							@endforeach
							@foreach($messengerial as $data)
							@if($data->status=='Confirmed' && (App\User::get_division($data->user_id) == Auth::user()->division) && App\User::get_user($data->user_id) != Auth::user()->name)
							<tr class="text-center">
								<td>{{$data->recipient}}</td>
								<td>{{$data->control_num}}</td>
								<td>{{App\User::get_user($data->user_id)}}</td>
								<td>{{ date('F j, Y', strtotime($data->created_at)) }} <br> {{ date('g:i A', strtotime($data->created_at)) }}</td>
								<td>{{$data->destination}}</td>
								<td>{{ date('F j, Y', strtotime($data->date_needed)) }} <br> {{ date('g:i A', strtotime($data->date_needed)) }}</td>
								<td>
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
								</td>
								<td>
									<button name="view" id="view" onclick="_viewMessengerial('{{$data->id}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button>|
									<a href="{{URL::to('/messengerial_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>

								</td>
							</tr>
							@endif
							@endforeach
							@foreach($messengerial as $data)
							@if($data->status=='Cancelled' && (App\User::get_division($data->user_id) == Auth::user()->division) && App\User::get_user($data->user_id) != Auth::user()->name)
							<tr class="text-center">
								<td>{{$data->recipient}}</td>
								<td>{{$data->control_num}}</td>
								<td>{{App\User::get_user($data->user_id)}}</td>
								<td>{{ date('F j, Y', strtotime($data->created_at)) }} <br> {{ date('g:i A', strtotime($data->created_at)) }}</td>
								<td>{{$data->destination}}</td>
								<td>{{ date('F j, Y', strtotime($data->date_needed)) }} <br> {{ date('g:i A', strtotime($data->date_needed)) }}</td>
								<td>
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->status)) }}</span>
								</td>
								<td>
									<button name="view" id="view" onclick="_viewMessengerial('{{$data->id}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button>|
									<a href="{{URL::to('/messengerial_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>

								</td>
							</tr>
							@endif
							@endforeach
							@foreach($messengerial as $data)
							@if($data->status=='Out For Delivery' && (App\User::get_division($data->user_id) == Auth::user()->division) && App\User::get_user($data->user_id) != Auth::user()->name)
							<tr class="text-center">
								<td>{{$data->recipient}}</td>
								<td>{{$data->control_num}}</td>
								<td>{{App\User::get_user($data->user_id)}}</td>
								<td>{{ date('F j, Y', strtotime($data->created_at)) }} <br> {{ date('g:i A', strtotime($data->created_at)) }}</td>
								<td>{{$data->destination}}</td>
								<td>{{ date('F j, Y', strtotime($data->date_needed)) }} <br> {{ date('g:i A', strtotime($data->date_needed)) }}</td>
								<td>
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>
								</td>
								<td>
									<button name="view" id="view" onclick="_viewMessengerial('{{$data->id}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button>|
									<a href="{{URL::to('/messengerial_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>

								</td>
							</tr>
							@endif
							@endforeach
							@foreach($messengerial as $data)
							@if($data->status=='Accomplished' && (App\User::get_division($data->user_id) == Auth::user()->division) && App\User::get_user($data->user_id) != Auth::user()->name)
							<tr class="text-center">
								<td>{{$data->recipient}}</td>
								<td>{{$data->control_num}}</td>
								<td>{{App\User::get_user($data->user_id)}}</td>
								<td>{{ date('F j, Y', strtotime($data->created_at)) }} <br> {{ date('g:i A', strtotime($data->created_at)) }}</td>
								<td>{{$data->destination}}</td>
								<td>{{ date('F j, Y', strtotime($data->date_needed)) }} <br> {{ date('g:i A', strtotime($data->date_needed)) }}</td>
								<td>
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
								</td>
								<td>
									<button name="view" id="view" onclick="_viewMessengerial('{{$data->id}}')" class="btn btn-sm btn-info">
										<span class="fa fa-users"></span>
									</button>|
									<a href="{{URL::to('/messengerial_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>

								</td>
							</tr>
							@endif
							@endforeach
						</tbody>
					</table>
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

@endsection

@section('js')
<script src="{{ asset('js/messengerial.js') }}"></script>
<script src="{{ asset('js/table.js') }}"></script>
@endsection