@extends('layouts.app')

@section('content')

<style>
    .rating {
  font-size: 40px;
}

.star {
  color: #b7b59c;
  cursor: pointer;
}

.star:hover,
.star:hover ~ .star {
  color: #f8e825;
}

.star.active {
  color: #f8e825;
}

    </style>
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
        <div class="box box-info box-solid">
            <div class="box-header">
                <h3 class="box-title">ตารางข้อมูลของคุณ</h3>
                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                </div>
            </div>

            <div class="box-body table-responsive">
                <table id="table" class="table table-hover">
                    <thead>
                        <tr>

                            <th class="text-center">หมายเลขการจอง</th>
                            <th class="text-center">ประเภท</th>
                            <th class="text-center">โครงการ</th>
                            <th class="text-center">ลูกค้า</th>
                            <th class="text-center">ชื่อ Sale</th>

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

                            <td class="project-state">
                                <a>{{$booking->booking_user_ref[0]->name_th}}</a>
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

                                 @endphp
                                   @if ($booking->job_detailsubmission!=null)
                                   <span class="badge" style="background-color:#00a65a">ส่งงานเรียบร้อย</span>
                                   @endif
                                </td>

                            <td class="project-actions text-center">
                                @if ($booking->booking_status < 2)
                                <a class="btn btn-success btn-sm" target="_blank" href="{{url('/booking/print/'.$booking->bkid)}}">
                                    <i class="fa fa-print">
                                    </i>
                                    พิมพ์
                                </a>
                                @endif
                                <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-{{$booking->bkid}}">
                                    <i class="fa fa-folder">
                                    </i>
                                    รายละเอียด
                                  </button>
                                  @if ($booking->booking_status <= 2)

                                  <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modal-status-{{$booking->bkid}}">
                                    <i class="fa fa-refresh">
                                    </i>
                                    สถานะ
                                  </button>

                                  @endif
                                  @if ($booking->booking_status == 3)

                                  <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#modal-update-{{$booking->bkid}}">
                                    <i class="fa fa-picture-o">
                                    </i>
                                    ส่งงาน
                                  </button>
                                  {{-- <button  data-id="{{$booking->bkid}}" data-original-title="Edit" class="btn btn-success btn-sm closejob"><i class="fa fa-picture-o"></i> ส่งงาน</button> --}}
                                  @if ($booking->job_score==null)
                                  <button type="button" class="btn bg-maroon btn-sm" data-toggle="modal" data-target="#modal-score-{{$booking->bkid}}">
                                    <i class="fa fa-star-o">
                                    </i>
                                    คะแนนความพึงพอใจ
                                  </button>
                                  @endif
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
                                        @if ($booking->booking_status == 0)
                                        <option value="1">รับงาน</option>
                                        @endif
                                        @if ($booking->booking_status == 2)
                                        <option value="3">เยี่ยมชมเรียบร้อย</option>
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
                        <!-- Aj -->
                        <div class="modal fade" id="modal-update-{{$booking->bkid}}">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="">ส่งงาน</h4>
                                    </div>
                                    <div class="modal-body">
                                        <!-- form start -->
                                        <form id="FormEdit" name="FormEdit" action="{{ route('booking.update.job') }}" class="form-horizontal" enctype="multipart/form-data">
                                            @csrf
                                            <input type="hidden" name="id" id="id" value="{{$booking->bkid}}">
                                            <div class="box-body">

                                                <div class="form-group">
                                                    <label>รายละเอียดรับลูกค้า</label>
                                                    <textarea class="form-control" rows="3" id="job_detailsubmission" name="job_detailsubmission" placeholder="" autocomplete="off" required></textarea>
                                                </div>
                                                <div class="form-group">
                                                    <label for="image">เลือกรูป</label>
                                                    <input type="file" class="form-control" name="job_img" id="job_img" onchange="previewImage(this);" accept="image/*" required>

                                                    <img id="preview" src="#" alt="Image preview" style="display:none;" width="150px">

                                                </div>

                                            </div>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="submit" class="btn btn-success btn-block" id="update" >ตกลง</button>
                                    </div>
                                    </form>
                                </div>
                                <!-- /.modal-content -->
                                </div>
                                <!-- /.modal-dialog -->

                        </div>

                        <div class="modal fade" id="modal-score-{{$booking->bkid}}">
                            <div class="modal-dialog modal-sm">
                            <form id="updateScoreForm" method="POST" name="updateScoreForm" class="form-horizontal" action="{{ route('booking.update.status') }}">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="booking_id" id="booking_id" value="{{$booking->bkid}}">
                              <div class="modal-content">
                                <div class="modal-header">
                                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span></button>
                                  <h4 class="modal-title">คะแนนความพึงพอใจ</h4>
                                </div>
                                <div class="modal-body">
                                    <div class="form-group">
                                        <label>เลือก ระดับความพึ่งพอใจ</label>
                                        <div class="rating text-center">
                                          <span class="star" data-value="1">&#9733;</span>
                                          <span class="star" data-value="2">&#9733;</span>
                                          <span class="star" data-value="3">&#9733;</span>
                                          <span class="star" data-value="4">&#9733;</span>
                                          <span class="star" data-value="5">&#9733;</span>
                                        </div>
                                      </div>

                                </div>
                                <div class="modal-footer">

                                    <button type="submit" class="btn btn-success btn-block" id="">ตกลง</button>

                                </div>
                                </form>
                              </div>
                              <!-- /.modal-content -->
                            </div>
                            <!-- /.modal-dialog -->
                        </div>

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
        // รอการกดปุ่ม "ตกลง" ใน modal
        $('#updateScoreForm').submit(function(e) {
            e.preventDefault(); // หยุดการ submit แบบปกติ

            var formData = $(this).serialize(); // ดึงข้อมูลฟอร์มทั้งหมดเป็น object
            formData += '&rating=' + $('.rating .star.active').data('value'); // เพิ่มค่า rating เข้าไปใน object formData

            // ส่งข้อมูลผ่าน AJAX
            $.ajax({
                url: $(this).attr('action'),
                type: $(this).attr('method'),
                data: formData,
                success: function(response) {
                    console.log(response); // แสดงข้อมูลตอบกลับจากเซิร์ฟเวอร์ (สามารถใช้ response ทำอะไรต่อได้ตามต้องการ)
                    $('#modal-score-' + response.booking_id).modal('hide'); // ปิด modal
                },
                error: function(error) {
                    console.log(error); // แสดง error (สามารถ debug ได้)
                }
            });
        });

        // เมื่อผู้ใช้กดคะแนนใน modal
        $('.rating .star').click(function() {
            $(this).addClass('active').prevAll('.star').addClass('active'); // เพิ่ม class active ให้กับคะแนนที่ถูกคลิกและคะแนนก่อนหน้านั้น
            $(this).nextAll('.star').removeClass('active'); // ลบ class active ออกจากคะแนนถัดไป
        });
    });
    </script>

<script>
    $(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
// // เมื่อผู้ใช้คลิกดาวใดดาวหนึ่ง
//     const stars = document.querySelectorAll('.rating .star');
//     stars.forEach(star => {
//     star.addEventListener('click', () => {
//         // เก็บค่า data-value ของดาวที่ผู้ใช้คลิก
//         const ratingValue = star.getAttribute('data-value');

//         // ส่งค่า ratingValue ไปยังเว็บเซอร์วิสด้วย AJAX
//         const xhr = new XMLHttpRequest();
//         xhr.open('POST', '/api/ratings', true);
//         xhr.setRequestHeader('Content-type', 'application/json');
//         xhr.onreadystatechange = () => {
//         if (xhr.readyState === 4 && xhr.status === 200) {
//             console.log('คะแนนถูกบันทึกแล้ว');
//         }
//         };
//         xhr.send(JSON.stringify({ rating: ratingValue }));
//     });
//     });

    $('#table').DataTable({
    'paging'      : true,
    'searching'   : true,
    'ordering'    : false
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
    function previewImage(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#preview').attr('src', e.target.result);
                $('#preview').show();
            }
            reader.readAsDataURL(input.files[0]);
        }
    }
    $('#image').change(function(){
        previewImage(this);
    });

    // $('body').on('click', '.closejob', function () {

    // const id = $(this).data('id');
    //     //console.log(id);
    //     $('#modal-update').modal('show');

    //     $.get("/booking/showJob" +'/' + id , function (data) {
    //         //console.log(data);
    //     $('#id').val(data.id);
    //     $('#job_detailsubmission').val(data.job_detailsubmission);
    //     $('#job_img').val(data.job_img);
    //     });
    // });

    // $('#update').click(function(e) {
    //             e.preventDefault();
    //             $(this).html('รอสักครู่..');
    //             const _token = $("input[name='_token']").val();
    //             const id = $("#id").val();
    //             const job_detailsubmission= $("#job_detailsubmission").val();
    //             const job_img= $("#job_img").val();
    //             console.log(id);

    //             $.ajax({
    //                 data: $('#FormEdit').serialize(),
    //                 url: "/booking/showJob/update/"+id,
    //                 type: "POST",
    //                 dataType: 'json',

    //                 success: function(data) {
    //                     //console.log(data);
    //                     if (data.success = true) {

    //                         if ($.isEmptyObject(data.error)) {
    //                             Swal.fire({

    //                                 icon: 'success',
    //                                 title: 'แก้ไขข้อมูลสำเร็จ!',
    //                                 showConfirmButton: true,
    //                                 timer: 2500
    //                             });
    //                             $('#FormEdit').trigger("reset");
    //                             $('#modal-update').modal('hide');
    //                             //tableUser.draw();
    //                             window.location.href = '{{ route("main") }}';
    //                         } else {

    //                             $('#update').html('ลองอีกครั้ง');

    //                             //$('#userFormEdit').trigger("reset");
    //                             Swal.fire({
    //                                 position: 'top-center',
    //                                 icon: 'error',
    //                                 title: 'เกิดข้อผิดพลาด',
    //                                 showConfirmButton: true,
    //                                 timer: 2500
    //                             });
    //                         }

    //                     } else {
    //                         Swal.fire({
    //                             position: 'top-center',
    //                             icon: 'error',
    //                             title: 'เพิ่มข้อมูลสำเร็จ!',
    //                             showConfirmButton: true,
    //                             timer: 2500
    //                         });
    //                         $('#FormEdit').trigger("reset");
    //                     }


    //                 },

    //             });
    // });
  </script>
  @endpush
