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
        max-width: 200px;
        min-width: 200px;
        min-height: 5px;
        max-height: 5px;
        text-align: left;
    }

    #col2 {
        max-width: 280px;
        min-width: 280px;
        max-height: 5px;
        min-height: 5px;
        text-align: center;
    }



    #col3 {
        max-width: 230px;
        min-width: 230px;
        max-height: 5px;
        min-height: 5px;
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

    #control_num {
        text-align: right;
    }

    #noted_by {
        text-align: right;
        font-family: "Helvetica";
    }

    #return {
        text-align: left;
        border: 0px;
    }

    table,
    td,
    th {
        border: 1px solid black;

        font-family: "Helvetica";
    }

    #recipient_header {
        text-align: center;
    }

    table {
        border-collapse: collapse;
        max-width: 100%;
        text-align: center;
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
<small>

    <body>
        <div class="row">
            <div id="header" class="row">
                <img src="{{asset('images/header.jpg')}}" alt="PSRTI Header" id="header_logo">
                <img src="{{asset('images/iso-fad.png')}}" alt="PSRTI ISO" id="header_iso_fad">
            </div>
        </div>

        <center>
            <div>
                <h3>MESSENGERIAL REQUEST FORM</h3>
            </div>
        </center>
        <div class="row" id="control_num">
            Control No.: <u>{{$messengerial->control_num}}</u>
        </div>
        <br>
        <div class="row">
            <small>
                <i>(to be filled up by the requesting staff)</i>
            </small>
        </div>
        <div class="row">
            <table>
                <div class="row">
                    <tr>
                        <td id="col1"><b>DATE OF REQUEST</b></td>
                        <td id="col2">{{ date('F j, Y', strtotime($messengerial->created_at)) }}</td>
                        <td id="col3"><b>TIME: </b>
                            <span style="text-align: center;">{{ date('g:i A', strtotime($messengerial->created_at)) }}</span>
                        </td>
                    </tr>
                </div>

                <tr>
                    <td id="col1"><b>PRINTED NAME OF REQUESTING STAFF</b></td>
                    <td id="col2">{{App\User::get_user($messengerial->user_id)}}</td>
                    <td id="col3">
                        <b>DIVISION: </b>
                        <span style="text-align: center;"> {{App\User::get_division($messengerial->user_id)}}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td id="col1"><b>SIGNATURE OF THE REQUESTING STAFF</b> </td>
                    <td id="col2">&nbsp;</td>

                    <!-- if user type = 1, 3 and division = FAD -->
                    @if((App\User::get_user_type($messengerial->user_id) == 1 || App\User::get_user_type($messengerial->user_id) == 3) && App\User::get_division($messengerial->user_id) == "Finance and Administrative Division" && ($messengerial->status != "Accomplished" && $messengerial->status != "Out For Delivery" && $messengerial->status != "Confirmed"))
                    <td id="col3">
                        <b>NOTED BY: </b>
                        &nbsp;
                        <span style="text-align: right;"><img id="dc_fad_signature" src=""></span>
                    </td>
                    @elseif((App\User::get_user_type($messengerial->user_id) == 1 || App\User::get_user_type($messengerial->user_id) == 3) && $messengerial->status == "Confirmed" && App\User::get_division($messengerial->user_id) == "Finance and Administrative Division")
                    <td id="col3">
                        <b>NOTED BY: </b>
                        &nbsp;
                        <span style="text-align: right;"><img id="dc_fad_signature" src="{{asset('images/dc_fad_signature.png')}}" alt="PSRTI DC signature"></span>
                    </td>
                    @elseif((App\User::get_user_type($messengerial->user_id) == 1 || App\User::get_user_type($messengerial->user_id) == 3) && $messengerial->status == "Out For Delivery" && App\User::get_division($messengerial->user_id) == "Finance and Administrative Division")
                    <td id="col3">
                        <b>NOTED BY: </b>
                        &nbsp;
                        <span style="text-align: right;"><img id="dc_fad_signature" src="{{asset('images/dc_fad_signature.png')}}" alt="PSRTI DC signature"></span>
                    </td>
                    @elseif((App\User::get_user_type($messengerial->user_id) == 1 || App\User::get_user_type($messengerial->user_id) == 3) && $messengerial->status == "Accomplished" && App\User::get_division($messengerial->user_id) == "Finance and Administrative Division")
                    <td id="col3">
                        <b>NOTED BY: </b>
                        &nbsp;
                        <span style="text-align: right;"><img id="dc_fad_signature" src="{{asset('images/dc_fad_signature.png')}}" alt="PSRTI DC signature"></span>
                    </td>
                    @endif

                    <!-- if user type = 1 and division = OED -->
                    @if(App\User::get_user_type($messengerial->user_id) == 1 && App\User::get_division($messengerial->user_id) == "Office of the Executive Director" && ($messengerial->status != "Accomplished" && $messengerial->status != "Out For Delivery" && $messengerial->status != "Confirmed"))
                    <td id="col3">
                        <b>NOTED BY: </b>
                        &nbsp;
                        <span style="text-align: right;"><img id="dc_fad_signature" src=""></span>
                    </td>
                    @elseif(App\User::get_user_type($messengerial->user_id) == 1 && $messengerial->status == "Confirmed" && App\User::get_division($messengerial->user_id) == "Office of the Executive Director")
                    <td id="col3">
                        <b>NOTED BY: </b>
                        &nbsp;
                        <span style="text-align: right;"><img id="dc_oed_signature" src="{{asset('images/dc_oed_signature.png')}}" alt="PSRTI DC signature"></span>
                    </td>
                    @elseif(App\User::get_user_type($messengerial->user_id) == 1 && $messengerial->status == "Out For Delivery" && App\User::get_division($messengerial->user_id) == "Office of the Executive Director")
                    <td id="col3">
                        <b>NOTED BY: </b>
                        &nbsp;
                        <span style="text-align: right;"><img id="dc_oed_signature" src="{{asset('images/dc_oed_signature.png')}}" alt="PSRTI DC signature"></span>
                    </td>
                    @elseif(App\User::get_user_type($messengerial->user_id) == 1 && $messengerial->status == "Accomplished" && App\User::get_division($messengerial->user_id) == "Office of the Executive Director")
                    <td id="col3">
                        <b>NOTED BY: </b>
                        &nbsp;
                        <span style="text-align: right;"><img id="dc_oed_signature" src="{{asset('images/dc_oed_signature.png')}}" alt="PSRTI DC signature"></span>
                    </td>
                    @endif

                    <!-- if user type = 1, 5 and division != FAD and division != OED -->
                    @if(App\User::get_user_type($messengerial->user_id) == 1 || App\User::get_user_type($messengerial->user_id) == 5 && App\User::get_division($messengerial->user_id) != "Finance and Administrative Division")
                    @if($messengerial->status != "Filing" && $messengerial->status != "Cancelled" && $messengerial->status != "For DC Approval")
                    @if(App\User::get_division($messengerial->user_id) == "Knowledge Management Division")
                    <td id="col3">
                        <b>NOTED BY: </b>
                        &nbsp;
                        <span style="text-align: center;"><img id="dc_kmd_signature" src="{{asset('images/dc_kmd_signature.png')}}" alt="PSRTI DC signature"></span>
                    </td>
                    @endif
                    @if(App\User::get_division($messengerial->user_id) == "Research Division")
                    <td id="col3">
                        <b>NOTED BY: </b>
                        &nbsp;
                        <span style="text-align: center;"><img id="dc_rd_signature" src="{{asset('images/dc_rd_signature.png')}}" alt="PSRTI DC signature"></span>
                    </td>
                    @endif
                    @if(App\User::get_division($messengerial->user_id) == "Training Division")
                    <td id="col3">
                        <b>NOTED BY: </b>
                        &nbsp;
                        <span style="text-align: center;"><img id="dc_td_signature" src="{{asset('images/dc_td_signature.png')}}" alt="PSRTI DC signature"></span>
                    </td>
                    @endif
                    @elseif($messengerial->status == "Filing" || $messengerial->status == "Cancelled" || $messengerial->status == "For DC Approval")

                    <td id="col3">
                        <b>NOTED BY: </b>
                        &nbsp;
                        <span style="text-align: right;"><img id="dc_fad_signature" src=""></span>
                    </td>
                    @endif
                    @endif

                    <!-- if DC, ED, CAO -->
                    @if(App\User::get_user_type($messengerial->user_id) == 2 || App\User::get_user_type($messengerial->user_id) == 4 || App\User::get_user_type($messengerial->user_id) == 6)
                    @if(App\User::get_division($messengerial->user_id) == "Knowledge Management Division")
                    <td id="col3">
                        <b>NOTED BY: </b>
                        &nbsp;
                        <span style="text-align: center;"><img id="dc_kmd_signature" src="{{asset('images/dc_kmd_signature.png')}}" alt="PSRTI DC signature"></span>
                    </td>
                    @endif
                    @if(App\User::get_division($messengerial->user_id) == "Office of the Executive Director")
                    <td id="col3">
                        <b>NOTED BY: </b>&nbsp;
                        <span style="text-align: center;"><img id="dc_oed_signature" src="{{asset('images/dc_oed_signature.png')}}" alt="PSRTI DC signature"></span>
                    </td>
                    @endif
                    @if(App\User::get_division($messengerial->user_id) == "Research Division")
                    <td id="col3">
                        <b>NOTED BY: </b>
                        &nbsp;
                        <span style="text-align: center;"><img id="dc_rd_signature" src="{{asset('images/dc_rd_signature.png')}}" alt="PSRTI DC signature"></span>
                    </td>
                    @endif
                    @if(App\User::get_division($messengerial->user_id) == "Training Division")
                    <td id="col3">
                        <b>NOTED BY: </b>
                        &nbsp;
                        <span style="text-align: center;"><img id="dc_td_signature" src="{{asset('images/dc_td_signature.png')}}" alt="PSRTI DC signature"></span>
                    </td>
                    @endif
                    @if(App\User::get_division($messengerial->user_id) == "Finance and Administrative Division")

                    <td id="col3">
                        <b>NOTED BY: </b>
                        &nbsp;
                        <span style="text-align: right;"><img id="dc_fad_signature" src=""> &nbsp;</span>
                    </td>
                    @endif
                    @endif

                </tr>
            </table>
            <div class="row" id="received_by">
                @if($messengerial->status == "Filing" || $messengerial->status == "For DC Approval" || $messengerial->status == "For Assignment" || $messengerial->status == "For CAO Approval"|| $messengerial->status == "Cancelled")
                <tr>
                    <b>Received by: </b><img id="CAO_signature" src="{{asset('images/cao_no_signature.png')}}" alt="PSRTI CAO signature">
                    &nbsp;
                    <b>Date: </b>
                    <u> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    </u>
                    &nbsp;&nbsp;
                    <b>Time: </b>
                    <u>&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;</u>
                </tr>
                @else
                <tr>
                    <b>Received by: </b><img id="CAO_signature" src="{{asset('images/cao_signature.png')}}" alt="PSRTI CAO signature">
                    &nbsp;
                    <b>Date: </b><u>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        {{ date('F j, Y', strtotime($messengerial->approvedcao_date)) }}
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u> &nbsp;
                    <b>Time: </b><u>&nbsp;&nbsp;
                        {{ date('h:i A', strtotime($messengerial->approvedcao_date)) }}
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</u>
                </tr>
                @endif
            </div>
            <small>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                Chief Administrative Officer
            </small>

            <br>
            <center>
                <div>
                    <h3>RECIPIENT PORTION</h3>
                </div>
            </center>
            <div id="div2" style="text-align: center;" class="row">
                <table id="tbl_recipient">
                    <tr>
                        <th style="min-width: 140px; max-width: 140px; min-height: 10px; max-height: 10px;">AGENCY/OFFICE</th>
                        <th style="min-width: 140px; max-width: 140px; min-height: 10px; max-height: 10px;">NAME/SIGNATURE</th>
                        <th style="min-width: 110px; max-width: 110px; min-height: 10px; max-height: 10px;">CONTACT NO.</th>
                        <th style="min-width: 170px; max-width: 170px; min-height: 10px; max-height: 10px;">WHAT TO DELIVER</th>
                        <th style="min-width: 100px; max-width: 100px; min-height: 10px; max-height: 10px;">DATE/TIME</th>
                    </tr>
                    <tr>
                        <td style="min-width: 140px; max-width: 140px; min-height: 10px; max-height: 10px;">{{$messengerial->agency}}</td>
                        <td style="min-width: 140px; max-width: 140px; min-height: 10px; max-height: 10px;">{{$messengerial->recipient}}</td>
                        <td style="min-width: 110px; max-width: 110px; min-height: 10px; max-height: 10px;">{{$messengerial->contact}}</td>
                        <td style="min-width: 170px; max-width: 170px; min-height: 10px; max-height: 10px;">{{$messengerial->delivery_item}}</td>
                        <td style="min-width: 100px; max-width: 100px; min-height: 10px; max-height: 10px;">{{ date('F j, Y', strtotime($messengerial->date_needed)) }} <br>{{ date('g:i A', strtotime($messengerial->date_needed)) }}</td>
                    </tr>
                    <tr>
                        <td style="min-width: 140px; max-width: 140px; min-height: 10px; max-height: 10px;">&nbsp;<br>&nbsp;</td>
                        <td style="min-width: 140px; max-width: 140px; min-height: 10px; max-height: 10px;">&nbsp;<br>&nbsp;</td>
                        <td style="min-width: 110px; max-width: 110px; min-height: 10px; max-height: 10px;">&nbsp;<br>&nbsp;</td>
                        <td style="min-width: 170px; max-width: 170px; min-height: 10px; max-height: 10px;">&nbsp;<br>&nbsp;</td>
                        <td style="min-width: 100px; max-width: 100px; min-height: 10px; max-height: 10px;">&nbsp;<br>&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="min-width: 140px; max-width: 140px; min-height: 10px; max-height: 10px;">&nbsp;<br>&nbsp;</td>
                        <td style="min-width: 140px; max-width: 140px; min-height: 10px; max-height: 10px;">&nbsp;<br>&nbsp;</td>
                        <td style="min-width: 110px; max-width: 110px; min-height: 10px; max-height: 10px;">&nbsp;<br>&nbsp;</td>
                        <td style="min-width: 170px; max-width: 170px; min-height: 10px; max-height: 10px;">&nbsp;<br>&nbsp;</td>
                        <td style="min-width: 100px; max-width: 100px; min-height: 10px; max-height: 10px;">&nbsp;<br>&nbsp;</td>
                    </tr>
                </table>

                <br>
                <div class="row" id="instruction">
                    <tr><b>INSTRUCTION(S):</b>

                        @if($messengerial->instruction == null)
                        <u>N/A</u>
                        @else
                        <u>{{$messengerial->instruction}}</u>
                        @endif
                    </tr>
                </div>
                <br>
            </div>
            <center>
                <div class="row">
                    ----------------------------------------------------------------------------------------------------------------------------------------------------------------
                </div>
            </center>
            <h3>MESSENGER PORTION</h3>
            </center>
            <div class="row">
                <small>
                    <i>(to be filled up by Finance and Administrative Division)</i>
                </small>
            </div>

            <div class="row">
                <table>
                    <input type="hidden" id="out" name="out">

                    <tr>
                        <div class="col">
                            <td id="row1"><b>DATE OF DELIVERY</b></td>
                            @if($messengerial->status == "Out For Delivery" || $messengerial->status == "Accomplished")
                            <td id="row1">{{ date('F j, Y', strtotime($messengerial->outfordel_date)) }}</td>
                            <td id="row1"><b>TIME: </b> {{ date('g:i A', strtotime($messengerial->outfordel_date)) }}</td>
                            @else
                            <td id="row1">&nbsp;</td>
                            <td id="row1">&nbsp;</td>
                            @endif

                        </div>
                    </tr>

                    <tr>
                        <div class="col">
                            <td id="row1"><b>WHO DELIVERED</b></td>
                            @if($messengerial->status == "Out For Delivery" || $messengerial->status == "Accomplished")
                            <td id="row1">{{$messengerial->driver}}</td>
                            @else
                            <td id="row1">&nbsp;</td>
                            @endif<td id="return"><b>RETURNED ACCOMPLISHED FORM TO REQUESTING STAFF DATE/TIME: </b> </td>
                        </div>
                    </tr>

                    <tr>
                        <div class="col">
                            <td id="row1"><b>SIGNATURE OF THE MESSENGER</b></td>
                            @if($messengerial->status == "Out For Delivery" || $messengerial->status == "Accomplished")
                            <td id="row1">{{$messengerial->driver}}</td>
                            @else
                            <td id="row1">&nbsp;</td>
                            @endif
                            @if($messengerial->status == "Accomplished" || $messengerial->status == "Accomplished")
                            <td id="return">{{ date('F j, Y g:i A', strtotime($messengerial->accomplished_date)) }} </td>
                            @else
                            <td id="return">&nbsp; </td>
                            @endif
                        </div>
                    </tr>
                </table>
            </div>
        </div>
        <br>
        <div class="row" style="float: right">
            <div class="row">
                <div></div>
                Noted By:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <u>&nbsp;&nbsp;&nbsp;&nbsp;Percus Imperio&nbsp;&nbsp;&nbsp;&nbsp;</u>
                </div>
            </div>
            <div" class="row">
                <div class="col"> &nbsp;&nbsp;&nbsp;Authorized Staff
                </div>
        </div>
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
<script type="text/javascript">
    window.onload = function() {
        window.print();
    }
</script>
</body>

</html>