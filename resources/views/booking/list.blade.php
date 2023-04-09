@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            จัดการข้อมูลการจอง
            <small>Bookings management</small>
        </h1>
        {{-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol> --}}
    </section>


    <!-- Main content -->
    <section class="content">
        {{-- <div class="row">
            <div class="col-md-12">
            <div class="box box-danger">
                <div class="box-header with-border">
                  <h3 class="box-title">ค้นหาข้อมูล</h3>
                </div>
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

                                </select>
                            </div>
                            <div class="col-xs-3">
                                <label>วันที่เริ่ม</label>
                            <input type="text" class="form-control" placeholder="">
                            </div>
                            <div class="col-xs-3">
                                <label>วันที่สิ้นสุด</label>
                                <input type="text" class="form-control" placeholder="">
                                </div>

                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-3">
                                <label>สถานะ</label>
                                <select class="form-control" name="project_id" autocomplete="off" >
                                    <option value="">เลือก</option>
                                    <option value="0">รอรับงาน</option>
                                    <option value="1">รับงานแล้ว</option>
                                    <option value="2">จองสำเร็จ / รอเข้าเยี่ยม</option>
                                    <option value="3">เยี่ยมชมเรียบร้อย</option>
                                    <option value="4">ยกเลิก</option>
                                    <option value="4">ยกเลิกอัตโนมัติ</option>


                                </select>
                            </div>
                            <div class="col-xs-3">
                                <label>ชื่อลูกค้า</label>
                                <input type="text" class="form-control" placeholder="">
                            </div>
                            <div class="col-xs-3">
                                <label>ชื่อ Sale</label>
                            <input type="text" class="form-control" placeholder="">
                            </div>
                            <div class="col-xs-3">
                                <label>ชื่อเจ้าหน้าทีโครงการ</label>
                                <input type="text" class="form-control" placeholder="">
                                </div>

                        </div>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer text-center">
                    <button type="submit" class="btn btn-primary ">ค้นหา</button>
                    <button type="reset" class="btn btn-danger">เคลียร์</button>
                  </div>
              </div>
              <!-- /.box -->
            </div>
        </div> --}}

        <!-- table boxes -->
        <div class="row">
            <!-- /.col -->

            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            ตารางข้อมูล
                        </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="table" style="width:100%" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    {{-- <th class="text-center"><button id="print-button" onclick="printChecked()">Print</button></th> --}}
                                    <th class="text-center">#</th>
                                    <th class="text-center">ประเภท</th>
                                    <th class="text-center">โครงการ</th>
                                    <th class="text-center">ลูกค้า</th>
                                    {{-- <th class="text-center">ทีม</th> --}}
                                    {{-- <th class="text-center">เจ้าหน้าที่โครงการ </th> --}}
                                    {{-- <th class="text-center">ผู้จอง </th> --}}
                                    <th class="text-center">สถานะ</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">

                                @foreach ( $bookings as  $booking)

                                @php

                                        // $data1 = $booking->customer_doc_personal;
                                        // $data2 = [$booking->num_home,$booking->num_idcard,$booking->num_app_statement,$booking->num_statement];

                                        // $doc_personal = array_combine(explode(',', $data1), $data2);

                                        // $data1_array = explode(',', $data1);
                                        // $data2_array = explode(',', $data2);

                                        // $data_array = array_combine($data1_array, $data2_array);
                                        // $result = [];
                                        // foreach ($data_array as $key => $value) {
                                        // array_push($result, "{$key}({$value})");
                                        // }


                                @endphp


                                <tr>
                                    {{-- <td>
                                        <input type="checkbox" name="select[]" value="{{ $loop->index+1 }}">
                                    </td> --}}
                                    <td>
                                        {{$booking->id}}
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
                                        <a><strong>{{$booking->customer_name}}</strong></a>
                                        <br />
                                        <small>
                                            {{$booking->customer_tel}}
                                        </small>

                                    </td>

                                    <td class="project-state">
                                        @php
                                       if($booking->booking_status==0){
                                            echo $textStatus="<span class=\"badge\" yle=\"background-color:#a6a6a6\">รอรับงาน</span>";
                                        }elseif($booking->booking_status==1){
                                            echo $textStatus="<span class=\"badge\" style=\"background-color:#3c8dbc\">รับงานแล้ว</span>";
                                        }elseif($booking->booking_status==2){
                                            echo $textStatus="<span class=\"badge\" style=\"background-color:#00a65a\">จองสำเร็จ</span>";
                                        }elseif($booking->booking_status==3){
                                            echo $textStatus="<span class=\"badge\" style=\"background-color:#00a65a\">เยี่ยมชมเรียบร้อย</span>";
                                        }elseif($booking->booking_status==4){
                                            echo $textStatus="<span class=\"badge\" style=\"background-color:#cc2d2d\">ยกเลิก</span>";
                                        }else{
                                            echo $textStatus="<span class=\"badge\" style=\"background-color:#b342f5\">ยกเลิกอัตโนมัติ</span>";
                                        }

                                        @endphp

                                    </td>
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
                                          <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-status-{{$booking->bkid}}">
                                            <i class="fa fa-refresh">
                                            </i>
                                            สถานะ
                                          </button>
                                          @if ($booking->booking_title=="เยี่ยมโครงการ")

                                            <a class="btn btn-info btn-sm" href="{{url('/booking/edit/'.$booking->bkid)}}">
                                                <i class="fa fa-pencil">
                                                </i>
                                                แก้ไข
                                            </a>


                                          @endif
                                          @if ($booking->booking_title=="ประเมินห้องชุด")
                                          <a class="btn btn-info btn-sm" href="">
                                            <i class="fa fa-pencil">
                                            </i>
                                            แก้ไข
                                         </a>
                                          @endif
                                          @if ($booking->booking_title=="ตรวจDF/รับมอบห้อง")
                                          <a class="btn btn-info btn-sm" href="">
                                            <i class="fa fa-pencil">
                                            </i>
                                            แก้ไข
                                         </a>
                                          @endif

                                        <button class="btn btn-danger btn-sm delete-item" data-id="{{$booking->bkid}}">
                                            <i class="fa fa-trash">
                                            </i>
                                            ลบ
                                        </button>


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
                                                    @if ($booking->booking_status <=0)
                                                    <option value="0" {{ $booking->booking_status == 0 ? 'selected' : '' }}>รอรับงาน</option>
                                                    @endif

                                                <option value="1" {{ $booking->booking_status == 1 ? 'selected' : '' }}>รับงานแล้ว</option>
                                                <option value="4" {{ $booking->booking_status == 4 ? 'selected' : '' }}>ยกเลิก</option>
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

                                                    <input type="text" name="because_cancel_other" id="because_cancel_other" value="">
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
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

            </div>
            <!-- /.col -->


        </div>
        <!-- /.row -->


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
                'autoWidth'   : true
            })

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
            console.log(result2);
            if (result2 == 'อื่นๆ') {
                $("#my-element-text").show();

            } else {

                $("#my-element-text").hide();
            }
        });
        //Delete
        $(document).on('click', '.delete-item', function() {
            let id = $(this).data('id');
            //console.log(id);
            Swal.fire({
                title: 'คุณแน่ใจไหม?',
                text: 'หากต้องการลบข้อมูลนี้ โปรดยืนยัน การลบข้อมูล',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'ยกเลิก',
                confirmButtonText: 'ยืนยัน'
            }).then(function(result) {
                if (result.isConfirmed) {
                    var url = '{{ route("booking.del", ":id") }}';
                    //console.log(url);
                    url = url.replace(':id', id);
                    //console.log(url);
                    $.ajax({
                        url: url,
                        type: 'DELETE',
                        data: {
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            window.location.href = '{{ route("listBooking") }}';
                            Swal.fire({
                                title: 'สำเร็จ!',
                                text: 'ลบข้อมูลเรียบร้อย..',
                                icon: 'success'
                            });
                            //table.draw();

                        },
                        error: function() {
                            window.location.href = '{{ route("listBooking") }}';
                            Swal.fire({
                                title: 'Oops...',
                                text: 'มีบางอย่างผิดพลาด!',
                                icon: 'error'
                            });
                            //table.draw();

                        }
                    });
                }


            });
        });







    </script>
@endpush
