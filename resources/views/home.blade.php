<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SMS</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="icon" href="{{asset('images/sms.png')}}">
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

        .fc-event-title {
            font-size: 13px !important;
        }

        /* .fc-basic-view .fc-body .fc-row{
            min-height: 2em;
        } */
    </style>


</head>

<body>
    <div class="wrapper">
        @include('partials._header')
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <a href="{{ URL::to('/') }}" class="brand-link">
                <img src="{{asset('images/sms.png')}}" alt="SMS Logo" class="brand-image img-circle elevation-3">
                <span class="brand-text font-weight-light">Finance SMS</span>
            </a>
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex text-white">
                    <div class="info">
                        <span class="nav-icon fas fa-user"> &nbsp; </span>
                        {{ucwords(strtolower(Auth::user()->name))}}
                    </div>
                </div>
                @include('partials._sidebar')
            </div>
            <!-- /.sidebar -->
        </aside>
        <!-- /.navbar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <div class="content">
                <br>
                <div class="col-md">
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">
                            </h3>
                        </div>
                        <div class="card-body">
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.row -->
        </div>
        <!-- /.content -->
        <!-- /.content-wrapper -->
        <!-- Main Footer -->
        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>SMS | Copyright &copy; 2022.</strong> All rights
            reserved.
        </footer>
    </div>

    <!-- ./wrapper -->

    <!-- REQUIRED SCRIPTS -->

    <!-- jQuery -->
    <!-- @yield('content') -->
    <script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
    <script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
    <script src="{{asset('assets/dist/js/adminlte.min.js')}}"></script>
    <script src="{{asset('assets/plugins/moment/moment.min.js')}}"></script>
    <!-- <script src="{{ asset('assets/plugins/fullcalendar/main.js')}}"></script> -->
    <script src="{{asset('assets/dist/js/demo.js')}}"></script>
    <script src="{{ asset('assets/plugins/fastclick/fastclick.js')}}"></script>
    <script src="{{ asset('assets/plugins/toastr/toastr.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.bundle.js')}}"></script>
    <script src='{{ asset("assets/lib/main.js")}}'></script>

    <script>
        var global_path = "{{ URL::to('') }}";
    </script>
    <script type="text/javascript">
        $(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var calendarEl = document.getElementById('calendar');
            var calEvent = '';
            $.ajax({
                url: global_path + "/calendar/feed",
                method: 'post',
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    var calendar = new FullCalendar.Calendar(calendarEl, {
                        headerToolbar: {

                            left: 'prev,next today',
                            center: 'title',
                            description: 'long description',
                            right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
                        },
                        // initialDate: '2020-09-12',
                        navLinks: true, // can click day/week names to navigate views
                        businessHours: true, // display business hours
                        editable: false,
                        expandRows: true,
                        selectable: false,
                        googleCalendarApiKey: 'AIzaSyDcnW6WejpTOCffshGDDb4neIrXVUA1EAE',
                        events: response

                    });


                    calendar.render();
                },
                cache: false,
                contentType: false,
                processData: false
            });


        });
    </script>
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.js"></script>
    <script src="{{asset('js/table.js')}}"></script>

    @if (Session::has('message'))
    <script>
        $(document).ready(function() {
            var session = "{{ Session::get('message') }}"
            if (session == 'success') {
                let timerInterval
                Swal.fire({
                    type: 'success',
                    title: 'Timelog Recorded',
                    html: 'loading..',
                    timer: 1000,
                    onOpen: () => {
                        Swal.showLoading()
                        timerInterval = setInterval(() => {
                            const content = Swal.getContent()
                            if (content) {
                                const b = content.querySelector('b')
                                if (b) {
                                    b.textContent = Swal.getTimerLeft()
                                }
                            }
                        }, 100)
                    },
                    onClose: () => {
                        clearInterval(timerInterval)
                    }
                })
            } else {
                Swal.fire(
                    'DB ERROR.',
                    session,
                    'error'
                )
            }
        });
    </script>
    @endif
</body>

</html>