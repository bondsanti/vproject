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
                            ตารางข้อมูล
                        </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="tableUser" style="width:100%" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center">#</th>
                                    <th class="text-center">ประเภท</th>
                                    <th class="text-center">โครงการ</th>
                                    <th class="text-center">ลูกค้า</th>
                                    <th class="text-center">ทีม</th>
                                    <th class="text-center">เจ้าหน้าที่โครงการ </th>
                                    <th class="text-center">ผู้จอง </th>
                                    <th class="text-center">สถานะ</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ( $bookings as  $booking)


                                <tr>
                                    <td>
                                        #
                                    </td>
                                    <td>
                                        <p>
                                            {{$booking->booking_title}}
                                        </p>


                                    </td>
                                    <td>
                                        <a>{{$booking->project_name}}</a>
                                        <br />
                                        <small>
                                            เวลานัด :{{date('d/m/Y',strtotime($booking->booking_start))}}
                                            {{date('H:i',strtotime($booking->booking_start))}}
                                            -
                                            {{date('H:i',strtotime($booking->booking_end))}}
                                            น.
                                        </small>
                                    </td>
                                    <td>
                                        <p> <strong>{{$booking->customer_name}}</strong></p>
                                        <small>
                                            {{$booking->customer_tel}}
                                        </small>

                                        {{-- <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <img alt="Avatar" class="table-avatar" src="../../dist/img/avatar.png">
                                            </li>
                                            <li class="list-inline-item">
                                                <img alt="Avatar" class="table-avatar" src="../../dist/img/avatar2.png">
                                            </li>
                                            <li class="list-inline-item">
                                                <img alt="Avatar" class="table-avatar" src="../../dist/img/avatar3.png">
                                            </li>
                                            <li class="list-inline-item">
                                                <img alt="Avatar" class="table-avatar" src="../../dist/img/avatar4.png">
                                            </li>
                                        </ul> --}}
                                    </td>
                                    <td class="project_progress">
                                        <p> <strong>{{$booking->team_name}}</strong></p>
                                        <small>
                                            {{$booking->subteam_name}}
                                        </small>
                                    </td>
                                    <td class="project_progress">
                                        <p>{{$booking->emp_name}} </p>
                                        <small>

                                        </small>
                                    </td>
                                    <td class="project_progress">
                                        <p>  {{$booking->sale_name}} </p>
                                        <small>

                                        </small>
                                    </td>
                                    <td class="project-state">
                                        <span class="badge badge-success">รอรับงาน</span>
                                    </td>
                                    <td class="project-actions text-right">
                                        <a class="btn btn-primary btn-sm" href="#">
                                            <i class="fa fa-folder">
                                            </i>
                                            View
                                        </a>
                                        <a class="btn btn-info btn-sm" href="#">
                                            <i class="fa fa-pencil">
                                            </i>
                                            Edit
                                        </a>
                                        <a class="btn btn-danger btn-sm" href="#">
                                            <i class="fa fa-trash">
                                            </i>
                                            Delete
                                        </a>
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


            $('body').on('click', '.editUser', function() {

                const user_id = $(this).data('id');
                //console.log(user_id);
                $('#modal-update').modal('show');
                $('#savedata').val("edit-user");
                $('#modelHeading').html("แก้ไข");

                $.get("user/edit" + '/' + user_id, function(data) {
                    //console.log(data);
                    $('#id_edit').val(data.id);
                    // $('#code').val(data.code);
                    // $('#password').val(data.password);
                    $('#fullname_edit').val(data.fullname);
                    $('#role_edit').val(data.role);
                    $('#team_id_edit option[value="' + data.team_id + '"]').prop('selected', true);
                    $('#active_edit').val(data.active);
                });
            });

            $('#update').click(function(e) {
                e.preventDefault();
                $(this).html('รอสักครู่..');
                const _token = $("input[name='_token']").val();
                const id = $("#id_edit").val();
                const fullname = $("#fullname_edit").val();
                const role = $("#role_edit").val();
                const team_id = $("#team_id_edit").val();
                const active = $("#active_edit").val();

                $.ajax({
                    data: $('#userFormEdit').serialize(),
                    url: "user/update" + '/' + id,
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
