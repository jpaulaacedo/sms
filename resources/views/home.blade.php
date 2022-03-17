<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PSRTI | VAMRS</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Google Font: Source Sans Pro -->
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="icon" href="{{asset('images/psrti_logo.png')}}">
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css')}}">
    <!-- datatables -->
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.css')}}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.0/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    @yield('css')
    <link rel="stylesheet" href="{{asset('assets/dist/css/adminlte.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link rel="stylesheet" href="{{asset('css/bday.css')}}">

    <!-- <link rel="stylesheet" href="{{ asset('assets/plugins/fullcalendar/main.css')}}"> -->
    <link href='{{ asset("assets/lib/main.css")}}' rel='stylesheet' />

    <style>
        #calendar {
            max-width: 1100px;
            margin: 0 auto;
        }

        .fc .fc-button-primary {
            background-color: #22856c !important;
            color: white !important;
        }
    </style>
</head>
<body >
@extends('partials._layout')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/datetime/1.0.3/css/dataTables.dateTime.min.css" />
<link href='{{ asset("assets/lib/main.css")}}' rel='stylesheet' />
<style>
    .scrolledTable {
        overflow-y: auto;
        clear: both;
    }
</style>
@endsection

@section('content')
<div class="card">
    <div class="card-header card-header-dark">
        <h3><span class="fa fa-business-time"></span> Requests</h3>
    </div>
    <div class="card card-default">
         <div class="card-header">
                <h3 class="card-title">
                    <i class="fa fa-calendar"></i>
                        Calendar
                </h3>
           </div>
        <div class="card-body">
             <div id='calendar'></div>
        </div>    
    </div>
</div>    
 
@endsection

@section('js')
<script type="text/javascript" src="https://cdn.datatables.net/datetime/1.0.3/js/dataTables.dateTime.min.js"></script>
<script src="{{asset('js/ot.js')}}"></script>
@endSection
<script>
        var global_path = "{{ URL::to('') }}";
    </script>
    <script type="text/javascript">
        $(function() {

        var calendarEl = document.getElementById('calendar');
            var calEvent = '';
            $.ajax({
                url: global_path + "/leaves/calendar/feed",
                method: 'post',
                dataType: 'json',
                success: function(response) {
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                        },
                        // initialDate: '2020-09-12',
                        navLinks: true, // can click day/week names to navigate views
                        businessHours: true, // display business hours
                        editable: true,
                        selectable: true,
                        events: response,
                        googleCalendarApiKey: 'AIzaSyDcnW6WejpTOCffshGDDb4neIrXVUA1EAE',
                    });
                    calendar.render();
                },
                cache: false,
                contentType: false,
                processData: false
            });
            console.log(calEvent);

        });
           
</script>


<script src="{{asset('js/dtr.js')}}"></script>

</body>
</html>