<?php

namespace App\Http\Controllers;
use Session;
use DataTables;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;
use App\Models\Role_user;
use App\Models\Team;
use App\Models\SubTeam;
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
        ->select('subteams.id', 'teams.team_name', 'subteams.subteam_name')
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

            $subteam = New SubTeam();
            $subteam->team_id = $request->team_id;
            $subteam->subteam_name = $request->subteam_name;
            $subteam->save();

            return response()->json([
                'message' => 'เพิ่มข้อมูลสำเร็จ'
            ], 201);

        }


        return response()->json(['error'=>$validator->errors()]);

    }

    public function destroy($id){


        $subteam = SubTeam::where('id',"=",$id)->delete($id);
       //Role_user::find($id)->delete($id);

       if(!$subteam){
        return response()->json([
            'errors' => [
                'message'=>'ไม่สามารถลบข้อมูลได้'
                ]
        ],400);
    }
       return response()->json([
           'message' => 'ลบข้อมูลสำเร็จ'
       ], 201);

    }

    public function edit($id){

        $subteam = SubTeam::where('id', '=', $id)->first();

        return response()->json($subteam, 200);
    }

    public function update(Request $request,$id){


        $subteam = SubTeam::where('id', '=', $id)->first();


        if(!$subteam){
            return response()->json([
                'errors' => [
                    'message'=>'ไม่สามารถอัพเดทข้อมูลได้ ID ไม่ถูกต้อง..'
                    ]
            ],400);
        }

        $validator = Validator::make($request->all(),[
            'team_id_edit' => 'required',
            'subteam_name_edit' => 'required',
        ],[
            'team_id_edit.required'=>'กรุณาเลือกทีม',
            'subteam_name_edit.required'=>'ป้อนชื่อสายงาน',
        ]);



        if ($validator->passes()) {

            $subteam->team_id = $request->team_id_edit;
            $subteam->subteam_name = $request->subteam_name_edit;
            $subteam->save();

            return response()->json([
                'message' => 'แก้ไขข้อมูลสำเร็จ'
            ], 201);

        }

        return response()->json(['error'=>$validator->errors()]);
    }
}
