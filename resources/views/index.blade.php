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

    <!-- Info boxes -->
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
              <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
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
            <a href="#" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
    </div>


</section>
<!-- /.content -->
@endsection
