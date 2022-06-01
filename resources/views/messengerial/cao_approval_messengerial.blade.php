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
								<th width="20%">Subject</th>
								<th width="10%">Control Number</th>
								<th width="15%">Request Date</th>
								<th width="15%">Requested By</th>
								<th width="10%">Status</th>
								<th width="15%">No. of Recipients</th>
								<th width="15%">Action</th>
							</tr>
						</thead>
						<tbody>

							@foreach($messengerial as $data)
							@if(Auth::user()->user_type == 6 && $data->status=='For CAO Approval' || (App\User::get_division($data->user_id) == "Finance and Administrative Division") && $data->status=='For DC Approval')
							<tr class="text-center">
								<td>{{$data->subject}}</td>
								<td>{{$data->control_num}}</td>
								<td>{{$data->created_at}}</td>
								<td>{{App\User::get_user($data->user_id)}}</td>
								<td>
									<span class="right badge badge-warning">{{ ucwords(strtoupper($data->status)) }}</span>
								</td>
								<td>{{$data->count_rec}}</td>
								<td>
									<a href="{{URL::to('/messengerial/recipient')}}/{{$data->id}}" class="btn btn-info btn-sm">
										<span class="fa fa-users"></span>
										recipient
									</a> |

									<button type="submit" onclick="_approveCAO('{{$data->id}}')" class="btn btn-success btn-sm">
										<span class="fa fa-thumbs-up"></span>
										approve
									</button>
									<a href="{{URL::to('/messengerial_form')}}/{{$data->id}}" target="_blank" class="btn btn-secondary btn-sm"><span class="fa fa-print"></span></a>
								</td>
							</tr>
							@endif

							@if(Auth::user()->user_type == 6 && $data->status=='For Pickup' || (App\User::get_division($data->user_id) == "Finance and Administrative Division") && $data->status=='For Pickup')
							<tr class="text-center">
								<td>{{$data->subject}}</td>
								<td>{{$data->control_num}}</td>
								<td>{{$data->created_at}}</td>
								<td>{{App\User::get_user($data->user_id)}}</td>
								<td>
									<span class="right badge badge-warning">APPROVED</span>
								</td>
								<td>{{$data->count_rec}}</td>
								<td>
									<a href="{{URL::to('/messengerial/recipient')}}/{{$data->id}}" class="btn btn-info btn-sm">
										<span class="fa fa-users"></span>
										recipient
									</a> |


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

@endsection

@section('js')
<script src="{{ asset('js/messengerial.js') }}"></script>
<script src="{{ asset('js/table.js') }}"></script>
@endsection