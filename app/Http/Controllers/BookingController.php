<?php

namespace App\Http\Controllers;
use Session;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Project;
use App\Models\Booking;
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

        //    foreach ($bookings as $booking) {
        //     $start_time = Carbon::parse($booking->booking_start)->toIso8601String();
        //     $end_time = Carbon::parse($booking->booking_end)->toIso8601String();
        //     $event = [
        //         'title' => $booking->booking_title,
        //         'start' => $start_time,
        //         'end' => $end_time
        //     ];
        //     array_push($events, $event);
        //     }


        }
        if($request->ajax())
    	{
            $bookings = Booking::get();
            foreach ($bookings as $booking) {
                    $start_time = Carbon::parse($booking->booking_start)->toIso8601String();
                    $end_time = Carbon::parse($booking->booking_end)->toIso8601String();

                    if($booking->booking_status==0){
                        $backgroundColor="#00c0ef";
                        $borderColor="#00c0ef";
                    }else{
                        $backgroundColor="#00a65a";
                        $borderColor="#00a65a";
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

        return view("booking.index",compact('dataUserLogin','projects'));
    }
}
