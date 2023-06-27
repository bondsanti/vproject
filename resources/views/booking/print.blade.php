
<!DOCTYPE html>
<html>
<head>
	<title>พิมพ์ใบจอง</title>
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

        <!-- bootstrap datepicker -->
        <link rel="stylesheet" href="{{ asset('vendors/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css')}}">
          <!-- DataTables -->
        <link rel="stylesheet" href="{{ asset('vendors/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css')}}">

        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('vendors/dist/css/AdminLTE.min.css') }}">

        <link rel="stylesheet" href="{{ asset('vendors/dist/css/skins/_all-skins.min.css') }}">

      <link rel="preconnect" href="https://fonts.googleapis.com">
      <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
      <link href="https://fonts.googleapis.com/css2?family=Sarabun:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
      body{
          font-family: 'Sarabun', sans-serif;
      }
      .under-line-dot{
        border-bottom: 2px dotted;
      }
      p {
        font-size: 0.875em;
        }
        .border-doc {
        border: 1px solid black; /* This will set the thickness, style, and color of the border */
        padding: 10px; /* This will add some padding inside the border */
        }
  </style>
</head>
<body onload="window.print()">
        <!-- Main content -->
        <section class="content border-doc">

            <div class="row">
                <div class="col-md-4"></div>
                <div class="col-md-4 text-center">
                    <img src="{{url('/uploads/logo_vbeyond.png')}}" width="170px" alt="">
                    <h4>แจ้งขอนัดชมโครงการ</h4>
                    <h5>ชื่อ <span class="under-line-dot"> {{ optional($booking->booking_project_ref->first())->name }} </span></h5>
                    <h5>วันเวลา <span class="under-line-dot"> {{$Strdate_start = date('d/m/Y H:00', strtotime($bookings->booking_start . ' +543 years'))}} -
                        {{$Strdate_end = date('H:00', strtotime($bookings->booking_end))}} น.</span></h5>
                </div>
                <div class="col-md-4"></div>
            </div>
            <!-- table boxes -->
            <div class="row">
                <!-- /.col -->
                <div class="col-md-12">

                    <table id="table" style="width:60%" align="center" class="table table-striped ">
                        <thead>
                            <tr>
                                {{-- <th class="text-center"><button id="print-button" onclick="printChecked()">Print</button></th> --}}
                                <th class="text-center" colspan="2">ข้อมูลลูกค้า</th>
                            </tr>
                        </thead>
                        <tbody class="text-center">
                            <tr>
                                <td class="text-right">Booking ID :</td>
                                <td class="text-left">{{$bookings->bkid}} </td>
                            </tr>
                            <tr>
                                <td class="text-right">ชื่อ ลูกค้า :</td>
                                <td class="text-left">คุณ {{$bookings->customer_name}}, {{$bookings->customer_tel}} </td>
                            </tr>

                            <tr>
                                <td class="text-right">ข้อมูลเข้าชม :</td>
                                <td class="text-left"> {{$bookings->customer_req}}
                                    @php
                                    if($bookings->room_price > 0){
                                        echo number_format($bookings->room_price).".-";
                                    }
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">เลขห้อง :</td>
                                <td class="text-left"> @php
                                    if($bookings->room_price!=null){
                                        echo $bookings->room_no;
                                    }
                                    @endphp
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">ชื่อ Sale :</td>
                                <td class="text-left"> {{ optional($booking->booking_user_ref->first())->name_th }}, {{$bookings->user_tel}}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-right">เจ้าหน้าที่โครงการ :</td>
                                <td class="text-left">คุณ {{ optional($booking->booking_emp_ref->first())->name_th }}, {{ optional($booking->booking_emp_ref->first())->phone }}</td>
                            </tr>
                            <tr>
                                <td class="text-right">เอกสารขอกู้ธนาคาร :</td>
                                <td class="text-left"> {{$bookings->customer_req_bank}}
                                </td>
                            </tr>
                            @php
                                    if($bookings->num_home > 0){
                                        echo "<tr>
                                <td class=\"text-right\">ฝากรับเอกสารลูกค้า :</td>
                                <td class=\"text-left\">
                                        สำเนาทะเบียนบาน <strong>".$bookings->num_home."</strong>ชุด
                                </td>
                            </tr>
                            ";
                                    }
                             @endphp
                            @php
                            if($bookings->num_idcard > 0){
                                echo "
                            <tr>
                                <td class=\"text-right\"></td>
                                <td class=\"text-left\">
                                        สำเนาบัตรประชาชน <strong>".$bookings->num_idcard."</strong>ชุด

                                </td>
                            </tr>
                            ";}
                            @endphp
                            @php
                            if($bookings->num_app_statement > 0){
                                echo "<tr>
                                <td class=\"text-right\"></td>
                                <td class=\"text-left\">

                                       หนังสือรับรองเงินเดือน <strong>".$bookings->num_app_statement."</strong>ชุด


                                </td>
                            </tr>
                            ";}
                            @endphp
                            @php
                            if($bookings->num_statement > 0){
                                echo"
                            <tr>
                                <td class=\"text-right\"></td>
                                <td class=\"text-left\">
                                        เอกสาร Statement <strong>".$bookings->num_statement."</strong>ชุด

                                </td>
                            </tr>";}
                            @endphp
                            <tr>
                                <td colspan="2" class="text-center"><p>กรณีมีข้อมูลสอบถาม ติดต่อ คุณแคท 090-9896697 / คุณอีฟ 084-6757689</p></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>


</body>
</html>
  <!-- jQuery 3 -->
  <script src="{{ asset('vendors/bower_components/jquery/dist/jquery.min.js') }}"></script>
  <!-- Bootstrap 3.3.7 -->
  <script src="{{ asset('vendors/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

  <!-- DataTables -->
  <script src="{{ asset('vendors/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
  <script src="{{ asset('vendors/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

  <script src="{{ asset('vendors/dist/js/adminlte.min.js') }}"></script>
  <!-- Sparkline -->

  <!-- ChartJS -->
  <script src="{{ asset('vendors/bower_components/chart.js/Chart.js') }}"></script>



  <script src="{{ asset('vendors/dist/js/demo.js') }}"></script>
