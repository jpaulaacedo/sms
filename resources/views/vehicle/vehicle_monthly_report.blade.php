<!DOCTYPE html>
<html>
<style>
    @page {

        size: A4;
    }

    #header {
        max-height: 75px;
        max-width: 40x;
        text-align: center;
    }

    #header_logo {
        max-height: 75px;
        max-width: 40x;
        text-align: center;
    }

    #report_iso {
        max-height: 75px;
        max-width: 40x;
        text-align: center;
    }

    table,
    td,
    th {
        border: 1px solid black;
        font-size: small;
        font-family: "Helvetica";
    }

    table {
        border-collapse: collapse;
        max-width: 100%;
    }

    th,
    td {
        padding: 8px;
    }

    td,
    th,
    tr {
        max-height: 15px;
    }
</style>


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PSRTI - vamrs</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
    <div class="row">
        <div id="header" class="row">
            <img src="{{asset('images/header.jpg')}}" alt="PSRTI Header" id="header_logo">
            <img src="{{asset('images/report_iso.png')}}" alt="PSRTI ISO" id="report_iso">
        </div>
    </div>
    <br><br>
    <center>
        <div>
            <label for=""> <b>MONTHLY REPORT ON VEHICLE REQUEST</b></label>
        </div>
        <div class="row">
            {{$my_date}}

        </div>
    </center>


    <div class="row">
        <table>

            <thead>
                <th width="10%" class="text-center">Date Received</th>
                <th width="15%" class="text-center">Date Needed</th>
                <th width="10%" class="text-center">Date Accomplished</th>
                <th width="12%" class="text-center">Name</th>
                <th width="10%" class="text-center">Division/ <br> Unit</th>
                <th width="15%" class="text-center">Destination</th>
                <th width="15%" class="text-center">Purpose</th>
                <th width="15%" class="text-center">Passenger</th>
    </div>
    </thead>
    <tbody>
        @foreach($vehicle as $data)
        @if($data->status=='Accomplished')

        <tr class="text-center">
            <td style="text-align: center" width="10%">{{ date('m-d-y', strtotime($data->approvedcao_date)) }} <br> {{ date('g:i A', strtotime($data->approvedcao_date)) }}</td>
            <td style="text-align: center" width="15%">{{ date('m-d-y', strtotime($data->date_needed)) }} <br> {{ date('g:i A', strtotime($data->date_needed)) }}</td>
            <td style="text-align: center" width="10%">{{ date('m-d-y', strtotime($data->returned_date)) }} <br> {{ date('g:i A', strtotime($data->returned_date)) }}</td>
            <td style="text-align: center" width="12%">{{App\User::get_user($data->user_id)}}</td>
            <td style="text-align: center" width="10%">
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
            </td>
            <td width="15%" class="text-left">
                {{$data->destination}}
            </td>

            <td width="15%" class="text-left">
                {{$data->purpose}}
            </td>

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
    <br>
    <div class="row">
        <div class="col-sm">
            <div class="row">
                <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Summary of <br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Vehicle Request</small>
            </div>
            <div class="row">
                <table>
                    <thead>
                        <th>Division</th>
                        <th>No. of <br>Request</th>
                    </thead>
                    <tbody>


                        <tr>
                            <td>KMD</td>
                            <td>{{$kmd_count}}</td>
                        </tr>
                        <tr>
                            <td>OED</td>
                            <td>{{$oed_count}}</td>
                        </tr>
                        <tr>
                            <td>FAD</td>
                            <td>{{$fad_count}}</td>
                        </tr>
                        <tr>
                            <td>RD</td>
                            <td>{{$rd_count}}</td>
                        </tr>
                        <tr>
                            <td>TD</td>
                            <td>{{$td_count}}</td>
                        </tr>

                    </tbody>

                </table>
            </div>
        </div>
    </div>
    </div>
    <script type="text/javascript">
        window.onload = function() {
            window.print();
        }
    </script>