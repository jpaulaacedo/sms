<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>PSRTI - vamrs</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link rel="icon" href="{{asset('images/psrti_logo.png')}}">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="{{asset('assets/plugins/fontawesome-free/css/all.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/sweetalert2/sweetalert2.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/toastr/toastr.min.css')}}">
  <link rel="stylesheet" href="{{ asset('assets/plugins/fullcalendar/main.css')}}">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.39.0/css/tempusdominus-bootstrap-4.min.css" integrity="sha512-3JRrEUwaCkFUBLK1N8HehwQgu8e23jTH4np5NHOmQOobuC4ROQxFwFgBLTnhcnQRMs84muMh0PnnwXlPq5MGjg==" crossorigin="anonymous" />

  <!-- calendar -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/fullcalendar/main.css')}}">

  <!-- datatables -->
  <link rel="stylesheet" href="{{ asset('assets/plugins/datatables/dataTables.bootstrap4.css')}}">
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
        <img src="{{asset('images/psrti_logo.png')}}" alt="PSRTI Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">PSRTI | VAMRS</span>
      </a>
      <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex text-white">
          <div class="info">
            <span class="nav-icon fas fa-user"> &nbsp; </span>
            {{ucwords(strtolower(Auth::user()->name))}}  |
            @if(Auth::user()->division == "Office of the Executive Director")
            <span class="badge badge-success">OED</span>
            @elseif(Auth::user()->division == "Finance and Administrative Division")
            <span class="badge badge-primary">FAD</span>
            @elseif(Auth::user()->division == "Knowledge Management Division")
            <span class="badge badge-warning">KMD</span>
            @elseif(Auth::user()->division == "Research Division")
            <span class="badge badge-info">RD</span>
            @elseif(Auth::user()->division == "Training Division")
            <span class="badge badge-danger">TD</span>
            @endif
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
      <strong>Copyright &copy; 2022 <a href="http://psrti.gov.ph">psrti.gov.ph</a>.</strong> All rights
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
  <!-- <script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
  <script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script> -->



  <script>
    var global_path = "{{ URL::to('') }}";
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