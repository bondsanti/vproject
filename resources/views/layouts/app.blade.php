<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>vBis | ระบบนัดเยี่ยมโครงการ</title>
    <link rel="icon" type="image/x-icon" href="{{ url('uploads/vbeicon.ico') }}">
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('vendors/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendors/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('vendors/bower_components/Ionicons/css/ionicons.min.css') }}">
    <!-- jvectormap -->
    <link rel="stylesheet" href="{{ asset('vendors/bower_components/jvectormap/jquery-jvectormap.css') }}">
      <!-- daterange picker -->
    <link rel="stylesheet" href="{{ asset('vendors/bower_components/bootstrap-daterangepicker/daterangepicker.css')}}">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="{{ asset('vendors/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
      <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('vendors/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">
      <!-- Pace style -->
    <link rel="stylesheet" href="{{ asset('vendors/plugins/pace/pace.min.css')}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('vendors/dist/css/AdminLTE.min.css') }}">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{ asset('vendors/plugins/iCheck/all.css') }}">
      <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('vendors/bower_components/select2/dist/css/select2.min.css')}}">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{ asset('vendors/dist/css/skins/_all-skins.min.css') }}">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="{{ asset('vendors/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
  <!-- fullCalendar -->
  <link rel="stylesheet" href="{{ asset('vendors/bower_components/fullcalendar/dist/fullcalendar.min.css') }}">
  <link rel="stylesheet" href="{{ asset('vendors/bower_components/fullcalendar/dist/fullcalendar.print.min.css') }}" media="print">
  <!-- jQuery UI -->

  {{-- <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.css' /> --}}

        <!-- moment lib -->
    {{-- <script src='https://cdn.jsdelivr.net/npm/moment@2.27.0/min/moment.min.js'></script> --}}

    <!-- fullcalendar bundle -->
    {{-- <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.4/index.global.min.js'></script> --}}

    <!-- the moment-to-fullcalendar connector. must go AFTER the moment lib -->
    {{-- <script src='https://cdn.jsdelivr.net/npm/@fullcalendar/moment@6.1.4/index.global.min.js'></script> --}}

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    {{-- <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic"> --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<style>
    body{
        font-family: 'Sarabun', sans-serif;
    }
</style>
</head>

<body class="hold-transition skin-green sidebar-mini">
    <div class="wrapper">

        {{-- 1. Top --}}
        @include('layouts.top')

        {{-- 2. Left --}}
        @include('layouts.left')

        {{-- 3. Main Content --}}
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            @include('sweetalert::alert')
                    @yield('content')

        </div>
        <!-- /.content-wrapper -->

        {{-- 4. Footer --}}
        @include('layouts.footer')


    </div>
    <!-- ./wrapper -->

    <!-- jQuery 3 -->
    <script src="{{ asset('vendors/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('vendors/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- FastClick -->
    <script src="{{ asset('vendors/bower_components/fastclick/lib/fastclick.js') }}"></script>
    <!-- Select2 -->
    <script src="{{ asset('vendors/bower_components/select2/dist/js/select2.full.min.js') }}"></script>
    <!-- iCheck 1.0.1 -->
    <script src="{{ asset('vendors/plugins/iCheck/icheck.min.js') }}"></script>
    <!-- date-range-picker -->
    <script src="{{ asset('vendors/bower_components/moment/min/moment.min.js')}}"></script>
    <script src="{{ asset('vendors/bower_components/bootstrap-daterangepicker/daterangepicker.js')}}"></script>

    <!-- DataTables -->
    <script src="{{ asset('vendors/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('vendors/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
    <!-- PACE -->
    <script src="{{ asset('vendors/bower_components/PACE/pace.min.js') }}"></script>
    <!-- bootstrap datepicker -->
    <script src="{{ asset('vendors/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('vendors/dist/js/adminlte.min.js') }}"></script>
    <!-- Sparkline -->
    <script src="{{ asset('vendors/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js') }}"></script>
    <!-- jvectormap  -->
    <script src="{{ asset('vendors/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js') }}"></script>
    <script src="{{ asset('vendors/plugins/jvectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
    <!-- SlimScroll -->
    <script src="{{ asset('vendors/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
    <!-- ChartJS -->
    <script src="{{ asset('vendors/bower_components/chart.js/Chart.js') }}"></script>

    <!-- bootstrap datepicker -->
    <script src="{{ asset('vendors/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    {{-- <script src="{{ asset('vendors/dist/js/pages/dashboard2.js') }}"></script> --}}
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('vendors/dist/js/demo.js') }}"></script>
    {{-- <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.9.0/fullcalendar.js'></script> --}}
    <!-- fullCalendar -->
    <script src='https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/locale/th.js'></script>
    {{-- <script src="{{ asset('vendors/bower_components/moment/moment.js') }}"></script> --}}
    <script src="{{ asset('vendors/bower_components/fullcalendar/dist/fullcalendar.min.js') }}"></script>

</body>
    {{-- <script>
        $(function () {
        //Initialize Select2 Elements


        //Date picker
        // $('#datepicker').datepicker({
        // autoclose: true
        // })

        });
    </script> --}}
    @stack('script')

</html>
