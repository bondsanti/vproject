@extends('layouts.app')

@section('content')


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


    <!-- Main content -->
    <section class="content">
        <!-- Info boxes -->
        <div class="row">
            <div class="col-md-4 col-xs-12">
                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                      <li class="active"><a href="#tab_1" data-toggle="tab">เยี่ยมโครงการ</a></li>
                      <li><a href="#tab_2" data-toggle="tab">   ประเมินห้องชุด</a></li>
                      <li><a href="#tab_3" data-toggle="tab">ตรวจ DF/ รับมอบห้อง</a></li>
                    </ul>
                    <div class="tab-content">
                      <div class="tab-pane active" id="tab_1">
                        <form action="{{route('bookingPoject.create')}}" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <label>วันที่ </label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                            </div>
                                            <input type="text" class="form-control pull-right" id="datepicker" name="date">
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <label>เวลา </label>
                                        <div class="input-group date">
                                            <div class="input-group-addon">
                                            <i class="fa fa-clock-o"></i>
                                            </div>
                                            <select class="form-control select2" style="width: 100%;" name="time">
                                                <option value="">เลือก</option>
                                                <option value="09:00">09.00 - 10.00 น.</option>
                                                <option value="10:00">10.00 - 11.00 น.</option>
                                                <option value="11:00">11.00 - 12.00 น.</option>
                                                <option value="13:00">13.00 - 14.00 น.</option>
                                                <option value="14:00">14.00 - 15.00 น.</option>
                                                <option value="15:00">15.00 - 16.00 น.</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label>โครงการ</label>
                                <select class="form-control select2" style="width: 100%;" name="project_id" required>
                                <option value="">เลือก</option>
                                @foreach ($projects as $project )
                                <option value="{{$project->id}}">{{$project->project_name}}</option>
                                @endforeach

                                </select>
                            </div>
                            <div class="form-group">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <label>ชื่อ-นามสกุล (ลูกค้า)</label>
                                        <input type="text" class="form-control" placeholder="" name="customer_name" autocomplete="off">
                                    </div>
                                    <div class="col-xs-6">
                                        <label>เบอร์ติดต่อ</label>
                                        <input type="text" class="form-control" placeholder="" name="tel_name" autocomplete="off">
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
                                                <input type="checkbox" class="minimal" name="checkbox_bank[]">
                                                กสิกร
                                              </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="minimal" name="checkbox_bank[]">
                                                กรุงไทย
                                              </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="minimal" name="checkbox_bank[]">
                                                เกียรตินาคิน
                                              </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="minimal" name="checkbox_bank[]">
                                                ไทยพาณิชย์
                                              </label>
                                        </div>
                                    </div>
                                    <div class="col-xs-6">
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="minimal" name="checkbox_bank[]">
                                                ธอส.
                                              </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="minimal" name="checkbox_bank[]">
                                                ออมสิน
                                              </label>
                                        </div>
                                        <div class="form-check-inline">
                                            <label class="form-check-label">
                                                <input type="checkbox" class="minimal" name="checkbox_bank[]">
                                                TTB
                                              </label>
                                        </div>
                                        <div class="form-check-inline">

                                                <div class="form-check-inline">
                                                    <div class="input-group">
                                                        <span class="input-group-addon" style="border: none;  padding: 0px 10px 0px 0px;">
                                                        <input type="checkbox" class="minimal" name="checkbox_bank[]" value="อื่น ๆ">
                                                        </span>
                                                        <input type="text" class="form-control" name="checkbox_bank[]" placeholder="อื่น ๆ ระบุ..">
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
                                                <input type="checkbox" class="minimal" name="checkbox_bank[]"   >
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
                                        <input type="text" class="form-control" name="" value="{{$dataUserLogin->fullname}}" disabled>
                                        <input type="hidden" class="form-control" name="name_sale" value="{{$dataUserLogin->fullname}}">
                                    </div>
                                    <div class="col-xs-6">
                                        <label>เบอร์ติดต่อ</label>
                                        <input type="text" class="form-control" name="tel_sale" placeholder="" required>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">

                                        <label>หมายเหตุ</label>
                                        <textarea class="form-control" rows="3" name="remark" placeholder="หมายเหตุ ..."></textarea>
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
                        Tab2
                      </div>
                      <!-- /.tab-pane -->
                      <div class="tab-pane" id="tab_3">
                       Tab3
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

{{-- <script>
    document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        locale: 'cy',
        // themeSystem: 'bootstrap',
        timeZone: 'Asia/Thailand',
        initialView: 'timeGridWeek',
        headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        // left:'title',
        // center:'prev,next today',
        right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },

        defaultView: 'timeGridWeek',
       //slotDuration: '01:00:00',
        dayHeaderFormat: { weekday: 'long', month: 'numeric', day: 'numeric', omitCommas: true },
        slotLabelFormat: [
            { hour: '2-digit', minute: '2-digit' },
            { hour: '2-digit', minute: '2-digit' }
        ],

        events: [
            {
                title: 'นัดเยี่ยมโครงการ',
                start: '2023-03-07T09:00:00',
                end: '2023-03-07T12:00:00',
                allDay: false,

            },

            {
                title: 'Booking 2',
                start: '2023-03-08T13:00:00',
                end: '2023-03-08T16:00:00',
                allDay: false
            },],

    });

    calendar.render();
    });

</script> --}}
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
        //Date picker
    $('#datepicker').datepicker({
      autoclose: true
    })

    $.ajaxSetup({
        headers:{
            'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')
        }
    });

  $('#calendar').fullCalendar({
    locale: 'cy',
    defaultView: 'month',
    eventLimit: false,
    timeZone: 'Asia/Bangkok',
    header    : {
        left  : 'prev,next today',
        center: 'title',
        right : 'month,agendaWeek,agendaDay'
      },


      events:'/booking_project',

        eventClick: function(event, jsEvent, view) {
        // Handle event click here
        },
        eventRender: function(event, element) {
        // Handle event rendering here
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
