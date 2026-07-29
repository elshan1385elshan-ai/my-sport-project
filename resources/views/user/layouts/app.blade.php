<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>پنل کاربری | داشبورد</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="{{asset('plugins/font-awesome/css/font-awesome.min.css')}}">
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <link rel="stylesheet" href="{{asset('dist/css/adminlte.min.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/iCheck/flat/blue.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/morris/morris.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/jvectormap/jquery-jvectormap-1.2.2.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/datepicker/datepicker3.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/daterangepicker/daterangepicker-bs3.css')}}">
  <link rel="stylesheet" href="{{asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css')}}">
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  <link rel="stylesheet" href="{{asset('dist/css/bootstrap-rtl.min.css')}}">
  <link rel="stylesheet" href="{{asset('dist/css/custom-style.css')}}?v={{ time() }}">
  <style>
    .swal2-container { z-index: 9999 !important; }
    body, .wrapper, .main-header, .main-sidebar, .content-wrapper, .main-footer { font-family: {{ $appSettings['font_family'] ?? "'Vazir', sans-serif" }} !important; }
  </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  @include('user.layouts.partials.nav')

  @include('user.layouts.partials.sidebar')

  @yield('content')

  @include('user.layouts.partials.footer')

  <aside class="control-sidebar control-sidebar-dark">
  </aside>
</div>

<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="{{asset('plugins/morris/morris.min.js')}}"></script>
<script src="{{asset('plugins/sparkline/jquery.sparkline.min.js')}}"></script>
<script src="{{asset('plugins/jvectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
<script src="{{asset('plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>
<script src="{{asset('plugins/knob/jquery.knob.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js"></script>
<script src="{{asset('plugins/daterangepicker/daterangepicker.js')}}"></script>
<script src="{{asset('plugins/datepicker/bootstrap-datepicker.js')}}"></script>
<script src="{{asset('plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js')}}"></script>
<script src="{{asset('plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>
<script src="{{asset('plugins/fastclick/fastclick.js')}}"></script>
<script src="{{asset('dist/js/adminlte.js')}}"></script>
<script src="{{asset('dist/js/pages/dashboard.js')}}"></script>
<script src="{{asset('dist/js/demo.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  $(document).ready(function() {
    @if(session('success'))
      Swal.fire({
        icon: 'success',
        title: 'موفق',
        text: '{{ session('success') }}',
        timer: 3000,
        showConfirmButton: false,
        toast: true,
        position: 'top-start'
      });
    @endif
  });
</script>
@stack('scripts')
</body>
</html>
