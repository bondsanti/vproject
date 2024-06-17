<header class="main-header">

        <!-- Logo -->
        <a href="{{ url('/') }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>v</b>BNEXT</span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>VBNEXT</b> Project</span>
          </a>

    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
        <!-- Sidebar toggle button-->
        <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
        </a>
        <!-- Navbar Right Menu -->
        <div class="navbar-custom-menu">
            <ul class="nav navbar-nav">
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <img src="{{ url('uploads/avatar.png') }}" class="user-image" alt="User Image">
                        <span class="">{{$dataUserLogin['email']}}</span>
                    </a>
                    <ul class="dropdown-menu">
                        <!-- User image -->
                        <li class="user-header">
                            <img src="{{ url('uploads/avatar.png') }}" class="img-circle" alt="User Image">

                            <p>
                                {{$dataUserLogin['email']}}
                                <small>ประเภทผู้ใช้งาน {{$dataRoleUser->role_type}}</small>
                            </p>
                        </li>

                        <!-- Menu Footer-->
                        <li class="user-footer">
                            {{-- <div class="pull-left">
                                <a href="#" class="btn btn-default btn-flat">Profile</a>
                            </div> --}}
                            <div class="pull-right">
                                <a href="{{route('logoutUser')}}" class="btn btn-default btn-flat">Sign out</a>
                            </div>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>

    </nav>
</header>
