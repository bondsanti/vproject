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
            <div class="col-md-4">

                <div class="box box-primary">
                  <div class="box-header with-border">
                    <h3 class="box-title">นัดเยี่ยมโครงการ</h3>
                  </div>
                  <div class="box-body">
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-6">
                                    <label>วันที่ </label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                        <i class="fa fa-calendar"></i>
                                        </div>
                                        <input type="text" class="form-control pull-right" id="datepicker">
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <label>เวลา </label>
                                    <div class="input-group date">
                                        <div class="input-group-addon">
                                        <i class="fa fa-clock-o"></i>
                                        </div>
                                        <select class="form-control select2" style="width: 100%;">
                                            <option>เลือก</option>
                                            <option>09.00 - 10.00 น.</option>
                                            <option>10.00 - 11.00 น.</option>
                                            <option>11.00 - 12.00 น.</option>
                                            <option>13.00 - 14.00 น.</option>
                                            <option>14.00 - 15.00 น.</option>
                                            <option>15.00 - 16.00 น.</option>
                                            </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>โครงการ</label>
                            <select class="form-control select2" style="width: 100%;">
                            <option>เลือก</option>
                            <option>A Spece Me รัตนาธิเบศร์</option>
                            <option>Altitude Symphony เจริญกรุง</option>
                            <option>Altitude Unicorn</option>
                            <option>Artisan Ratchada</option>
                            <option>Astoria Rangsit-Klong 3</option>
                            <option>Atmoz Chaengwattana</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-6">
                                    <label>ชื่อ-นามสกุล (ลูกค้า)</label>
                                    <input type="text" class="form-control" placeholder="">
                                </div>
                                <div class="col-xs-6">
                                    <label>เบอร์ติดต่อ</label>
                                    <input type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>เซ็นเอกสารใบคำขอกู้ธนาคาร</label>
                            <br>
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="minimal">
                                            กสิกร
                                          </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="minimal">
                                            กรุงไทย
                                          </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="minimal">
                                            เกียรตินาคิน
                                          </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="minimal">
                                            ไทยพาณิชย์
                                          </label>
                                    </div>
                                </div>
                                <div class="col-xs-6">
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="minimal">
                                            ธอส.
                                          </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="minimal">
                                            ออมสิน
                                          </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="minimal">
                                            TTB
                                          </label>
                                    </div>
                                    <div class="form-check-inline">

                                            <div class="form-check-inline">
                                                <div class="input-group">
                                                    <span class="input-group-addon" style="border: none;  padding: 0px 10px 0px 0px;">
                                                    <input type="checkbox" class="minimal">
                                                    </span>
                                                    <input type="text" style="" class="form-control" placeholder="อื่น ๆ ระบุ..">
                                                </div>
                                            </div>

                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="form-group">
                            <label>ข้อมูลลูกค้าเข้าชม</label>
                            <br>
                            <div class="row">
                                <div class="col-xs-6">
                                    <div class="form-check-inline">
                                        <label class="form-check-label">
                                            <input type="checkbox" class="minimal">
                                            ชมห้องตัวอย่าง
                                          </label>
                                    </div>
                                    <div class="form-check-inline">
                                        <div class="input-group">
                                            <span class="input-group-addon" style="border: none;  padding: 0px 10px 0px 0px;">
                                            <input type="checkbox" class="minimal">
                                            </span>
                                            <input type="text" style="" class="form-control" placeholder="พาชมห้อง ราคา">
                                        </div>
                                    </div>

                                </div>
                                <div class="col-xs-6">
                                    <label>ระบุเลขห้อง</label>
                                    <input type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>เอกสารจากลูกค้า</label>
                            <br>
                            <div class="row">
                                <div class="col-xs-12">

                                    <table width="100%">
                                        <tr>
                                            <td width="60%">
                                            <div class="form-check-inline">
                                                <div class="input-group tex-left">
                                                    <span class="input-group-addon" style="border: none;  padding: 0px 15px 0px 0px;">
                                                    <input type="checkbox" class="minimal">
                                                     สำเนาทะเบียนบ้าน
                                                    </span>


                                                </div>
                                            </div>
                                            </td>
                                            <td width="20%"><input type="number" class="form-control" placeholder=""></td>
                                            <td width="20%">&nbsp;&nbsp;ชุด</td>
                                        </tr>
                                        <tr>
                                            <td width="50%">
                                            <div class="form-check-inline">
                                                <div class="input-group">
                                                    <span class="input-group-addon" style="border: none;  padding: 0px 12px 0px 0px;">
                                                    <input type="checkbox" class="minimal">
                                                    สำเนาบัตรประชาชน
                                                    </span>


                                                </div>
                                            </div>
                                            </td>
                                            <td><input type="number" class="form-control" placeholder=""></td>
                                            <td>&nbsp;&nbsp;ชุด</td>
                                        </tr>
                                        <tr>
                                            <td width="50%">
                                            <div class="form-check-inline">
                                                <div class="input-group">
                                                    <span class="input-group-addon" style="border: none;  padding: 0px 0px 0px 0px;">
                                                    <input type="checkbox" class="minimal">
                                                    หนังสือรับรองเงินเดือน
                                                    </span>


                                                </div>
                                            </div>
                                            </td>
                                            <td><input type="number" class="form-control" placeholder=""></td>
                                            <td>&nbsp;&nbsp;ชุด</td>
                                        </tr>
                                        <tr>
                                            <td width="50%">
                                            <div class="form-check-inline">
                                                <div class="input-group">
                                                    <span class="input-group-addon" style="border: none;  padding: 0px 24px 0px 0px;">
                                                    <input type="checkbox" class="minimal">
                                                    เอกสาร Statement
                                                    </span>


                                                </div>
                                            </div>
                                            </td>
                                            <td><input type="number" class="form-control" placeholder=""></td>
                                            <td>&nbsp;&nbsp;ชุด</td>
                                        </tr>
                                        {{-- <tr>
                                            <td width="50%">
                                            <div class="form-check-inline">
                                                <div class="input-group">
                                                    <span class="input-group-addon" style="border: none;  padding: 0px 10px 0px 0px;">
                                                    <input type="checkbox" class="minimal">
                                                    </span>
                                                    <input type="text" style="width: 100%;" class="form-control" placeholder="อื่น ๆ ระบุ..">
                                                </div>
                                            </div>
                                        </td>
                                        <td><input type="number" class="form-control" placeholder=""></td>
                                        <td>&nbsp;&nbsp;ชุด</td>
                                        </tr> --}}
                                    </table>

                                </div>
                            </div>
                        </div>
                        <hr style=" border: 1px solid rgb(2, 116, 209);">
                        <div class="form-group">
                            <label>เจ้าหน้าที่โครงการ</label>
                            <select class="form-control select2" style="width: 100%;">
                            <option>เลือก</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label>ผู้ดูแลสายงาน</label>
                            <select class="form-control select2" style="width: 100%;">
                            <option>เลือก</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <label>ชื่อสายงาน</label>
                            <select class="form-control select2" style="width: 100%;">
                            <option>เลือก</option>

                            </select>
                        </div>
                        <div class="form-group">
                            <div class="row">
                                <div class="col-xs-6">
                                    <label>ชื่อ-นามสกุล (Sale)</label>
                                    <input type="text" class="form-control" placeholder="">
                                </div>
                                <div class="col-xs-6">
                                    <label>เบอร์ติดต่อ</label>
                                    <input type="text" class="form-control" placeholder="">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">

                                    <label>หมายเหตุ</label>
                                    <input type="text" class="form-control" placeholder="">
                        </div>
                        <div class="box-footer text-center">
                            <button type="submit" class="btn btn-primary ">บันทึก</button>
                            <button type="reset" class="btn btn-danger">เคลียร์</button>
                            </div>

                  </div>
                </div>
              </div>
              <!-- /.col -->
              <div class="col-md-8">
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
