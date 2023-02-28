@extends('layouts.app')

@section('content')


    <section class="content-header">
        <h1>
            จัดการผู้ใช้งานระบบ
            <small>User management</small>
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
                    <div class="box-header">
                      <h3 class="box-title">
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                            <i class="fa fa-plus"></i> เพิ่มข้อมูล
                      </button>
                    </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <table id="example2" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th>#</th>
                          <th>Code</th>
                          <th>ชื่อ-สกุล</th>
                          <th>ประเภทผู้ใช้งาน</th>
                          <th>สถานะ</th>
                          <th>เครื่องมือ</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                          <td>1</td>
                          <td>Trident</td>
                          <td>Internet
                            Explorer 4.0
                          </td>
                          <td>Win 95+</td>
                          <td> 4</td>
                          <td>X</td>
                        </tr>

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
