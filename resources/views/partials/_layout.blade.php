<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>SMS</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="icon" href="{{asset('images/sms.png')}}">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css')}}">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css" integrity="sha512-3JRrEUwaCkFUBLK1N8HehwQgu8e23jTH4np5NHOmQOobuC4ROQxFwFgBLTnhcnQRMs84muMh0PnnwXlPq5MGjg==" crossorigin="anonymous" /> -->

  <!-- calendar -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/fullcalendar/main.css')}}">

  <!-- datatables -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/jquery.dataTables.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  @yield('css')
  <link rel="stylesheet" href="{{asset('assets/dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
</head>

<body class="hold-transition sidebar-mini">
  <div id="overlay" style="display:none;">
    <div class="spinner"></div>
    <br />
    Loading...
  </div>
  <div class="wrapper">
    @include('partials._header')
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <a href="{{ URL::to('/') }}" class="brand-link">
        <img src="{{asset('images/sms.png')}}" alt="SMS Logo" class="brand-image img-circle elevation-3">
        <span class="brand-text font-weight-light">SMS</span>
      </a>
      <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex text-white">
          <div class="info">
            <span class="nav-icon fas fa-user"> &nbsp; </span>
            {{ucwords(strtolower(Auth::user()->name))}} |
          </div>
        </div>
        @include('partials._sidebar')
      </div>
      <!-- /.sidebar -->
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
      <!-- Content Header (Page header) -->
      <br>

      <!-- Main content -->
      <section class="content">

        <!-- Default box -->
        @yield('content')
        <!-- /.card -->

      </section>
      <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <footer class="main-footer">
      <div class="float-right d-none d-sm-block">
        <b>Version</b> 1.0.0
      </div>
      <strong>SMS | Copyright &copy; 2022.</strong> All rights
      reserved.
    </footer>

    <!-- Control Sidebar -->
    <!-- /.control-sidebar -->
  </div>
  <script src="{{asset('assets/plugins/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('assets/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset('assets/plugins/fastclick/fastclick.js')}}"></script>
  <script src="{{ asset('assets/plugins/toastr/toastr.min.js')}}"></script>
  <script src="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.js')}}"></script>
  <script src="{{asset('assets/dist/js/adminlte.min.js')}}"></script>

  <script src="{{asset('assets/dist/js/demo.js')}}"></script>
  <script src="{{asset('assets/plugins/moment/moment.min.js')}}"></script>
  <script src="{{ asset('assets/plugins/inputmask/jquery.inputmask.bundle.js')}}"></script>
  <!-- datatables -->
  <script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
  <script src="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.js') }}"></script>



  <script>
    var global_path = "{{ URL::to('') }}";
  </script>
  <script>
    $(function() {
      $.ajaxSetup({
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      });
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

            // displayEventTime: false, // don't show the time column in list view

            // THIS KEY WON'T WORK IN PRODUCTION!!!
            // To make your own Google API key, follow the directions here:
            // http://fullcalendar.io/docs/google_calendar/
            googleCalendarApiKey: 'AIzaSyDcnW6WejpTOCffshGDDb4neIrXVUA1EAE',

            // US Holidays
            // events: 'en.usa#holiday@group.v.calendar.google.com',

            // eventClick: function(arg) {
            //     // opens events in a popup window
            //     window.open(arg.event.url, 'google-calendar-event', 'width=700,height=600');

            //     arg.jsEvent.preventDefault() // don't navigate in main tab
            // },

            // loading: function(bool) {
            //     document.getElementById('loading').style.display =
            //         bool ? 'block' : 'none';
            // }

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

  @if(Session::has('message'))
  <script>
    $(document).ready(function() {
      var session = "{{Session::get('message')}}"
      if (session != '') {
        if (session == 'success') {
          let timerInterval
          Swal.fire({
            type: 'success',
            title: session,
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
            'DB Error',
            session,
            'warning'
          )
        }
      }
    });
  </script>
  @endif
  @yield('js')
</body>

</html>