@extends('layouts.app')

@section('content')


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
              <div class="col-md-12">
                <div class="box box-primary">
                  <div class="box-body no-padding">
                    <!-- THE CALENDAR -->
                    <table class="table table-bordered text-center">
                        <thead>
                        <tr style="height:60px;">
                          <th style="vertical-align: middle;">วัน / เวลา</th>
                          <th style="vertical-align: middle;">09:00 - 10:00</th>
                          <th style="vertical-align: middle;">10:00 - 11:00</th>
                          <th style="vertical-align: middle;">11:00 - 12:00</th>
                          {{-- <th style="vertical-align: middle;">12:00 - 13:00</th> --}}
                          <th style="vertical-align: middle;">13:00 - 14:00</th>
                          <th style="vertical-align: middle;">14:00 - 15:00</th>
                          <th style="vertical-align: middle;">15:00 - 16:00</th>
                          <th style="vertical-align: middle;">16:00 - 17:00</th>
                          <th style="vertical-align: middle;">17:00 - 18:00</th>
                        </tr>
                        </thead>
                        <tbody >
                            <tr style="height:100px;">
                                <td style="vertical-align: middle;"> จันทร์
                                    <p>xx-xx-xxxx</p>
                                </td>
                            </tr>
                            <tr style="height:100px;">
                                <td style="vertical-align: middle;"> อังคาร
                                    <p>xx-xx-xxxx</p></td>
                            </tr>
                            <tr style="height:100px;">
                                <td style="vertical-align: middle;"> พุธ
                                    <p>xx-xx-xxxx</p></td>
                            </tr>
                            <tr style="height:100px;">
                                <td style="vertical-align: middle;"> พฤหัส
                                    <p>xx-xx-xxxx</p></td>
                            </tr>
                            <tr style="height:100px;">
                                <td style="vertical-align: middle;"> ศุกร์
                                    <p>xx-xx-xxxx</p></td>
                            </tr>
                            <tr style="height:100px;">
                                <td style="vertical-align: middle;"> เสาร์
                                    <p>xx-xx-xxxx</p></td>
                            </tr>
                            <tr style="height:100px;">
                                <td style="vertical-align: middle;"> อาทิตย์
                                    <p>xx-xx-xxxx</p></td>
                            </tr>
                        </tbody>
                      </table>
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
