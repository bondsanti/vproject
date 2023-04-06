@extends('layouts.app')

@section('content')
@push('styles')

<style>
.my-event {
  padding: 7px;
  cursor: pointer;
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
              <div class="col-md-2">
              </div>
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
                    <div id="calendar"></div>
                  </div>
                  <!-- /.box-body -->
                </div>
                <!-- /. box -->
              </div>
              <div class="col-md-2">
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

            events:'/calendar',

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
                    <h5><strong>สถานะ ${event.status}</strong></h5>
                    `,
                    // icon: 'info',
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
