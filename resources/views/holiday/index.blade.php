@extends('layouts.app')

@section('content')
@push('styles')

<style>
.my-event {
  padding: 7px;
  cursor: pointer;
}
.fc-time {
  display: none;
}



</style>

    <section class="content-header">
        <h1>
            ปฏิทินวันหยุด
            <small>
                Holiday Calendar</small>
        </h1>
        {{-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol> --}}
    </section>
    @include('sweetalert::alert')

    <!-- Main content -->
    <section class="content">

        <!-- Info boxes -->
        <div class="row">
              <!-- /.col -->
              <div class="col-md-4 col-xs-12">
                <div class="box box-primary">
                        <div class="box-header with-border">
                        <h3 class="box-title">ลงวันหยุด</h3>
                        </div>
                        <div class="box-body">
                            <form id="addForm">
                                @csrf
                                <input type="hidden" name="id" id="id">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label>วันที่เริ่ม:</label>
                                            <div class="input-group date">
                                            <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right" id="datepicker1" name="start_date" autocomplete="off" required>

                                        </div>
                                        <small class="text-danger mt-1 start_date_err"></small>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-group">
                                            <label>วันที่สิ้นสุด:</label>
                                            <div class="input-group date">
                                            <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right" id="datepicker2" name="end_date" autocomplete="off" required>

                                            </div>
                                            <small class="text-danger mt-1 end_date_err"></small>
                                        </div>
                                    </div>

                                </div>

                                <div class="form-group">

                                    <label>หมายเหตุ</label>
                                    <textarea class="form-control" rows="3" id="remark" name="remark" placeholder="ถ้ามี ..." autocomplete="off"></textarea>
                                </div>

                                <div class="box-footer text-center">
                                    <button type="submit" class="btn btn-primary" id="savedata">บันทึก</button>
                                    <button type="reset" class="btn btn-danger">เคลียร์</button>
                                </div>
                            </form>
                        </div>
                </div>

                <div class="box box-primary">

                    <div class="box-body">

                        <table id="table" class="table table-condensed">
                            <thead>
                            <tr>
                            <th>#</th>
                            <th>ชื่อ-สกุล</th>
                            <th>Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ( $holidays as $holiday)


                            <tr>
                            <td>{{ $loop->index+1 }}</td>
                            <td>{{$holiday->user_ref->name_th}}</td>

                            <td>
                               @if ($dataRoleUser->role_type == "Admin" || $dataRoleUser->role_type == "HeadStaff")
                               @if ($holiday->status=="0")
                                <button type="button" data-id="{{$holiday->id}}"  data-original-title="Update" class="btn btn-warning btn-xs updateStatus">
                                    <i class="fa fa-refresh">
                                    </i>
                                    สถานะ
                                  </button>
                                  @endif
                                @endif
                                @if ($holiday->status=="0")
                                <button  data-id="{{$holiday->id}}" data-original-title="Edit" class="btn btn-primary btn-xs updateData"><i class="fa fa-pencil"></i> แก้ไข</button>
                                <button class="btn btn-danger btn-xs delete-item" data-id="{{$holiday->id}}">
                                <i class="fa fa-trash">
                                </i>
                                ลบ
                                </button>
                                @endif
                            </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

              </div>
              <div class="col-md-8 col-xs-12">
                <div class="box box-primary">
                  <div class="box-body no-padding">
                    <h5>
                        &nbsp;&nbsp;สถานะ <span class="label label-default">รออนุมัติ</span>
                        &nbsp;<span class="label label-success">อนุมัติแล้ว</span>
                        &nbsp;<span class="label label-danger">ยกเลิก/ไม่อนุมัติ</span>
                    </h5>
                    <div id="calendar"></div>
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

    <div class="modal fade" id="updateStatus">
        <div class="modal-dialog modal-sm">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">อนุมัติ?</h4>
            </div>
            <form id="updateForm" name="updateForm" class="form-horizontal">
                @csrf
                <input type="hidden" name="id" id="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="" class="col-sm-4 control-label">สถานะ</label>
                        <div class="col-sm-6">
                        <select class="form-control select2" style="width: 100%;" id="status" name="status" autocomplete="off">
                        <option value="">เลือก</option>
                        <option value="0">รออนุมัติ</option>
                        <option value="1">อนุมัติ</option>
                        <option value="2">ไม่อนุมัติ</option>
                        </select>
                        <small class="text-danger mt-1 status_err"></small>
                        </div>
                    </div>

                </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">ออก</button>
              <button type="button" class="btn btn-primary" id="updatestatus">บันทึก</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="updateData">
        <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">แก้ไขวันหยุด</h4>
            </div>
            <form id="updateDataForm" name="updateDataForm">
                @csrf
                <input type="hidden" name="id_edit" id="id_edit">
                <div class="modal-body">

                    <div class="row">
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label>วันที่เริ่ม:</label>
                                <div class="input-group date">
                                <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="datepicker1_e" name="start_date_edit" autocomplete="off" required>

                            </div>
                            <small class="text-danger mt-1 start_dateedit_err"></small>
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div class="form-group">
                                <label>วันที่สิ้นสุด:</label>
                                <div class="input-group date">
                                <div class="input-group-addon">
                                <i class="fa fa-calendar"></i>
                                </div>
                                <input type="text" class="form-control pull-right" id="datepicker2_e" name="end_date_edit" autocomplete="off" required>

                                </div>
                                <small class="text-danger mt-1 end_dateedit_err"></small>
                            </div>
                        </div>

                    </div>

                    <div class="form-group">

                        <label>หมายเหตุ</label>
                        <textarea class="form-control" rows="3" id="remark_edit" name="remark_edit" placeholder="ถ้ามี ..." autocomplete="off"></textarea>
                    </div>
                </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">ออก</button>
              <button type="button" class="btn btn-primary" id="updatedata">บันทึก</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@endsection
@push('script')


<script>
    $('#table').DataTable({
        'paging'      : true,
        'lengthChange': true,
        'searching'   : false,
        'ordering'    : false,
         'info'        : false,
         'autoWidth'   : true
    })
    $('#datepicker1').datepicker({
        format:'yyyy-mm-dd',
        autoclose: true,
        startDate: new Date(), // sets the minimum date to today
        datesDisabled: [new Date()], // disables today's date in the datepicker
        todayHighlight: true, // highlights today's date in the datepicker
    }).on('changeDate', function(selected){
        var minDate = new Date(selected.date.valueOf());
        var maxDate = new Date(minDate.getFullYear(), minDate.getMonth(), minDate.getDate()+3);
        $('#datepicker2').datepicker('setStartDate', minDate);
        $('#datepicker2').datepicker('setEndDate', maxDate);
    });

    $('#datepicker1_e').datepicker({
        format:'yyyy-mm-dd',
        autoclose: true,
        startDate: new Date(), // sets the minimum date to today
        datesDisabled: [new Date()], // disables today's date in the datepicker
        todayHighlight: true, // highlights today's date in the datepicker
    });


    $('#datepicker2').datepicker({
        format:'yyyy-mm-dd',
        autoclose: true,
        startDate: new Date(), // sets the minimum date to today
        datesDisabled: [new Date()], // disables today's date in the datepicker
        todayHighlight: true, // highlights today's date in the datepicker
    }).on('show', function(){
        var minDate = $('#datepicker1').val();
        if(minDate){
            minDate = new Date(minDate);
            var maxDate = new Date(minDate.getFullYear(), minDate.getMonth(), minDate.getDate()+3);
            $(this).datepicker('setStartDate', minDate);
            $(this).datepicker('setEndDate', maxDate);
        }
    });

    $('#datepicker2_e').datepicker({
        format:'yyyy-mm-dd',
        autoclose: true,
        startDate: new Date(), // sets the minimum date to today
        datesDisabled: [new Date()], // disables today's date in the datepicker
        todayHighlight: true, // highlights today's date in the datepicker
    });
</script>

<script>
        $(document).ready(function() {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $('#savedata').click(function(e) {
                    e.preventDefault();
                    $(this).html('รอสักครู่..');
                    const _token = $("input[name='_token']").val();
                    const start_date = $("#datepicker1").val();
                    const end_date = $("#datepicker2").val();
                    const remark = $("#remark").val();
                    //console.log(start_date);
                    $.ajax({
                        data: $('#addForm').serialize(),
                        url: "{{ route('holiday.insert') }}",
                        type: "POST",
                        dataType: 'json',

                        success: function(data) {
                            //console.log(data)
                            if (data.success = true) {

                                if ($.isEmptyObject(data.error)) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: data.message,
                                        showConfirmButton: true,
                                        timer: 1500
                                    });

                                    $('#addForm')[0].reset();

                                    setTimeout("location.href = '{{ route("holiday") }}';",1500);

                                } else {
                                    printErrorMsg(data.error);
                                    $('#savedata').html('ลองอีกครั้ง');
                                    $('.start_date_err').text(data.error.start_date);
                                    $('.end_date_err').text(data.error.end_date);
                                    $('#addForm').trigger("reset");

                                    Swal.fire({
                                        position: 'top-center',
                                        icon: 'error',
                                        title: data.message,
                                        showConfirmButton: true,
                                        timer: 1300
                                    });
                                }

                            } else {
                                Swal.fire({
                                    position: 'top-center',
                                    icon: 'error',
                                    title: 'เกิดข้อผิดพลาด!',
                                    showConfirmButton: true,
                                    timer: 1300
                                });
                                $('#addForm')[0].reset();
                            }


                        },

                    });

                });

                //updateStatus
                $('body').on('click', '.updateStatus', function () {

                    const id = $(this).data('id');
                    $('#updateStatus').modal('show');
                    $.get("holiday" +'/' + id , function (data) {

                    //console.log(data);
                    $('#id').val(data.id);
                    $('#status option[value="'+data.status+'"]').prop('selected', true);

                    });
                });

                $('#updatestatus').click(function(e) {
                    e.preventDefault();
                    $(this).html('รอสักครู่..');
                    const _token = $("input[name='_token']").val();
                    const id = $("#id").val();
                    const status= $("#status").val();

                    $.ajax({
                        data: $('#updateForm').serialize(),
                        url: "/holiday/update_status"+'/'+id,
                        type: "POST",
                        dataType: 'json',

                        success: function(data) {
                            //console.log(url);
                            if (data.success = true) {

                                if ($.isEmptyObject(data.error)) {
                                    Swal.fire({

                                        icon: 'success',
                                        title: data.message,
                                        showConfirmButton: true,
                                        timer: 1500
                                    });
                                    $('#updateForm').trigger("reset");
                                    $('#updateStatus').modal('hide');
                                    //tableUser.draw();
                                    setTimeout("location.href = '{{ route("holiday") }}';",1500);
                                } else {
                                    printErrorMsg2(data.error);
                                    $('.status_err').text(data.error.status);
                                    $('#updateForm').trigger("reset");
                                    $('#updatestatus').html('ลองอีกครั้ง');
                                    Swal.fire({
                                        position: 'top-center',
                                        icon: 'error',
                                        title: "เกิดข้อผิดพลาด",
                                        showConfirmButton: true,
                                        timer: 1500
                                    });
                                }

                            } else {
                                Swal.fire({
                                    position: 'top-center',
                                    icon: 'error',
                                    title: 'เพิ่มข้อมูลสำเร็จ!',
                                    showConfirmButton: true,
                                    timer: 1300
                                });
                                $('#userFormEdit').trigger("reset");
                                $('#updateStatus').modal('hide');
                            }


                        },

                    });
                });


                $('body').on('click', '.updateData', function () {

                    const id = $(this).data('id');
                    $('#updateData').modal('show');
                    $.get("holiday" +'/' + id , function (data) {

                    //console.log(data);
                    $('#id_edit').val(data.id);
                    $('#datepicker1_e').val(data.start_date);
                    $('#datepicker2_e').val(data.end_date);
                    $('#remark_edit').val(data.remark);

                    });
                });

                $('#updatedata').click(function(e) {
                    e.preventDefault();
                    $(this).html('รอสักครู่..');
                    const _token = $("input[name='_token']").val();
                    // const id_edit = $("#id_edit").val();
                    const start_date_edit = $("#datepicker1_e").val();
                    const end_date_edit = $("#datepicker2_e").val();
                    const remark_edit = $("#remark_edit").val();
                    //console.log(start_date_edit);

                    $.ajax({
                    data: $('#updateDataForm').serialize(),
                    url: "holiday/update"+'/'+id,
                    type: "POST",
                    dataType: 'json',

                    success: function(data) {
                        //console.log(data);
                        if (data.success = true) {

                            if ($.isEmptyObject(data.error)) {
                                Swal.fire({

                                    icon: 'success',
                                    title: 'แก้ไขข้อมูลสำเร็จ!',
                                    showConfirmButton: true,
                                    timer: 1300
                                });
                                $('#updateData').trigger("reset");
                                $('#updateData').modal('hide');
                                //tableUser.draw();
                                setTimeout("location.href = '{{ route("holiday") }}';",1300);
                            } else {
                                printErrorMsg2(data.error);
                                $('.start_dateedit_err').text(data.error.start_date_edit);
                                $('.end_dateedit_err').text(data.error.end_date_edit);
                                $('#updateData').trigger("reset");
                                $('#updatedata').html('ลองอีกครั้ง');

                                //$('#userFormEdit').trigger("reset");
                                Swal.fire({
                                    position: 'top-center',
                                    icon: 'error',
                                    title: 'เกิดข้อผิดพลาด',
                                    showConfirmButton: true,
                                    timer: 1300
                                });
                            }

                        } else {
                            Swal.fire({
                                position: 'top-center',
                                icon: 'error',
                                title: 'เพิ่มข้อมูลสำเร็จ!',
                                showConfirmButton: true,
                                timer: 1300
                            });
                            $('#userFormEdit').trigger("reset");
                        }


                    },

                });
                });

                //del
                $('body').on('click', '.delete-item', function() {
                    const holiday_id = $(this).data("id");
                        //console.log(id);
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
                                url: "holiday" + '/' + holiday_id,

                                success: function(data) {
                                    Swal.fire(
                                        'สำเร็จ!',
                                        data.message,
                                        'success'
                                    )
                                    setTimeout("location.href = '{{ route("holiday") }}';",1000);

                                },
                                error: function(data) {
                                    Swal.fire(
                                        'เกิดข้อผิดพลาด!',
                                        data.message,
                                        'error'
                                    )
                                }
                            });

                        }
                    });

                });

                function printErrorMsg(msg) {
                        $.each(msg, function(key, value) {
                            //console.log(key);
                            $('.' + key + '_err').text(value);
                        });
                    }
                    function printErrorMsg2(msg) {
                            $.each(msg, function(key, value) {
                                //console.log(key);
                                $('.' + key + '_err2').text(value);
                            });
                    }
        });

</script>

<script>
    $(document).ready(function() {
        $('#calendar').fullCalendar({
            locale: 'th',
            defaultView: 'month',
            allDayDefault: true,
            eventLimit: false,
            timeZone: 'Asia/Bangkok',
            header    : {
                left  : 'prev,next today',
                center: 'title',
                right : 'month'
            },
            timeFormat: '',
            slotDuration: '12:00:00',
            slotLabelInterval: '1 day',
            slotEventOverlap: false,

            events:'/holiday',

                eventClick: function(event, jsEvent, view) {

                    Swal.fire({
                        title: 'คุณ '+ event.title,
                        html: `
                        <h5>ขออนุญาต <strong>${event.remark}</strong></h5>
                        <h5><strong>วันที่ </strong> ${event.start.format('DD/MM/YYYY')} <strong> - </strong> ${event.showEnd}</h5>

                        <hr>
                        <h5><strong>สถานะ ${event.status}</strong></h5>
                        `,
                        // icon: 'info',
                        confirmButtonText: 'OK'
                    });
                },


                eventRender: function(event, element) {

                    element.addClass('my-event');


                },
                dayClick: function(date, jsEvent, view) {
                // Handle day click here
                }
        });
    });
</script>
@endpush
