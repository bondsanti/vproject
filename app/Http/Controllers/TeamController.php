<?php

namespace App\Http\Controllers;
use Session;
use DataTables;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use App\Models\Role_user;
use App\Models\Team;
use App\Models\Booking;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function index(Request $request){
        $dataUserLogin = array();
        $dataUserLogin = DB::connection('mysql_user')->table('users')->where('user_id', '=', Session::get('loginId')['user_id'])->first();
        $dataRoleUser = Role_user::where('user_id',"=", Session::get('loginId')['user_id'])->first();

        $teams = Team::get();


        return view('teams.index',compact(
            'dataUserLogin',
            'dataRoleUser',
            'teams'));
    }

    public function insert(Request $request){

        $validator = Validator::make($request->all(),[
            'team_name' => ['required','unique:teams'],
        ],[
            'team_name.required'=>'กรอก ชื่อทีม',
            'team_name.unique'=>'ชื่อทีมซ้ำ',
        ]);



        if ($validator->passes()) {

            $team = New Team();
            $team->team_name = $request->team_name;
            $team->save();

            return response()->json([
                'message' => 'เพิ่มข้อมูลสำเร็จ'
            ], 201);

        }


        return response()->json(['error'=>$validator->errors()]);

    }

    public function destroy($id){

        $checkDataBooking = Booking::where('team_id',$id)->count();
        if ($checkDataBooking > 0 ) {

            return response()->json([
                'message' => 'ไม่สามารถลบได้ เนื่องจาก ข้อมูลนี้มีใช้อยู่ในฐานข้อมูล'
            ], 400);

        }else{
            $team = Team::where('id',"=",$id)->delete($id);
        //Role_user::find($id)->delete($id);

        return response()->json([
            'message' => 'ลบข้อมูลสำเร็จ'
        ], 201);
        }

    }

    public function edit($id){

        $team = Team::where('id', '=', $id)->first();

        return response()->json($team, 200);
    }

    public function update(Request $request,$id){


        $team = Team::where('id', '=', $id)->first();


        if(!$team){
            return response()->json([
                'errors' => [
                    'message'=>'ไม่สามารถอัพเดทข้อมูลได้ ID ไม่ถูกต้อง..'
                    ]
            ],400);
        }

        $validator = Validator::make($request->all(),[
            'team_name_edit' => 'required',
        ],[
            'team_name_edit.required'=>'กรอก ชื่อทีม',
        ]);



        if ($validator->passes()) {

            $team->team_name = $request->team_name_edit;
            $team->save();

            return response()->json([
                'message' => 'แก้ไขข้อมูลสำเร็จ'
            ], 201);

        }

        return response()->json(['error'=>$validator->errors()]);
    }
}
