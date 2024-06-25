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
        <div class="row">
            <div class="col-md-6">
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                สามารถจองล่วงหน้าได้เท่านั้น !!!
             </div>
        </div>
        <div class="col-md-6">
            <div class="alert alert-info alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-info"></i> Information!</h4>
                    ปฎิทินจะแสดงเฉพาะงานของคุณเอง<br>
            </div>
        </div>
        </div>

        <div class="row">

            <div class="col-md-4 col-xs-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#tab_1" data-toggle="tab">เยี่ยมโครงการ</a></li>
                      <li><a href="#tab_2" data-toggle="tab">ประเมินห้องชุด</a></li>
                      <li><a href="#tab_3" data-toggle="tab">ตรวจ DF/ รับมอบห้อง</a></li>
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane active" id="tab_1">
                        <form action="{{route('createBookingProject.create')}}" method="post">
                            @csrf
                            <input type="hidden" name="booking_title" value="เยี่ยมโครงการ">
                        <div class="box-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <label><span class="text-danger">*</span> วันที่ </label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right" id="datepicker" name="date" value="{{old('date')}}" autocomplete="off">
                                        </div>
                                        <small class="text-danger mt-1">@error('date'){{$message}} @enderror</small>
                                    </div>
                                    <div class="col-xs-6">
                                        <label><span class="text-danger">*</span> เวลา </label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                            </div>
                                            <select class="form-control" style="width: 100%;" name="time" autocomplete="off" >
                                                <option value="">เลือก</option>
                                                {{-- <option value="08:00">08.00</option> --}}
                                                <option value="09:00">09.00</option>
                                                <option value="10:00">10.00</option>
                                                <option value="11:00">11.00</option>
                                                <option value="13:00">13.00</option>
                                                <option value="14:00">14.00</option>
                                                <option value="15:00">15.00</option>
                                                <option value="16:00">16.00</option>
                                                <option value="17:00">17.00</option>
                                            </select>
                                        </div>
                                        <small class="text-danger mt-1">@error('time'){{$message}} @enderror</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><span class="text-danger">*</span> โครงการ</label>
                                <select class="form-control select2" style="width: 100%;" name="project_id" autocomplete="off" >
                                <option value="">เลือก</option>
                                @foreach ($projects as $project)
                                <option value="{{$project->id}}">{{$project->name}}</option>
                                @endforeach
                                </select>
                                <small class="text-danger mt-1">@error('project_id'){{$message}} @enderror</small>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <label><span class="text-danger">*</span> ชื่อ-นามสกุล (ลูกค้า)</label>
                                        <input type="text" class="form-control" placeholder="" name="customer_name" autocomplete="off" value="{{old('customer_name')}}">
                                        <small class="text-danger mt-1">@error('customer_name'){{$message}} @enderror</small>
                                    </div>
                                    <div class="col-xs-6">
                                        <label><span class="text-danger">*</span> เบอร์ติดต่อ</label>
                                        <input type="text" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask value="{{old('customer_tel')}}" name="customer_tel" autocomplete="off">
                                        <small class="text-danger mt-1">@error('customer_tel'){{$message}} @enderror</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label><span class="text-danger">*</span> ข้อมูลลูกค้าเข้าชม</label>
                                <br>
                                <div class="row">
                                    <div class="col-xs-6">
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="minimal" name="checkbox_room[]" value="ชมห้องตัวอย่าง">
                                                ชมห้องตัวอย่าง
                                              </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <div class="input-group">
                                                <span class="input-group-addon" style="border: none;  padding: 0px 10px 0px 0px;">
                                                    <input type="checkbox" class="minimal" name="checkbox_room[]" value="พาชมห้องราคา">
                                                </span>

                                                <input type="text" id="inputNumber" name="room_price" class="form-control" placeholder="พาชมห้อง ราคา" autocomplete="off">
                                                <small class="text-danger mt-1">@error('room_price'){{$message}} @enderror</small>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-xs-6">
                                        <label><span class="text-danger">*</span> ระบุเลขห้อง</label>
                                        <input type="text" class="form-control" name="room_no" placeholder="เช่น 99/9" autocomplete="off">
                                        <small class="text-danger mt-1">@error('room_no'){{$message}} @enderror</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="form-check-label">
                                    <input type="checkbox" class="minimal" id="showdetail_1" value="" onchange="toggleDetail()">
                                    เก็บเอกสารลูกค้า
                                  </label>
                            </div>
                            <div id="detatil1" style="display:none">
                            <div class="form-group" >

                                <label>เอกสารใบคำขอกู้ธนาคาร</label>

                                <br>
                                <div class="row">

                                    <div class="col-xs-6">
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="minimal" name="checkbox_bank[]" value="กสิกร">
                                                กสิกร
                                              </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="minimal" name="checkbox_bank[]" value="กรุงไทย">
                                                กรุงไทย
                                              </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="minimal" name="checkbox_bank[]" value="เกียรตินาคิน">
                                                เกียรตินาคิน
                                              </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="minimal" name="checkbox_bank[]" value="ไทยพาณิชย์">
                                                ไทยพาณิชย์
                                              </label>
                                        </div>
                                    </div>

                                    <div class="col-xs-6">
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="minimal" name="checkbox_bank[]" value="ธอส.">
                                                ธอส.
                                              </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="minimal" name="checkbox_bank[]" value="ออมสิน">
                                                ออมสิน
                                              </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="minimal" name="checkbox_bank[]" value="TTB">
                                                TTB
                                              </label>
                                        </div>
                                        <div class="form-check-inline">

                                                <div class="form-check-inline">
                                                    <div class="input-group">
                                                        {{-- <span class="input-group-addon" style="border: none;  padding: 0px 10px 0px 0px;">
                                                        <input type="checkbox" class="minimal" name="checkbox_bank[]">
                                                        </span> --}}
                                                        <input type="text" class="form-control" name="checkbox_bank[]" placeholder="อื่น ๆ ระบุ.." autocomplete="off">
                                                    </div>
                                                </div>

                                        </div>
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
                                                        <input type="checkbox" class="minimal" name="checkbox_doc[]" value="สำเนาทะเบียนบ้าน">
                                                         สำเนาทะเบียนบ้าน
                                                        </span>


                                                    </div>
                                                </div>
                                                </td>
                                                <td width="20%"><input type="number" name="num_home" class="form-control" placeholder=""></td>
                                                <td width="20%">&nbsp;&nbsp;ชุด</td>
                                            </tr>
                                            <tr>
                                                <td width="50%">
                                                <div class="form-check-inline">
                                                    <div class="input-group">
                                                        <span class="input-group-addon" style="border: none;  padding: 0px 12px 0px 0px;">
                                                        <input type="checkbox" class="minimal" name="checkbox_doc[]" value="สำเนาบัตรประชาชน">
                                                        สำเนาบัตรประชาชน
                                                        </span>


                                                    </div>
                                                </div>
                                                </td>
                                                <td><input type="number" class="form-control" name="num_idcard" placeholder=""></td>
                                                <td>&nbsp;&nbsp;ชุด</td>
                                            </tr>
                                            <tr>
                                                <td width="50%">
                                                <div class="form-check-inline">
                                                    <div class="input-group">
                                                        <span class="input-group-addon" style="border: none;  padding: 0px 0px 0px 0px;">
                                                        <input type="checkbox" class="minimal"  name="checkbox_doc[]" value="หนังสือรับรองเงินเดือน">
                                                        หนังสือรับรองเงินเดือน
                                                        </span>


                                                    </div>
                                                </div>
                                                </td>
                                                <td><input type="number" class="form-control" name="num_app_statement" placeholder=""></td>
                                                <td>&nbsp;&nbsp;ชุด</td>
                                            </tr>
                                            <tr>
                                                <td width="50%">
                                                <div class="form-check-inline">
                                                    <div class="input-group">
                                                        <span class="input-group-addon" style="border: none;  padding: 0px 24px 0px 0px;">
                                                        <input type="checkbox" class="minimal"  name="checkbox_doc[]" value="เอกสาร Statement">
                                                        เอกสาร Statement
                                                        </span>


                                                    </div>
                                                </div>
                                                </td>
                                                <td><input type="number" class="form-control"name="num_statement" placeholder=""></td>
                                                <td>&nbsp;&nbsp;ชุด</td>
                                            </tr>
                                        </table>

                                    </div>
                                </div>
                            </div>
                            </div><!-- detail -->
                            <hr style=" border: 1px solid rgb(2, 116, 209);"></hr>
                            {{-- <div class="form-group">
                                <label>เจ้าหน้าที่โครงการ</label>
                                <select class="form-control select2" style="width: 100%;">
                                <option>เลือก</option>

                                </select>
                            </div> --}}
                            <div class="form-group">
                                <label><span class="text-danger">*</span> ผู้ดูแลสายงาน</label>
                                <select class="form-control select2" id="teamSelect" name="team_id" style="width: 100%;">
                                <option value="">เลือก</option>
                                @foreach ($teams as $team)
                                    <option value="{{$team->id}}">{{ $team->team_name }}</option>
                                @endforeach

                                </select>
                                <small class="text-danger mt-1">@error('team_id'){{$message}} @enderror</small>
                            </div>
                            <div class="form-group">
                                <label><span class="text-danger">*</span> ชื่อสายงาน</label>
                                <select class="form-control select2" id="subteamSelect" name="subteam_id" style="width: 100%;" disabled>
                                <option value="">เลือก</option>

                                </select>
                                <small class="text-danger mt-1">@error('subteam_id'){{$message}} @enderror</small>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    @if ($dataRoleUser->role_type== "SuperAdmin")
                                    <div class="col-xs-6">
                                        <label>ชื่อ-นามสกุล (Sale)</label>
                                        <select class="form-control select2" style="width: 100%;" name="user_id" autocomplete="off" >
                                            <option value="">เลือก</option>
                                            @foreach ($dataSales as $dataSale)
                                            <option value="{{ optional($dataSale->apiData)['id'] }}">{{ optional($dataSale->apiData)['name_th'] }}</option>
                                           @endforeach
                                        </select>
                                    </div>
                                    @else
                                    <div class="col-xs-6">
                                        <label>ชื่อ-นามสกุล (Sale)</label>
                                        <input type="hidden" class="form-control" name="user_id" value="{{$dataUserLogin['user_id']}}" >
                                        <input type="hidden" class="form-control" name="sale_name" value="{{ $dataUserLogin['apiData']['data']['name_th'] }}">
                                        <input type="text" class="form-control" name="" value="{{ $dataUserLogin['apiData']['data']['name_th'] }}" disabled>

                                    </div>
                                    @endif
                                    <div class="col-xs-6">
                                        <label>*เบอร์ติดต่อสายงาน</label>
                                        <input type="text" class="form-control" name="user_tel" data-inputmask='"mask": "(999) 999-9999"' data-mask value="" autocomplete="off">
                                        <small class="text-danger mt-1">@error('user_tel'){{$message}} @enderror</small>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">

                                        <label>หมายเหตุ</label>
                                        <textarea class="form-control" rows="3" name="remark" placeholder="หมายเหตุ ..." autocomplete="off"></textarea>
                            </div>
                            <div class="box-footer text-center">
                                <button type="submit" class="btn btn-primary ">บันทึก</button>
                                <button type="reset" class="btn btn-danger">เคลียร์</button>
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
                        {{-- &nbsp;<span class="label label-primary">SL คอนเฟริมแล้ว</span> --}}
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


@if($errors->any())
    <script>
        Swal.fire({
            title: 'เกิดข้อผิดพลาด!',
            text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
            icon: 'error',
            showCancelButton: false,
            confirmButtonText: 'OK',
        });
    </script>
@endif



<script>
function toggleDetail() {
    var checkbox = document.getElementById("showdetail_1");
    var detail = document.getElementById("detatil1");
    if (checkbox.checked == true){
      detail.style.display = "block";
    } else {
      detail.style.display = "none";
    }
  }

</script>
<script>
    $(document).ready(function() {
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
    $('[data-mask]').inputmask()
    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('.select2').select2();

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
                    html: `
                    <h5>โครงการ :   <strong>${event.project}</strong></h5>
                    <h5>วันที่ : <strong>${event.start.format('DD/MM/YYYY H:mm')} -  ${event.end.format('H:mm [น.]')}</strong></h5>
                    <h5>ลูกค้า :<strong>${event.customer} </strong>
                    <h5>ข้อมูลเข้าชม : <strong>  ${event.cus_req} ${event.room_price}.-</strong></h5>
                    <h5> เลขห้อง :  <strong> ${event.room_no}</strong>  </h5>
                    <hr>
                    <h5>ชื่อ Sale : <strong><span style="color:red">${event.sale}</span></strong></h5>
                    <h5>ทีม/สายงาน : <strong><span style="">${event.team_name}</span></strong></h5>
                    <h5>เบอร์สายงาน : <strong><span style="">${event.tel}</span></strong></h5>
                    <h5>เจ้าหน้าที่โครงการ : <strong><span style="">${event.employee}</span></strong></h5>
                    <h4><strong>สถานะ <span style="color:${event.backgroundColor}">${event.status}</span></strong></h4>
                    `,
                    icon: 'info',
                    customClass: 'swal-wide'
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
