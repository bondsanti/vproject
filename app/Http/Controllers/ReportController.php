<?php

namespace App\Http\Controllers;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Role_user;
use App\Models\User;
use App\Models\Team;
use App\Models\Booking;
use App\Models\Project;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function reportByProject(Request $request)
    {

        $dataUserLogin = array();
        $dataUserLogin = User::where('id', '=', Session::get('loginId'))->first();
        $dataRoleUser = Role_user::where('user_id',"=", Session::get('loginId'))->first();
        $events = [];

        if($request->ajax())
    	{
            $currentYear = Carbon::now()->year;
            $bookings= Booking::select(DB::raw('COUNT(id) as total_bookings'), DB::raw('MONTH(booking_start) as month'))
                        ->whereYear('booking_start', $currentYear)
                        ->groupBy('month')
                        ->orderBy('month')
                        ->get();

            return response()->json($bookings);
        }
                    //dd($bookings);

       return view('report.booking.project', compact(
        'dataUserLogin',
        'dataRoleUser'
       ));
    }

    public function reportGroupByProject(Request $request)
    {

        $dataUserLogin = array();
        $dataUserLogin = User::where('id', '=', Session::get('loginId'))->first();
        $dataRoleUser = Role_user::where('user_id',"=", Session::get('loginId'))->first();

        if($request->ajax())
    	{
            $currentYear = Carbon::now()->year;
            $bookings = Booking::with('booking_project_ref:id,name')
            ->select(DB::raw('COUNT(id) as total_bookings'), DB::raw('MONTH(booking_start) as month'), 'project_id')
                        ->whereYear('booking_start', $currentYear)
                        ->groupBy('month', 'project_id')
                        ->orderBy('month')
                        ->get();
                        //dd($bookings);
            return response()->json($bookings);
        }


       return view('report.booking.project', compact(
        'dataUserLogin',
        'dataRoleUser'
       ));
    }

    public function reportGroupByProjectPie(Request $request)
    {

        $dataUserLogin = array();
        $dataUserLogin = User::where('id', '=', Session::get('loginId'))->first();
        $dataRoleUser = Role_user::where('user_id',"=", Session::get('loginId'))->first();


        if($request->ajax())
    	{
            $currentYear = Carbon::now()->year;
            $bookings = Booking::with('booking_project_ref:id,name')
                        ->select(DB::raw('COUNT(id) as total_bookings'), 'project_id')
                        ->whereYear('booking_start', $currentYear)
                        ->groupBy('project_id')
                        ->get();
                        //dd($bookings);
            return response()->json($bookings);
        }


       return view('report.booking.project', compact(
        'dataUserLogin',
        'dataRoleUser'
       ));
    }

    public function reportByTeam(Request $request)
    {

        $dataUserLogin = array();
        $dataUserLogin = User::where('id', '=', Session::get('loginId'))->first();
        $dataRoleUser = Role_user::where('user_id',"=", Session::get('loginId'))->first();

        // if($request->ajax())
    	// {

        //     $currentYear = Carbon::now()->year;
        //     $teams = Team::select('team_name')->get();

        //     $bookings = Booking::rightJoin('teams', 'bookings.team_id', '=', 'teams.id')
        //                 ->select(
        //                     DB::raw('COALESCE(COUNT(team_id), 0) as total_bookings'),
        //                     DB::raw('MONTH(booking_start) as month'),
        //                     'teams.team_name'
        //                 )
        //                 ->whereYear('booking_start', $currentYear)
        //                 ->groupBy('month', 'teams.team_name')
        //                 ->orderBy('month')
        //                 ->get();

        //     $bookingsByTeam = [];
        //     foreach ($teams as $team) {
        //         $teamName = $team->team_name;
        //         $bookingsByTeam[$teamName] = [
        //             'team_name' => $teamName,
        //             'bookings' => array_fill(0, 12, 0)
        //         ];
        //     }

        //     foreach ($bookings as $booking) {
        //         $month = $booking->month - 1; // Highcharts เริ่มนับ index จาก 0
        //         $bookingsByTeam[$booking->team_name]['bookings'][$month] = $booking->total_bookings;
        //     }

        //     return response()->json(array_values($bookingsByTeam));


        // }

        if ($request->ajax()) {
            $currentYear = Carbon::now()->year;
            $bookings = Booking::leftJoin('teams', 'bookings.team_id', '=', 'teams.id')
            ->select(
                DB::raw('COUNT(team_id) as total_bookings'),
                DB::raw('MONTH(booking_start) as month'),
                'teams.team_name'
            )
            ->whereYear('booking_start', $currentYear)
            ->groupBy('month', 'teams.team_name')
            ->orderBy('month')
            ->get();

            return response()->json($bookings);
        }
        return view('report.booking.team', compact(
            'dataUserLogin',
            'dataRoleUser'
        ));
    }

    public function reportBySubTeam(Request $request)
    {

        $dataUserLogin = array();
        $dataUserLogin = User::where('id', '=', Session::get('loginId'))->first();
        $dataRoleUser = Role_user::where('user_id',"=", Session::get('loginId'))->first();



        if ($request->ajax()) {
            $currentYear = Carbon::now()->year;
            $bookings = Booking::leftJoin('subteams', 'bookings.subteam_id', '=', 'subteams.id')
            ->select(
                DB::raw('COUNT(subteam_id) as total_bookings'),
                DB::raw('MONTH(booking_start) as month'),
                'subteams.subteam_name'
            )
            ->whereYear('booking_start', $currentYear)
            ->groupBy('month', 'subteams.subteam_name')
            ->orderBy('month')
            ->get();

            return response()->json($bookings);
        }
        return view('report.booking.team', compact(
            'dataUserLogin',
            'dataRoleUser'
        ));
    }

    public function reportGroupProjectByTeam(Request $request)
    {

        $dataUserLogin = array();
        $dataUserLogin = User::where('id', '=', Session::get('loginId'))->first();
        $dataRoleUser = Role_user::where('user_id',"=", Session::get('loginId'))->first();


        if ($request->ajax()) {
            $currentYear = Carbon::now()->year;
            $bookings = Booking::with('booking_project_ref:id,name')
            ->leftJoin('teams', 'bookings.team_id', '=', 'teams.id')
            ->select(DB::raw('COUNT(team_id) as total_bookings'),DB::raw('MONTH(booking_start) as month'),'teams.team_name', 'project_id')
            ->whereYear('booking_start', $currentYear)
            ->groupBy('month', 'teams.team_name', 'project_id')
            ->orderBy('month')
            ->get();




            return response()->json($bookings);
        }

        return view('report.booking.team', compact(
            'dataUserLogin',
            'dataRoleUser'
        ));
    }
}
