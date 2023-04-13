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
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                จองล่วงหน้าได้เท่านั้น !!!
              </div>
            </div>
            <div class="col-md-4 col-xs-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#tab_1" data-toggle="tab">เยี่ยมโครงการ</a></li>
                      <li><a href="#tab_2" data-toggle="tab">   ประเมินห้องชุด</a></li>
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
                                        <label>วันที่ </label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right" id="datepicker" name="date" autocomplete="off" required>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <label>เวลา </label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                            </div>
                                            <select class="form-control" style="width: 100%;" name="time" autocomplete="off" required>
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
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>โครงการ</label>
                                <select class="form-control select2" style="width: 100%;" name="project_id" autocomplete="off" required>
                                <option value="">เลือก</option>
                                @foreach ($projects as $project)
                                <option value="{{$project->id}}">{{$project->name}}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <label>ชื่อ-นามสกุล (ลูกค้า)</label>
                                        <input type="text" class="form-control" placeholder="" name="customer_name" autocomplete="off" required>
                                    </div>
                                    <div class="col-xs-6">
                                        <label>เบอร์ติดต่อ</label>
                                        <input type="text" class="form-control" data-inputmask='"mask": "(999) 999-9999"' data-mask value="" name="customer_tel" autocomplete="off" required>
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
                                            </div>
                                        </div>

                                    </div>
                                    <div class="col-xs-6">
                                        <label>ระบุเลขห้อง</label>
                                        <input type="text" class="form-control" name="room_no" placeholder="เช่น 99/9" autocomplete="off">
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
                                <label>ผู้ดูแลสายงาน</label>
                                <select class="form-control select2" id="teamSelect" name="team_id" style="width: 100%;" required>
                                <option value="">เลือก</option>
                                @foreach ($teams as $team)
                                    <option value="{{$team->id}}">{{ $team->team_name }}</option>
                                @endforeach

                                </select>
                            </div>
                            <div class="form-group">
                                <label>ชื่อสายงาน</label>
                                <select class="form-control select2" id="subteamSelect" name="subteam_id" style="width: 100%;" disabled required>
                                <option value="">เลือก</option>

                                </select>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <label>ชื่อ-นามสกุล (Sale)</label>
                                        <input type="hidden" class="form-control" name="user_id" value="{{$dataUserLogin->id}}" >
                                        <input type="text" class="form-control" name="" value="{{$dataUserLogin->name_th}}" disabled>
                                    </div>
                                    <div class="col-xs-6">
                                        <label>*เบอร์ติดต่อสายงาน</label>
                                        <input type="text" class="form-control" name="user_tel" data-inputmask='"mask": "(999) 999-9999"' data-mask value="" autocomplete="off" required>
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

{{-- <script>
    $(function () {

      /* initialize the external events
       -----------------------------------------------------------------*/
      function init_events(ele) {
        ele.each(function () {

          // create an Event Object (http://arshaw.com/fullcalendar/docs/event_data/Event_Object/)
          // it doesn't need to have a start or end
          var eventObject = {
            title: $.trim($(this).text()) // use the element's text as the event title
          }

          // store the Event Object in the DOM element so we can get to it later
          $(this).data('eventObject', eventObject)

          // make the event draggable using jQuery UI
          $(this).draggable({
            zIndex        : 1070,
            revert        : true, // will cause the event to go back to its
            revertDuration: 0  //  original position after the drag
          })

        })
      }

      init_events($('#external-events div.external-event'))

      /* initialize the calendar
       -----------------------------------------------------------------*/
      //Date for the calendar events (dummy data)
    //   var date = new Date()
    //   var d    = date.getDate(),
    //       m    = date.getMonth(),
    //       y    = date.getFullYear()
      $('#calendar').fullCalendar({
        header    : {
          left  : 'prev,next today',
          center: 'title',
          right : 'month,agendaWeek,agendaDay'
        },
        buttonText: {
          today: 'today',
          month: 'month',
          week : 'week',
          day  : 'day'
        },
        //Random default events
        events:'/booking_project',
        // events    : [

        //   {
        //     title          : 'Meeting',
        //     start          : new Date(y, m, d, 10, 30),
        //     allDay         : false,
        //     backgroundColor: '#0073b7', //Blue
        //     borderColor    : '#0073b7' //Blue
        //   },
        //   {
        //     title          : 'Lunch',
        //     start          : new Date(y, m, d, 12, 0),
        //     end            : new Date(y, m, d, 14, 0),
        //     allDay         : false,
        //     backgroundColor: '#00c0ef', //Info (aqua)
        //     borderColor    : '#00c0ef' //Info (aqua)
        //   },

        // ],

    })
    })
</script> --}}
@endpush
