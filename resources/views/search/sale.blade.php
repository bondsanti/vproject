@extends('layouts.app')

@section('content')
<section class="content-header">
    <h1>
        แดชบอร์ด
        <small>Dashboard</small>
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
    <div class="row">
        <div class="col-md-12">

            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                    - ถ้าสถานะการจอง <b><u>รับงานแล้ว</u></b> จะไม่สามารถ แก้ไข รายละเอียดการจองได้<br>
                    - จะคอนเฟริ์มนัดได้ สถานะการจองต้องเป็น <b><u>รับงานแล้ว</u></b><br>
                    - หากต้องการลบข้อมูลการจอง โปรดติดต่อ <b><u>แอดมิน</u></b> เจ้าหน้าที่โครงการ
            </div>

        <div class="box box-danger">
            <div class="box-header with-border">
              <h3 class="box-title">ค้นหาข้อมูล</h3>
            </div>
            <form action="{{route('main.search')}}" method="post">
                @csrf
            <div class="box-body">
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-3">
                            <label>โครงการ</label>
                            <select class="form-control select2" style="width: 100%;" name="project_id" autocomplete="off" >
                                <option value="">เลือก</option>
                                @foreach ($projects as $project)
                                <option value="{{$project->id}}">{{$project->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-xs-3">
                            <label>ประเภท</label>
                            <select class="form-control select2" style="width: 100%;" name="booking_title" autocomplete="off" >
                                <option value="">เลือก</option>
                                <option value="เยี่ยมโครงการ">เยี่ยมโครงการ</option>

                            </select>
                        </div>
                        <div class="col-xs-3">
                            <label>วันที่เริ่ม</label>
                            <input type="text" class="form-control pull-right" id="datepicker1" name="start_date" value="{{old('start_date')}}" autocomplete="off">
                        </div>
                        <div class="col-xs-3">
                            <label>วันที่สิ้นสุด</label>
                            <input type="text" class="form-control pull-right"  id="datepicker2" name="end_date" value="{{old('end_date')}}" autocomplete="off">
                            </div>

                    </div>
                </div>
                <div class="form-group">
                    <div class="row">
                        <div class="col-xs-3">
                            <label>สถานะ</label>
                            <select class="form-control" name="status" autocomplete="off" >
                                <option value="">เลือก</option>
                                <option value="0">รอรับงาน</option>
                                <option value="1">รับงานแล้ว</option>
                                <option value="2">จองสำเร็จ / รอเข้าเยี่ยม</option>
                                <option value="3">เยี่ยมชมเรียบร้อย</option>
                                <option value="4">ยกเลิก</option>
                                <option value="5">ยกเลิกอัตโนมัติ</option>


                            </select>
                        </div>
                        <div class="col-xs-3">
                            <label>ชื่อลูกค้า</label>
                            <input type="text" class="form-control" name="customer_name" value="{{old('customer_name')}}" autocomplete="off">
                        </div>
                        <div class="col-xs-3">
                            <label>สายงาน</label>
                            <select class="form-control select2" style="width: 100%;" name="subteam_id" autocomplete="off" >
                                <option value="">เลือก</option>
                                @foreach ($subTeams as $subTeam)
                                <option value="{{$subTeam->id}}">{{$subTeam->subteam_name}}</option>
                               @endforeach
                            </select>
                        </div>
                        <div class="col-xs-3">
                            <label>เจ้าหน้าทีโครงการ</label>
                            <select class="form-control select2" style="width: 100%;" name="emp_id" autocomplete="off" >
                                <option value="">เลือก</option>

                                @foreach ($dataEmps as $dataEmp)
                                 <option value="{{$dataEmp->user_ref[0]->id}}">{{$dataEmp->user_ref[0]->name_emp}}</option>
                                @endforeach

                            </select>
                            </div>

                    </div>
                </div>
            </div>
            <!-- /.box-body -->
            <div class="box-footer text-center">
                <button type="submit" class="btn btn-primary ">ค้นหา</button>
                <a href="{{route('main')}}" type="button" class="btn btn-danger">เคลียร์</a>
            </div>
            </form>
          </div>

          <!-- /.box -->
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
        <div class="box box-info box-solid">
            <div class="box-header">
                <h3 class="box-title">ตารางข้อมูลของคุณ <button id="exportBtn" class="btn btn-primary btn-sm">Export to Excel</button></h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>

            <div class="box-body ">
                <table id="table" class="table table-hover">
                    <thead>
                        <tr>

                            <th class="text-center">หมายเลขการจอง</th>
                            <th class="text-center">ประเภท</th>
                            <th class="text-center">โครงการ</th>
                            <th class="text-center">ลูกค้า</th>
                            <th class="text-center">ทีม/สายงาน</th>
                            <th class="text-center">เจ้าหน้าที่โครงการ</th>

                            <th class="text-center">สถานะ</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">

                        @foreach ( $bookings as  $booking)

                        <tr>
                            <td>
                                {{$booking->bkid}}
                            </td>
                            <td>
                                <p>
                                    {{$booking->booking_title}}
                                </p>
                            </td>
                            <td>
                                <a>{{$booking->booking_project_ref[0]->name}}</a>
                                <br />
                                <small>
                                    เวลานัด :{{date('d/m/Y',strtotime($booking->booking_start))}}
                                    {{date('H:i',strtotime($booking->booking_start))}}
                                    -
                                    {{date('H:i',strtotime($booking->booking_end))}}
                                    น.
                                </small>
                            </td>
                            <td>
                                <a>{{$booking->customer_name}}</a>
                                <br />
                                <small>
                                    {{$booking->customer_tel}}
                                </small>

                            </td>
                            <td>{{$booking->team_name}} / {{$booking->subteam_name}}</td>
                            <td class="project-state">
                                <a>{{$booking->booking_emp_ref[0]->name_th}}</a>
                                <br />
                                <small>
                                    {{$booking->user_tel}}
                                </small>

                            </td>

                            <td> @php
                                if($booking->booking_status==0){
                                     echo $textStatus="<span class=\"badge\" yle=\"background-color:#a6a6a6\">รอรับงาน</span>";
                                 }elseif($booking->booking_status==1){
                                     echo $textStatus="<span class=\"badge\" style=\"background-color:#f39c12\">รับงานแล้ว</span>";
                                 }elseif($booking->booking_status==2){
                                     echo $textStatus="<span class=\"badge\" style=\"background-color:#00c0ef\">จองสำเร็จ</span>";
                                 }elseif($booking->booking_status==3){
                                     echo $textStatus="<span class=\"badge\" style=\"background-color:#00a65a\">เยี่ยมชมเรียบร้อย</span>";
                                 }elseif($booking->booking_status==4){
                                     echo $textStatus="<span class=\"badge\" style=\"background-color:#dd4b39\">ยกเลิก</span>";
                                 }else{
                                     echo $textStatus="<span class=\"badge\" style=\"background-color:#b342f5\">ยกเลิกอัตโนมัติ</span>";
                                 }

                                 @endphp</td>
                            <td class="project-actions text-center">
                                <a class="btn btn-success btn-sm" target="_blank" href="{{url('/booking/print/'.$booking->bkid)}}">
                                    <i class="fa fa-print">
                                    </i>
                                    พิมพ์
                                </a>

                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-{{$booking->bkid}}">
                                    <i class="fa fa-folder">
                                    </i>
                                    รายละเอียด
                                  </button>
                                  @if ($booking->booking_title=="เยี่ยมโครงการ")
                                  @if ($booking->booking_status > 0)
                                      <button class="btn btn-default btn-sm" disabled>
                                          <i class="fa fa-pencil">
                                          </i>
                                          แก้ไข
                                      </button>
                                  @else
                                  <a class="btn btn-info btn-sm" href="{{url('/booking/edit/'.$booking->bkid)}}">
                                      <i class="fa fa-pencil">
                                      </i>
                                      แก้ไข
                                  </a>
                                  @endif

                                @endif
                                @if ($booking->booking_status > 1)

                                <button type="button" class="btn btn-default btn-sm" disabled>
                                    <i class="fa fa-refresh">
                                    </i>
                                    สถานะ
                                  </button>
                                  @else
                                  <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-status-{{$booking->bkid}}">
                                    <i class="fa fa-refresh">
                                    </i>
                                    สถานะ
                                  </button>
                                  @endif



                            </td>
                        </tr>

                        <div class="modal fade" id="modal-status-{{$booking->bkid}}">
                            <div class="modal-dialog modal-sm">
                            <form id="updateStatusForm" method="POST" name="updateStatusForm" class="form-horizontal" action="{{ route('booking.update.status') }}">
                                    @csrf
                                   @method('PUT')
                                    <input type="hidden" name="booking_id" id="booking_id" value="{{$booking->bkid}}">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title">อัพเดทสถานะ</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>สถานะการจอง</label>
                                        <select class="form-control" name="booking_status" id="my-dropdown" required>
                                            <option value="">เลือก</option>
                                        @if ($booking->booking_status == 1)
                                        <option value="2">คอนเฟิร์ม</option>
                                        @endif
                                        <option value="4">ยกเลิก</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <div id="my-element" style="display:none">
                                            <label>เลือกเหตุผลที่ยกเลิกการจอง</label>
                                        <select class="form-control" id="my-dropdown2" name="because_cancel_remark">
                                            <option value="">เลือก</option>
                                        {{-- <option value="ลูกค้าไม่สะดวกเข้าชมตามเวลานัดหมาย">ลูกค้าไม่สะดวกเข้าชมตามเวลานัดหมาย</option> --}}
                                        <option value="ลูกค้าเลื่อนเข้าชมวันอื่น">ลูกค้าเลื่อนเข้าชมวันอื่น</option>
                                        <option value="ลูกค้าแจ้งไม่สนใจโครงการนี้แล้ว">ลูกค้าแจ้งไม่สนใจโครงการนี้แล้ว</option>
                                        <option value="อื่นๆ">อื่น ๆ</option>
                                        </select>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <div id="my-element-text" style="display:none">

                                            <label>ระบุเหตุผลอื่น ๆ</label>

                                            <input type="text" class="form-control" name="because_cancel_other" id="because_cancel_other" value="">
                                        </div>

                                    </div>


                                </div>
                                <div class="modal-footer">

                                    <button type="submit" class="btn btn-success" id="">ตกลง</button>
                                    <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">ยกเลิก</button>
                                    {{-- <button type="reset" class="btn btn-danger btn-block">ล้าง</button> --}}
                                </div>
                                </form>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                        <!-- /.modal -->
                        <div class="modal fade" id="modal-{{$booking->bkid}}">
                            <div class="modal-dialog">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title">{{$booking->booking_title}}</h4>
                                </div>
                                <div class="modal-body">
                                    <dl class="dl-horizontal">
                                        <dt>โครงการ</dt>
                                        <dd><span class="badge bg-blue">{{$booking->booking_project_ref[0]->name}}</span></dd>
                                        <dt>วัน / เวลา</dt>
                                        <dd><span class="badge bg-yellow">{{date('d/m/Y',strtotime($booking->booking_start))}}</span>
                                            <span class="badge bg-yellow">{{date('H:i',strtotime($booking->booking_start))}}
                                            -
                                            {{date('H:i',strtotime($booking->booking_end))}}
                                            น.</span></dd>

                                        <dt>ลูกค้า</dt>
                                        <dd><strong>{{$booking->customer_name}} {{$booking->customer_tel}}</strong></dd>
                                        <dt>ข้อมูลเข้าชม</dt>
                                        <dd>
                                            {{$booking->customer_req}}
                                            @php
                                            if($booking->room_price > 0){
                                                echo number_format($booking->room_price).".-";
                                            }
                                            @endphp
                                        </dd>
                                        <dt>เลขห้อง</dt>
                                        <dd>

                                            @php
                                            if($booking->room_price!=null){
                                                echo $booking->room_no;
                                            }
                                            @endphp
                                        </dd>
                                        <dt>เอกสารขอกู้ธนาคาร</dt>
                                        <dd>
                                            {{$booking->customer_req_bank}}
                                        </dd>
                                        <dt>ฝากรับเอกสารลูกค้า</dt>
                                        <dd>
                                            @php
                                                if($booking->num_home > 0){
                                                    echo "สำเนาทะเบียนบาน <strong>".$booking->num_home."</strong>ชุด";
                                                }
                                            @endphp
                                        </dd>
                                        <dd>
                                            @php
                                                if($booking->num_idcard > 0){
                                                    echo "สำเนาบัตรประชาชน <strong>".$booking->num_idcard."</strong>ชุด";
                                                }
                                            @endphp
                                        </dd>
                                        <dd>
                                            @php
                                                if($booking->num_app_statement > 0){
                                                    echo "หนังสือรับรองเงินเดือน <strong>".$booking->num_app_statement."</strong>ชุด";
                                                }
                                            @endphp
                                        </dd>
                                        <dd>
                                            @php
                                                if($booking->num_statement > 0){
                                                    echo "เอกสาร Statement <strong>".$booking->num_statement."</strong>ชุด";
                                                }
                                            @endphp
                                        </dd>
                                        <dt>หมายเหตุ</dt>
                                        <dd>{{$booking->remark}}</dd>
                                    </dl>
                                    <dl  class="dl-horizontal">
                                        <hr>
                                    </dl>
                                    <dl  class="dl-horizontal">
                                        <dt>ทีม/สายงาน</dt>
                                        <dd><strong class="text-primary">{{$booking->team_name}}</strong> - {{$booking->subteam_name}}</dd>
                                        <dt>ชื่อ Sale</dt>
                                        <dd>{{$booking->booking_user_ref[0]->name_th}}, {{$booking->user_tel}} </dd>

                                        <dt>ทีม หน้าโครงการ</dt>
                                        <dd>{{$booking->booking_emp_ref[0]->name_th}}, {{$booking->booking_emp_ref[0]->phone}}</dd>

                                    </dl>
                                </div>

                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>
                          <!-- /.modal -->
                        @endforeach

                    </tbody>

                </table>
            </div>
        </div>
        </div>
    </div>


</section>
<!-- /.content -->
@endsection

@push('script')
<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $('#table').DataTable({
                'paging'      : true,
                'lengthChange': true,
                'searching'   : true,
                'ordering'    : false,
                'info'        : false,
                'autoWidth'   : false,
                "responsive": true,
                "buttons": ["excel"],
                'language': {
                    'buttons': {
                        'excel': 'Export to Excel'
                    }
                }
            });
            $('#exportBtn').on('click', function() {
                $('#table').DataTable().button('.buttons-excel').trigger();
            });
        $("#my-dropdown").change(function () {
        const result = $("#my-dropdown").val();
        //console.log(v);
        if (result == '4') {
            $("#my-element").show();
        } else {
            $("#my-element").hide();
        }

        });
        $("#my-dropdown2").change(function () {
        const result2 = $("#my-dropdown2").val();
            //console.log(result2);
            if (result2 == 'อื่นๆ') {
                $("#my-element-text").show();

            } else {

                $("#my-element-text").hide();
            }
        });
    });
  </script>
  @endpush
