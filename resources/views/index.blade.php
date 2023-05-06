@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
        Dashboard
        <small>page</small>
    </h1>
    {{-- <ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Dashboard</li>
</ol> --}}
</section>


<!-- Main content -->
<section class="content">

    <!-- Info Booking -->
    <div class="row">
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
              <div class="inner">
                <h3>{{$countAllBooking}}</h3>

                <p>นัดหมายทั้งหมด</p>
              </div>
              <div class="icon">
                <i class="fa fa-align-justify"></i>
              </div>

            </div>
          </div>
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$countSucessBooking}}</h3>

              <p>สำเร็จแล้ว</p>
            </div>
            <div class="icon">
              <i class="fa fa-check"></i>
            </div>

          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
              <h3>{{$countCancelBooking}}</h3>

              <p>ยกเลิก</p>
            </div>
            <div class="icon">
              <i class="fa fa-times"></i>
            </div>

          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box" style="background-color: #b342f5;color:white">
            <div class="inner">
              <h3>{{$countExitBooking}}</h3>

              <p>ยกเลิกอัตโนมัติ</p>
            </div>
            <div class="icon">
              <i class="fa fa-repeat"></i>
            </div>

          </div>
        </div>
        <!-- ./col -->
    </div>

    <!-- Info User -->
    <div class="row">

        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $countUser }}</h3>

                    <p>ข้อมูลผู้ใช้งานทั้งหมด</p>
                </div>
                <div class="icon">
                    <i class="fa fa-users" aria-hidden="true"></i>
                </div>

            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $countUserAdmin }}</h3>

                    <p>ผู้ใช้งาน [Admin]</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                </div>

            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $countUserStaff }}</h3>

                    <p>ผู้ใช้งาน [Staff]</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                </div>

            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-blue">
                <div class="inner">
                    <h3>{{ $countUserSale }}</h3>

                    <p>ผู้ใช้งาน [Sale]</p>
                </div>
                <div class="icon">
                    <i class="fa fa-user-plus" aria-hidden="true"></i>
                </div>

            </div>
        </div>
        <!-- ./col -->

    </div>


</section>
<!-- /.content -->
@endsection
