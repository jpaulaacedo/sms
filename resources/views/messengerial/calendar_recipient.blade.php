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
	<a class="btn btn-primary" href="{{URL::to('/home')}}">
		<span class="fa fa-reply"></span> Back
	</a>
</div>
<br>
<div class="card">
	<div class="card-header card-header-new card-header-dark">
		<h4 align="center">
			<span class="fa fa-envelope"></span>
			&nbsp;Messengerial Request
		</h4>
	</div>

	<div class="card-body">
		<div class="row">
			<div class="col-sm">
				<table>
					<tbody>

						<tr>
							<td style="text-align:right">CONTROL #:&nbsp;</td>
							<td><b>{{$messengerial->control_num}}</b></td>
						</tr>
						@if($messengerial->status != "Filing" || $messengerial->status != "For DC Approval")
						<tr>
							<td style="text-align:right">DRIVER:&nbsp;</td>
							<td><b>{{$messengerial->driver}}</b></td>
						</tr>
						@endif

						<tr>
							<td style="text-align:right">TIME DEPARTURE:&nbsp;</td>
							<td style="text-align:right"><b>{{ date('F j, Y g:i A', strtotime($messengerial->outfordel_date)) }}</b></td>
						</tr>
						@if($messengerial->status == "Accomplished")
						<tr>
							<td style="text-align:right">ACCOMPLISHED DATE:&nbsp;</td>
							<td><b>{{ date('F j, Y g:i A', strtotime($messengerial->accomplished_date)) }}</b></td>
						</tr>
						@endif

						<tr>
							<td style="text-align:right">STATUS:&nbsp;</td>
							<td>
								@if($data->urgency == "urgent")
								<span class="right badge badge-warning">{{ ucwords(strtoupper($data->urgency)) }}!</span> <br>
								@endif
								
								@if($messengerial->status=='Filing')
								<span class="right badge badge-primary">{{ ucwords(strtoupper($messengerial->status)) }}</span>

								@elseif($messengerial->status == "For CAO Approval" || $messengerial->status == "For DC Approval")
								<span class="right badge badge-warning">{{ ucwords(strtoupper($messengerial->status)) }}</span>

								@elseif($messengerial->status == "Cancelled")
								<span class="right badge badge-danger">{{ ucwords(strtoupper($messengerial->status)) }}</span>

								@elseif($messengerial->status=='Confirmed')
								<span class="right badge badge-success">{{ ucwords(strtoupper($messengerial->status)) }}</span>

								@elseif($messengerial->status == "Out For Delivery")
								<span class="right badge badge-primary">{{ ucwords(strtoupper($messengerial->status)) }}</span>

								@elseif($messengerial->status == "For Assignment")
								<span class="right badge badge-info">{{ ucwords(strtoupper($messengerial->status)) }}</span>

								@elseif($messengerial->status=='Accomplished')
								<span class="right badge badge-success">{{ ucwords(strtoupper($messengerial->status)) }}</span>
								@endif
							</td>
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
				</div>

				<div class="row">
					<table class="table-sm table table-bordered table-striped searchTable no-footer" id="tickets_table" align="center" role="grid" aria-describedby="tickets_table_info">
						<thead>
							<tr class="text-center">
								<th width="10%">Requestor</th>
								<th width="10%">Date Requested</th>
								<th width="15%">Recipient</th>
								<th width="10%">Agency</th>
								<th width="10%">Contact #</th>
								<th width="15%">Destination</th>
								<th width="10%">What to Deliver</th>
								<th width="10%">Instruction</th>
								<th width="10%">Date Needed</th>
							</tr>
						</thead>
						<tbody>

							<tr class="text-center">
								<td>{{App\User::get_user($messengerial->user_id)}}</td>
								<td>
									{{ date('F j, Y', strtotime($messengerial->created_at)) }}
									<br>
									{{ date('g:i A', strtotime($messengerial->created_at)) }}
								</td>
								<td>{{$messengerial->recipient}}</td>
								<td>{{$messengerial->agency}}</td>
								<td>{{$messengerial->contact}}</td>
								<td>{{$messengerial->destination}}</td>
								<td>{{$messengerial->delivery_item}}</td>
								<td>{{$messengerial->instruction}}</td>
								<td>
									{{ date('F j, Y', strtotime($messengerial->date_needed)) }}
									<br>
									{{ date('g:i A', strtotime($messengerial->date_needed)) }}
								</td>
							</tr>
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