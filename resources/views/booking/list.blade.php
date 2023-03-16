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
                                    <td>
                                        {{ $loop->index+1 }}
                                    </td>
                                    <td>
                                        <p>
                                            {{$booking->booking_title}}
                                        </p>
                                    </td>
                                    <td>
                                        <a>{{$booking->project_name}}</a>
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
                                        <p> <strong>{{$booking->customer_name}}</strong></p>
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
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-{{$booking->id}}">
                                            <i class="fa fa-folder">
                                            </i>
                                            View
                                          </button>

                                        <a class="btn btn-info btn-sm" href="#">
                                            <i class="fa fa-pencil">
                                            </i>
                                            Edit
                                        </a>
                                        <a class="btn btn-danger btn-sm" href="#">
                                            <i class="fa fa-trash">
                                            </i>
                                            Delete
                                        </a>
                                    </td>
                                </tr>

                                <div class="modal fade" id="modal-{{$booking->id}}">
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
                                                <dd><span class="badge bg-blue">{{$booking->project_name}}</span></dd>
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
                                            </dl>
                                            <dl  class="dl-horizontal">
                                                <hr>
                                            </dl>
                                            <dl  class="dl-horizontal">
                                                <dt>ทีม ขาย</dt>
                                                <dd><strong class="text-primary">{{$booking->team_name}}</strong> - {{$booking->subteam_name}}</dd>
                                                <dt>เบอร์ Sale</dt>
                                                <dd>{{$booking->user_tel}} </dd>

                                                <dt>ทีม หน้าโครงการ</dt>
                                                <dd>{{$booking->emp_name}} </dd>
                                                <dt>เบอร์เจ้าหน้าที่ โครงการ</dt>
                                                <dd>{{$booking->tel}} </dd>
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
                'lengthChange': false,
                'searching'   : false,
                'ordering'    : true,
                'info'        : true,
                'autoWidth'   : false
            })

            $('body').on('click', '.deleteUser', function() {

                const user_id = $(this).data("id");

                //confirm("Are You sure want to delete this Post!");
                Swal.fire({
                    title: 'คุณแน่ใจไหม? ',
                    text: "หากต้องการลบข้อมูลนี้ โปรดยืนยัน การลบข้อมูล",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'ยกเลิก',
                    confirmButtonText: 'ยืนยัน'
                }).then((result) => {

                    if (result.isConfirmed) {
                        $.ajax({
                            type: "DELETE",
                            url: "user" + '/' + user_id,

                            success: function(data) {
                                tableUser.draw();
                            },
                            error: function(data) {
                                //console.log('Error:', data);
                            }
                        });
                        Swal.fire(
                            'สำเร็จ!',
                            'ลบข้อมูลเรียบร้อย..',
                            'success'
                        )
                    }
                });

            });

        });
    </script>
@endpush
