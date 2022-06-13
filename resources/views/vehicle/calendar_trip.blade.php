@extends('partials._layout')

@section('content')
<div>
	@foreach($vehicle as $data)
	<a class="btn btn-primary" href="{{URL::to('/vehicle')}}">
		<span class="fa fa-reply"></span> Back
	</a>
	@endforeach

</div>
<br>	
<div class="card">
	<div class="card-header card-header-vhl">
		<h4 align="center"><span class="fa fa-truck"></span>&nbsp;Vehicle Request</h4>
	</div>
	<div class="card-body">
		<div class="row">
			<div class="col-sm">

				<table>
					<tbody>
						@foreach($vehicle as $data)
						<tr>
							<td style="text-align:right">REQUESTOR: &nbsp;</td>
							<td><b>{{App\User::get_user($data->user_id)}}</b></td>
						</tr>

						@if($data->status == "Out For Delivery" || $data->status == "Accomplished")
						<tr>
							<td style="text-align:right">DRIVER:&nbsp;</td>
							<td><b>{{$data->driver}}</b></td>
						</tr>
						@endif
						@endforeach

					</tbody>
				</table>
				&nbsp;
				<table>
					<tbody>

					</tbody>
				</table>
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
								<th width="10%">Date Requested</th>
								<th width="15%">Purpose of Trip</th>
								<th width="10%">Date and Time Needed</th>
								<th width="15%">Destination</th>
								<th width="10%">Status</th>
								<th width="10%">Passenger/s</th>
							</tr>
						</thead>
						<tbody>

							@foreach($vehicle as $data)
							<tr class="text-center">
								<td>{{ $my_date_req = date('F j, Y g:i A', strtotime($data->created_at)) }}</td>
								<td>{{$data->purpose}}</td>
								<td>{{ $my_date_needed = date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
								<td>{{$data->destination}}</td>
								<td>
									@if($data->status=='Filing')
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "For CAO Approval" || $data->status == "For DC Approval")
									<span class="right badge badge-warning">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "Cancelled")
									<span class="right badge badge-danger">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status=='Approved')
									<span class="right badge badge-info">{{ ucwords(strtoupper($data->status)) }}</span>

									@elseif($data->status == "On The Way")
									<span class="right badge badge-primary">{{ ucwords(strtoupper($data->status)) }}</span>

									@else
									<span class="right badge badge-success">{{ ucwords(strtoupper($data->status)) }}</span>
									@endif
								</td>
								@endforeach

								<td>
									@foreach($passenger as $data)
									• {{$data->passenger}}
									<br>
									@endforeach
								</td>
							</tr>
						</tbody>
					</table>
					</table>
				</div>
			</div>
		</div>
	</div>
</div>


@endsection

@section('js')
<script src="{{ asset('js/vehicle.js') }}"></script>
<script src="{{ asset('js/table.js') }}"></script>
@endsection