<?php

namespace App\Http\Controllers;
use Session;
use App\Models\User;
use DataTables;
use App\Models\Role_user;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Phattarachai\LineNotify\Line;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
   public function index(Request $request){
    $dataUserLogin = array();

    $dataUserLogin = DB::connection('mysql_user')->table('users')
    ->where('id', '=', Session::get('loginId'))
    ->first();

    $dataRoleUser = Role_user::where('user_id',"=", Session::get('loginId'))->first();


       $countUser = Role_user::count();
       $countUserAdmin = Role_user::where('role_type',"=",'Admin')->count();
       $countUserStaff= Role_user::where('role_type',"=",'Staff')->count();
       $countUserSell= Role_user::where('role_type',"=",'Sell')->count();
       $users = Role_user::with('user_ref:id,code,name_th')->get();

       dd($users);

        if ($request->ajax()) {
           $allData = DataTables::of($users)
           ->addIndexColumn()
           ->addColumn('role_type' ,function($row){
            if ($row->role_type =="Admin") {
                $role_type = '<span class="label label-success">Admin</span>';
            }else if($row->role_type =="Staff"){
                $role_type = '<span class="label label-warning">Staff</span>';
            }else{
                $role_type = '<span class="label label-primary">Sell</span>';
            }
            return $role_type;
            })
           ->addColumn('action' ,function($row){
            if ($row->role_type =="Admin") {
                $btn = '-';
            }else{
                $btn = '<button  data-id="'.$row->id.'" data-original-title="Edit" class="btn btn-primary btn-sm editUser"><i class="fa fa-pencil"></i> แก้ไข</button>';
                $btn = $btn.' <button  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteUser"><i class="fa fa-trash"></i> ลบ</button>';
            }
            return $btn;
            })
            ->rawColumns(['role_type','action'])
            ->make(true);

            return $allData;
        }




    return view('user.admin.index',compact(
        'dataUserLogin','dataRoleUser',
        'countUser',
        'countUserAdmin',
        'countUserStaff',
        'countUserSell',
        'users'));
   }

   public function insert(Request $request){

        $validator = Validator::make($request->all(),[
            'code'=>['required','unique:users'],
            'password'=>['required','min:8'],
            'fullname' => 'required',
            'role'=>'required'
        ],[
            'code.required'=>'ป้อนรหัสพนักงาน',
            'code.unique'=>'รหัสนี้มีผู้ใช้แล้ว',
            'fullname.required' => 'ป้อนชื่อ-นามสกุล',
            'password.required' => 'ป้อนรหัสผ่าน',
            'password.min' => 'รหัสผ่านต้องไม่ต่ำกว่า 8 ตัวอักษร',
            'role.required' => 'เลือกประเภทผู้ใช้งาน',
        ]);

        if ($validator->passes()) {
            User::updateOrCreate(['id' => $request->id],
            [
            'code' => $request->code,
            'password' => Hash::make($request->password),
            'fullname' => $request->fullname,
            'role' => $request->role,
            'team_id' => $request->team_id,
            'active'=> $request->active
        ]);

        return response()->json([
            'message' => 'เพิ่มข้อมูลสำเร็จ'
        ], 201);

        }

    return response()->json(['error'=>$validator->errors()]);

   }

   public function destroy($id){

            User::find($id)->delete($id);

            return response()->json([
                'success' => 'successfully!'
            ]);
   }

   public function edit($id){
        $user = User::find($id);

        return response()->json($user, 200);
   }

    public function update(Request $request,$id){

        $user = User::find($id);

        if(!$user){
            return response()->json([
                'errors' => [
                    'message'=>'ไม่สามารถอัพเดทข้อมูลได้ ID ไม่ถูกต้อง..'
                    ]
            ],400);
        }

        $validator = Validator::make($request->all(),[
            'fullname_edit' => 'required',
            'role_edit'=>'required'
        ],[

            'fullname_edit.required' => 'ป้อนชื่อ-นามสกุล',
            'role_edit.required' => 'เลือกประเภทผู้ใช้งาน',
        ]);


        if ($validator->passes()) {

            $user->fullname = $request->fullname_edit;
            $user->role = $request->role_edit;
            $user->team_id = $request->team_id_edit;
            $user->active = $request->active_edit;
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
