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
	<a class="btn btn-primary" href="{{URL::to('/messengerial')}}">
		<span class="fa fa-reply"></span> Back to Messengerial
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
							<td style="text-align:right">REQUESTOR: &nbsp;</td>
							<td><b>{{App\User::get_user($messengerial->user_id)}}</b></td>
						</tr>
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
						@if($messengerial->status == "Out For Delivery" || $messengerial->status == "Accomplished")
						<tr>
							<td style="text-align:right">DRIVER:&nbsp;</td>
							<td><b>{{$messengerial->driver}}</b></td>
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
								<th width="10%">Due Date</th>
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
									<b><span class="text-red">{{ date('F j, Y', strtotime($data->due_date)) }}</span></b>
									<br>
									<b><span class="text-red">{{ date('g:i A', strtotime($data->due_date)) }}</span></b>
									@else
									{{ date('F j, Y', strtotime($data->due_date)) }}
									<br>
									{{ date('g:i A', strtotime($data->due_date)) }}
									@endif
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


@endsection

@section('js')
<script src="{{ asset('js/messengerial.js') }}"></script>
<script src="{{ asset('js/table.js') }}"></script>
@endsection