@extends('partials._layout')
@section('content')
<div class="card">
    <div class="card-header card-header-vhl">
        <h4 align="center"><span class="fa fa-truck"></span>&nbsp;Vehicle Report</h4>
    </div>
    <div class="card-body">
        <div class="row">

            <div class="col-sm-4">
                <div class="input-group mb-6">
                    <span class="input-group-text" id="basic-addon3">
                        <span class="fa fa-search">&nbsp;</span>
                        Search
                    </span>
                    <input type="text" placeholder="Type here..." class="form-control text_search" id="basic-url" aria-describedby="basic-addon3">
                </div>
            </div>
            <div class="col-sm">
                <button class="btn btn-secondary float-right" data-dismiss="modal" data-toggle="modal" data-target="#monthly_report_modal"><span class="fa fa-print"></span> Print Report</button>
            </div>
        </div>

        <br>
        <div class="row">
            <div class="col-sm">
                <table class="table table-sm table-bordered table-striped report ">
                    <thead>
                        <div class="row">
                            <th width="15%" class="text-center">Date Received</th>
                            <th width="15%" class="text-center">Date Needed</th>
                            <th width="15%" class="text-center">Date Accomplished</th>
                            <th width="10%" class="text-center">Requestor</th>
                            <th width="10%" class="text-center">Division/Unit</th>
                            <th width="10%" class="text-center">Destination</th>
                            <th width="15%" class="text-center">Purpose</th>
                            <th width="10%" class="text-center">Passengers</th>
                            <th width="15%" class="text-center">Driver</th>

                            <th width="10%" class="text-center">Rating</th>
                            <th width="15%" class="text-center">Feedback</th>
                        </div>
                    </thead>
                    <tbody>
                        @foreach($vehicle as $data)
                        @if($data->status=='Accomplished')

                        <tr class="text-center">
                            <td width="10%">{{ date('F j, Y g:i A', strtotime($data->approvedcao_date)) }}</td>
                            <td width="10%">{{ date('F j, Y g:i A', strtotime($data->date_needed)) }}</td>
                            <td width="10%">{{ date('F j, Y g:i A', strtotime($data->accomplished_date)) }}</td>
                            <td width="12%">{{App\User::get_user($data->user_id)}}</td>
                            <td width="13%">
                                @php
                                $division = App\User::get_division($data->user_id);
                                if ($division == "Finance and Administrative Division")
                                $division = "FAD";
                                elseif ($division == "Knowledge Management Division")
                                $division = "KMD";
                                elseif ($division == "Training Division")
                                $division = "TD";
                                elseif ($division == "Research Division")
                                $division = "RD";
                                elseif($division == "Office of the Executive Director")
                                $division = "OED";
                                @endphp
                                {{$division}}
                            <td width="15%">{{$data->destination}}</td>

                            <td width="15%">{{$data->purpose}}</td>

                            <td width="15%" class="text-left">
                                @foreach(App\VehiclePassenger::get_passenger($data->id) as $rec)

                                • {{$rec->passenger}}
                                <br>
                                @endforeach
                            </td>
                            <td>
                                {{App\Vehicle::get_driver($data->id)}}
                            </td>
                            <td>
                                {{App\Vehicle::get_star($data->id)}}
                            </td>
                            <td>
                                {{App\Vehicle::get_feedback($data->id)}}
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

<div class="modal fade" id="monthly_report_modal" tabindex="-1" aria-labelledby="recipient_modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info">
                <h5 class="modal-title" id="recipient_modalLabel">
                    <span class="fa fa-calendar"></span>
                    &nbsp;Vehicle Report
                </h5>
            </div>
            <div class="modal-body">
                <label for="">Filter By Date:<span class="text-red">*</span></label>
                <div class="row">
                    <div class="col-sm">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="start_date">Start Date:</label>
                            </div>
                            <input type="date" class="form-control" name="start_date" id="start_date">
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="end_date">End Date:</label>
                            </div>
                            <input type="date" class="form-control" name="end_date" id="end_date">
                        </div>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-sm-5">
                        <label for="">Filter By Driver: <small>(optional)</small></label>
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="report_driver">Driver:</label>
                            </div>
                            <select class="custom-select" id="report_driver">
                                <option selected value="All">-- all --</option>
                                <option value="Elmo">Elmo</option>
                                <option value="Ruben">Ruben</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal" data-toggle="modal" data-target="#monthly_report_modal">
                    Close
                </button>
                <button class="btn btn-success" onclick="generate_report()"><span class="fa fa-print"></span> Generate</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('js')
<script src="{{ asset('js/table.js') }}"></script>
<script src="{{ asset('js/vehicle.js') }}"></script>
<script>

</script>
@endsection