@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            จัดการทีม
            <small>Team management</small>
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
                <div class="alert alert-info alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h4><i class="icon fa fa-info"></i> Alert!</h4>
                    หาก Team ไหนมีข้อมูลการจอง จะไม่สามารถ ลบ ได้
                  </div>
                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">
                                <i class="fa fa-plus"></i> เพิ่มข้อมูล
                            </button>
                        </h3>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="table" style="width:100%" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" width="10%">#</th>
                                    <th class="text-center" width="">ชื่อทีม</th>
                                    <th class="text-center" width="20%">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ( $teams as  $team)


                                <tr>
                                    <td> {{ $loop->index+1 }}</td>
                                    <td>{{ $team->team_name }}</td>

                                    <td>
                                        <button  data-id="{{$team->id}}" data-original-title="Edit" class="btn btn-primary btn-sm editData"><i class="fa fa-pencil"></i> แก้ไข</button>


                                          <button class="btn btn-danger btn-sm delete-item" data-id="{{$team->id}}">
                                            <i class="fa fa-trash">
                                            </i>
                                            ลบ
                                        </button>
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

    <div class="modal fade" id="createModal">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">เพิ่มข้อมูล</h4>
            </div>
            <form id="addForm" name="addForm" class="form-horizontal">

                @csrf
                <input type="hidden" name="id" id="id">
            <div class="modal-body">
                <div class="form-group">
                     <label for="" class="col-sm-4 control-label">ชื่อทีม</label>
                     <div class="col-sm-6">
                          <input type="text" class="form-control" id="team_name" name="team_name" placeholder="Team name" autocomplete="off">
                          <small class="text-danger mt-1 team_err"></small>
                     </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">ออก</button>
              <button type="button" class="btn btn-primary" id="savedata">บันทึก</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
      <!-- /.modal -->

      <div class="modal fade" id="editData">
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span></button>
              <h4 class="modal-title">แก้ไข</h4>
            </div>
            <form id="editForm" name="editForm" class="form-horizontal">

                @csrf
                <input type="hidden" name="id_edit" id="id_edit">
            <div class="modal-body">
                <div class="form-group">
                     <label for="" class="col-sm-4 control-label">ชื่อทีม</label>
                     <div class="col-sm-6">
                          <input type="text" class="form-control" id="team_name_edit" name="team_name_edit" placeholder="Team name" autocomplete="off">
                          <small class="text-danger mt-1 team2_err"></small>
                     </div>
                </div>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">ออก</button>
              <button type="button" class="btn btn-primary" id="updatedata">บันทึก</button>
            </div>
            </form>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


@endsection


@push('script')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#create').click(function() {
                $('#savedata').val("create-data");
                $('#id').val('');
                $('#addForm').trigger("reset");
                $('#modal-default').modal('show');
            });

            $('#savedata').click(function(e) {
                e.preventDefault();
                $(this).html('รอสักครู่..');
                const _token = $("input[name='_token']").val();
                const team_name = $("#team_name").val();

                $.ajax({
                    data: $('#addForm').serialize(),
                    url: "{{ route('team.insert') }}",
                    type: "POST",
                    dataType: 'json',

                    success: function(data) {
                        //console.log(data)
                        if (data.success = true) {

                            if ($.isEmptyObject(data.error)) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'เพิ่มข้อมูลสำเร็จ!',
                                    showConfirmButton: true,
                                    timer: 2500
                                });

                                $('#addForm')[0].reset();
                                $('#editData').modal('hide');
                                setTimeout("location.href = '{{ route("team") }}';",2000);
                                //window.location.href = '{{ route("team") }}';
                            } else {
                                printErrorMsg(data.error);
                                $('#savedata').html('ลองอีกครั้ง');
                                $('.team_err').text(data.error.team_name);
                                $('#addForm').trigger("reset");

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
                            $('#addForm')[0].reset();
                        }


                    },

                });
            });

            $('body').on('click', '.delete-item', function() {
                const team_id = $(this).data("id");
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
                            url: "team" + '/' + team_id,

                            success: function(data) {

                                setTimeout("location.href = '{{ route("team") }}';",1000);

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


            $('body').on('click', '.editData', function () {

                const team_id = $(this).data('id');
                $('#editData').modal('show');
                //$('#updatedata').val("edit-data");
                $.get("team/edit" +'/' + team_id , function (data) {
                    //console.log(data.team_name);
                   $('#id_edit').val(data.id);
                   $('#team_name_edit').val(data.team_name);
                });
            });

            $('#updatedata').click(function(e) {
                e.preventDefault();
                $(this).html('รอสักครู่..');
                const _token = $("input[name='_token']").val();
                const id = $("#id_edit").val();
                const team_name= $("#team_name_edit").val();
                console.log(id);
                $.ajax({
                    data: $('#editForm').serialize(),
                    url: "team/update"+'/'+id,
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
                                $('#editData').trigger("reset");
                                $('#editData').modal('hide');
                                //tableUser.draw();
                                setTimeout("location.href = '{{ route("team") }}';",2000);
                            } else {
                                printErrorMsg2(data.error);
                                $('.team2_err').text(data.error.team_name_edit);
                                $('#editData').trigger("reset");
                                $('#updatedata').html('ลองอีกครั้ง');

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
