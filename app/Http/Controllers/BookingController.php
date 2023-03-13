<?php

namespace App\Http\Controllers;
use Session;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Project;
use App\Models\Booking;
use App\Models\Team;
use App\Models\Subteam;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    //นัดเยี่ยมโครงการ
    public function bookingProject(Request $request){

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
            $bookings = Booking::get();
            foreach ($bookings as $booking) {
                    $start_time = Carbon::parse($booking->booking_start)->toIso8601String();
                    $end_time = Carbon::parse($booking->booking_end)->toIso8601String();

                    if($booking->booking_status==0){
                        $backgroundColor="#8b8c8b";
                        $borderColor="#8b8c8b";
                        // $backgroundColor="#00c0ef";
                        // $borderColor="#00c0ef";
                    }elseif($booking->booking_status==1){
                        $backgroundColor="#00a65a";
                        $borderColor="#00a65a";
                    }else{
                        $backgroundColor="#cc2d2d";
                        $borderColor="#cc2d2d";
                    }

                    $event = [
                        'title' => $booking->booking_title,
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

    public function getByTeam(Request $request)
    {
        $subteams = Subteam::where('team_id', $request->team_id)->get();
        return response()->json($subteams);
    }
    //สร้างนัดเยี่ยมโครงการ
    public function createBookingProject(Request $request){

        dd($request);


    }
}
