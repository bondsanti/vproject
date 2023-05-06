@extends('layouts.app')

@section('content')

@push('styles ')

<style>
.my-event {
  padding: 7px;
  cursor: pointer;
}
/* .fc-event:hover {
  cursor: pointer;
} */
.swal-wide{
    width:450px !important;
}

</style>

    <section class="content-header">
        <h1>
            นัดหมาย
            <small>Booking</small>
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
            <div class="col-md-12">
            {{-- <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                จองล่วงหน้าได้เท่านั้น !!!
              </div> --}}
            </div>
            <div class="col-md-4 col-xs-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#tab_1" data-toggle="tab">เยี่ยมโครงการ</a></li>
                      <li><a href="#tab_2" data-toggle="tab">ประเมินห้องชุด</a></li>
                      <li><a href="#tab_3" data-toggle="tab">ตรวจ DF/ รับมอบห้อง</a></li>
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane active" id="tab_1">
                        <form action="{{route('updateBookingProject')}}" method="post">
                            @csrf
                            <input type="hidden" name="booking_id" value="{{$bookings->bkid}}">
                            <input type="hidden" name="booking_title" value="{{$bookings->booking_title}}">
                            <input type="hidden" name="user_id" value="{{$bookings->user_id}}">
                            <input type="hidden" name="teampro_id" value="{{$bookings->teampro_id}}">
                        <div class="box-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <label>วันที่ </label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                            </div>
                                            @php
                                                $booking_start = date('Y-m-d', strtotime($bookings->booking_start));
                                                $time_start = date('H:i', strtotime($bookings->booking_start));
                                            @endphp
                                            <input type="text" class="form-control pull-right" id="datepicker" name="date" value="{{$booking_start}}" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <label>เวลา </label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                            </div>
                                            <select class="form-control select2" style="width: 100%;" name="time" autocomplete="off" required>
                                                <option value="">เลือก</option>
                                                <option value="08:00" {{ $time_start == "08:00" ? 'selected' : '' }}>08.00</option>
                                                <option value="09:00" {{ $time_start == "09:00" ? 'selected' : '' }}>09.00</option>
                                                <option value="10:00" {{ $time_start == "10:00" ? 'selected' : '' }}>10.00</option>
                                                <option value="11:00" {{ $time_start == "11:00" ? 'selected' : '' }}>11.00</option>
                                                <option value="13:00" {{ $time_start == "13:00" ? 'selected' : '' }}>13.00</option>
                                                <option value="14:00" {{ $time_start == "14:00" ? 'selected' : '' }}>14.00</option>
                                                <option value="15:00" {{ $time_start == "15:00" ? 'selected' : '' }}>15.00</option>
                                                <option value="16:00" {{ $time_start == "16:00" ? 'selected' : '' }}>16.00</option>
                                                <option value="17:00" {{ $time_start == "17:00" ? 'selected' : '' }}>17.00</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>โครงการ</label>
                                <select class="form-control select2" style="width: 100%;" name="project_id" autocomplete="off" required>
                                <option value="">เลือก</option>
                                @foreach ($projects as $project )
                                <option value="{{$project->id}}" {{ $bookings->project_id == $project->id ? 'selected' : '' }}>{{$project->name}}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <label>ชื่อ-นามสกุล (ลูกค้า)</label>
                                        <input type="text" class="form-control" placeholder="" value="{{$bookings->customer_name}}" name="customer_name" autocomplete="off" required>
                                    </div>
                                    <div class="col-xs-6">
                                        <label>เบอร์ติดต่อ</label>
                                        <input type="text" class="form-control" placeholder="099xxxxxxx" value="{{$bookings->customer_tel}}" maxlength="10" name="customer_tel" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>เซ็นเอกสารใบคำขอกู้ธนาคาร</label>
                                <br>
                                @php

                                $data_req_bank = $bookings->customer_req_bank;
                                $array_data_req_bank = explode(",", $data_req_bank);
                                //print_r($array_data_req_bank);

                                @endphp
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="minimal" name="checkbox_bank[]" value="กสิกร" @php if (in_array("กสิกร", $array_data_req_bank)) {echo "checked";}
                                                @endphp>
                                                กสิกร
                                              </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="minimal" name="checkbox_bank[]" value="กรุงไทย" @php if (in_array("กรุงไทย", $array_data_req_bank)) {echo "checked";}
                                                @endphp>
                                                กรุงไทย
                                              </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="minimal" name="checkbox_bank[]" value="เกียรตินาคิน" @php if (in_array("เกียรตินาคิน", $array_data_req_bank)) {echo "checked";}
                                                @endphp>
                                                เกียรตินาคิน
                                              </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="minimal" name="checkbox_bank[]" value="ไทยพาณิชย์" @php if (in_array("ไทยพาณิชย์", $array_data_req_bank)) {echo "checked";}
                                                @endphp>
                                                ไทยพาณิชย์
                                              </label>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="minimal" name="checkbox_bank[]" value="ธอส." @php if (in_array("ธอส.", $array_data_req_bank)) {echo "checked";}
                                                @endphp>
                                                ธอส.
                                              </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="minimal" name="checkbox_bank[]" value="ออมสิน" @php if (in_array("ออมสิน", $array_data_req_bank)) {echo "checked";}
                                                @endphp>
                                                ออมสิน
                                              </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="minimal" name="checkbox_bank[]" value="TTB" @php if (in_array("TTB", $array_data_req_bank)) {echo "checked";}
                                                @endphp>
                                                TTB
                                              </label>
                                        </div>
                                        <div class="form-check-inline">

                                                <div class="form-check-inline">
                                                    <div class="input-group">
                                                        {{-- <span class="input-group-addon" style="border: none;  padding: 0px 10px 0px 0px;">
                                                        <input type="checkbox" class="minimal" name="checkbox_bank[]" value="อื่น">
                                                        </span> --}}
                                                        <input type="text" class="form-control" name="customer_req_bank_other" placeholder="อื่น ๆ ระบุ.." autocomplete="off" value="{{$bookings->customer_req_bank_other}}">
                                                    </div>
                                                </div>

                                        </div>
                                    </div>

                                </div>

                            </div>
                            <div class="form-group">
                                <label>ข้อมูลลูกค้าเข้าชม</label>
                                <br>
                                @php

                                $data_req = $bookings->customer_req;
                                $array_data_req = explode(",", $data_req);
                               // print_r($array_data_req);

                                @endphp

                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="minimal" name="checkbox_room[]" value="ชมห้องตัวอย่าง" {{ (isset($array_data_req[0]) && $array_data_req[0] == "ชมห้องตัวอย่าง") ? 'checked' : '' }}>
                                                ชมห้องตัวอย่าง
                                              </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <div class="input-group">
                                                <span class="input-group-addon" style="border: none;  padding: 0px 10px 0px 0px;">
                                                <input type="checkbox" class="minimal" name="checkbox_room[]" value="พาชมห้องราคา" {{ (isset($array_data_req[1]) && $array_data_req[1] == "พาชมห้องราคา") ? 'checked' : '' }}>
                                                </span>
                                                <input type="text" id="inputNumber" name="room_price" class="form-control" placeholder="พาชมห้อง ราคา"  value="{{$bookings->room_price}}" autocomplete="off">
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-xs-6">
                                        <label>ระบุเลขห้อง</label>
                                        <input type="text" class="form-control" name="room_no" placeholder="เช่น 99/9" value="{{$bookings->room_no}}" autocomplete="off">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>เอกสารจากลูกค้า</label>
                                <br>
                                @php

                                $data_req_doc = $bookings->customer_doc_personal;
                                $array_data_doc = explode(",", $data_req_doc);
                               //print_r($array_data_doc);

                                @endphp
                                <div class="row">
                                    <div class="col-xs-12">

                                        <table width="100%">
                                            <tr>
                                                <td width="60%">
                                                <div class="form-check-inline">
                                                    <div class="input-group tex-left">
                                                        <span class="input-group-addon" style="border: none;  padding: 0px 15px 0px 0px;">
                                                        <input type="checkbox" class="minimal" name="checkbox_doc[]" value="สำเนาทะเบียนบ้าน" {{ (isset($array_data_doc[0]) && $array_data_doc[0] == "สำเนาทะเบียนบ้าน") ? 'checked' : '' }}>
                                                         สำเนาทะเบียนบ้าน
                                                        </span>


                                                    </div>
                                                </div>
                                                </td>
                                                <td width="20%"><input type="number" name="num_home" class="form-control" placeholder="" value="{{$bookings->num_home}}"></td>
                                                <td width="20%">&nbsp;&nbsp;ชุด</td>
                                            </tr>
                                            <tr>
                                                <td width="50%">
                                                <div class="form-check-inline">
                                                    <div class="input-group">
                                                        <span class="input-group-addon" style="border: none;  padding: 0px 12px 0px 0px;">
                                                        <input type="checkbox" class="minimal" name="checkbox_doc[]" value="สำเนาบัตรประชาชน" {{ (isset($array_data_doc[1]) && $array_data_doc[1] == "สำเนาบัตรประชาชน") ? 'checked' : '' }}>
                                                        สำเนาบัตรประชาชน
                                                        </span>


                                                    </div>
                                                </div>
                                                </td>
                                                <td><input type="number" class="form-control" name="num_idcard" placeholder="" value="{{$bookings->num_idcard}}"></td>
                                                <td>&nbsp;&nbsp;ชุด</td>
                                            </tr>
                                            <tr>
                                                <td width="50%">
                                                <div class="form-check-inline">
                                                    <div class="input-group">
                                                        <span class="input-group-addon" style="border: none;  padding: 0px 0px 0px 0px;">
                                                        <input type="checkbox" class="minimal"  name="checkbox_doc[]" value="หนังสือรับรองเงินเดือน" {{ (isset($array_data_doc[2]) && $array_data_doc[2] == "หนังสือรับรองเงินเดือน") ? 'checked' : '' }}>
                                                        หนังสือรับรองเงินเดือน
                                                        </span>


                                                    </div>
                                                </div>
                                                </td>
                                                <td><input type="number" class="form-control" name="num_app_statement" placeholder="" value="{{$bookings->num_app_statement}}"></td>
                                                <td>&nbsp;&nbsp;ชุด</td>
                                            </tr>
                                            <tr>
                                                <td width="50%">
                                                <div class="form-check-inline">
                                                    <div class="input-group">
                                                        <span class="input-group-addon" style="border: none;  padding: 0px 24px 0px 0px;">
                                                        <input type="checkbox" class="minimal"  name="checkbox_doc[]" value="เอกสาร Statement" {{ (isset($array_data_doc[3]) && $array_data_doc[3] == "เอกสาร Statement") ? 'checked' : '' }}>
                                                        เอกสาร Statement
                                                        </span>


                                                    </div>
                                                </div>
                                                </td>
                                                <td><input type="number" class="form-control"name="num_statement" placeholder="" value="{{$bookings->num_statement}}"></td>
                                                <td>&nbsp;&nbsp;ชุด</td>
                                            </tr>
                                        </table>

                                    </div>
                                </div>
                            </div>
                            <hr style=" border: 1px solid rgb(2, 116, 209);"></hr>
                            {{-- <div class="form-group">
                                <label>เจ้าหน้าที่โครงการ</label>
                                <select class="form-control select2" style="width: 100%;">
                                <option>เลือก</option>

                                </select>
                            </div> --}}
                            <div class="form-group">
                                <label>ผู้ดูแลสายงาน</label>
                                <select class="form-control select2" id="teamSelect" name="team_id" style="width: 100%;" required>
                                <option value="">เลือก</option>
                                @foreach ($teams as $team)
                                    <option value="{{$team->id}}" {{ $bookings->team_id == $team->id ? 'selected' : '' }}>{{ $team->team_name }}</option>
                                @endforeach

                                </select>
                            </div>
                            <div class="form-group">
                                <label>ชื่อสายงาน</label>
                                <select class="form-control select2" id="subteamSelect" name="subteam_id" style="width: 100%;" required>
                                <option value="{{ $bookings->subteam_id }}">{{ $bookings->subteam_name }}</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    @if ($dataRoleUser->role_type== "SuperAdmin")
                                    <div class="col-xs-6">
                                        <label>ชื่อ-นามสกุล (Sale)</label>
                                        <select class="form-control select2" style="width: 100%;" name="user_id" autocomplete="off" >
                                            <option value="">เลือก</option>
                                            @foreach ($dataSales as $dataSale)
                                            <option value="{{$dataSale->user_ref[0]->id}}"  {{ $dataSale->user_ref[0]->id == $bookings->user_id ? 'selected' : '' }}>{{$dataSale->user_ref[0]->name_sale}}</option>
                                           @endforeach
                                        </select>
                                    </div>
                                    @else
                                    <div class="col-xs-6">
                                        <label>ชื่อ-นามสกุล (Sale)</label>
                                        <input type="hidden" class="form-control" name="user_id" value="{{$bookings->booking_user_ref[0]->id}}" >
                                        <input type="hidden" class="form-control" name="sale_name" value="{{$bookings->booking_user_ref[0]->name_th}}" >
                                        <input type="text" class="form-control" name="" value="{{$bookings->booking_user_ref[0]->name_th}}" disabled>
                                    </div>
                                    @endif
                                    <div class="col-xs-6">
                                        <label>เบอร์ติดต่อสายงาน</label>
                                        <input type="text" class="form-control" name="user_tel" placeholder="099xxxxxxx" maxlength="10" value="{{ $bookings->user_tel }}" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">

                                        <label>หมายเหตุ</label>
                                        <textarea class="form-control" rows="3" name="remark" placeholder="หมายเหตุ ..." autocomplete="off" >{{ $bookings->remark }}</textarea>
                            </div>
                            <div class="box-footer text-center">
                                <button type="submit" class="btn btn-primary">บันทึก</button>
                                <button type="button" class="btn btn-danger" onclick="window.location.replace('{{url()->previous()}}')">ยกเลิก</button>
                            </div>

                        </div>
                        </form>
                      </div>
                      <!-- /.tab-pane -->
                      <div class="tab-pane" id="tab_2">
                        Comming soon
                      </div>
                      <!-- /.tab-pane -->
                      <div class="tab-pane" id="tab_3">
                        Comming soon
                      </div>
                      <!-- /.tab-pane -->
                    </div>
                    <!-- /.tab-content -->
                  </div>
                  <!-- nav-tabs-custom -->
            </div>
              <!-- /.col -->



              <div class="col-md-8 col-xs-12">

                <div class="box box-primary">
                  <div class="box-body no-padding">
                    <h5>
                        &nbsp;&nbsp;สถานะ <span class="label label-default">รอรับงาน</span>
                        &nbsp;<span class="label label-warning">รับงานแล้ว</span>
                        &nbsp;<span class="label label-info">จองสำเร็จ / รอเข้าเยี่ยม</span>
                        &nbsp;<span class="label label-success">เยี่ยมชมเรียบร้อย</span>
                        &nbsp;<span class="label label-danger">ยกเลิก</span>
                        &nbsp;<span class="label" style="background-color:#b342f5">ยกเลิกอัตโนมัติ</span>
                    </h5>

                    <!-- THE CALENDAR -->
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
@endsection
@push('script')

<script>

    $(document).ready(function() {
        $("#inputNumber").keyup(function() {
                if (!isNaN(parseFloat($(this).val().replace(/,/g, "")))) {
                    $(this).val(comma(parseFloat($(this).val().replace(/,/g, ""))));
                }
            });

            function comma(number) {
                return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
         }
        $('#teamSelect').change(function() {
            var teamId = $(this).val();
            if (teamId) {
                $.ajax({
                    url: '{{ route('subteams.get') }}',
                    type: 'GET',
                    data: {team_id: teamId},
                    success: function(data) {
                        $('#subteamSelect').empty().append('<option value="">เลือก</option>');
                        $.each(data, function(index, subteam) {
                            $('#subteamSelect').append('<option value="'+ subteam.id +'">'+ subteam.subteam_name +'</option>');
                        });
                        $('#subteamSelect').prop('disabled', false);
                    }
                });
            } else {
                $('#subteamSelect').empty().prop('disabled', true);
            }
        });
    });
</script>
<script>
$(document).ready(function() {
    $("#inputNumber").keyup(function() {
                if (!isNaN(parseFloat($(this).val().replace(/,/g, "")))) {
                    $(this).val(comma(parseFloat($(this).val().replace(/,/g, ""))));
                }
            });

            function comma(number) {
                return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }
        //Date picker
    $('#datepicker').datepicker({
      format:'yyyy-mm-dd',
      autoclose: true,
      startDate: new Date(), // sets the minimum date to today
      datesDisabled: [new Date()], // disables today's date in the datepicker
      todayHighlight: true, // highlights today's date in the datepicker
    })

    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#calendar').fullCalendar({
        locale: 'th',
        defaultView: 'month',
        eventLimit: true,
        timeZone: 'Asia/Bangkok',
        header    : {
            left  : 'prev,next today',
            center: 'title',
            right : 'month,agendaWeek,agendaDay'
        },
        timeFormat: 'H:mm [น.]',
        slotLabelFormat:"HH:mm [น.]",
        axisFormat: 'H:mm [น.]',
        minTime: '08:00:00',
        maxTime: '20:00:00',
        events:'/booking',

            eventClick: function(event, jsEvent, view) {
            // Handle event click here
            // Show the details of the clicked event
            //alert('Event: ' + event.title + '\nStart: ' + event.start.format('DD/MM/YYYY H:mm [น.]') + '\nEnd: ' + event.end.format('DD/MM/YYYY H:mm [น.]'));
            Swal.fire({
                title: event.title,
                // html: `
                // <p><strong>Start:</strong> ${event.start.format('DD/MM/YYYY H:mm [น.]')}</p>
                // <p><strong>End:</strong> ${event.end.format('DD/MM/YYYY H:mm [น.]')}</p>
                // `,
                html: `

                <h5><strong>${event.project}</strong></h5>

                <h5><strong>วันที่ </strong> ${event.start.format('DD/MM/YYYY H:mm')} <strong> - </strong> ${event.end.format('H:mm [น.]')}</h5>
                <h5><strong>ลูกค้า </strong> <span style="color:red">${event.customer}</span></h5>
                <h5><strong>ข้อมูลเข้าชม </strong> ${event.cus_req}</h5>
                <h5><strong>เลขห้อง </strong> ${event.room_no} <strong>ราคา </strong> ${event.room_price}.-</h5>
                <hr>
                <h5><strong>เจ้าหน้าที่โครงการ </strong> <span style="color:red">${event.employee}</span></h5>
                <h4><strong>สถานะ ${event.status}</strong></h4>
                `,
                icon: 'info',
                customClass: 'swal-wide',
                confirmButtonText: 'OK'
            });
            },
            eventRender: function(event, element) {
            // Handle event rendering here
            element.addClass('my-event');
            },
            dayClick: function(date, jsEvent, view) {
            // Handle day click here
            }

    });


});
  </script>

@endpush
