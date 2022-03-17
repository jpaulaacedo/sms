@extends('partials._layout')
@section('css')
<style>
#right {
  border-right-color: grey;
  width: 380px; 
    	   		 border: 2px solid #FFFFFF;				
				border-right-color: #009966;
}
	th,
	tr {
		border-color: #009966;
	}
</style>
@endsection

@section('content')

<form>
	<div class="card">
		<div class="card-header card-header-dark">
			<h5><span class="fa fa-envelope"></span>&nbsp;Messengerial | My Requests</h5>
		</div>
		<div class="card-body">
			<div class="row">
				<!-- 1st col -->
				<div id="right" class="col">
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
						<h5>Recipient</h5>
					</div>
					<div class="row">
						<div class="col">
							<label>First Name</label>
							<input type="text" id="lname" class="form-control" rows="5">
						</div>
						<div class="col">
							<label>Last Name</label>
							<input type="text" id="lname" class="form-control" rows="5">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-4">
							<label>Contact Number</label>
							<input type="phone" pattern="[0-9]{12}" name="phone" class="form-control" required />
						</div>
					</div>
					<div class="row">
						<div class="col-sm-8">
							<label>Agency/Office</label>
							<input type="text" name="agency" class="form-control" />
						</div>
					</div>
					&nbsp;
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
							<label>What to Deliver</label>
							<div class="input-group mb-3">
								<input type="text" class="form-control" aria-describedby="button-addon2">
								<button style="background-color:#009966" class="btn btn-outline-secondary" type="button" id="button-addon2">+</button>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col">
							<table style="width:100%">
								<tr style="height:42px">
									<th>Delivery Items</th>
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
					<div class="row">
						<div class="col">
							<label>Remarks/Instruction</label>
							<textarea class="form-control" rows="5"></textarea>
						</div>
					</div>
				</div>
			</div>
			&nbsp;
			<div class="row">
				<div class="col">
					<button type="button" class="btn btn-primary pull-right">Submit</button>
				</div>
			</div>
		</div>
	</div>
</form>
@endsection

@section('js')
<script src="{{ asset('js/table.js') }}"></script>
@endsection