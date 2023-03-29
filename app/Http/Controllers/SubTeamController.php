<?php

namespace App\Http\Controllers;
use Session;
use DataTables;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use App\Models\Role_user;
use App\Models\Team;
use Illuminate\Http\Request;

class SubTeamController extends Controller
{
    public function index(Request $request){
        $dataUserLogin = array();
        $dataUserLogin = DB::connection('mysql_user')->table('users')->where('id', '=', Session::get('loginId'))->first();
        $dataRoleUser = Role_user::where('user_id',"=", Session::get('loginId'))->first();

        $teams = Team::get();

        $subteams = DB::table('teams')
        ->leftJoin('subteams', 'teams.id', '=', 'subteams.team_id')
        ->select('teams.id', 'teams.team_name', 'subteams.subteam_name')
        ->orderBy('teams.id')
        ->get();

        $subteamsList = DB::table('subteams')
        ->leftJoin('teams', 'teams.id', '=', 'subteams.team_id')
        ->select('teams.id', 'teams.team_name', 'subteams.subteam_name')
        ->orderBy('subteams.id')
        ->get();
        //dd($subteamsList);

        return view('subteams.admin.index',compact(
            'dataUserLogin',
            'dataRoleUser',
            'teams','subteams','subteamsList'));
    }

    public function insert(Request $request){

        $validator = Validator::make($request->all(),[
            'team_id' => 'required',
            'subteam_name' => 'required',
        ],[
            'team_id.required'=>'กรุณาเลือกทีม',
            'subteam_name.required'=>'ป้อนชื่อสายงาน',
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


        $team = Team::where('id',"=",$id)->delete($id);
       //Role_user::find($id)->delete($id);

       return response()->json([
           'message' => 'ลบข้อมูลสำเร็จ'
       ], 201);

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
