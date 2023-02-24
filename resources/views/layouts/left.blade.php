  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="{{ url('uploads/avatar.png') }}" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p>Admin IT</p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>


      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">เมนูหลัก</li>
        <li class="{{ request()->routeIs('main') ? 'active' : '' }}"><a href="{{ route('main') }}"><i class="fa fa-dashboard"></i> <span>Dashboard </span></a></li>
        <li class="{{ request()->routeIs('calendar') ? 'active' : '' }}"><a href="{{ route('calendar') }}"><i class="fa fa-calendar"></i> <span>Calendar </span></a></li>
        <li class="header">เมนู ผู้ดูแลระบบ</li>
        <li><a href=""><i class="fa fa-users"></i> <span>ผู้ใช้งานระบบ </span></a></li>
        <li class="treeview">
            <a href="#">
              <i class="fa fa-cogs"></i> <span>ตั้งค่าระบบ</span>
              <span class="pull-right-container">
                <i class="fa fa-angle-left pull-right"></i>
              </span>
            </a>
            <ul class="treeview-menu">
              <li class=""><a href="index.html"><i class="fa fa-circle-o"></i> จัดการโครงการ</a></li>
              <li class=""><a href="index.html"><i class="fa fa-circle-o"></i> จัดการสถานะเข้าชม</a></li>
              <li><a href="index2.html"><i class="fa fa-circle-o"></i> จัดการทีม</a></li>
            </ul>
        </li>
        <li class="header">คู่มือ</li>
        <li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>
        <li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>
