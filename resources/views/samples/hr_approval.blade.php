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
						</tr>
					</thead>
					<tbody>
						<tr role="row" class="odd">
							<td>2022-03-14 11:21:02</td>
							<td>Web/Social Media Update Request</td>
							<td>
								<a href="http://192.168.137.5/ticketing/agent/view/243">Posting of Social Media Cards on the PSRTI Social Media sites.</a>

								<i class="fas fa-paperclip"></i>

							</td>
							<td>Junelle Barcena</td>
							<td>Stephen Randolph Trinidad</td>
							<td>
								<span class="right badge badge-warning">
									APPROVED BY DC
								</span>
							</td>
							<td>2022-03-17 11:21:02</td>
						</tr>
						<tr role="row" class="even">
							<td>2022-03-11 16:26:57</td>
							<td>Web/Social Media Update Request</td>
							<td>
								<a href="http://192.168.137.5/ticketing/agent/view/242">Web Posting for CBA for MIAA</a>

								<i class="fas fa-paperclip"></i>

							</td>
							<td>Junelle Barcena</td>
							<td>Denver Pasiliao</td>
							<td>
								<span class="right badge badge-warning">
									APPROVED BY DC
								</span>
							</td>
							<td>2022-03-16 16:26:57</td>
						</tr>
						<tr role="row" class="odd">
							<td>2022-03-11 10:25:57</td>
							<td>IT Job Request / Others</td>
							<td>
								<a href="http://192.168.137.5/ticketing/agent/view/237">PC SET UP</a>


							</td>
							<td>Danilo Loayon</td>
							<td>Janine Nozares</td>
							<td>
								<span class="right badge badge-success">
									ACCOMPLISHED
								</span>
							</td>
							<td>2022-03-16 10:25:57</td>
						</tr>
						<tr role="row" class="even">
							<td>2022-03-09 09:42:42</td>
							<td>IT Job Request / Application Installation</td>
							<td>
								<a href="http://192.168.137.5/ticketing/agent/view/236">Software Installation</a>


							</td>
							<td>Danilo Loayon</td>
							<td>Wilma Dumantay</td>
							<td>
								<span class="right badge badge-success">
									ACCOMPLISHED
								</span>
							</td>
							<td>2022-03-14 09:42:42</td>
						</tr>
						<tr role="row" class="odd">
							<td>2022-03-09 09:42:51</td>
							<td>IT Job Request / Application Installation</td>
							<td>
								<a href="http://192.168.137.5/ticketing/agent/view/235">Printer Troubleshooting</a>


							</td>
							<td>Danilo Loayon</td>
							<td>Wilma Dumantay</td>
							<td>
								<span class="right badge badge-success">
									ACCOMPLISHED
								</span>
							</td>
							<td>2022-03-14 09:42:51</td>
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