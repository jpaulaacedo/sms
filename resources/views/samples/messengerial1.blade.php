@extends('partials._layout')

@section('content')
<form>
	<div class="card">
		<div class="card-header card-header-dark">
			<h5><span class="fa fa-envelope"></span>&nbsp;Messengerial Request</h5>
		</div>
		<div class="card-body">
			<div class="col">

				<div class="row">
					<div class="col-3">
						<label>Date Requested</label>
						<input class="form-control datetime" id="date" name="date" type="text" />
						<!-- <div class="input-group date" id="my_datetime" data-target-input="nearest">
							<input type="text" class="form-control datetimepicker-input" data-target="#my_datetime">
							<div class="input-group-append" data-target="#my_datetime" data-toggle="datetimepicker">
								<div class="input-group-text">
									<i class="fa fa-calendar"></i>
								</div>
							</div>
						</div> -->
					</div>

					<div class="col-2">
						<label>Time</label>
						<input type="time" id="time" class="form-control" rows="5">
					</div>
				</div>

				&nbsp;

				<div class="col>
						<div class="row">
					<div class="card-header card-header-dark">
						<h5><span class="fa fa-envelope"></span>&nbsp;Recipient Portion</h5>
					</div>
				</div>
				&nbsp;

				<div class="row">
					<div class="col-sm-3">
						<label>First Name</label>
						<input type="text" id="fname" class="form-control" required>
					</div>

					<div class="col-sm-3">
						<label>Last Name</label>
						<input type="text" id="lname" class="form-control" required>
					</div>

					<div class="col-sm-3">
						<label>Contact Number</label>
						<input maxlength="10" id="phone"type="tel" name="phone"required />
					</div>

					<div class="col-sm-3">
						<label>Agency/Office</label>
						<input type="text" name="agency" class="form-control" required />
					</div>
				</div>

				&nbsp;
				<div class="col-sm-6">
						<label>What to Deliver</label>
						<div class="input-group mb-3">
							<input type="text" class="form-control" aria-describedby="button-addon2">
							<button class="btn btn-outline-secondary" type="button" id="button-addon2">Button</button>
						</div>
					</div>

				<div class="row">
					<div class="col-sm-3">
						<label>Destination</label>
						<input type="text" id="fname" class="form-control" required>
					</div>

				
					&nbsp;
					<div class="col-sm-12">
						<label>Instruction</label>
						<textarea class="form-control" rows="3" placeholder="Enter instruction here..." required></textarea>
					</div>
				</div>
				&nbsp;
			</div>

			<div class="col-sm-2">
				<button type="button" class="btn btn-block btn-success">SAVE</button>
			</div>
		</div>


	</div>
	</div>


</form>
@endsection

@section('js')
<script src="{{ asset('js/table.js') }}"></script>
@endsection