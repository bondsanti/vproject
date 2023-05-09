@extends('layouts.app')

@section('content')
@push('styles')

<style>
.my-event {
  padding: 7px;
  cursor: pointer;
}
.swal-wide{
    width:450px !important;
}
</style>

    <section class="content-header">
        <h1>
            ปฏิทินงาน
            <small>Calendar</small>
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
              <!-- /.col -->
              <div class="col-md-9 col-xs-12">
                <div class="box box-primary">
                  <div class="box-body no-padding">

                    <div id="calendar"></div>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /. box -->
              </div>
              <div class="col-md-3 col-xs-12">
                <div class="box box-solid">

                    <div class="box-header with-border">
                        <i class="fa fa-bullhorn"></i>
                    <h4 class="box-title">สถานะ</h4>
                    </div>

                    <div class="box-body">

                        <div id="external-events">
                            <div class="external-event bg-gray" style="color:white">รอรับงาน</div>
                            <div class="external-event bg-yellow">รับงานแล้ว</div>
                            <div class="external-event bg-aqua">จองสำเร็จ</div>
                            <div class="external-event bg-green">เยี่ยมชมเรียบร้อย</div>
                            <div class="external-event bg-red">ยกเลิก</div>
                            <div class="external-event" style="background-color: #b342f5;color:white">ยกเลิก อัตโนมัติ</div>
                        </div>

                    </div>

                </div>
                <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-info"></i> Information!</h4>
                        - ปฎิทินงานจะแสดงของทุกคน<br>
                        - สัญญาลักษณ์ 📌 คืองานของคุณเอง<br>

                </div>
                <div class="alert alert-warning alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-warning"></i> Alert!</h4>
                        - หากคุณไม่กดรับงานภายในเวลาที่กำหนด ระบบจะยกเลิกการจองอัตโนมัติ

                </div>
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
        $('#calendar').fullCalendar({
            locale: 'th',
            defaultView: 'month',
            eventLimit: false,
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

            events:'/calendar',

                eventClick: function(event, jsEvent, view) {
                // Handle event click here
                // Show the details of the clicked event
                //alert('Event: ' + event.title + '\nStart: ' + event.start.format('DD/MM/YYYY H:mm [น.]') + '\nEnd: ' + event.end.format('DD/MM/YYYY H:mm [น.]'));
                Swal.fire({
                    title: event.title,
                    html: `
                    <h5>โครงการ :   <strong>${event.project}</strong></h5>
                    <h5>วันที่ : <strong>${event.start.format('DD/MM/YYYY H:mm')} -  ${event.end.format('H:mm [น.]')}</strong></h5>

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
