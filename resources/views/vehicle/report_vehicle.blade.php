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
                    &nbsp;Monthly Report
                </h5>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="month_search">Month:</label>
                            </div>
                            <select class="custom-select" id="month_search">
                                <option selected value="" disabled>-- select --</option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-sm">
                        <div class="input-group mb-3">
                            <div class="input-group-prepend">
                                <label class="input-group-text" for="year_search">Year:</label>
                            </div>
                            @php
                            $earliest_year = 2022;
                            $now = date('Y');
                            @endphp
                            <select class="custom-select" id="year_search">
                                <option selected value="" disabled>-- select --</option>
                                @foreach (range(date('Y'), $earliest_year) as $x)
                                <option value="{{ $x }}">{{ $x }}</option>
                                @endforeach
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