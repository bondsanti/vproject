<?php

namespace App\Http\Controllers;
use Session;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Role_user;
use App\Models\Project;
use App\Models\Booking;
use App\Models\Bookingdetail;
use App\Models\Team;
use App\Models\Subteam;
use RealRashid\SweetAlert\Facades\Alert;
use Phattarachai\LineNotify\Line;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class BookingController extends Controller
{

    public function bookingProject(Request $request)
    {

        $dataUserLogin = array();
        $events = [];

        $dataUserLogin = DB::connection('mysql_user')->table('users')
        ->where('id', '=', Session::get('loginId'))
        ->first();
        $dataRoleUser = Role_user::where('user_id',"=", Session::get('loginId'))->first();


        // $projects = DB::connection('mysql_project')->table('projects')->get();
        // dd($projects);
        $projects = Project::where('is_active', 'enable')->get();
        $teams = Team::get();

        //    $subteams = Subteam::leftJoin('teams', 'teams.id', '=', 'subteams.team_id')
        //    ->select('subteams.*', 'teams.team_name')
        //    ->get();
        //    dd($subteams);


        if($request->ajax())
    	{

                $bookings = Booking::leftJoin('projects','projects.id','=','bookings.project_id')
                ->leftJoin('bookingdetails','bookingdetails.booking_id','=','bookings.id')->get();


            //dd($bookings);
            foreach ($bookings as $booking) {
                    $start_time = Carbon::parse($booking->booking_start)->toIso8601String();
                    $end_time = Carbon::parse($booking->booking_end)->toIso8601String();

                    if($booking->booking_status==0){
                        $backgroundColor="#a6a6a6";
                        $borderColor="#a6a6a6";
                        $textStatus="รอรับงาน";
                        // $backgroundColor="#00c0ef";
                        // $borderColor="#00c0ef";
                    }elseif($booking->booking_status==1){
                        $backgroundColor="#f39c12";
                        $borderColor="#f39c12";
                        $textStatus="รับงานแล้ว";
                    }elseif($booking->booking_status==2){
                        $backgroundColor="#00c0ef";
                        $borderColor="#00c0ef";
                        $textStatus="จองสำเร็จ";
                    }elseif($booking->booking_status==3){
                        $backgroundColor="#00a65a";
                        $borderColor="#00a65a";
                        $textStatus="เยี่ยมชมเรียบร้อย";
                    }elseif($booking->booking_status==4){
                        $backgroundColor="#dd4b39";
                        $borderColor="#dd4b39";
                        $textStatus="ยกเลิก";
                    }else{
                        $backgroundColor="#b342f5";
                        $borderColor="#b342f5";
                        $textStatus="ยกเลิกอัตโนมัติ";
                    }

                    $event = [
                        'title' => $booking->booking_title,
                        'project' => $booking->project_name,
                        'status' => $textStatus,
                        'customer' => $booking->customer_name." ".$booking->customer_tel,
                        'room_no'=>$booking->room_no,
                        'room_price'=> number_format($booking->room_price),
                        'cus_req'=>$booking->customer_req,
                        'start' => $start_time,
                        'end' => $end_time,
                        'allDay' => false,
                        'backgroundColor' => $backgroundColor,
                        'borderColor' => $borderColor,
                    ];
                    array_push($events, $event);
            }
    		//$bookings = Booking::get();
            return response()->json($events);
    	}



            return view("booking.index",compact('dataUserLogin','dataRoleUser','projects','teams'));


    }

    public function listBooking(Request $request)
    {

        $dataUserLogin = array();

        $dataUserLogin = DB::connection('mysql_user')->table('users')
        ->where('id', '=', Session::get('loginId'))
        ->first();
        $dataRoleUser = Role_user::where('user_id',"=", Session::get('loginId'))->first();

        $projects = Project::where('is_active', 'enable')->get();
        $teams = Team::get();

         $bookings = Booking::with('booking_user_ref:id,code,name_th')->with('booking_emp_ref:id,code,name_th,phone')
         ->leftJoin('projects', 'projects.id', '=', 'bookings.project_id')
        ->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
        ->leftJoin('users as sales', 'sales.id', '=', 'bookings.user_id')
        ->leftJoin('users as employees', 'employees.id', '=', 'bookings.teampro_id')
        ->leftJoin('teams','teams.id', '=', 'bookings.team_id')
        ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
        ->select('bookings.*', 'projects.*', 'bookingdetails.*','bookings.id as bkid', 'sales.fullname as sale_name',
        'employees.fullname as emp_name','teams.id', 'teams.team_name', 'subteams.subteam_name')
        ->get();


       return view("booking.list",compact('dataUserLogin','dataRoleUser','bookings','projects','teams'));

    }

    public function getByTeam(Request $request)
    {
        $subteams = Subteam::where('team_id', $request->team_id)->get();
        return response()->json($subteams);
    }

    //สร้างนัดเยี่ยมโครงการ
    public function createBookingProject(Request $request)
    {

            //dd($request);
            $dataUserLogin = array();

            $dataUserLogin = DB::connection('mysql_user')->table('users')
            ->where('id', '=', Session::get('loginId'))
            ->first();


            $end_time = date('H:i', strtotime($request->time . ' +3 hours'));
            $booking_date = $request->date;
            $booking_start = $request->date." ".$request->time;
            $booking_end = $request->date." ".$end_time;
            //dd($booking_date);
            // $employees_not_on_holiday = Role_user::leftJoin('holiday_users', function ($join) use ($booking_date) {
            //     $join->on('role_users.user_id', '=', 'holiday_users.user_id')
            //          ->where('start_date', '<=', $booking_date)
            //          ->where('end_date', '>=', $booking_date)
            //          //->whereNotIn('holiday_users.status', [1]);
            // })
            // ->where(function ($query) use ($booking_date) {
            //     $query->whereNull('holiday_users.status')->whereIn('role_type', ['Staff']);

            // })
            // ->select('role_users.*')
            // ->orderBy('role_users.id')
            // ->get();
            //เช็คพนักงานวันหยุดและมีสถานะ = 1 อนุมัติ ออกไป
            $employees_not_on_holiday = Role_user::with('user_ref:id,code,name_th')
            ->leftJoin('holiday_users', function ($join) use ($booking_date) {
                $join->on('role_users.user_id', '=', 'holiday_users.user_id')
                     ->where(function($query) use ($booking_date) {
                        $query->where('start_date', '>=', $booking_date)
                              ->Where('end_date', '<=', $booking_date);
                     })
                     ->orWhere(function($query) {
                        $query->whereNotIn('holiday_users.status', [1]);
                     });
            })
            ->where(function ($query) use ($booking_date) {
                $query->whereNull('holiday_users.status')->whereIn('role_type', ['Staff']);
            })
            ->select('role_users.*')
            ->orderBy('role_users.id') // เรียงลำดับตาม ID พนักงาน
            ->get();

            //dd($employees_not_on_holiday );

            foreach ($employees_not_on_holiday as $employee) {
                //dd($employee);
                $booking_count = Booking::where('booking_start', $booking_start)
                    ->where('teampro_id', $employee->user_id)
                    ->count();
                    //dd($booking_count);
                if ($booking_count == 0 && !in_array($employee->user_id, session()->get('booked_employee_ids', []))) {
                    //เรียกค่าของ session ของ booked_employee_ids หากไม่มีข้อมูล จะ return ค่าว่างไว้ก่อน
                    session()->push('booked_employee_ids', $employee->user_id);
                    break; // หลังจาก insert แล้ว ให้ break การวน loop เพื่อให้เลือกพนักงานคนต่อไป

                }
                if ($employee->user_id == $employees_not_on_holiday->last()->user_id) {
                    // ถ้าถึงคนสุดท้ายแล้ว ให้ reset ค่า array ที่เก็บไว้ใน session
                    session()->forget('booked_employee_ids');
                    session()->save();
                    reset($employees_not_on_holiday); // ให้วน loop จากตัวแรกอีกครั้ง
                    break; // หลังจาก reset ให้ break การวน loop เพื่อให้เลือกพนักงานคนต่อไป
                }
            }
            //สรุป ระบบจะทำการเลือกพนักงานตามลำดับ ID จนครบสมาชิกและเริ่มเลือกพนักงานคนใหม่ หากถึงคนสุดท้ายแล้ว ณ วันที่ นั้น ๆ
            //หากเปลี่ยนวัน ก็จะเลอืกพนักงานตามลำดับ ID ใหม่เหมื่อนเดิม
            //แต่จะเลือกคนที่ไม่หยุดและมีสถานะอนุมัติแล้ว ในวันนั้น

                        $booking = New Booking();
                        $booking->booking_title = $request->booking_title; //หัวข้อการจอง
                        $booking->booking_start = $booking_start;
                        $booking->booking_end = $booking_end;
                        $booking->booking_status = "0"; //สถานะ เยี่ยมโครงการ
                        $booking->project_id = $request->project_id;
                        $booking->booking_status_df = "0"; //สถานะ DF
                        $booking->teampro_id = $employee->user_id; //เจ้าหน้าที่โครง
                        $booking->team_id = $request->team_id;
                        $booking->subteam_id = $request->subteam_id;
                        $booking->user_id = $request->user_id; //ชื่อผู้จอง|ผู้ทำรายการจอง
                        $booking->user_tel = $request->user_tel;
                        $booking->remark = $request->remark;


                        $res1 = $booking->save();



            $id_booking = Booking::latest()->first();

            $projects = Project::where('id', $request->project_id)->first();

            $Strdate_start = date('d/m/Y',strtotime($request->date));


            //insert detail customer
            $bookingdetail = New Bookingdetail();
            $bookingdetail->booking_id = $id_booking->id; //ref booking_id
            $bookingdetail->customer_name = $request->customer_name;
            $bookingdetail->customer_tel = $request->customer_tel;

            if ($request->checkbox_room!=null) {
                $bookingdetail->customer_req = implode(',', $request->checkbox_room);
            }else{
                $bookingdetail->customer_req = "";
            }

            if ($request->checkbox_bank!=null) {
                $bookingdetail->customer_req_bank = implode(',', $request->checkbox_bank);
            }else{
                $bookingdetail->customer_req_bank = "";
            }

            if ($request->checkbox_doc!=null) {
                $bookingdetail->customer_doc_personal = implode(',', $request->checkbox_doc);
            }else{
                $bookingdetail->customer_doc_personal = "";
            }
            $bookingdetail->customer_req_bank_other = $request->customer_req_bank_other;
            $bookingdetail->num_home = $request->num_home;
            $bookingdetail->num_idcard = $request->num_idcard;
            $bookingdetail->num_app_statement = $request->num_app_statement;
            $bookingdetail->num_statement = $request->num_statement;
            $bookingdetail->room_no = $request->room_no;
            $bookingdetail->room_price = ($request->room_price) ? str_replace(',', '', $request->room_price) : NULL;

            $res2 = $bookingdetail->save();


            if ($res1 && $res2) {
                Alert::success('จองสำเร็จ!', '');
                $token_line = config('line-notify.access_token_project');
                $line = new Line($token_line);
                $line->send('มีนัด '.$request->booking_title." \n".
                'หมายเลขการจอง : *'.$id_booking->id."* \n".
                '*'.$projects->project_name."* \n".
                'วัน/เวลา : `'.$Strdate_start.' '.$request->time.'-'.$end_time."` \n".
                'ลูกค้าชื่อ : *'.$request->customer_name."* \n".
                '-------------------'." \n".
                'เจ้าหน้าที่โครงการ : *'.$employee->user_ref[0]->name_th ."* \n".
                'กรุณากดรับจองภายใน 1 ชม. '." \n".'หากไม่รับจองภายในเวลาที่กำหนด ระบบจะยกเลิกการจองอัตโนมัติ!');

                return back();
            }else{
                Alert::error('Error', '');
                return back();
            }

        //dd($request);


    }

    public function showBooking(Request $request,$id)
    {

    }

    public function destroyBooking(Request $request,$id){

        $booking = Booking::find($id);

        $bookingdetail = Bookingdetail::where('booking_id',$id);

        if (!$booking || !$bookingdetail) {
            return response()->json([
                'error' => 'Error!'
            ]);
        }else{
            $booking->delete();
            $bookingdetail->delete();

            return response()->json([
                'success' => 'successfully!'
            ]);
        }

    }

    //update status
    public function updateStatus(Request $request)
    {
        $booking = Booking::findOrFail($request->booking_id);
        //dd($booking);
        if (!$booking) {
            Alert::error('Error', 'Not found ID');
            return redirect()->back();
        }else{


            $booking->booking_status = $request->booking_status;
            $booking->because_cancel_remark = $request->because_cancel_remark;
            $booking->save();

            Alert::success('Success', 'อัปเดตสถานะการจองสำเร็จแล้ว!');
            return redirect()->back();


        }

    }

    public function editBooking(Request $request,$id)
    {

        $dataUserLogin = array();


        $dataUserLogin = DB::connection('mysql_user')->table('users')
        ->where('id', '=', Session::get('loginId'))
        ->first();
        $dataRoleUser = Role_user::where('user_id',"=", Session::get('loginId'))->first();


        $projects = Project::where('is_active', 'enable')->get();
        $teams = Team::get();

        $bookings = Booking::leftJoin('projects', 'projects.id', '=', 'bookings.project_id')
        ->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
        ->leftJoin('users as sales', 'sales.id', '=', 'bookings.user_id')
        ->leftJoin('users as employees', 'employees.id', '=', 'bookings.teampro_id')
        ->leftJoin('teams','teams.id', '=', 'bookings.team_id')
        ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
        ->select('bookings.*', 'projects.*', 'bookingdetails.*','bookings.id as bkid', 'sales.fullname as sale_name',
        'employees.fullname as emp_name','teams.id', 'teams.team_name', 'subteams.subteam_name')
        ->where('bookings.id',"=",$id)->first();
        // dd($bookings);

       return view("booking.edit",compact('dataUserLogin','dataRoleUser','bookings','projects','teams'));

    }

    public function updateBookingProject(Request $request)
    {

            //dd($request);
            $dataUserLogin = array();

            $dataUserLogin = DB::connection('mysql_user')->table('users')
            ->where('id', '=', Session::get('loginId'))
            ->first();

            //หาเจ้าหน้าที่โครงการ
            // $employees = Role_user::orderBy('id')->get();
            $employees = Role_user::with('user_ref:id,code,name_th')->where('user_id',$request->teampro_id)->first();
            //dd($employees);
            $booking = Booking::where('bookings.id',"=",$request->booking_id)->first();


            //dd($booking);

            $end_time = date('H:i', strtotime($request->time . ' +3 hours'));
            $booking_start = $request->date." ".$request->time;
            $booking_end = $request->date." ".$end_time;


            $booking->booking_start = $booking_start;
            $booking->booking_end = $booking_end;
            $booking->booking_status = "0"; //สถานะ เยี่ยมโครงการ
            $booking->project_id = $request->project_id;
            $booking->booking_status_df = "0"; //สถานะ DF

            $booking->team_id = $request->team_id;
            $booking->subteam_id = $request->subteam_id;
            $booking->user_id = $request->user_id; //ชื่อผู้จอง|ผู้ทำรายการจอง
            $booking->user_tel = $request->user_tel;
            $booking->remark = $request->remark;

            $res1 = $booking->save();

            //dd($booking);
            //$id_booking = Booking::latest()->first();

            $projects = Project::where('id', $request->project_id)->first();

            $Strdate_start = date('d/m/Y',strtotime($request->date));


            //insert detail customer
            $bookingdetail = Bookingdetail::where('booking_id','=',$request->booking_id)->first();
            //$bookingdetail->booking_id = $request->booking_id; //ref booking_id
            $bookingdetail->customer_name = $request->customer_name;
            $bookingdetail->customer_tel = $request->customer_tel;

            if ($request->checkbox_room!=null) {
                $bookingdetail->customer_req = implode(',', $request->checkbox_room);
            }else{
                $bookingdetail->customer_req = "";
            }

            if ($request->checkbox_bank!=null) {
                $bookingdetail->customer_req_bank = implode(',', $request->checkbox_bank);
            }else{
                $bookingdetail->customer_req_bank = "";
            }

            if ($request->checkbox_doc!=null) {
                $bookingdetail->customer_doc_personal = implode(',', $request->checkbox_doc);
            }else{
                $bookingdetail->customer_doc_personal = "";
            }
            $bookingdetail->customer_req_bank_other = $request->customer_req_bank_other;
            $bookingdetail->num_home = $request->num_home;
            $bookingdetail->num_idcard = $request->num_idcard;
            $bookingdetail->num_app_statement = $request->num_app_statement;
            $bookingdetail->num_statement = $request->num_statement;
            $bookingdetail->room_no = $request->room_no;
            $bookingdetail->room_price = str_replace(',', '', $request->room_price);

            $res2 = $bookingdetail->save();


            if ($res1 && $res2) {
                Alert::success('แก้ไขข้อมูลการจองสำเร็จ!', '');
                $token_line = config('line-notify.access_token_project');
                $line = new Line($token_line);
                $line->send('อัพเดทข้อมูลการจองใหม่ '." \n".
                'หมายเลขการจอง : *'.$request->booking_id."* \n".
                'นัด *'.$request->booking_title."* \n".
                '*'.$projects->project_name."* \n".
                'วัน/เวลา : `'.$Strdate_start.' '.$request->time.'-'.$end_time."` \n".
                'ลูกค้าชื่อ : *'.$request->customer_name."* \n".
                '-------------------'." \n".
                'เจ้าหน้าที่โครงการ : *'.$employees->user_ref[0]->name_th."* \n \n".
                'กรุณากดรับจองภายใน 1 ชม. '." \n".'หากไม่รับจองภายในเวลาที่กำหนด ระบบจะยกเลิกการจองอัตโนมัติ!');

                return back();
            }else{
                Alert::error('Error', '');
                return back();
            }

        //dd($request);


    }

    public function printBooking(Request $request,$id)
    {
        $bookings = Booking::with('booking_user_ref:id,code,name_th')->with('booking_emp_ref:id,code,name_th,phone')
        ->leftJoin('projects', 'projects.id', '=', 'bookings.project_id')
        ->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
        ->leftJoin('users as sales', 'sales.id', '=', 'bookings.user_id')
        ->leftJoin('users as employees', 'employees.id', '=', 'bookings.teampro_id')
        ->leftJoin('teams','teams.id', '=', 'bookings.team_id')
        ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
        ->select('bookings.*', 'projects.*', 'bookingdetails.*','bookings.id as bkid', 'sales.fullname as sale_name',
        'employees.fullname as emp_name','teams.id', 'teams.team_name', 'subteams.subteam_name')
        ->where('bookings.id',"=",$id)->first();
        //dd($bookings);
        return view("booking.print",compact('bookings'));
    }

    public function testUser(){

        // $date = '2023-04-20';

        // $employees_not_on_holiday = DB::table('role_users')
        //     ->leftJoin('holiday_users', function ($join) use ($date) {
        //         $join->on('role_users.id', '=', 'holiday_users.user_id')
        //              ->where(function($query) use ($date) {
        //                  $query->where('start_date', '<=', $date)
        //                        ->where('end_date', '>=', $date);
        //              });
        //             //  ->whereNotIn('status', [1]); // เช็คว่า status ไม่ใช่ 1
        //     })
        //     ->whereNull('holiday_users.user_id')
        //     ->whereIn('role_type', ['HeadStaff', 'Staff'])
        //     ->select('role_users.*')
        //     ->get();


        $date = '2023-04-20';

        $employees_not_on_holiday = DB::table('role_users')
            ->leftJoin('holiday_users', function ($join) use ($date) {
                $join->on('role_users.user_id', '=', 'holiday_users.user_id')
                     ->where('start_date', '<=', $date)
                     ->where('end_date', '>=', $date)
                     ->whereIn('status', [0, 2]); // สถานะเป็น 0 หรือ 2 เท่านั้น
            })
            ->where(function ($query) use ($date) {
                $query->whereNull('holiday_users.user_id')->whereIn('role_type', ['HeadStaff', 'Staff']);
                      //->orWhere('holiday_users.status', '<>', 1); // ไม่ได้อนุมัติหยุดหรืออนุมัติแล้ว
            })
            ->select('role_users.*')
            ->get();

            // เก็บ ID ของพนักงานที่เลือกแล้ว
            $selected_employee_ids = [];

        // loop พนักงานที่ไม่หยุดและ status เป็น 0 หรือ 2 ในวันที่กำหนด
        foreach ($employees_not_on_holiday as $employee) {
            // ถ้า ID ของพนักงานนี้ยังไม่ถูกเลือก ก็ insert เข้าตาราง booking และเก็บ ID ของพนักงานนี้
            if (!in_array($employee->id, $selected_employee_ids)) {
                DB::table('booking')->insert([
                    'employee_id' => $employee->id,
                    'booking_date' => $date,
                ]);
                $selected_employee_ids[] = $employee->id;
            }
        }




            return response()->json($employees_not_on_holiday, 200);

    }
}
