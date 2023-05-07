<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Project;
use App\Models\Booking;
use App\Models\Bookingdetail;
use App\Models\Team;
use App\Models\Subteam;
use App\Models\Role_user;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Phattarachai\LineNotify\Line;
use Session;
use Illuminate\Http\Request;

class CalendarController extends Controller
{

    public function index(Request $request)
    {


        $dataUserLogin = User::where('id', Session::get('loginId'))->first();

        $dataRoleUser = Role_user::where('user_id', Session::get('loginId'))->first();

        $events = [];

        if (in_array($dataRoleUser->role_type, ["Admin", "SuperAdmin"])){

                if($request->ajax())
                    {
                        $bookings = Booking::with('booking_project_ref:id,name')//โครงการ
                        ->with('booking_emp_ref:id,code,name_th,phone')//จน. โครงการ
                        ->with('booking_user_ref:id,code,name_th')//ชื่อ Sale
                        ->leftJoin('bookingdetails','bookingdetails.booking_id','=','bookings.id')
                        ->leftJoin('teams','teams.id', '=', 'bookings.team_id')
                        ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
                        ->select('bookings.*', 'bookingdetails.*','bookings.id as bkid','teams.id', 'teams.team_name', 'subteams.subteam_name')
                        ->get();

                        //dd($bookings);

                        foreach ($bookings as $booking)
                        {
                            $start_time = Carbon::parse($booking->booking_start)->toIso8601String();
                            $end_time = Carbon::parse($booking->booking_end)->toIso8601String();

                            if($booking->booking_status==0){
                                $backgroundColor="#a6a6a6";
                                $borderColor="#a6a6a6";
                                $textStatus="รอรับงาน";
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
                                'id' => $booking->id,
                                'title' => $booking->booking_title,
                                'project' => $booking->booking_project_ref[0]->name,
                                'status' => $textStatus,
                                'booking_status' => $booking->booking_status,
                                // 'customer' => $booking->customer_name." ".$booking->customer_tel,
                                'sale'=> $booking->booking_user_ref[0]->name_th,
                                'employee'=> $booking->booking_emp_ref[0]->name_th." ".$booking->booking_emp_ref[0]->phone,
                                'team_name'=> $booking->team_name."/".$booking->subteam_name,
                                'tel'=> $booking->user_tel,
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

                        return response()->json($events);
                    }

                return view('calendar.admin',compact('dataUserLogin','dataRoleUser'));

        }elseif($dataRoleUser->role_type=="Staff"){

            if($request->ajax())
            {
                // $bookings = Booking::leftJoin('projects','projects.id','=','bookings.project_id')
                // ->leftJoin('bookingdetails','bookingdetails.booking_id','=','bookings.id')
                // ->where('user_id',Session::get('loginId'))
                // ->get();
                $bookings = Booking::with('booking_project_ref:id,name')//โครงการ
                ->with('booking_emp_ref:id,code,name_th,phone')//จน. โครงการ
                ->with('booking_user_ref:id,code,name_th')//ชื่อ Sale
                ->leftJoin('bookingdetails','bookingdetails.booking_id','=','bookings.id')
                ->leftJoin('teams','teams.id', '=', 'bookings.team_id')
                ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
                ->select('bookings.*', 'bookingdetails.*','bookings.id as bkid','teams.id', 'teams.team_name', 'subteams.subteam_name')
                ->where('teampro_id',Session::get('loginId'))->get();
                //dd($bookings);

                foreach ($bookings as $booking)
                    {
                            $start_time = Carbon::parse($booking->booking_start)->toIso8601String();
                            $end_time = Carbon::parse($booking->booking_end)->toIso8601String();

                            if($booking->booking_status==0){
                                $backgroundColor="#a6a6a6";
                                $borderColor="#a6a6a6";
                                $textStatus="รอรับงาน";
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
                                'id' => $booking->id,
                                'title' => $booking->booking_title,
                                'project' => $booking->booking_project_ref[0]->name,
                                'status' => $textStatus,
                                'booking_status' => $booking->booking_status,
                                // 'customer' => $booking->customer_name." ".$booking->customer_tel,
                                'sale'=> $booking->booking_user_ref[0]->name_th,
                                'employee'=> $booking->booking_emp_ref[0]->name_th." ".$booking->booking_emp_ref[0]->phone,
                                'team_name'=> $booking->team_name."/".$booking->subteam_name,
                                'tel'=> $booking->user_tel,
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

                return response()->json($events);
            }

            return view('calendar.index',compact('dataUserLogin','dataRoleUser'));

        }else{
            if($request->ajax())
            {

                $bookings = Booking::with('booking_project_ref:id,name')//โครงการ
                ->with('booking_emp_ref:id,code,name_th,phone')//จน. โครงการ
                ->with('booking_user_ref:id,code,name_th')//ชื่อ Sale
                ->leftJoin('bookingdetails','bookingdetails.booking_id','=','bookings.id')
                ->leftJoin('teams','teams.id', '=', 'bookings.team_id')
                ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
                ->select('bookings.*', 'bookingdetails.*','bookings.id as bkid','teams.id', 'teams.team_name', 'subteams.subteam_name')
                ->get();
                //dd($bookings);

                foreach ($bookings as $booking)
                    {
                            $start_time = Carbon::parse($booking->booking_start)->toIso8601String();
                            $end_time = Carbon::parse($booking->booking_end)->toIso8601String();

                            if($booking->user_id==Session::get('loginId')){
                                $isTitle="📌";
                            }else{
                                $isTitle="";
                            }

                            if($booking->booking_status==0){
                                $backgroundColor="#a6a6a6";
                                $borderColor="#a6a6a6";
                                $textStatus="รอรับงาน";
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
                                'id' => $booking->id,
                                'title' => $isTitle." ".$booking->booking_title,
                                'project' => $booking->booking_project_ref[0]->name,
                                'status' => $textStatus,
                                'booking_status' => $booking->booking_status,
                                // 'customer' => $booking->customer_name." ".$booking->customer_tel,
                                'sale'=> $booking->booking_user_ref[0]->name_th,
                                'employee'=> $booking->booking_emp_ref[0]->name_th." ".$booking->booking_emp_ref[0]->phone,
                                'team_name'=> $booking->team_name."/".$booking->subteam_name,
                                'tel'=> $booking->user_tel,
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

                return response()->json($events);
            }

            return view('calendar.sale',compact('dataUserLogin','dataRoleUser'));
        }



    }

}
