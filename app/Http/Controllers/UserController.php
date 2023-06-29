<?php

namespace App\Http\Controllers;
use Session;
use DataTables;
use App\Models\Role_user;
use App\Models\User;
use App\Models\Booking;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Phattarachai\LineNotify\Line;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
   public function index(Request $request){

    $dataUserLogin = User::where('id', '=', Session::get('loginId'))->first();

    $dataRoleUser = Role_user::where('user_id',"=", Session::get('loginId'))->first();


       $countUser = Role_user::count();
       $countUserAdmin = Role_user::whereIn('role_type',['Admin','SuperAdmin'])->count();
       $countUserStaff= Role_user::where('role_type',"=",'Staff')->count();
       $countUserSale= Role_user::where('role_type',"=",'Sale')->count();
       $countUserOther= Role_user::where('role_type',"=",'User')->count();
       $users = Role_user::with('user_ref:id,code,name_th,active_vproject,active')->get();



       // dd($users);

        // if ($request->ajax()) {
        //    $allData = DataTables::of($users)
        //    ->addIndexColumn()
        //    ->addColumn('name' ,function($row){
        //      $name = $row->user_ref->name_th;
        //     return $name;
        //     })
        //    ->addColumn('role_type' ,function($row){
        //     if ($row->role_type =="Admin") {
        //         $role_type = '<span class="label label-success">Admin</span>';
        //     }else if($row->role_type =="Staff"){
        //         $role_type = '<span class="label label-warning">Staff</span>';
        //     }else{
        //         $role_type = '<span class="label label-primary">Sell</span>';
        //     }
        //     return $role_type;
        //     })
        //    ->addColumn('action' ,function($row){
        //     if ($row->role_type =="Admin") {
        //         $btn = '-';
        //     }else{
        //         $btn = '<button  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-primary btn-sm editUser"><i class="fa fa-pencil"></i> แก้ไข</button>';
        //         $btn = $btn.' <button  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteUser"><i class="fa fa-trash"></i> ลบ</button>';
        //     }
        //     return $btn;
        //     })
        //     ->rawColumns(['name','role_type','action'])
        //     ->make(true);

        //     return $allData;
        // }




    return view('user.index',compact(
        'dataUserLogin','dataRoleUser',
        'countUser',
        'countUserAdmin',
        'countUserStaff',
        'countUserSale',
        'countUserOther',
        'users'));
   }

   public function insert(Request $request){

        $user = User::where('code',$request->code)->first();

       // dd($user);

       if (!$user) {
        return response()->json([
            'message' => 'Code ไม่ถูกต้อง'
        ], 400);

       }else{

        $validator = Validator::make($request->all(),[
            'code'=>'required',
            'role_type'=>'required'
        ],[
            'code.required'=>'กรอก Code',
            'role_type.required' => 'เลือกประเภทผู้ใช้งาน',
        ]);



        if ($validator->passes()) {

            $role_user = New Role_user();
            $role_user->user_id = $user->id;
            $role_user->role_type = $request->role_type;
            $role_user->save();

            $user->active_vproject = "1";
            $user->save();

            return response()->json([
                'message' => 'เพิ่มข้อมูลสำเร็จ'
            ], 201);

        }
        return response()->json(['error'=>$validator->errors()]);

       }






   }

   public function destroy($id){

            $checkDataBooking = Booking::where('user_id',$id)->orwhere('teampro_id',$id)->count();

            if ($checkDataBooking > 0 ) {

                return response()->json([
                    'message' => 'ไม่สามารถลบได้ ต้อง Disable เท่านั้น'
                ], 400);

            }else{

                $user = User::where('id',"=",$id)->first();
                $user->active_vproject = "0";
                $user->save();

                Role_user::where('user_id',"=",$id)->delete($id);
               //Role_user::find($id)->delete($id);


               return response()->json([
                   'message' => 'ลบข้อมูลสำเร็จ'
               ], 201);

            }


   }

   public function edit($id){

        $user = Role_user::with('user_ref:id,code,name_th,active_vproject')->where('user_id', '=', $id)->first();

        return response()->json($user, 200);
   }

    public function update(Request $request,$id){


        $role_user = Role_user::with('user_ref:id,code,name_th,active_vproject')->where('id', '=', $id)->first();

        //dd($role_user->user_ref[0]->id);
        $user = User::where('id',"=",$role_user->user_ref[0]->id)->first();

     //dd($user);
        if(!$role_user){
            return response()->json([
                'errors' => [
                    'message'=>'ไม่สามารถอัพเดทข้อมูลได้ ID ไม่ถูกต้อง..'
                    ]
            ],400);
        }

        $validator = Validator::make($request->all(),[
            'role_edit'=>'required'
        ],[
            'role_edit.required' => 'เลือกประเภทผู้ใช้งาน',
        ]);


        if ($validator->passes()) {

            $role_user->role_type = $request->role_edit;

            $role_user->save();

            $user->active_vproject = $request->r1;
            $user->save();

            return response()->json([
                'message' => 'อัพเดทข้อมูลสำเร็จ'
            ], 201);

        }

        return response()->json(['error'=>$validator->errors()]);
    }

    public function testteam(Request $request){
        $dataUserLogin = array();

        if (Session::has('loginId')) {
           $dataUserLogin = User::where('id',"=", Session::get('loginId'))->first();
           $data = DB::table('teams')
           ->leftJoin('subteams', 'teams.id', '=', 'subteams.team_id')
           ->select('teams.id', 'teams.team_name', 'subteams.subteam_name')
           ->orderBy('teams.id')
           ->get();

           //dd($data);
          return view('user.test',compact('data'));

        //    $data = DB::table('teams')
        //     ->leftJoin('subteams', 'teams.id', '=', 'subteams.team_id')
        //     ->select('teams.id', 'teams.team_name', 'subteams.subteam_name')
        //     ->orderBy('teams.id')
        //     ->get();

        // $grouped = $data->groupBy('id');

        // $response = [];

        // foreach ($grouped as $teamId => $subteams) {
        //     $team = [
        //         'team_id' => $teamId,
        //         'team_name' => $subteams->first()->team_name,
        //         'subteams' => [],
        //     ];

        //     foreach ($subteams as $subteam) {
        //         $team['subteams'][] = [
        //             'subteam_name' => $subteam->subteam_name,
        //         ];
        //     }

        //     $response[] = $team;
        // }

        // return response()->json($response);


        }


    }

}
