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

            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-aqua">
                    <div class="inner">
                        <h3>{{ $countUser }}</h3>

                        <p>ข้อมูลผู้ใช้งานทั้งหมด</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-users" aria-hidden="true"></i>
                    </div>

                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-green">
                    <div class="inner">
                        <h3>{{ $countUserAdmin }}</h3>

                        <p>ผู้ใช้งาน [Admin]</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-plus" aria-hidden="true"></i>
                    </div>

                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-yellow">
                    <div class="inner">
                        <h3>{{ $countUserStaff }}</h3>

                        <p>ผู้ใช้งาน [Staff]</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-plus" aria-hidden="true"></i>
                    </div>

                </div>
            </div>
            <!-- ./col -->
            <div class="col-lg-3 col-xs-6">
                <!-- small box -->
                <div class="small-box bg-blue">
                    <div class="inner">
                        <h3>{{ $countUserSale }}</h3>

                        <p>ผู้ใช้งาน [Sale]</p>
                    </div>
                    <div class="icon">
                        <i class="fa fa-user-plus" aria-hidden="true"></i>
                    </div>

                </div>
            </div>
            <!-- ./col -->

        </div>
        <!-- table boxes -->
        <div class="row">
            <!-- /.col -->
            <div class="col-md-12">
                <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-info"></i> Alert!</h4>
                    หาก Staff & Sale ท่านไหนมีข้อมูลการจอง จะไม่สามารถ ลบ ได้ หากไม่ใช้งาน User นั้นแล้วให้ทำการ <strong> Disable </strong> เพื่อปิดใช้งาน
                  </div>
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            <button type="button" class="btn btn-primary" href="javascript:void(0)" id="createNewPost">
                                <i class="fa fa-plus"></i> เพิ่มข้อมูล
                            </button>
                            {{-- <button  type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                                <i class="fa fa-plus"></i> เพิ่มข้อมูล
                            </button > --}}
                        </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="table_show" style="width:100%" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Code</th>
                                    <th class="text-center">ชื่อ-สกุล</th>
                                    <th class="text-center">ประเภทผู้ใช้งาน</th>
                                    <th class="text-center">สถานะ</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ( $users as  $user)


                                <tr>
                                    <td> {{ $loop->index+1 }}</td>
                                    <td>{{ $user->user_ref[0]->code }}</td>
                                    <td>{{ $user->user_ref[0]->name_th }}</td>
                                    <td>{{$user->role_type}}</td>
                                    <td>{{($user->user_ref[0]->active_vproject=="0") ? "Disable":"Enable"}}</td>

                                    <td>
                                        @if ($user->role_type!="SuperAdmin")
                                        <button  data-id="{{$user->user_id}}" data-original-title="Edit" class="btn btn-primary btn-sm editUser"><i class="fa fa-pencil"></i> แก้ไข</button>



                                          <button class="btn btn-danger btn-sm delete-item" data-id="{{$user->user_id}}">
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
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->

            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->


            <div class="modal fade" id="modal-default">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="">เพิ่มข้อมูล</h4>
                        </div>
                        <form id="userForm" name="userForm" class="form-horizontal">
                            @csrf
                        <div class="modal-body">
                            <!-- form start -->

                                <input type="hidden" name="id" id="id">
                                <div class="box-body">

                                    <div class="form-group">
                                        <label for="" class="col-sm-4 control-label">Code</label>

                                        <div class="col-sm-6">
                                            <input type="text" class="form-control" id="code" name="code" placeholder="code" autocomplete="off">
                                        <small class="text-danger mt-1 code_err"></small>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <label for="" class="col-sm-4 control-label">ประเภทผู้ใช้งาน</label>

                                        <div class="col-sm-6">
                                            <select class="form-control" id="role_type" name="role_type">

                                                <option value="Admin">Admin</option>
                                                <option value="Staff">Staff</option>
                                                <option value="Sale">Sale</option>
                                              </select>
                                              <small class="text-danger mt-1"></small>
                                        </div>


                                    </div>

                                </div>
                        </div>
                        <div class="modal-footer">
                          {{-- <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">ออก</button> --}}
                          <button type="submit" class="btn btn-success btn-block" id="savedata" value="create">ตกลง</button>
                          {{-- <button type="reset" class="btn btn-danger btn-block">ล้าง</button> --}}
                        </div>
                        </form>
                    </div>
                      <!-- /.modal-content -->
                </div>
                    <!-- /.modal-dialog -->
            </div>
                  <!-- /.modal -->

            <div class="modal fade" id="modal-update">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="">แก้ไข</h4>
                        </div>
                        <div class="modal-body">
                            <!-- form start -->
                            <form id="userFormEdit" name="userFormEdit" class="form-horizontal">
                                @csrf
                                <input type="hidden" name="id_edit" id="id_edit">
                                <input type="hidden" name="user_id" id="user_id">
                                <div class="box-body">

                                    <div class="form-group">
                                        <label for="" class="col-sm-4 control-label">ประเภทผู้ใช้งาน</label>

                                        <div class="col-sm-6">
                                            <select class="form-control" id="role_edit" name="role_edit" required>
                                                <option value="">เลือก</option>
                                                <option value="Admin">Admin</option>
                                                <option value="Staff">Staff</option>
                                                <option value="Sale">Sale</option>
                                              </select>
                                              <small class="text-danger mt-1 role_err2"></small>
                                        </div>
                                        <label for="" class="col-sm-4 control-label">สถานะใช้งาน</label>
                                        <div class="col-sm-6">
                                            <div style="margin-top:10px">
                                                <label>
                                                  <input type="radio" id="r1" name="r1" value="1" class="minimal">
                                                  Enable
                                                </label>
                                                <label>
                                                  <input type="radio" id="r1" name="r1" value="0" class="minimal">
                                                  Disable
                                                </label>
                                            </div>

                                        </div>

                                    </div>

                                </div>
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-success btn-block" id="update" >อัพเดท</button>
                        </div>
                        </form>
                      </div>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->

            </div>
            <!-- /.modal -->




    </section>
    <!-- /.content -->
@endsection


@push('script')
<script>
    $(function () {

      $('#table_show').DataTable({
        'paging'      : true,
        'lengthChange': true,
        'searching'   : true,
        'ordering'    : true,
        'autoWidth'   : false
      })
    })
  </script>
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // const tableUser = $('#tableUser_').DataTable({
            //     processing: true,
            //     serverSide: true,
            //     scrollX: true,
            //     order: [
            //         [0, 'desc']
            //     ],
            //     ajax: "{{ route('user') }}",
            //     columns: [{
            //             data: 'DT_RowIndex',
            //             name: 'DT_RowIndex'
            //         },
            //         {
            //             data: 'code',
            //             name: 'code'
            //         },
            //         {
            //             data: 'name',
            //             name: 'name'
            //         },
            //         {
            //             data: 'role_type',
            //             name: 'role_type'
            //         },
            //         {
            //             data: 'action',
            //             name: 'action',
            //             orderable: false,
            //             searchable: false
            //         },
            //     ]
            // });

            $('#createNewPost').click(function() {
                $('#savedata').val("create-user");
                $('#id').val('');
                $('#userForm').trigger("reset");
                $('#modal-default').modal('show');
            });

            $('#savedata').click(function(e) {
                e.preventDefault();
                $(this).html('รอสักครู่..');
                const _token = $("input[name='_token']").val();
                const code = $("#code").val();
                const role_type = $("#role_type").val();

                $.ajax({
                    data: $('#userForm').serialize(),
                    url: "{{ route('user.insert') }}",
                    type: "POST",
                    dataType: 'json',

                    success: function(data) {
                        //console.log(data.error)
                        if (data.success = true) {

                            if ($.isEmptyObject(data.error)) {
                                Swal.fire({

                                    icon: 'success',
                                    title: 'เพิ่มข้อมูลสำเร็จ!',
                                    showConfirmButton: true,
                                    timer: 2500
                                });
                                // $('#userForm').trigger("reset");
                                $('#userForm')[0].reset();
                                $('#modal-default').modal('hide');
                                //tableUser.draw();
                                window.location.href = '{{ route("user") }}';
                            } else {
                                printErrorMsg(data.error);
                                $('#savedata').html('ลองอีกครั้ง');
                                $('#userForm').trigger("reset");
                                $('.code_err').text(data.error.code);
                                $('.role_err').text(data.error.role_type);
                                Swal.fire({
                                    position: 'top-center',
                                    icon: 'error',
                                    title: 'เกิดข้อผิดพลาด',
                                    showConfirmButton: true,
                                    timer: 2500
                                });
                            }

                        } else {
                            Swal.fire({
                                position: 'top-center',
                                icon: 'error',
                                title: 'เพิ่มข้อมูลสำเร็จ!',
                                showConfirmButton: true,
                                timer: 2500
                            });
                            $('#userForm')[0].reset();
                        }


                    },

                });
            });


            $('body').on('click', '.delete-item', function() {

                const user_id = $(this).data("id");
                //console.log(user_id);

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
                            url: "user" + '/' + user_id,

                            success: function(data) {
                                //tableUser.draw();
                                window.location.href = '{{ route("user") }}';
                            },
                            error: function(data) {
                                //console.log('Error:', data);
                            }
                        });
                        Swal.fire(
                            'สำเร็จ!',
                            'ลบข้อมูลเรียบร้อย..',
                            'success'
                        )
                    }
                });

            });


            $('body').on('click', '.editUser', function () {

                const user_id = $(this).data('id');
                //console.log(user_id);
                $('#modal-update').modal('show');
                $('#savedata').val("edit-user");
                $('#modelHeading').html("แก้ไข");

                $.get("user/edit" +'/' + user_id , function (data) {
                    //console.log(data.user_ref[0].active_vproject);
                   $('#id_edit').val(data.id);
                   $('#user_id').val(data.user_ref[0].user_id);
                   //console.log(data.id);
                   //$('#code_edit').val(data.user_ref[0].code);
                   $('#role_edit option[value="'+data.role_type+'"]').prop('selected', true);
                   $('input[name="r1"][value="'+data.user_ref[0].active_vproject+'"]').prop('checked', true);

                });
            });

            $('#update').click(function(e) {
                e.preventDefault();
                $(this).html('รอสักครู่..');
                const _token = $("input[name='_token']").val();
                const id = $("#id_edit").val();
                const user_id = $("#user_id").val();
                //const code= $("#code_edit").val();
                const role= $("#role_edit").val();
                const r1= $("#r1").val();
                //console.log(r1);
                $.ajax({
                    data: $('#userFormEdit').serialize(),
                    url: "user/update"+'/'+id,
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
                                    timer: 2500
                                });
                                $('#userFormEdit').trigger("reset");
                                $('#modal-update').modal('hide');
                                //tableUser.draw();
                                window.location.href = '{{ route("user") }}';
                            } else {

                                $('#update').html('ลองอีกครั้ง');

                                //$('#userFormEdit').trigger("reset");
                                Swal.fire({
                                    position: 'top-center',
                                    icon: 'error',
                                    title: 'เกิดข้อผิดพลาด',
                                    showConfirmButton: true,
                                    timer: 2500
                                });
                            }

                        } else {
                            Swal.fire({
                                position: 'top-center',
                                icon: 'error',
                                title: 'เพิ่มข้อมูลสำเร็จ!',
                                showConfirmButton: true,
                                timer: 2500
                            });
                            $('#userFormEdit').trigger("reset");
                        }


                    },

                });
            });


            function printErrorMsg(msg) {
                $.each(msg, function(key, value) {
                    //console.log(key);
                    $('.' + key + '_err').text(value);
                });
            }

        });
    </script>
@endpush
