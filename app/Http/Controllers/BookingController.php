<?php

namespace App\Http\Controllers;
use Session;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Project;
use App\Models\Booking;
use App\Models\Bookingdetail;
use App\Models\Team;
use App\Models\Subteam;
use RealRashid\SweetAlert\Facades\Alert;
use Phattarachai\LineNotify\Line;
use Illuminate\Http\Request;

class BookingController extends Controller
{

    public function bookingProject(Request $request)
    {

        $dataUserLogin = array();
        $events = [];
        if (Session::has('loginId')) {
           $dataUserLogin = User::where('id',"=", Session::get('loginId'))->first();

           $projects = Project::where('is_active', 'enable')->get();
           $teams = Team::get();
        //    $subteams = Subteam::leftJoin('teams', 'teams.id', '=', 'subteams.team_id')
        //    ->select('subteams.*', 'teams.team_name')
        //    ->get();

        //    dd($subteams);


        }


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
                        $backgroundColor="#00a65a";
                        $borderColor="#00a65a";
                        $textStatus="รับงานแล้ว";
                    }elseif($booking->booking_status==2){
                        $backgroundColor="#00a65a";
                        $borderColor="#00a65a";
                        $textStatus="จองสำเร็จ";
                    }elseif($booking->booking_status==3){
                        $backgroundColor="#00a65a";
                        $borderColor="#00a65a";
                        $textStatus="เยี่ยมชมเรียบร้อย";
                    }elseif($booking->booking_status==4){
                        $backgroundColor="#cc2d2d";
                        $borderColor="#cc2d2d";
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

        return view("booking.index",compact('dataUserLogin','projects','teams'));
    }

    public function listBooking(Request $request)
    {

        $dataUserLogin = array();
        $events = [];

        $dataUserLogin = User::where('id',"=", Session::get('loginId'))->first();

        $projects = Project::where('is_active', 'enable')->get();
        $teams = Team::get();

        //$bookings = Booking::leftJoin('projects', 'projects.id', '=', 'bookings.project_id')
        // ->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
        // ->leftJoin('users as sales', 'sales.id', '=', 'bookings.user_id')
        // ->leftJoin('users as employees', 'employees.id', '=', 'bookings.teampro_id')
        // ->leftJoin('teams','teams.id', '=', 'bookings.team_id')
        // ->leftJoin('subteams', 'teams.id', '=', 'subteams.team_id')
        // ->select('bookings.*', 'projects.*', 'bookingdetails.*', 'sales.fullname as sale_name', 'employees.fullname as emp_name','teams.id', 'teams.team_name', 'subteams.subteam_name')
        // ->get();
         $bookings = Booking::leftJoin('projects', 'projects.id', '=', 'bookings.project_id')
        ->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
        ->leftJoin('users as sales', 'sales.id', '=', 'bookings.user_id')
        ->leftJoin('users as employees', 'employees.id', '=', 'bookings.teampro_id')
        ->leftJoin('teams','teams.id', '=', 'bookings.team_id')
        ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
        ->select('bookings.*', 'projects.*', 'bookingdetails.*','bookings.id as bkid', 'sales.fullname as sale_name',
        'employees.fullname as emp_name','teams.id', 'teams.team_name', 'subteams.subteam_name')
        ->get();


    //     $data1 = $bookings->customer_doc_personal;
    //     $data2 = $bookings->num_home.",".$bookings->num_idcard.",".$bookings->num_app_statement.",".$bookings->num_statement;

    //     $data1_array = explode(',', $data1);
    //     $data2_array = explode(',', $data2);

    //     $data_array = array_combine($data1_array, $data2_array);
    //     $result = [];
    //     foreach ($new_arr as $key => $value) {
    //       array_push($result, "{$key}({$value})");
    //   }

       // return response()->json($bookings);

       return view("booking.list",compact('dataUserLogin','bookings','projects','teams'));

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
            $dataUserLogin = User::where('id',"=", Session::get('loginId'))->first();

            //หาเจ้าหน้าที่โครงการ
            $users = User::where('active', 'enable')->where('role','staff')->orderBy('id')->first();




            $end_time = date('H:i', strtotime($request->time . ' +3 hours'));
            $booking_start = $request->date." ".$request->time;
            $booking_end = $request->date." ".$end_time;

            //insert booking
            $booking = New Booking();
            $booking->booking_title = $request->booking_title; //หัวข้อการจอง
            $booking->booking_start = $booking_start;
            $booking->booking_end = $booking_end;
            $booking->booking_status = "0"; //สถานะ เยี่ยมโครงการ
            $booking->project_id = $request->project_id;
            $booking->booking_status_df = "0"; //สถานะ DF
            $booking->teampro_id = $users->id; //เจ้าหน้าที่โครง
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

            $bookingdetail->num_home = $request->num_home;
            $bookingdetail->num_idcard = $request->num_idcard;
            $bookingdetail->num_app_statement = $request->num_app_statement;
            $bookingdetail->num_statement = $request->num_statement;
            $bookingdetail->room_no = $request->room_no;
            $bookingdetail->room_price = $request->room_price;

            $res2 = $bookingdetail->save();


            if ($res1 && $res2) {
                Alert::success('จองสำเร็จ!', '');
                $token_line = config('line-notify.access_token');
                $line = new Line($token_line);
                $line->send('มีนัด '.$request->booking_title.' : *'.$projects->project_name."* \n".
                'วัน/เวลา : `'.$Strdate_start.' '.$request->time.'-'.$end_time."` \n".
                'ลูกค้าชื่อ : *'.$request->customer_name."* \n".
                'กรุณากดรับจองภายใน 1 ชม. หากไม่รับจอง ระบบจะยกเลิกการจองทันที!');

                return back();
            }else{
                Alert::error('Error Title', 'Error Message');
                return back();
            }

        //dd($request);


    }

    public function showBooking(Request $request,$id)
    {

    }

    public function destroyBooking($id){

        $booking = Booking::find($id);
        $bookingdetail = Bookingdetail::where('booking_id',$id);

        if (!$booking) {
            return redirect()->back()->with('error','มีบางอย่างผิดพลาด!');
        }

        $booking->delete();
        $bookingdetail->delete();


        return redirect()->route('listBooking')->with('success', 'ลบข้อมูล..สำเร็จ!');


    }


}
