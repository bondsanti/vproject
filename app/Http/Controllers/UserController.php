<?php

namespace App\Http\Controllers;
use Session;
use App\Models\User;
use DataTables;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Phattarachai\LineNotify\Line;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class UserController extends Controller
{
   public function index(Request $request){
    $dataUserLogin = array();

    if (Session::has('loginId')) {
       $dataUserLogin = User::where('id',"=", Session::get('loginId'))->first();
       $countUser = User::count();
       $countUserActive = User::where('active',"=",'enable')->count();
       $countUserDisable = User::where('active',"=",'disable')->count();
       $users = User::get();
       //dd($users);
        if ($request->ajax()) {
           $allData = DataTables::of($users)
           ->addIndexColumn()
           ->addColumn('role' ,function($row){
            if ($row->role =="admin") {
                $role = '<span class="label label-success">Admin</span>';
            }else if($row->role =="staff"){
                $role = '<span class="label label-warning">Staff</span>';
            }else{
                $role = '<span class="label label-primary">User</span>';
            }
            return $role;
            })
            ->addColumn('active' ,function($row){
                if ($row->active =="enable") {
                    $active = '<span class="label label-success">Enable</span>';
                }else{
                    $active = '<span class="label label-default">Disable</span>';
                }
                return $active;
                })
           ->addColumn('action' ,function($row){
            if ($row->code =="admin") {
                $btn = '-';
            }else{
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editUser"><i class="fa fa-pencil"></i> แก้ไข</a>';
                $btn = $btn.' <button  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteUser"><i class="fa fa-trash"></i> ลบ</button>';
            }
            return $btn;
            })
            ->rawColumns(['role','active','action'])
            ->make(true);

            return $allData;
        }

    }


    return view('user.index',compact(
        'dataUserLogin',
        'countUser',
        'countUserActive',
        'countUserDisable',
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
        'success' => 'Record deleted successfully!'
    ]);
}
}
