<!DOCTYPE html>


<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>vBis | ระบบนัดเยี่ยมโครงการ</title>
    <link rel="icon" type="image/x-icon" href="{{ url('uploads/vbeicon.ico') }}">

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="{{ asset('vendors/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('vendors/bower_components/font-awesome/css/font-awesome.min.css') }}">

    <link rel="stylesheet" href="{{ asset('vendors/bower_components/Ionicons/css/ionicons.min.css') }}">

    <link rel="stylesheet" href="{{ asset('vendors/dist/css/AdminLTE.min.css') }}">



    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">


<body class="hold-transition login-page">
    @include('sweetalert::alert')
    <br><br><br><br><br>
    <div class="login-box">
        <div class="login-logo">
            <img src="https://report.vbeyond.co.th/images/logowhite.png" width="268px" alt="">


        </div>

        <div class="login-box-body">
            <p class="login-box-msg login-logo"><b>vBis</b>Project</p>
            <form action="{{route('insertRegis')}}" method="post">
                @csrf

                <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="code" placeholder="Code"  autocomplete="off" value="{{old('code')}}">
                    <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
                    <small class="text-danger mt-1">@error('code'){{$message}} @enderror</small>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="fullname" placeholder="Full name"  autocomplete="off" value="{{old('fullname')}}">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    <small class="text-danger mt-1">@error('fullname'){{$message}} @enderror</small>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="text" class="form-control" name="tel" placeholder="Tel"  autocomplete="off" value="{{old('tel')}}">
                    <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    <small class="text-danger mt-1">@error('tel'){{$message}} @enderror</small>
                  </div>

                  <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="password" placeholder="Password"  autocomplete="off">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    <small class="text-danger mt-1">@error('password'){{$message}} @enderror</small>
                  </div>

                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat"><i class="fa fa-plus"></i>
                            ลงทะเบียน</button>
                    </div>

                </div>
            </form>
            {{-- <div class="social-auth-links text-center">
<p>- OR -</p>
<a href="#" class="btn btn-success btn-block btn-flat"><i class="fa fa-user-plus"></i> สมัครเข้าใช้งานระบบ</a>

</div> --}}
        </div>

    </div>

    <script src="{{ asset('vendors/bower_components/jquery/dist/jquery.min.js') }}"></script>

    <script src="{{ asset('vendors/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>



</body>

</html>
