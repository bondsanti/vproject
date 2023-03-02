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
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
            <div class="inner">
              <h3>{{$countUser}}</h3>

              <p>ข้อมูลผู้ใช้งานทั้งหมด</p>
            </div>
            <div class="icon">
                <i class="fa fa-users" aria-hidden="true"></i>
            </div>

          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3>{{$countUserActive}}</h3>

              <p>ผู้ใช้งาน [Active]</p>
            </div>
            <div class="icon">
                <i class="fa fa-user-plus" aria-hidden="true"></i>
            </div>

          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-gray">
            <div class="inner">
              <h3>{{$countUserDisable}}</h3>

              <p>ผู้ใช้งาน [Disable]</p>
            </div>
            <div class="icon">
                <i class="fa fa-user-times" aria-hidden="true"></i>
            </div>

          </div>
        </div>
        <!-- ./col -->

    </div>
        <!-- table boxes -->
        <div class="row">
              <!-- /.col -->
              <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                      <h3 class="box-title">
                            <button  type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                                <i class="fa fa-plus"></i> เพิ่มข้อมูล
                            </button >
                      </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <table id="tableUser" class="table table-bordered table-striped">
                        <thead>
                        <tr>
                          <th  class="text-center">#</th>
                          <th  class="text-center">Code</th>
                          <th  class="text-center">ชื่อ-สกุล</th>
                          <th  class="text-center">ประเภทผู้ใช้งาน</th>
                          <th  class="text-center">ทีม</th>
                          <th  class="text-center">สถานะ</th>
                          <th  class="text-center">Action</th>
                        </tr>
                        </thead>
                        <tbody class="text-center">


                        </tbody>

                      </table>
                    </div>
                    <!-- /.box-body -->
                </div>
                  <!-- /.box -->

              </div>
              <!-- /.col -->
              <div class="modal fade" id="modal-default">
                <div class="modal-dialog">
                  <div class="modal-content">
                    <div class="modal-header">
                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                      <h4 class="modal-title">เพิ่มข้อมูล</h4>
                    </div>
                    <div class="modal-body">
                          <!-- form start -->
                        <form id="userForm" name="userForm" class="form-horizontal">
                            <div class="box-body">

                                <div class="form-group">
                                    <label for="" class="col-sm-4 control-label">code</label>

                                    <div class="col-sm-6">
                                    <input type="text" class="form-control" id="" name="code" placeholder="code" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-4 control-label">Password</label>

                                    <div class="col-sm-6">
                                    <input type="password" class="form-control" id="" name="password" placeholder="Password" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-4 control-label">ชื่อ-สกุล</label>

                                    <div class="col-sm-6">
                                    <input type="fullname" class="form-control" id="" name="fullname" placeholder="ชื่อ-สกุล" required>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="" class="col-sm-4 control-label">ประเภทผู้ใช้งาน</label>

                                    <div class="col-sm-6">
                                        <select class="form-control" name="role">
                                            <option value="">เลือก</option>
                                            <option value="admin">Super Admin</option>
                                            <option value="staff">Admin</option>
                                            <option value="user">User</option>
                                          </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="" class="col-sm-4 control-label">สถานะ</label>

                                    <div class="col-sm-6">
                                        <select class="form-control" >
                                            <option value="active">Active</option>
                                            <option value="disable">Disable</option>
                                          </select>
                                    </div>
                                </div>
                            </div>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">ออก</button>
                      <button type="submit" class="btn btn-success" id="savedata" value="create">ตกลง</button>
                    </div>
                    </form>
                  </div>
                  <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
              <!-- /.modal -->
        </div>
        <!-- /.row -->


    </section>
    <!-- /.content -->


@endsection
