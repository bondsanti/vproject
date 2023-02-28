@extends('layouts.app')

@section('content')
@php
///////////////// ตัวอย่างรูปแบบข้อมูล //////////////////
$demo_year_month=date("Y-m");
$data_schedule=array(
    array(
        "id"=>1,
        "start_date"=>"{$demo_year_month}-12", // รุปแบบ 0000-00-00
        "end_date"=>"{$demo_year_month}-21",
        "start_time"=>"08:00:00",
        "end_time"=>"09:30:00",
        "repeat_day"=>array(1,3,5),
        "title"=>"test data 1",
        "room"=>"ห้องบรรยาย 1",
        "building"=>"ตึก A"
    ),
    array(
        "id"=>2,
        "start_date"=>"{$demo_year_month}-15",
        "end_date"=>"{$demo_year_month}-21",
        "start_time"=>"10:00:00",
        "end_time"=>"11:00:00",
        "repeat_day"=>array(2,4),
        "title"=>"test data 2",
        "room"=>"ห้องบรรยาย 2",
        "building"=>"ตึก B"
    ),
    array(
        "id"=>3,
        "start_date"=>"{$demo_year_month}-15",
        "end_date"=>"{$demo_year_month}-25",
        "start_time"=>"14:30:00",
        "end_time"=>"16:00:00",
        "repeat_day"=>[],
        "title"=>"test data 3",
        "room"=>"ห้องบรรยาย 3",
        "building"=>"ตึก C"
    ),
    array(
        "id"=>4,
        "start_date"=>"{$demo_year_month}-19",
        "end_date"=>"{$demo_year_month}-28",
        "start_time"=>"16:30:00",
        "end_time"=>"18:00:00",
        "repeat_day"=>[1,4,5],
        "title"=>"test data 4",
        "room"=>"ห้องบรรยาย 4",
        "building"=>"ตึก D"
    ),
);
///////////////// ตัวอย่างรูปแบบข้อมูล //////////////////
@endphp
<style type="text/css">
    div.table-responsive::-webkit-scrollbar,
    div.table-responsive::-webkit-scrollbar {
      width: 10px;
      height: 2px;
    }
    ::-webkit-scrollbar {
      width: 10px;
      height: 7px;
    }
    ::-webkit-scrollbar-button {
      width: 0px;
      height: 0px;
    }
    ::-webkit-scrollbar-thumb {
      background: #CACACA;
      border: 0px none #CACACA;
      border-radius: 50px;
    }
    ::-webkit-scrollbar-thumb:active {
      background: #000000;
    }
    .wrap_schedule_control{
        margin:auto;
        width:800px;
    }
    .wrap_schedule{
        cursor: grab;
        margin:auto;
        width:800px;
    }
    .time_schedule{
        font-size:12px;
    }
    .day_schedule{
        font-size:12px;
    }
    .time_schedule_text{

    }
    .day_schedule_text{
        width:80px;
        font-size: 12px;
        padding: 10px 5px;
    }
    .day-head-label{
        position: relative;
        right: 10px;
        top: 0;
    }
    .time-head-label{
        position: relative;
        left: 10px;
        bottom: 0;
    }
    .diagonal-cross{
    border-bottom: 2px solid #dee2e6;
        /* -webkit-transform: translateY(20px) translateX(5px) rotate(26deg); */
        position: relative;
        top: -20px;
        left: 0;
        transform: translateY(20px) translateX(5px) rotate(20deg);
    }
    .sc-detail{
        font-size: 11px;
        background-color: #63E327;
        color: #FFFFFF;
    }
    .sc-detail a{
        color: #FF4F00;
        font-size: 14px;
    }
    </style>
    <section class="content-header">
        <h1>
            Calendar
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
              <!-- /.col -->
              <div class="col-md-12">
                <div class="box box-primary">
                  <div class="box-body no-padding">
                    <!-- THE CALENDAR -->
                    <table class="table table-bordered text-center">
                        <thead>
                        <tr style="height:60px;">
                          <th style="vertical-align: middle;">วัน / เวลา</th>
                          <th style="vertical-align: middle;">09:00 - 10:00</th>
                          <th style="vertical-align: middle;">10:00 - 11:00</th>
                          <th style="vertical-align: middle;">11:00 - 12:00</th>
                          {{-- <th style="vertical-align: middle;">12:00 - 13:00</th> --}}
                          <th style="vertical-align: middle;">13:00 - 14:00</th>
                          <th style="vertical-align: middle;">14:00 - 15:00</th>
                          <th style="vertical-align: middle;">15:00 - 16:00</th>
                          <th style="vertical-align: middle;">16:00 - 17:00</th>
                          <th style="vertical-align: middle;">17:00 - 18:00</th>
                        </tr>
                        </thead>
                        <tbody >
                            <tr style="height:100px;">
                                <td style="vertical-align: middle;"> จันทร์
                                    <p>xx-xx-xxxx</p>
                                </td>
                            </tr>
                            <tr style="height:100px;">
                                <td style="vertical-align: middle;"> อังคาร
                                    <p>xx-xx-xxxx</p></td>
                            </tr>
                            <tr style="height:100px;">
                                <td style="vertical-align: middle;"> พุธ
                                    <p>xx-xx-xxxx</p></td>
                            </tr>
                            <tr style="height:100px;">
                                <td style="vertical-align: middle;"> พฤหัส
                                    <p>xx-xx-xxxx</p></td>
                            </tr>
                            <tr style="height:100px;">
                                <td style="vertical-align: middle;"> ศุกร์
                                    <p>xx-xx-xxxx</p></td>
                            </tr>
                            <tr style="height:100px;">
                                <td style="vertical-align: middle;"> เสาร์
                                    <p>xx-xx-xxxx</p></td>
                            </tr>
                            <tr style="height:100px;">
                                <td style="vertical-align: middle;"> อาทิตย์
                                    <p>xx-xx-xxxx</p></td>
                            </tr>
                        </tbody>
                      </table>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /. box -->
              </div>
              <!-- /.col -->
        </div>
        <!-- /.row -->
    </section>
    <!-- /.content -->
@endsection
