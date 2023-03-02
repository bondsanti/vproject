<?php

namespace App\Http\Controllers;
use Session;
use App\Models\User;
use DataTables;
use Illuminate\Http\Request;

class UserController extends Controller
{
   public function index(Request $request){
    $dataUserLogin = array();

    if (Session::has('loginId')) {
       $dataUserLogin = User::where('id',"=", Session::get('loginId'))->first();
       $countUser = User::count();
       $countUserActive = User::where('active',"=",'active')->count();
       $countUserDisable = User::where('active',"=",'disable')->count();
       $users = User::get();
       //dd($users);
        if ($request->ajax()) {
           $allData = DataTables::of($users)
           ->addIndexColumn()
           ->addColumn('role' ,function($row){
            if ($row->role =="admin") {
                $role = '<span class="label label-success">Super Admin</span>';
            }else if($row->role =="staff"){
                $role = '<span class="label label-warning">Admin</span>';
            }else{
                $role = '<span class="label label-primary">User</span>';
            }
            return $role;
            })
           ->addColumn('action' ,function($row){
            if ($row->code =="admin") {
                $btn = '-';
            }else{
                $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Edit" class="edit btn btn-primary btn-sm editData"><i class="fa fa-pencil"></i> แก้ไข</a>';
                $btn = $btn.' <a href="javascript:void(0)" data-toggle="tooltip"  data-id="'.$row->id.'" data-original-title="Delete" class="btn btn-danger btn-sm deleteData"><i class="fa fa-trash"></i> ลบ</a>';
            }
            return $btn;
            })
            ->rawColumns(['role','action'])
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
   public function insert(Request $request)
   {
       User::updateOrCreate(['id' => $request->id],
               [
               'code' => $request->code,
               'password' => Hash::make($request->password),
               'fullname' => $request->fullname,
               'role' => $request->role
                ]);

       return response()->json(['success'=>'Post saved successfully.']);
   }
}
