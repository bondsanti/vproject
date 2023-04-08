@extends('layouts.app')

@section('content')
    <section class="content-header">
        <h1>
            จัดการสายงาน
            <small>SubTeam management</small>
            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createModal">
                <i class="fa fa-plus"></i> เพิ่มข้อมูล
            </button>
        </h1>
        {{-- <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Dashboard</li>
    </ol> --}}
    </section>
    <?php

    $groupedData = [];
    foreach ($subteams as $row) {
        $groupedData[$row->id]['id'] = $row->id;
        $groupedData[$row->id]['team_name'] = $row->team_name;
        $groupedData[$row->id]['subteams'][] = [
            'id' => $row->id,
            'subteam_name' => $row->subteam_name,
        ];
    }

    // Convert data to JSON
    $jsonData = json_encode(array_values($groupedData));

      ?>

    <!-- Main content -->
    <section class="content">
        <!-- table boxes -->
        <div class="row">
            <!-- /.col -->
            <div class="col-md-12">
                {{-- @php
                    echo "<pre>";
                    print_r($jsonData);
                    echo "</pre>";
                @endphp --}}
                <div class="box box-solid">
                    <div class="box-header">
                      <h3 class="box-title">รายชื่อสายงาน แบ่งตามกลุ่ม</h3>

                      <div class="box-tools pull-right">
                        <button type="button" class="btn btn-default btn-sm" data-widget="collapse"><i class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-default btn-sm" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                      </div>
                    </div>
                    <!-- /.box-header -->
                    <div id="myBody" class="box-body">
                        @foreach (json_decode($jsonData) as $team)
                        <div class="col-md-2">
                            <div class="box box-warning  box-solid">
                              <div class="box-header">
                                <h3 class="box-title">ทีม {{$team->team_name}}</h3>

                                <div class="box-tools pull-right">
                                  <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i>
                                  </button>

                                </div>
                                <!-- /.box-tools -->
                              </div>
                              <!-- /.box-header -->
                              <div class="box-body">
                                <ul class="nav nav-pills nav-stacked">
                                    @foreach ($team->subteams as $subteam)

                                        <li> {{$subteam->subteam_name}}
                                        {{-- <span class="pull-right text-red"> {{$subteam->subteam_name}}</span></li> --}}
                                    @endforeach
                                </ul>



                              </div>
                              <!-- /.box-body -->
                            </div>
                            <!-- /.box -->
                          </div>
                          <!-- /.col -->
                        @endforeach
                    </div>
                </div>

                    <!-- /.box-header -->

            </div>
            <!-- /.col -->

            <div class="col-md-12">
                <div class="box box-primary">
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="table_show" style="width:100%" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="text-center" width="10%">#</th>
                                    <th class="text-center" width="">ชื่อสายงาน</th>
                                    <th class="text-center" width="">ชื่อทีม</th>

                                    <th class="text-center" width="20%">Action</th>
                                </tr>
                            </thead>
                            <tbody class="text-center">
                                @foreach ( $subteamsList as  $row)


                                <tr>
                                    <td> {{ $loop->index+1 }}</td>
                                    <td>{{ $row->subteam_name }}</td>
                                    <td>{{ $row->team_name }}</td>

                                    <td>
                                        <button  data-id="{{$row->id}}" data-original-title="Edit" class="btn btn-primary btn-sm editData"><i class="fa fa-pencil"></i> แก้ไข</button>


                                          <button class="btn btn-danger btn-sm delete-item" data-id="{{$row->id}}">
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
            </div>
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
                    <label for="" class="col-sm-4 control-label">เลือกทีม</label>
                    <div class="col-sm-6">
                    <select class="form-control select2" style="width: 100%;" name="team_id" autocomplete="off" required>
                    <option value="">เลือก</option>
                    @foreach ($teams as $team)
                    <option value="{{$team->id}}">{{$team->team_name}}</option>
                    @endforeach
                    </select>
                    <small class="text-danger mt-1 team_err"></small>
                    </div>
                </div>
                <div class="form-group">
                     <label for="" class="col-sm-4 control-label">ชื่อสายงาน</label>
                     <div class="col-sm-6">
                          <input type="text" class="form-control" id="subteam_name" name="subteam_name" placeholder="" autocomplete="off">
                          <small class="text-danger mt-1 subteam_err"></small>
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
                        <label for="" class="col-sm-4 control-label">เลือกทีม</label>
                        <div class="col-sm-6">
                        <select class="form-control select2" style="width: 100%;" id="team_id_edit" name="team_id_edit" autocomplete="off" required>
                        <option value="">เลือก</option>
                        @foreach ($teams as $team)
                        <option value="{{$team->id}}">{{$team->team_name}}</option>
                        @endforeach
                        </select>
                        <small class="text-danger mt-1 team_err"></small>
                        </div>
                    </div>
                    <div class="form-group">
                         <label for="" class="col-sm-4 control-label">ชื่อสายงาน</label>
                         <div class="col-sm-6">
                              <input type="text" class="form-control" id="subteam_name_edit" name="subteam_name_edit" placeholder="" autocomplete="off">
                              <small class="text-danger mt-1 subteam_err"></small>
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

            $('#create').click(function() {
                $('#savedata').val("create-data");
                $('#id').val('');
                $('#addForm').trigger("reset");
                //$('#modal-default').modal('show');
            });

            $('#savedata').click(function(e) {
                e.preventDefault();
                $(this).html('รอสักครู่..');
                const _token = $("input[name='_token']").val();
                const team_id = $("#team_id").val();
                const subteam_name = $("#subteam_name").val();

                $.ajax({
                    data: $('#addForm').serialize(),
                    url: "{{ route('subteam.insert') }}",
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
                                setTimeout("location.href = '{{ route("subteam") }}';",1300);
                                //window.location.href = '{{ route("team") }}';
                            } else {
                                printErrorMsg(data.error);
                                $('#savedata').html('ลองอีกครั้ง');
                                $('.team_err').text(data.error.team_id);
                                $('.subteam_err').text(data.error.subteam_name);
                                $('#addForm').trigger("reset");

                                Swal.fire({
                                    position: 'top-center',
                                    icon: 'error',
                                    title: 'เกิดข้อผิดพลาด',
                                    showConfirmButton: true,
                                    timer: 1300
                                });
                            }

                        } else {
                            Swal.fire({
                                position: 'top-center',
                                icon: 'error',
                                title: 'เกิดข้อผิดพลาด!',
                                showConfirmButton: true,
                                timer: 1300
                            });
                            $('#addForm')[0].reset();
                        }


                    },

                });
            });

            $('body').on('click', '.delete-item', function() {
                const subteam_id = $(this).data("id");
                //console.log(subteam_id);
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
                            url: "subteam" + '/' + subteam_id,

                            success: function(data) {

                                setTimeout("location.href = '{{ route("subteam") }}';",1000);

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

                const subteam_id = $(this).data('id');
                //console.log(subteam_id);
                $('#editData').modal('show');
                //$('#updatedata').val("edit-data");
                $.get("subteam/edit" +'/' + subteam_id , function (data) {

                   $('#id_edit').val(data.id);
                   $('#team_id_edit option[value="'+data.team_id+'"]').prop('selected', true);
                   $('#subteam_name_edit').val(data.subteam_name);

                });
            });

            $('#updatedata').click(function(e) {
                e.preventDefault();
                $(this).html('รอสักครู่..');
                const _token = $("input[name='_token']").val();
                const id = $("#id_edit").val();
                const team_id= $("#team_id_edit").val();
                const subteam_name= $("#subteam_name_edit").val();
                //console.log(id);
                $.ajax({
                    data: $('#editForm').serialize(),
                    url: "subteam/update"+'/'+id,
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
                                setTimeout("location.href = '{{ route("subteam") }}';",1300);
                            } else {
                                printErrorMsg2(data.error);
                                $('.team2_err').text(data.error.team_id_edit);
                                $('.subteam2_err').text(data.error.subteam_name_edit);
                                $('#editData').trigger("reset");
                                $('#updatedata').html('ลองอีกครั้ง');

                                //$('#userFormEdit').trigger("reset");
                                Swal.fire({
                                    position: 'top-center',
                                    icon: 'error',
                                    title: 'เกิดข้อผิดพลาด',
                                    showConfirmButton: true,
                                    timer: 1300
                                });
                            }

                        } else {
                            Swal.fire({
                                position: 'top-center',
                                icon: 'error',
                                title: 'เพิ่มข้อมูลสำเร็จ!',
                                showConfirmButton: true,
                                timer: 1300
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
