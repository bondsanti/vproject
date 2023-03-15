@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            จัดการข้อมูลการจอง
            <small>Bookings management</small>
        </h1>
        {{-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol> --}}
    </section>


    <!-- Main content -->
    <section class="content">


        <!-- table boxes -->
        <div class="row">
            <!-- /.col -->
            <div class="col-md-12">
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            ตารางข้อมูลการจอง
                        </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="tableUser" style="width:100%" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">Code</th>
                                    <th class="text-center">ชื่อ-สกุล</th>
                                    <th class="text-center">ประเภทผู้ใช้งาน</th>
                                    <th class="text-center">ทีม</th>
                                    <th class="text-center">สถานะ</th>
                                    <th class="text-center">Action</th>
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
                                <div class="box-body">


                                    <div class="form-group">
                                        <label for="" class="col-sm-4 control-label">ชื่อ-สกุล</label>

                                        <div class="col-sm-6">
                                        <input type="fullname" class="form-control" id="fullname_edit" name="fullname_edit" placeholder="ชื่อ-สกุล" required>
                                        <small class="text-danger mt-1 fullname_err2"></small>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="" class="col-sm-4 control-label">ประเภทผู้ใช้งาน</label>

                                        <div class="col-sm-6">
                                            <select class="form-control" id="role_edit" name="role_edit" required>
                                                <option value="">เลือก</option>
                                                <option value="admin">Admin</option>
                                                <option value="staff">Staff</option>
                                                <option value="user">User</option>
                                              </select>
                                              <small class="text-danger mt-1 role_err2"></small>
                                        </div>

                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-4 control-label">ทีม</label>

                                        <div class="col-sm-6">
                                            <select class="form-control" id="team_id_edit" name="team_id_edit" required>
                                                <option value="0">ไม่มีทีม</option>
                                                <option value="1">ทีม 1</option>
                                                <option value="2">ทีม 2</option>
                                                <option value="3">ทีม 3</option>
                                              </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="" class="col-sm-4 control-label">สถานะ</label>

                                        <div class="col-sm-6">
                                            <select class="form-control" id="active_edit" name="active_edit" required>
                                                <option value="enable">Enable</option>
                                                <option value="disable">Disable</option>
                                              </select>
                                        </div>
                                    </div>
                                </div>
                        </div>
                        <div class="modal-footer">
                          {{-- <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">ออก</button> --}}
                          <button type="submit" class="btn btn-success btn-block" id="update" >อัพเดท</button>
                          {{-- <button type="reset" class="btn btn-danger btn-block">ล้าง</button> --}}
                        </div>
                        </form>
                      </div>
                      <!-- /.modal-content -->
                    </div>
                    <!-- /.modal-dialog -->
                </div>
                  <!-- /.modal -->


            </div>
            <!-- /.modal -->

        </div>
        <!-- /.row -->


    </section>
    <!-- /.content -->
@endsection


@push('script')
    <script>
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            // const tableUser = $('#tableUser').DataTable({
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
            //             data: 'fullname',
            //             name: 'fullname'
            //         },
            //         {
            //             data: 'role',
            //             name: 'role'
            //         },
            //         {
            //             data: 'team_id',
            //             name: 'team_id'
            //         },
            //         {
            //             data: 'active',
            //             name: 'active'
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
                const password = $("#password").val();
                const fullname = $("#fullname").val();
                const role = $("#role").val();
                const team_id = $("#team_id").val();
                const active = $("#active").val();

                $.ajax({
                    data: $('#userForm').serialize(),
                    url: "{{ route('user.insert') }}",
                    type: "POST",
                    dataType: 'json',
                    //console.log(data);
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
                                tableUser.draw();
                            } else {
                                printErrorMsg(data.error);
                                $('#savedata').html('ลองอีกครั้ง');
                                $('#userForm').trigger("reset");
                                // $('#userForm')[0].reset();
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


            $('body').on('click', '.deleteUser', function() {

                const user_id = $(this).data("id");

                //confirm("Are You sure want to delete this Post!");
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
                                tableUser.draw();
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
                    //console.log(data);
                    $('#id_edit').val(data.id);
                    // $('#code').val(data.code);
                    // $('#password').val(data.password);
                    $('#fullname_edit').val(data.fullname);
                    $('#role_edit').val(data.role);
                    $('#team_id_edit option[value="'+data.team_id+'"]').prop('selected', true);
                    $('#active_edit').val(data.active);
                });
            });

            $('#update').click(function(e) {
                e.preventDefault();
                $(this).html('รอสักครู่..');
                const _token = $("input[name='_token']").val();
                const id = $("#id_edit").val();
                const fullname= $("#fullname_edit").val();
                const role= $("#role_edit").val();
                const team_id= $("#team_id_edit").val();
                const active = $("#active_edit").val();

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
                                tableUser.draw();
                            } else {
                                printErrorMsg2(data.error);
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
            function printErrorMsg2(msg) {
                $.each(msg, function(key, value) {
                    //console.log(key);
                    $('.' + key + '_err2').text(value);
                });
            }
        });
    </script>
@endpush
