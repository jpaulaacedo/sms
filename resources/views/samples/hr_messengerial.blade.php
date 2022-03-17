@extends('partials._layout')
@section('content')
@section('css')
<style>
	#right {
		border-right-color: grey;
		width: 380px;
		border: 2px solid #FFFFFF;
		border-right-color: #009966;
	}
</style>
@endsection
<form>
	<div class="card">
		<div class="card-header card-header-dark">
			<h5><span class="fa fa-envelope"></span>&nbsp;Vehicle Request</h5>
		</div>
		<div class="card-body">
			<div class="row">
				<!-- 1st col -->
				<div class="col" id="right">
					<div class="row">
						<div class="col">
							<label>Date Requested</label>
							<input class="form-control datetime" id="date" name="date" type="date" />
						</div>
						<div class="col">
							<label>Time</label>
							<input type="time" id="time" class="form-control" rows="5">
						</div>
					</div>

					&nbsp;
					<div class="row">
						<div class="col">
							<label>Purpose of Trip</label>
							<textarea class="form-control" rows="5"></textarea>
						</div>
					</div>

					<div class="row">
						<div class="col">
							<label>Destination</label>
							<textarea class="form-control" rows="5"></textarea>
						</div>
					</div>
				</div>

				<!-- 2nd col -->
				<div class=" col">
					<div class="row">
						<div class="col">
							<label>Date Needed</label>
							<input class="form-control datetime" id="date" name="date" type="date" />
						</div>
						<div class="col">
							<label>Time Needed</label>
							<input type="time" id="time" class="form-control" rows="5">
						</div>

					</div>
					&nbsp;
					<div class="row">
						<div class="col">
							<label>Requested By</label>
							<div class="input-group mb-3">
								<input type="text" class="form-control" aria-describedby="button-addon2">
								<button style="background-color: #009966" class="btn btn-outline-secondary" type="button" id="button-addon2">+</button>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<table style="width:100%">
								<tr style="height:42px">
									<th>Requested List</th>
								</tr>
								<tr class="hidden" style="height:10px">
									<td>Item 1</td>
								</tr>
								<tr class="hidden" style="height:10px">
									<td>Item 2</td>
								</tr>
								<tr class="hidden" style="height:10px">
									<td>Item 3</td>
								</tr>
								<tr class="hidden" style="height:10px">
									<td>Item 2</td>
								</tr>
								<tr class="hidden" style="height:10px">
									<td>Item 3</td>
								</tr>
								<tr class="hidden" style="height:10px">
									<td>Item 2</td>
								</tr>
								<tr class="hidden" style="height:10px">
									<td>Item 3</td>
								</tr>
								<tr class="hidden" style="height:10px">
									<td>Item 3</td>
								</tr>
							</table>
						</div>
					</div>
					&nbsp;
				</div>
			</div>

			<div class="row">
				<div class="col">
					<button type="button" class="btn btn-primary pull-right">Submit</button>
				</div>
			</div>

</form>
@endsection

@section('js')
<script src="{{ asset('js/table.js') }}"></script>
@endsection