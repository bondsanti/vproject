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
                    }else{
                        $backgroundColor="#cc2d2d";
                        $borderColor="#cc2d2d";
                        $textStatus="ยกเลิก";
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
        ->leftJoin('subteams', 'teams.id', '=', 'subteams.team_id')
        ->select('bookings.*', 'projects.*', 'bookingdetails.*', 'sales.fullname as sale_name', 'employees.fullname as emp_name','teams.id', 'teams.team_name', 'subteams.subteam_name')
        ->first();


        //return response()->json($bookings);

       return view("booking.list",compact('dataUserLogin','bookings','projects','teams'));

    }
    public function getByTeam(Request $request)
    {
        $subteams = Subteam::where('team_id', $request->team_id)->get();
        return response()->json($subteams);
    }

    //สร้างนัดเยี่ยมโครงการ
    public function createBookingProject(Request $request){

            //dd($request);
            $dataUserLogin = array();
            $dataUserLogin = User::where('id',"=", Session::get('loginId'))->first();

            //หาเจ้าหน้าที่โครงการ
            $users = User::where('active', 'enable')->where('role','staff')->where('is_jobs','0')->orderBy('id')->first();




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


            //insert detail customer
            $bookingdetail = New Bookingdetail();
            $bookingdetail->booking_id = $id_booking->id; //ref booking_id
            $bookingdetail->customer_name = $request->customer_name;
            $bookingdetail->customer_tel = $request->customer_tel;
            $bookingdetail->customer_req = implode(',', $request->checkbox_room);
            $bookingdetail->customer_req_bank = implode(',', $request->checkbox_bank);
            $bookingdetail->customer_doc_personal = implode(',', $request->checkbox_doc);
            $bookingdetail->num_home = $request->num_home;
            $bookingdetail->num_idcard = $request->num_idcard;
            $bookingdetail->num_app_statement = $request->num_app_statement;
            $bookingdetail->num_statement = $request->num_statement;
            $bookingdetail->room_no = $request->room_no;
            $bookingdetail->room_price = $request->room_price;

            $res2 = $bookingdetail->save();


            if ($res1 && $res2) {
                Alert::success('จองสำเร็จ!', '');
                //return redirect('/');
                return back();
            }else{
                Alert::error('Error Title', 'Error Message');
                return back();
            }

        //dd($request);


    }


}
