<!DOCTYPE html>
<html>
@section('css')
<style>
    @page {

        size: A4;
    }

    #header {
        max-height: 75px;
        max-width: 40x;
        text-align: center;


    }

    @media print {
        footer {
            page-break-after: always;
        }



    }

    p {
        font-size: 11px;
    }

    small {
        font-size: smaller;
    }

    #footer {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        text-align: center;
    }

    #header_logo {
        max-height: 75px;
        max-width: 40x;
        text-align: center;
    }

    #header_iso_fad {
        max-height: 75px;
        max-width: 40x;
        text-align: center;
    }

    #col1 {
        max-width: 400px;
        min-width: 400px;
        min-height: 5px;
        max-height: 5px;
        text-align: left;
    }

    #col2 {
        max-width: 400px;
        min-width: 400px;
        max-height: 5px;
        min-height: 5px;
        text-align: left;
    }

    #col3 {
        max-width: 500px;
        min-width: 500px;
        max-height: 5px;
        min-height: 5px;
        text-align: left;
    }

    #col4 {
        max-width: 500px;
        min-width: 500px;
        min-height: 5px;
        max-height: 5px;
        text-align: left;
    }

    #col5 {
        max-width: 350px;
        min-width: 350px;
        min-height: 5px;
        max-height: 5px;
        text-align: left;
    }

    #row1 {
        max-width: 170px;
        min-width: 170px;
        max-height: 8px;
        min-height: 8px;
        text-align: left;
    }

    #row2 {
        max-width: 230px;
        min-width: 230px;
        max-height: 8px;
        min-height: 8px;
        text-align: left;
    }

    #row3 {
        max-width: 230px;
        min-width: 230px;
        max-height: 8px;
        min-height: 8px;
        text-align: left;
    }

    #instruction {
        text-align: left;
        max-width: 60x;
        min-width: 60x;
        min-height: 20px;
        max-height: 20px;
    }

    #dc_signature {
        max-width: 75x;
        min-width: 75x;
        min-height: 35px;
        max-height: 35px;
        text-align: center;
    }

    #dc_td_signature {
        max-width: 75x;
        min-width: 75x;
        min-height: 34px;
        max-height: 34px;
        text-align: center;
    }

    #dc_fad_signature {
        max-width: 100x;
        min-width: 100x;
        min-height: 34px;
        max-height: 34px;
        text-align: center;
    }

    #dc_oed_signature {
        max-width: 120x;
        min-width: 120x;
        min-height: 34px;
        max-height: 34px;
        text-align: center;
    }

    #dc_kmd_signature {
        max-width: 80x;
        min-width: 80x;
        min-height: 34px;
        max-height: 34px;
        text-align: center;
    }

    #dc_rd_signature {
        max-width: 70x;
        min-width: 70x;
        min-height: 34px;
        max-height: 34px;
        text-align: center;
    }

    #CAO_signature {
        max-height: 70px;
        min-height: 70px;
        min-width: 230x;
        max-width: 230x;
    }

    #received_by {
        min-height: 10px;
        text-align: center;
    }

    #noted_by {
        text-align: right;
        font-family: "Helvetica";
    }

    #return {
        text-align: left;
        border: 0px;
    }



    #tbl1 {
        border: .5px solid black;
        font-family: "Helvetica";
        float: center;
    }

    #recipient_header {
        text-align: center;
    }

    #tbl2,
    #td2 {
        border-collapse: collapse;
        max-width: 100%;
        border-left: .5px solid black;
        border-right: .5px solid black;
        text-align: center;
        font-family: "Helvetica";

    }

    #tbl3,
    #td3 {
        border-collapse: collapse;
        max-width: 100%;
        font-family: "Helvetica";
        border: .5px solid black;
    }

    #tbl4,
    #td4 {
        border-collapse: collapse;
        max-width: 100%;
        border: 1px solid black;
        font-family: "Helvetica";
    }

    #tbl5,
    #td5 {
        border-collapse: collapse;
        max-width: 100%;
        border: 1px solid black;
        font-family: "Helvetica";
    }

    #tbl6 {

        font-family: "Helvetica";
    }

    th,
    td {
        padding: 8px;
    }

    #td2 {
        max-width: 263px;
        min-width: 263px;
        max-height: 5px;
        min-height: 5px;
        text-align: left;
    }

    #th3 {
        border: .5px solid black;
        max-width: 193px;
        min-width: 193px;
        max-height: 5px;
        min-height: 5px;
        text-align: center;
    }

    #td3 {
        max-width: 193px;
        min-width: 193px;
        max-height: 10px;
        min-height: 10px;
        text-align: left;
    }

    #td4 {
        max-width: 193px;
        min-width: 193px;
        max-height: 10px;
        min-height: 10px;
        text-align: left;
    }

    #td5 {
        max-width: 260px;
        min-width: 260px;
        max-height: 10px;
        min-height: 10px;
        text-align: left;
    }

    /* td,
    th,
    tr {
        max-height: 5px;
        max-width: 200px;
        text-align: left;
    } */
</style>


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>PSRTI - vamrs</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<small>
    <!-- page1 -->
    @if(count($passenger) <= 10) <body>
        <div class="row">
            <div id="header" class="row">
                <img src="{{asset('images/header.jpg')}}" alt="PSRTI Header" id="header_logo">
                <img src="{{asset('images/iso-fad.png')}}" alt="PSRTI ISO" id="header_iso_fad">
            </div>
        </div>

        <center>
            <div>
                <h3>VEHICLE REQUEST FORM</h3>
            </div>
        </center>
        <center>
            <table id="tbl1">
                <tr>
                    <td id="col1"></td>
                    <td><label><b>Date Needed&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b></label>
                        <u>{{ date('F j, Y', strtotime($vehicle->date_needed)) }}&nbsp;&nbsp;&nbsp;&nbsp;</u>
                    </td>
                </tr>
                <br>
                <tr>
                    <td id="col1">
                        <label><b>Date Requested&nbsp;&nbsp;&nbsp;: </b></label>
                        <u>{{ date('F j, Y g:i A', strtotime($vehicle->created_at)) }}</u>
                    </td>
                    <td id="col2">
                        <label><b>Time Needed&nbsp;&nbsp;&nbsp;&nbsp;: </b></label>
                        <u>{{ date('g:i A', strtotime($vehicle->date_needed)) }}&nbsp;&nbsp;&nbsp;</u>
                    </td>
                </tr>
                <tr>
                    <td id="col1">
                        <label><b>Requesting Staff :</b> </label>
                        <u>{{App\User::get_user($vehicle->user_id)}}</u>
                    </td>
                    <td id="col2">
                        <label>&nbsp;<b>Division&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b> </label>
                        @php
                        $division = App\User::get_division($vehicle->user_id);


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
                        <u>{{$division}}&nbsp;&nbsp;&nbsp;</u>
                    </td>
                </tr>
                <tr></tr>
                <td id="col1">
                    <label><b>Destination&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b> </label>
                    <u>{{$vehicle->destination}}</u>
                </td>
                <td id="col2">
                    <label><b>Purpose of Trip:</b></label>
                    <u>{{$vehicle->purpose}}&nbsp;&nbsp;&nbsp;</u>
                </td>
                </tr>
            </table>
        </center>
        <center>
            <table id="tbl2">
                <div class="row">
                    <tr>
                        <td id="td2">
                            <label style="float: left">Requested By:</label>
                            <br>
                            <center><span style="text-align: center;"><img id="dc_kmd_signature"></span>
                                <br><small><b>Employee Name</b></small>
                            </center>
                        </td>
                        <td id="td2">
                            <label style="float: left">Recommended By:</label>
                            <br>

                            <center>
                                @if($vehicle->status == "For CAO Approval" || $vehicle->status == "Confirmed" || $vehicle->status == "On The Way" || $vehicle->status == "Accomplished")
                                @if(App\User::get_division($vehicle->user_id) == "Finance and Administrative Division")
                                <span style="text-align: center;"><img id="dc_fad_signature" src="{{asset('images/dc_fad_signature.png')}}" alt="PSRTI DC signature"></span>
                                @elseif(App\User::get_division($vehicle->user_id) == "Knowledge Management Division")
                                <span style="text-align: center;"><img id="dc_kmd_signature" src="{{asset('images/dc_kmd_signature.png')}}" alt="PSRTI DC signature"></span>
                                @elseif(App\User::get_division($vehicle->user_id) == "Office of the Executive Director")
                                <span style="text-align: center;"><img id="dc_oed_signature" src="{{asset('images/dc_oed_signature.png')}}" alt="PSRTI DC signature"></span>
                                @elseif(App\User::get_division($vehicle->user_id) == "Training Division")
                                <span style="text-align: center;"><img id="dc_td_signature" src="{{asset('images/dc_td_signature.png')}}" alt="PSRTI DC signature"></span>
                                @elseif(App\User::get_division($vehicle->user_id) == "Research Division")
                                <span style="text-align: center;"><img id="dc_rd_signature" src="{{asset('images/dc_rd_signature.png')}}" alt="PSRTI DC signature"></span>
                                @else
                                <span style="text-align: center;"><img id="dc_kmd_signature"></span>
                                @endif
                                @endif
                                <br><small><b>Division Chief</b></small>
                            </center>
                        </td>
                        <td id="td2">
                        <label style="float: left"> By:</label>
                            <br>
                            <center>
                                @if($vehicle->status == "Confirmed" || $vehicle->status == "On The Way" || $vehicle->status == "Accomplished")
                                <span style="text-align: right;"><img id="dc_fad_signature" src="{{asset('images/dc_fad_signature.png')}}" alt="PSRTI DC signature"></span>
                                @else
                                <span style="text-align: right;"><img id="dc_fad_signature"></span>
                                @endif
                                <br>
                                <small><b>Chief Administrative Officer</b></small>
                            </center>
                        </td>
                    </tr>
                </div>
            </table>
            <table id="tbl3">
                <tr>
                    <td id="th3"><label><b>NAME</b></label></td>
                    <td id="th3"><label><b>SIGNATURE</b></label></td>
                    <td id="th3"><label><b>NAME</b></label></td>
                    <td id="th3"><label><b>SIGNATURE</b></label></td>
                </tr>
                @php
                $array = array();
                foreach($passenger as $data)
                $array[] = $data;
                @endphp
                @if(count($passenger) == 10)
                <tr>
                    <td id="td3">{{$array[0]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">{{$array[5]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">{{$array[1]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">{{$array[6]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">{{$array[2]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">{{$array[7]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">{{$array[3]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">{{$array[8]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">{{$array[4]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">{{$array[9]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                @elseif(count($passenger) == 9)
                <tr>
                    <td id="td3">{{$array[0]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">{{$array[5]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">{{$array[1]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">{{$array[6]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">{{$array[2]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">{{$array[7]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">{{$array[3]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">{{$array[8]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">{{$array[4]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                @elseif(count($passenger) == 8)
                <tr>
                    <td id="td3">{{$array[0]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">{{$array[5]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">{{$array[1]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">{{$array[6]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">{{$array[2]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">{{$array[7]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">{{$array[3]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">{{$array[4]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                @elseif(count($passenger) == 7)
                <tr>
                    <td id="td3">{{$array[0]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">{{$array[5]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">{{$array[1]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">{{$array[6]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">{{$array[2]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">{{$array[3]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">{{$array[4]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                @elseif(count($passenger) == 6)
                <tr>
                    <td id="td3">{{$array[0]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">{{$array[5]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">{{$array[1]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">{{$array[2]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">{{$array[3]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">{{$array[4]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                @elseif(count($passenger) == 5)
                <tr>
                    <td id="td3">{{$array[0]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">{{$array[1]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">{{$array[2]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">{{$array[3]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">{{$array[4]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                @elseif(count($passenger) == 4)
                <tr>
                    <td id="td3">{{$array[0]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">{{$array[1]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">{{$array[2]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">{{$array[3]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                @elseif(count($passenger) == 3)
                <tr>
                    <td id="td3">{{$array[0]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">{{$array[1]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">{{$array[2]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                @elseif(count($passenger) == 2)
                <tr>
                    <td id="td3">{{$array[0]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">{{$array[1]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                @elseif(count($passenger) == 1)
                <tr>
                    <td id="td3">{{$array[0]->passenger}}</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                @elseif(count($passenger) == 0)
                <tr>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                <tr>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                    <td id="td3">&nbsp;</td>
                </tr>
                @endif
            </table>
        </center>
        </div>
        </table>
        <br>
        <center> ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- </center>
        <br>
        <center><b>To be accomplished by the Driver</b>
            <table id="tbl4">
                <div class="row">
                    <tr>
                        <td id="th3" style="min-width: 180px; max-width: 180px; min-height: 10px; max-height: 10px;"><label>PLACE OF DEPARTURE</label></td>
                        <td id="th3" style="min-width: 180px; max-width: 180px; min-height: 10px; max-height: 10px;"><label>TIME OF DEPARTURE</label></td>
                        <td id="th3" style="min-width: 180px; max-width: 180px; min-height: 10px; max-height: 10px;"><label>DESTINATION</label></td>
                        <td id="th3" style="min-width: 180px; max-width: 180px; min-height: 10px; max-height: 10px;"><label>TIME OF ARRIVAL</label></td>
                    </tr>
                    <tr>
                        <td id="td4">1.</td>
                        <td id="td4"></td>
                        <td id="td4"></td>
                        <td id="td4"></td>
                    </tr>
                    <tr>
                        <td id="td4">2.</td>
                        <td id="td4"></td>
                        <td id="td4"></td>
                        <td id="td4"></td>
                    </tr>
                    <tr>
                        <td id="td4">3.</td>
                        <td id="td4"></td>
                        <td id="td4"></td>
                        <td id="td4"></td>
                    </tr>
                    <tr>
                        <td id="td4">4.</td>
                        <td id="td4"></td>
                        <td id="td4"></td>
                        <td id="td4"></td>
                    </tr>
                    <tr>
                        <td id="td4">5.</td>
                        <td id="td4"></td>
                        <td id="td4"></td>
                        <td id="td4"></td>
                    </tr>
                    <tr>
                        <td id="td4">6.</td>
                        <td id="td4"></td>
                        <td id="td4"></td>
                        <td id="td4"></td>
                    </tr>
                    <tr>
                        <td id="td4">7.</td>
                        <td id="td4"></td>
                        <td id="td4"></td>
                        <td id="td4"></td>
                    </tr>
                </div>
            </table>
            <br>
            <div>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <b> Time of Arrival noted and signed by </b>
                <br>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <b>PSRTI Guard on Duty</b>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ====>
                &nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <br>
            <table id="tbl5">
                <b>
                    <center>Kilometer and Gasoline Reading</center>
                </b>
                <tr>
                    <td id="td5">Kilometer Reading:</td>
                    <td id="td5">Start of the Trip:</td>
                    <td id="td5">End of Last Trip:</td>

                </tr>
                <tr>
                    <td id="td5">Gasoline Reading:</td>
                    <td id="td5">Before the Trip:</td>
                    <td id="td5">After the Trip:</td>
                </tr>
                <tr>
                    <td id="td5"></td>
                    <td id="td5"></td>
                    <td id="td5">Liters Consumed : </td>
                </tr>
            </table>
        </center>
        <br>
        <table id="tbl6">
            <tr>
                <td id="col4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Accomplished by:</b>
                </td>
                <td id="col5"><b> Verified by:</b>
                </td>
            </tr>
            <tr>
                <td id="col4"></td>
                <td id="col5"></td>
            </tr>
            <tr>
                <td id="col4"></td>
                <td id="col5"></td>
            </tr>
            <tr>
                <td id="col4"></td>
                <td id="col5"></td>
            </tr>
            <tr>
                <td id="col4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Signature over printed name</td>
                <td id="col5"><b>LOLITA M. OREO</b> <br>
                    Chief, FAD
                </td>
            </tr>
        </table>
        <div class="row" id="footer">
            <div class="col">
                <p>
                    7th Floor South Insula Condominium, 61 Timog Avenue, Brgy. South Triangle, Quezon City 1103 <br>
                    Telefax: (632) 288-4948/245-1067/929-7543/288-4150/426-0620/245-1093/920-9649 <br>
                    http://psrti.gov.ph
                </p>
            </div>
        </div>
        </body>
        @endif
        @if(count($passenger) >= 11)
        <!-- page1.1 -->

        <body>
            <div class="row">
                <div id="header" class="row">
                    <img src="{{asset('images/header.jpg')}}" alt="PSRTI Header" id="header_logo">
                    <img src="{{asset('images/iso-fad.png')}}" alt="PSRTI ISO" id="header_iso_fad">
                </div>
            </div>

            <center>
                <div>
                    <h3>VEHICLE REQUEST FORM</h3>
                </div>
            </center>
            <center>
                <table id="tbl1">
                    <tr>
                        <td id="col1"></td>
                        <td><label><b>Date Needed&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b></label>
                            <u>{{ date('F j, Y', strtotime($vehicle->date_needed)) }}&nbsp;&nbsp;&nbsp;&nbsp;</u>
                        </td>
                    </tr>
                    <br>
                    <tr>
                        <td id="col1">
                            <label><b>Date Requested&nbsp;&nbsp;&nbsp;: </b></label>
                            <u>{{ date('F j, Y g:i A', strtotime($vehicle->created_at)) }}</u>
                        </td>
                        <td id="col2">
                            <label><b>Time Needed&nbsp;&nbsp;&nbsp;&nbsp;: </b></label>
                            <u>{{ date('g:i A', strtotime($vehicle->date_needed)) }}&nbsp;&nbsp;&nbsp;</u>
                        </td>
                    </tr>
                    <tr>
                        <td id="col1">
                            <label><b>Requesting Staff :</b> </label>
                            <u>{{App\User::get_user($vehicle->user_id)}}</u>
                        </td>
                        <td id="col2">
                            <label>&nbsp;<b>Division&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b> </label>
                            @php
                            $division = App\User::get_division($vehicle->user_id);


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
                            <u>{{$division}}&nbsp;&nbsp;&nbsp;</u>
                        </td>
                    </tr>
                    <tr></tr>
                    <td id="col1">
                        <label><b>Destination&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b> </label>
                        <u>{{$vehicle->destination}}</u>
                    </td>
                    <td id="col2">
                        <label><b>Purpose of Trip:</b></label>
                        <u>{{$vehicle->purpose}}&nbsp;&nbsp;&nbsp;</u>
                    </td>
                    </tr>
                </table>
            </center>
            <center>
                <table id="tbl2">
                    <div class="row">
                        <tr>
                            <td id="td2">
                                <label style="float: left">Requested By:</label>
                                <br>
                                <center><span style="text-align: center;"><img id="dc_kmd_signature"></span>
                                    <br><small><b>Employee Name</b></small>
                                </center>
                            </td>
                            <td id="td2">
                                <label style="float: left">Recommended By:</label>
                                <br>

                                <center>
                                    @if($vehicle->status == "For CAO Approval" || $vehicle->status == "Confirmed" || $vehicle->status == "On The Way" || $vehicle->status == "Accomplished")
                                    @if(App\User::get_division($vehicle->user_id) == "Finance and Administrative Division")
                                    <span style="text-align: center;"><img id="dc_fad_signature" src="{{asset('images/dc_fad_signature.png')}}" alt="PSRTI DC signature"></span>
                                    @elseif(App\User::get_division($vehicle->user_id) == "Knowledge Management Division")
                                    <span style="text-align: center;"><img id="dc_kmd_signature" src="{{asset('images/dc_kmd_signature.png')}}" alt="PSRTI DC signature"></span>
                                    @elseif(App\User::get_division($vehicle->user_id) == "Office of the Executive Director")
                                    <span style="text-align: center;"><img id="dc_oed_signature" src="{{asset('images/dc_oed_signature.png')}}" alt="PSRTI DC signature"></span>
                                    @elseif(App\User::get_division($vehicle->user_id) == "Training Division")
                                    <span style="text-align: center;"><img id="dc_td_signature" src="{{asset('images/dc_td_signature.png')}}" alt="PSRTI DC signature"></span>
                                    @elseif(App\User::get_division($vehicle->user_id) == "Research Division")
                                    <span style="text-align: center;"><img id="dc_rd_signature" src="{{asset('images/dc_rd_signature.png')}}" alt="PSRTI DC signature"></span>
                                    @else
                                    <span style="text-align: center;"><img id="dc_kmd_signature"></span>
                                    @endif
                                    @endif
                                    <br><small><b>Division Chief</b></small>
                                </center>
                            </td>
                            <td id="td2">
                                <label style="float: left">Approved By:</label>
                                <br>
                                <center>
                                    @if($vehicle->status == "Confirmed" || $vehicle->status == "On The Way" || $vehicle->status == "Accomplished")
                                    <span style="text-align: right;"><img id="dc_fad_signature" src="{{asset('images/dc_fad_signature.png')}}" alt="PSRTI DC signature"></span>
                                    @else
                                    <span style="text-align: right;"><img id="dc_fad_signature"></span>
                                    @endif
                                    <br>
                                    <small><b>Chief Administrative Officer</b></small>
                                </center>
                            </td>
                        </tr>
                    </div>
                </table>
                <table id="tbl3">
                    <tr>
                        <td id="th3"><label><b>NAME</b></label></td>
                        <td id="th3"><label><b>SIGNATURE</b></label></td>
                        <td id="th3"><label><b>NAME</b></label></td>
                        <td id="th3"><label><b>SIGNATURE</b></label></td>
                    </tr>
                    @php
                    $array = array();
                    foreach($passenger as $data)
                    $array[] = $data;
                    @endphp
                    <tr>
                        <td id="td3">{{$array[0]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">{{$array[5]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[1]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">{{$array[6]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[2]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">{{$array[7]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[3]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">{{$array[8]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[4]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">{{$array[9]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                </table>
            </center>
            </div>
            </table>
            <br>
            <center> ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- </center>
            <br>
            <center><b>To be accomplished by the Driver</b>
                <table id="tbl4">
                    <div class="row">
                        <tr>
                            <td id="th3" style="min-width: 180px; max-width: 180px; min-height: 10px; max-height: 10px;"><label>PLACE OF DEPARTURE</label></td>
                            <td id="th3" style="min-width: 180px; max-width: 180px; min-height: 10px; max-height: 10px;"><label>TIME OF DEPARTURE</label></td>
                            <td id="th3" style="min-width: 180px; max-width: 180px; min-height: 10px; max-height: 10px;"><label>DESTINATION</label></td>
                            <td id="th3" style="min-width: 180px; max-width: 180px; min-height: 10px; max-height: 10px;"><label>TIME OF ARRIVAL</label></td>
                        </tr>
                        <tr>
                            <td id="td4">1.</td>
                            <td id="td4"></td>
                            <td id="td4"></td>
                            <td id="td4"></td>
                        </tr>
                        <tr>
                            <td id="td4">2.</td>
                            <td id="td4"></td>
                            <td id="td4"></td>
                            <td id="td4"></td>
                        </tr>
                        <tr>
                            <td id="td4">3.</td>
                            <td id="td4"></td>
                            <td id="td4"></td>
                            <td id="td4"></td>
                        </tr>
                        <tr>
                            <td id="td4">4.</td>
                            <td id="td4"></td>
                            <td id="td4"></td>
                            <td id="td4"></td>
                        </tr>
                        <tr>
                            <td id="td4">5.</td>
                            <td id="td4"></td>
                            <td id="td4"></td>
                            <td id="td4"></td>
                        </tr>
                        <tr>
                            <td id="td4">6.</td>
                            <td id="td4"></td>
                            <td id="td4"></td>
                            <td id="td4"></td>
                        </tr>
                        <tr>
                            <td id="td4">7.</td>
                            <td id="td4"></td>
                            <td id="td4"></td>
                            <td id="td4"></td>
                        </tr>
                    </div>
                </table>
                <br>
                <div>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <b> Time of Arrival noted and signed by </b>
                    <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <b>PSRTI Guard on Duty</b>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ====>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <br>
                <table id="tbl5">
                    <b>
                        <center>Kilometer and Gasoline Reading</center>
                    </b>
                    <tr>
                        <td id="td5">Kilometer Reading:</td>
                        <td id="td5">Start of the Trip:</td>
                        <td id="td5">End of Last Trip:</td>

                    </tr>
                    <tr>
                        <td id="td5">Gasoline Reading:</td>
                        <td id="td5">Before the Trip:</td>
                        <td id="td5">After the Trip:</td>
                    </tr>
                    <tr>
                        <td id="td5"></td>
                        <td id="td5"></td>
                        <td id="td5">Liters Consumed : </td>
                    </tr>
                </table>
            </center>
            <br>
            <table id="tbl6">
                <tr>
                    <td id="col4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Accomplished by:</b>
                    </td>
                    <td id="col5"><b> Verified by:</b>
                    </td>
                </tr>
                <tr>
                    <td id="col4"></td>
                    <td id="col5"></td>
                </tr>
                <tr>
                    <td id="col4"></td>
                    <td id="col5"></td>
                </tr>
                <tr>
                    <td id="col4"></td>
                    <td id="col5"></td>
                </tr>
                <tr>
                    <td id="col4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Signature over printed name</td>
                    <td id="col5"><b>LOLITA M. OREO</b> <br>
                        Chief, FAD
                    </td>
                </tr>
            </table>
            <div class="row" id="footer">
                <div class="col">
                    <p>
                        7th Floor South Insula Condominium, 61 Timog Avenue, Brgy. South Triangle, Quezon City 1103 <br>
                        Telefax: (632) 288-4948/245-1067/929-7543/288-4150/426-0620/245-1093/920-9649 <br>
                        http://psrti.gov.ph
                    </p>
                </div>
            </div>
        </body>
        <!-- page2 -->
        <br><br>
        <br><br>

        <body>
            <div class="row">
                <div id="header" class="row">
                    <img src="{{asset('images/header.jpg')}}" alt="PSRTI Header" id="header_logo">
                    <img src="{{asset('images/iso-fad.png')}}" alt="PSRTI ISO" id="header_iso_fad">
                </div>
            </div>

            <center>
                <div>
                    <h3>VEHICLE REQUEST FORM</h3>
                </div>
            </center>
            <center>
                <table id="tbl1">
                    <tr>
                        <td id="col1"></td>
                        <td><label><b>Date Needed&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b></label>
                            <u>{{ date('F j, Y', strtotime($vehicle->date_needed)) }}&nbsp;&nbsp;&nbsp;&nbsp;</u>
                        </td>
                    </tr>
                    <br>
                    <tr>
                        <td id="col1">
                            <label><b>Date Requested&nbsp;&nbsp;&nbsp;: </b></label>
                            <u>{{ date('F j, Y g:i A', strtotime($vehicle->created_at)) }}</u>
                        </td>
                        <td id="col2">
                            <label><b>Time Needed&nbsp;&nbsp;&nbsp;&nbsp;: </b></label>
                            <u>{{ date('g:i A', strtotime($vehicle->date_needed)) }}&nbsp;&nbsp;&nbsp;</u>
                        </td>
                    </tr>
                    <tr>
                        <td id="col1">
                            <label><b>Requesting Staff :</b> </label>
                            <u>{{App\User::get_user($vehicle->user_id)}}</u>
                        </td>
                        <td id="col2">
                            <label>&nbsp;<b>Division&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b> </label>
                            @php
                            $division = App\User::get_division($vehicle->user_id);


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
                            <u>{{$division}}&nbsp;&nbsp;&nbsp;</u>
                        </td>
                    </tr>
                    <tr></tr>
                    <td id="col1">
                        <label><b>Destination&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:</b> </label>
                        <u>{{$vehicle->destination}}</u>
                    </td>
                    <td id="col2">
                        <label><b>Purpose of Trip:</b></label>
                        <u>{{$vehicle->purpose}}&nbsp;&nbsp;&nbsp;</u>
                    </td>
                    </tr>
                </table>
            </center>
            <center>
                <table id="tbl2">
                    <div class="row">
                        <tr>
                            <td id="td2">
                                <label style="float: left">Requested By:</label>
                                <br>
                                <center><span style="text-align: center;"><img id="dc_kmd_signature"></span>
                                    <br><small><b>Employee Name</b></small>
                                </center>
                            </td>
                            <td id="td2">
                                <label style="float: left">Recommended By:</label>
                                <br>

                                <center>
                                    @if($vehicle->status == "For CAO Approval" || $vehicle->status == "Confirmed" || $vehicle->status == "On The Way" || $vehicle->status == "Accomplished")
                                    @if(App\User::get_division($vehicle->user_id) == "Finance and Administrative Division")
                                    <span style="text-align: center;"><img id="dc_fad_signature" src="{{asset('images/dc_fad_signature.png')}}" alt="PSRTI DC signature"></span>
                                    @elseif(App\User::get_division($vehicle->user_id) == "Knowledge Management Division")
                                    <span style="text-align: center;"><img id="dc_kmd_signature" src="{{asset('images/dc_kmd_signature.png')}}" alt="PSRTI DC signature"></span>
                                    @elseif(App\User::get_division($vehicle->user_id) == "Office of the Executive Director")
                                    <span style="text-align: center;"><img id="dc_oed_signature" src="{{asset('images/dc_oed_signature.png')}}" alt="PSRTI DC signature"></span>
                                    @elseif(App\User::get_division($vehicle->user_id) == "Training Division")
                                    <span style="text-align: center;"><img id="dc_td_signature" src="{{asset('images/dc_td_signature.png')}}" alt="PSRTI DC signature"></span>
                                    @elseif(App\User::get_division($vehicle->user_id) == "Research Division")
                                    <span style="text-align: center;"><img id="dc_rd_signature" src="{{asset('images/dc_rd_signature.png')}}" alt="PSRTI DC signature"></span>
                                    @else
                                    <span style="text-align: center;"><img id="dc_kmd_signature"></span>
                                    @endif
                                    @endif
                                    <br><small><b>Division Chief</b></small>
                                </center>
                            </td>
                            <td id="td2">
                                <label style="float: left">Approved By:</label>
                                <br>
                                <center>
                                    @if($vehicle->status == "Confirmed" || $vehicle->status == "On The Way" || $vehicle->status == "Accomplished")
                                    <span style="text-align: right;"><img id="dc_fad_signature" src="{{asset('images/dc_fad_signature.png')}}" alt="PSRTI DC signature"></span>
                                    @else
                                    <span style="text-align: right;"><img id="dc_fad_signature"></span>
                                    @endif
                                    <br>
                                    <small><b>Chief Administrative Officer</b></small>
                                </center>
                            </td>
                        </tr>
                    </div>
                </table>
                <table id="tbl3">
                    <tr>
                        <td id="th3"><label><b>NAME</b></label></td>
                        <td id="th3"><label><b>SIGNATURE</b></label></td>
                        <td id="th3"><label><b>NAME</b></label></td>
                        <td id="th3"><label><b>SIGNATURE</b></label></td>
                    </tr>
                    @php
                    $array = array();
                    foreach($passenger as $data)
                    $array[] = $data;
                    @endphp

                    @if(count($passenger) == 11)
                    <tr>
                        <td id="td3">{{$array[10]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3"></td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3"></td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3"></td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3"></td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3"></td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3"></td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3"></td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3"></td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3"></td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    @elseif(count($passenger) == 12)
                    <tr>
                        <td id="td3">{{$array[10]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[11]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    @elseif(count($passenger) == 13)
                    <tr>
                        <td id="td3">{{$array[10]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[11]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[12]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    @elseif(count($passenger) == 14)
                    <tr>
                        <td id="td3">{{$array[10]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[11]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[12]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[13]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    @elseif(count($passenger) == 15)
                    <tr>
                        <td id="td3">{{$array[10]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[11]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[12]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[13]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[14]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                    </tr>

                    @elseif(count($passenger) == 16)
                    <tr>
                        <td id="td3">{{$array[10]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">{{$array[15]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[11]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[12]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[13]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[14]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    @elseif(count($passenger) == 17)
                    <tr>
                        <td id="td3">{{$array[10]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">{{$array[15]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[11]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">{{$array[16]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[12]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[13]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[14]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    @elseif(count($passenger) == 18)
                    <tr>
                        <td id="td3">{{$array[10]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">{{$array[15]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[11]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">{{$array[16]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[12]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">{{$array[17]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[13]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[14]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    @elseif(count($passenger) == 19)
                    <tr>
                        <td id="td3">{{$array[10]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">{{$array[15]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[11]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">{{$array[16]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[12]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">{{$array[17]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[13]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">{{$array[18]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[14]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    @elseif(count($passenger) == 20)
                    <tr>
                        <td id="td3">{{$array[10]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">{{$array[15]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[11]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">{{$array[16]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[12]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">{{$array[17]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[13]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">{{$array[18]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[14]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">{{$array[19]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    @elseif(count($passenger) >= 20)
                    <tr>
                        <td id="td3">{{$array[10]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">{{$array[15]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[11]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">{{$array[16]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[12]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">{{$array[17]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[13]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">{{$array[18]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    <tr>
                        <td id="td3">{{$array[14]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                        <td id="td3">{{$array[19]->passenger}}</td>
                        <td id="td3">&nbsp;</td>
                    </tr>
                    @endif


                </table>
            </center>
            </div>
            </table>
            <br>
            <center> ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- </center>
            <br>
            <center><b>To be accomplished by the Driver</b>
                <table id="tbl4">
                    <div class="row">
                        <tr>
                            <td id="th3" style="min-width: 180px; max-width: 180px; min-height: 10px; max-height: 10px;"><label>PLACE OF DEPARTURE</label></td>
                            <td id="th3" style="min-width: 180px; max-width: 180px; min-height: 10px; max-height: 10px;"><label>TIME OF DEPARTURE</label></td>
                            <td id="th3" style="min-width: 180px; max-width: 180px; min-height: 10px; max-height: 10px;"><label>DESTINATION</label></td>
                            <td id="th3" style="min-width: 180px; max-width: 180px; min-height: 10px; max-height: 10px;"><label>TIME OF ARRIVAL</label></td>
                        </tr>
                        <tr>
                            <td id="td4">1.</td>
                            <td id="td4"></td>
                            <td id="td4"></td>
                            <td id="td4"></td>
                        </tr>
                        <tr>
                            <td id="td4">2.</td>
                            <td id="td4"></td>
                            <td id="td4"></td>
                            <td id="td4"></td>
                        </tr>
                        <tr>
                            <td id="td4">3.</td>
                            <td id="td4"></td>
                            <td id="td4"></td>
                            <td id="td4"></td>
                        </tr>
                        <tr>
                            <td id="td4">4.</td>
                            <td id="td4"></td>
                            <td id="td4"></td>
                            <td id="td4"></td>
                        </tr>
                        <tr>
                            <td id="td4">5.</td>
                            <td id="td4"></td>
                            <td id="td4"></td>
                            <td id="td4"></td>
                        </tr>
                        <tr>
                            <td id="td4">6.</td>
                            <td id="td4"></td>
                            <td id="td4"></td>
                            <td id="td4"></td>
                        </tr>
                        <tr>
                            <td id="td4">7.</td>
                            <td id="td4"></td>
                            <td id="td4"></td>
                            <td id="td4"></td>
                        </tr>
                    </div>
                </table>
                <br>
                <div>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <b> Time of Arrival noted and signed by </b>
                    <br>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <b>PSRTI Guard on Duty</b>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ====>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                </div>
                <br>
                <table id="tbl5">
                    <b>
                        <center>Kilometer and Gasoline Reading</center>
                    </b>
                    <tr>
                        <td id="td5">Kilometer Reading:</td>
                        <td id="td5">Start of the Trip:</td>
                        <td id="td5">End of Last Trip:</td>

                    </tr>
                    <tr>
                        <td id="td5">Gasoline Reading:</td>
                        <td id="td5">Before the Trip:</td>
                        <td id="td5">After the Trip:</td>
                    </tr>
                    <tr>
                        <td id="td5"></td>
                        <td id="td5"></td>
                        <td id="td5">Liters Consumed : </td>
                    </tr>
                </table>
            </center>
            <br>
            <table id="tbl6">
                <tr>
                    <td id="col4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Accomplished by:</b>
                    </td>
                    <td id="col5"><b> Verified by:</b>
                    </td>
                </tr>
                <tr>
                    <td id="col4"></td>
                    <td id="col5"></td>
                </tr>
                <tr>
                    <td id="col4"></td>
                    <td id="col5"></td>
                </tr>
                <tr>
                    <td id="col4"></td>
                    <td id="col5"></td>
                </tr>
                <tr>
                    <td id="col4">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Signature over printed name</td>
                    <td id="col5"><b>LOLITA M. OREO</b> <br>
                        Chief, FAD
                    </td>
                </tr>
            </table>
            <div class="row" id="footer">
                <div class="col">
                    <p>
                        7th Floor South Insula Condominium, 61 Timog Avenue, Brgy. South Triangle, Quezon City 1103 <br>
                        Telefax: (632) 288-4948/245-1067/929-7543/288-4150/426-0620/245-1093/920-9649 <br>
                        http://psrti.gov.ph
                    </p>
                </div>
            </div>

</small>

</body>
@endif
<script type="text/javascript">
    window.onload = function() {
        window.print();
    }
</script>

</html>