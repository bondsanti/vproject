<?php

namespace App\Http\Controllers;

use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Phattarachai\LineNotify\Line;
use App\Models\Role_user;
use App\Models\User;
use App\Models\Holiday;
use Illuminate\Http\Request;

class HolidayController extends Controller
{
    public function index(Request $request)
    {
        $dataUserLogin = array();

        $dataUserLogin = User::where('id', '=', Session::get('loginId'))->first();
        $userSelected = Role_user::with('user_ref:id,code,name_th')->whereIn('role_type',['Admin','Staff'])->get();
        $dataRoleUser = Role_user::where('user_id',"=", Session::get('loginId'))->first();
        //dd($dataRoleUser);
        $events = [];



        if (in_array($dataRoleUser->role_type, ["Admin", "SuperAdmin"])){

            $holidays = Holiday::with('user_ref:id,name_th')->get();

            if($request->ajax())
                {
                    // $holidays = Holiday::with('user_ref:id,name_th')->get();
                    foreach ($holidays as $holiday)
                        {
                                // $start_time = Carbon::parse($holiday->start_date)->toIso8601String();
                                // $end_time = Carbon::parse($holiday->end_date)->toIso8601String();
                                $end_date = date('Y-m-d', strtotime($holiday->end_date. ' +1 day'));
                                $start_date_th = date('d/m/Y', strtotime($holiday->start_date.' +543 year'));
                                $end_date_th = date('d/m/Y', strtotime($holiday->end_date.' +543 year'));

                                if($holiday->status==0){
                                    $backgroundColor="#a6a6a6";
                                    $borderColor="#a6a6a6";
                                    $textStatus="รออนุมัติ";
                                }elseif($holiday->status==1){
                                    $backgroundColor="#00a65a";
                                    $borderColor="#00a65a";
                                    $textStatus="อนุมัติ";
                                }else{
                                    $backgroundColor="#dd4b39";
                                    $borderColor="#dd4b39";
                                    $textStatus="ยกเลิก/ไม่อนุมัติ";
                                }

                                $event = [
                                    'id' => $holiday->id,
                                    'title' => $holiday->user_ref->name_th,
                                    'remark' => $holiday->remark,
                                    'start' => $holiday->start_date,
                                    'end' => $end_date,
                                    'showStart' => $start_date_th,
                                    'showEnd' => $end_date_th,
                                    'allDay' => false,
                                    'status' => $textStatus,
                                    'backgroundColor' => $backgroundColor,
                                    'borderColor' => $borderColor,
                                ];
                                array_push($events, $event);
                        }

                    return response()->json($events);
                }

            return view('holiday.admin',compact('dataUserLogin','dataRoleUser','holidays','userSelected'));


        }else{
            $holidays = Holiday::with('user_ref:id,name_th')->where('user_id',Session::get('loginId'))->get();

            if($request->ajax())
            {
                // $holidays = Holiday::with('user_ref:id,name_th')->get();
                foreach ($holidays as $holiday)
                    {
                            // $start_time = Carbon::parse($holiday->start_date)->toIso8601String();
                            // $end_time = Carbon::parse($holiday->end_date)->toIso8601String();
                            $end_date = date('Y-m-d', strtotime($holiday->end_date. ' +1 day'));
                            $start_date_th = date('d/m/Y', strtotime($holiday->start_date.' +543 year'));
                            $end_date_th = date('d/m/Y', strtotime($holiday->end_date.' +543 year'));

                            if($holiday->status==0){
                                $backgroundColor="#a6a6a6";
                                $borderColor="#a6a6a6";
                                $textStatus="รออนุมัติ";
                            // }elseif($holiday->status==1){
                            //     $backgroundColor="#00a65a";
                            //     $borderColor="#00a65a";
                            //     $textStatus="อนุมัติ";
                            }else{
                                $backgroundColor="#dd4b39";
                                $borderColor="#dd4b39";
                                $textStatus="ยกเลิก/ไม่อนุมัติ";
                            }

                            $event = [
                                'id' => $holiday->id,
                                'title' => "OFF / วันหยุด",
                                'remark' => $holiday->remark,
                                'start' => $holiday->start_date,
                                'end' => $end_date,
                                'showStart' => $start_date_th,
                                'showEnd' => $end_date_th,
                                'allDay' => false,
                                'status' => $textStatus,
                                'backgroundColor' => $backgroundColor,
                                'borderColor' => $borderColor,
                            ];
                            array_push($events, $event);
                    }

                return response()->json($events);
            }

            return view('holiday.index',compact('dataUserLogin','dataRoleUser','holidays'));

        }

    }

    public function insert(Request $request){

        $validator = Validator::make($request->all(),[
            'start_date' => 'required',
            'end_date' => 'required',
        ],[
            'start_date.required'=>'เลือกวันที่เริ่มต้น',
            'end_date.required'=>'เลือกวันที่สิ้นสุด',
        ]);



        if ($validator->passes()) {

            $holiday = New Holiday();
            $holiday->user_id = Session::get('loginId');
            $holiday->start_date = $request->start_date;
            $holiday->end_date = $request->end_date;
            $holiday->remark = ($request->remark == NULL)? "หยุดงาน" : $request->remark;
            $holiday->status = 0;
            $holiday->save();

            if ($holiday) {
                return response()->json([
                    'message' => 'เพิ่มข้อมูลสำเร็จ'
                ], 201);
            }else{
                return response()->json([
                    'message' => 'ไม่สามารถเพิ่มข้อมูลได้'
                ], 404);
            }


        }


        return response()->json(['error'=>$validator->errors()]);

    }

    public function destroy($id){


        $holiday = Holiday::where('id',"=",$id)->delete($id);

        //dd(holiday);
        if ($holiday) {
            return response()->json([
                'message' => 'ลบข้อมูลสำเร็จ'
            ], 201);
        }else{
            return response()->json([
                'message' => 'ไม่สามารถลบข้อมูลได้'
            ], 404);
        }



    }

    public function showStatus(Request $request,$id){

        $holiday = Holiday::where('id',"=",$id)->first();

        return response()->json($holiday, 200);

    }

    public function updateStatus(Request $request,$id){

        $holiday = Holiday::where('id',"=",$id)->first();

        $validator = Validator::make($request->all(),[
            'status' => 'required',
        ],[
            'status.required'=>'กรุณาเลือกสถานะ',
        ]);

        if ($validator->passes()) {

            $holiday->status = $request->status;
            $holiday->save();

            if ($holiday) {
                return response()->json([
                    'message' => 'อัพเดทข้อมูลสำเร็จ'
                ], 201);
            }else{
                return response()->json([
                    'message' => 'ไม่สามารถเพิ่มข้อมูลได้'
                ], 404);
            }


        }

        return response()->json(['error'=>$validator->errors()]);

    }

    public function updateData(Request $request,$id){

        $holiday = Holiday::where('id',"=",$request->id_edit)->first();


            $holiday->start_date = $request->start_date_edit;
            $holiday->end_date = $request->end_date_edit;
            $holiday->remark = ($request->remark_edit == NULL)? "หยุดงาน" : $request->remark_edit;
            $holiday->save();

            if ($holiday) {
                return response()->json([
                    'message' => 'เพิ่มข้อมูลสำเร็จ'
                ], 201);
            }else{
                return response()->json([
                    'message' => 'ไม่สามารถเพิ่มข้อมูลได้'
                ], 404);

             }




    }


}
