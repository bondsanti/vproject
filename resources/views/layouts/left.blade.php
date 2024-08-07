  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src=" {{ url('uploads/avatar.png') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>คุณ {{ $dataUserLogin['apiData']['data']['name_th'] }}</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>


      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">เมนูหลัก</li>

        <li class="{{ request()->routeIs('main') ? 'active' : '' }} {{ request()->routeIs('main.search') ? 'active' : '' }}"><a href="{{ route('main') }}"><i class="fa fa-dashboard"></i> <span>แดชบอร์ด </span></a></li>
        @if ($dataRoleUser->role_type!="User")
        <li class="{{ request()->routeIs('calendar') ? 'active' : '' }}"><a href="{{ route('calendar') }}"><i class="fa fa-calendar"></i> <span>ปฏิทินงาน </span></a></li>
        @endif
        @if ($dataRoleUser->role_type=="SuperAdmin" || $dataRoleUser->role_type=="Sale")
        <li class="{{ request()->routeIs('bookingProject') ? 'active' : '' }}{{ request()->routeIs('booking.edit') ? 'active' : '' }}"><a href="{{ route('bookingProject') }}">
            <i class="fa fa-calendar-plus-o"></i> <span>นัดหมาย </span></a></li>

        @endif
        @if ($dataRoleUser->role_type=="SuperAdmin" || $dataRoleUser->role_type=="Admin")
        <li class="{{ request()->routeIs('holiday') ? 'active' : '' }}"><a href="{{ route('holiday') }}"><i class="fa fa-calendar-times-o"></i> <span>ข้อมูลวันหยุด ทีม</span></a></li>
        @endif
        @if ($dataRoleUser->role_type=="SuperAdmin")
        <li class="{{ request()->routeIs('listBooking') ? 'active' : '' }} {{ request()->routeIs('booking.search') ? 'active' : '' }}"><a href="{{ route('listBooking') }}"><i class="fa fa-table"></i> <span>ตารางข้อมูลนัดหมาย </span></a></li>
        @endif

        @if ($dataRoleUser->role_type=="Staff")
        <li class="{{ request()->routeIs('holiday') ? 'active' : '' }}"><a href="{{ route('holiday') }}"><i class="fa fa-calendar-times-o"></i> <span>ปฏิทินวันหยุด</span></a></li>
        @endif

        @if ($dataRoleUser->role_type=="SuperAdmin" || $dataRoleUser->role_type=="Admin" || $dataRoleUser->role_type=="User")
        <li class="treeview {{ request()->routeIs('report.book.project') ? 'active' : '' }} {{ request()->routeIs('report.book.team') ? 'active' : '' }}">
            <a href="#">
              <i class="fa fa-files-o"></i> <span>รายงาน</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
                <li class="{{ request()->routeIs('report.book.project') ? 'active' : '' }}"><a href="{{ route('report.book.project') }}"><i class="fa fa-file"></i> <span>รายงาน โครงการ </span></a></li>
                <li class="{{ request()->routeIs('report.book.team') ? 'active' : '' }}"><a href="{{ route('report.book.team') }}"><i class="fa fa-file"></i> <span>รายงาน ทีม/สายงาน </span></a></li>
            </ul>
        </li>
        @endif
        {{-- <li><a href="{{route('logoutUser')}}" style="background-color: rgba(255, 23, 23, 0.3)"><i class="fa fa-sign-out"></i> ออกจากระบบ</a></li> --}}
        @if ($dataRoleUser->role_type=="SuperAdmin")
        <li class="header">เมนู ผู้ดูแลระบบ</li>
        <li class="treeview {{ request()->routeIs('user') ? 'active' : '' }} {{ request()->routeIs('team') ? 'active' : '' }} {{ request()->routeIs('subteam') ? 'active' : '' }}">

            <a href="#">
              <i class="fa fa-cogs"></i> <span>ตั้งค่าระบบ</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>

            <ul class="treeview-menu">
                {{-- <li class="{{ request()->routeIs('user') ? 'active' : '' }}"><a href="{{ route('user') }}"><i class="fa fa-user-plus"></i> <span>จัดการผู้ใช้งานระบบ </span></a></li> --}}
                <li class="{{ request()->routeIs('team') ? 'active' : '' }}"><a href="{{ route('team') }}"><i class="fa fa-user"></i> <span>จัดการทีม </span></a></li>
                <li class="{{ request()->routeIs('subteam') ? 'active' : '' }}"><a href="{{ route('subteam') }}"><i class="fa fa-users"></i> <span>จัดการสายงาน </span></a></li>
            </ul>

        </li>
        @endif
        <li class="header">คู่มือ</li>

        @if ($dataRoleUser->role_type=="Sale")
        <li><a href="{{ url('uploads/manual/คู่มือใช้งานระบบ_Sale.pdf') }}" target="_blank" style="background-color: rgba(23, 166, 255, 0.3)"><i class="fa fa-book text-aqua"></i> <span>คู่มือใช้งานระบบ</span></a></li>
        @elseif ($dataRoleUser->role_type=="Staff")
        <li><a href="{{ url('uploads/manual/คู่มือใช้งานระบบ_Staff.pdf') }}" target="_blank" style="background-color: rgba(23, 166, 255, 0.3)"><i class="fa fa-book text-aqua"></i> <span>คู่มือใช้งานระบบ</span></a></li>
        @else
        <li><a href="{{ url('uploads/manual/คู่มือใช้งานระบบ_Sale.pdf') }}" target="_blank"><i class="fa fa-book text-aqua"></i> <span>คู่มือใช้งานระบบ Sale</span></a></li>
        <li><a href="{{ url('uploads/manual/คู่มือใช้งานระบบ_Staff.pdf') }}" target="_blank"><i class="fa fa-book text-aqua"></i> <span>คู่มือใช้งานระบบ Project</span></a></li>
        <li><a href="{{ url('uploads/manual/คู่มือใช้งานระบบ__Admin.pdf') }}" target="_blank"><i class="fa fa-book text-aqua"></i> <span>คู่มือใช้งานระบบ Admin</span></a></li>
        @endif
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
