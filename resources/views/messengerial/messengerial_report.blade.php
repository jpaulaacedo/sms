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
        <title>PSRTI - VAMRS</title>
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
                <label for=""> <b>MESSENGERIAL REPORT</b></label>
            </div>
            <br>

            <div class="row">
                {{$my_date}}
            </div>
        </center>

        <br>
        <div class="row">
            <table>
                <thead>
                    <div class="row" style="text-align: center">
                        <div class="col">
                            <th width="10%" class="text-center">Date Received</th>
                        </div>
                        <div class="col">
                            <th width="10%" class="text-center">Date Delivered</th>
                        </div>
                        <div class="col">
                            <th width="10%" class="text-center">No. of Days Delivered</th>
                        </div>

                        <th width="12%" class="text-center">Name</th>
                        <th width="10%" class="text-center">Division/ <br> Unit</th>

                        <th width="15%" class="text-center">Name/Type of Document</th>
                        <th width="15%" class="text-center">Agency/Office</th>
                        <th width="15%" class="text-center">Address</th>
                        <th width="15%" class="text-center">Driver</th>
                        <th width="10%" class="text-center">Star Rating</th>
                        <th width="15%" class="text-center">Feedback</th>
                    </div>
                </thead>
                <tbody>
                    @foreach($messengerial as $data)
                    @if($data->status=='Accomplished')

                    <tr class="text-center">
                        <td style="text-align: center" width="10%">{{ date('m-d-y', strtotime($data->approvedcao_date)) }} <br> {{ date('g:i A', strtotime($data->approvedcao_date)) }}</td>
                        <td style="text-align: center" width="10%">{{ date('m-d-y', strtotime($data->accomplished_date)) }} <br> {{ date('g:i A', strtotime($data->accomplished_date)) }}</td>
                        <td style="text-align: center" width="10%">
                            @php
                            $date1 = strtotime($data->accomplished_date);
                            $date2 = strtotime($data->approvedcao_date);
                            $diff = $date1 - $date2;
                            $datediff = round($diff / (60 * 60 * 24));

                            if ($datediff == 0)
                            $datediff = "within the day"
                            @endphp
                            {{$datediff}}
                        </td>
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
                        <td class="text-left">
                            {{App\Messengerial::get_del_item($data->id)}}
                        </td>

                        <td>
                            {{App\Messengerial::get_agency($data->id)}}
                        </td>

                        <td>
                            {{App\Messengerial::get_dest($data->id)}}
                        </td>
                        <td>
                            {{App\Messengerial::get_driver($data->id)}}
                        </td>
                        <td>
                            {{App\Messengerial::get_star($data->id)}}
                        </td>
                        <td>
                            {{App\Messengerial::get_feedback($data->id)}}
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
                        <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Summary of <br>&nbsp;&nbsp;&nbsp;Messengerial Request</small>
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

            <br>

            <div class="row">
                <div class="col-sm">
                    <small> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Average Rating: {{$avg_rating}}</small> 
                </div>
            </div>
        </div>
        </div>
        <script type="text/javascript">
            window.onload = function() {
                window.print();
            }
        </script>