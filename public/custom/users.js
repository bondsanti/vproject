$(document).ready(function () {

    $.ajaxSetup({
             headers:{
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
             }
 });
  $('#tableUser').DataTable({
    processing: true,
    serverSide: true,
         ajax:"{{route('../user')}}",
         columns:[
             {data: 'DT_RowIndex', name: 'DT_RowIndex'},
             {data:'code',name:'code'},
             {data:'fullname',name:'fullname'},
             {data:'role',name:'role'},
             {data:'team_id',name:'team_id'},
             {data:'active',name:'active'},
             {data:'action',name:'action'},
         ]
  })


});
