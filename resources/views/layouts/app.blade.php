<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
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



    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <!-- Google Font -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>

<body class="hold-transition skin-green sidebar-mini">
    <div class="wrapper">
        @include('sweetalert::alert')
        {{-- 1. Top --}}
        @include('layouts.top')

        {{-- 2. Left --}}
        @include('layouts.left')

        {{-- 3. Main Content --}}
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->

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
    <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
    {{-- <script src="{{ asset('vendors/dist/js/pages/dashboard2.js') }}"></script> --}}
    <!-- AdminLTE for demo purposes -->
    <script src="{{ asset('vendors/dist/js/demo.js') }}"></script>



</body>
    <script>
        $(function () {
        //Initialize Select2 Elements
        $('.select2').select2()

        //iCheck for checkbox and radio inputs
        $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass   : 'iradio_minimal-blue'
        })

        //Date picker
        // $('#datepicker').datepicker({
        // autoclose: true
        // })

        });
    </script>
    <script>
    $(document).ready(function () {
        $.ajaxSetup({
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
        $('#tableUser').DataTable({
        processing: true,
        serverSide: true,
            ajax:"{{route('user')}}",
            columns:[
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data:'code',name:'code'},
                {data:'fullname',name:'fullname'},
                {data:'role',name:'role'},
                {data:'team_id',name:'team_id'},
                {data:'active',name:'active'},
                {data:'action',name:'action',orderable:false,searchable:false},
            ]
        })
        $('#savedata').click(function (e) {
        e.preventDefault();
        $(this).html('Sending..');

        $.ajax({
          data: $('#userForm').serialize(),
          url: "{{ route('user.insert') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {

              $('#userForm').trigger("reset");
              $('#modal-default').modal('hide');
              table.draw();

          },
          error: function (data) {
              console.log('Error:', data);
              $('#savedata').html('Save Changes');
          }
      });
    });

    });
    </script>

</html>
