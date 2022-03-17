@extends('partials._layout')
@section('content')

<form>
	<div class="card">
		<div class="card-header card-header-dark">
			<h5><span class="fa fa-envelope"></span>&nbsp;To Approve</h5>
		</div>
		<div class="card-body">
			<div class="row">
				<table class="table table-bordered table-striped dataTable no-footer" id="tickets_table" align="center" role="grid" aria-describedby="tickets_table_info">
					<thead>
						<tr bgcolor="#084596" class="text-white" role="row">
							<th width="10%" class="sorting_disabled" rowspan="1" colspan="1">Date Requested</th>
							<th width="20%" class="sorting_disabled" rowspan="1" colspan="1">Request Type</th>
							<th width="20%" class="sorting_disabled" rowspan="1" colspan="1">What to Deliver/Purpose of Trip</th>
							<th width="20%" class="sorting_disabled" rowspan="1" colspan="1">Requested By</th>
							<th width="20%" class="sorting_disabled" rowspan="1" colspan="1">Recipient</th>
							<th width="20%" class="sorting_disabled" rowspan="1" colspan="1">Status</th>
							<th width="20%" class="sorting_disabled" rowspan="1" colspan="1">Action</th>



						</tr>
					</thead>
					<tbody>
						<tr role="row" class="odd">
							<td>2022-03-14 11:21:02</td>
							<td>Messengerial</td>
							<td>
								<a href="http://192.168.137.5/ticketing/agent/view/243">Landbank Check</a>

								<i class="fas fa-paperclip"></i>

							</td>
							<td>Paula Acedo</td>
							<td>LBP</td>
							<td>
								<span class="right badge badge-warning">
									For Approval
								</span>
							</td>
							<td> <button type="button" class="btn btn-primary pull-right">Approve</button>
							</td>
						</tr>

					</tbody>
				</table>


			</div>
		</div>
	</div>
</form>
@endsection

@section('js')
<script src="{{ asset('js/table.js') }}"></script>
@endsection