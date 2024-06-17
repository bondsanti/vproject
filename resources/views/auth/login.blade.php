<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>VBNext | ระบบนัดเยี่ยมชมโครงการ</title>
    <link rel="icon" type="image/x-icon" href="{{ url('uploads/vbeicon.ico') }}">

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <link rel="stylesheet" href="{{ asset('vendors/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('vendors/bower_components/font-awesome/css/font-awesome.min.css') }}">

    <link rel="stylesheet" href="{{ asset('vendors/bower_components/Ionicons/css/ionicons.min.css') }}">

    <link rel="stylesheet" href="{{ asset('vendors/dist/css/AdminLTE.min.css') }}">

    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

        <style>
            .login-logo img {
                max-width: 100%;
                height: auto;
            }
        </style>
<body class="hold-transition login-page">

    <br><br>
    <div class="login-box">
        <div class="login-logo">
            <img src="{{url('uploads/logovb2.png')}}">

        </div>
        @include('sweetalert::alert')

        <div class="login-box-body">

            <p class="login-box-msg login-logo"><b>Project</b></p>

            <form action="{{route('loginUser')}}" method="post">
                @csrf
                <div class="form-group has-feedback">
                    {{-- <input type="text" class="form-control" name="code" placeholder="Code"  autocomplete="off" value="{{old('code')}}"> --}}
                    <input type="text" class="form-control" name="code" placeholder="Code"  autocomplete="off">
                    <span class="glyphicon glyphicon-barcode form-control-feedback"></span>
                    <small class="text-danger mt-1">@error('code'){{$message}} @enderror</small>
                  </div>
                  <div class="form-group has-feedback">
                    <input type="password" class="form-control" name="password" placeholder="Password"  autocomplete="off">
                    <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    <small class="text-danger mt-1">@error('password'){{$message}} @enderror</small>
                  </div>
                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-primary btn-block btn-flat"><i class="fa fa-sign-in"></i>
                            เข้าสู่ระบบ</button>
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
