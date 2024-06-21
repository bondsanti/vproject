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


        //$dataUserLogin = User::where('user_id', '=', Session::get('loginId')['user_id'])->first();
        $dataUserLogin = Session::get('loginId');
        $dataRoleUser = Role_user::where('user_id',"=", Session::get('loginId')['user_id'])->first();
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

        $dataUserLogin = Session::get('loginId');
        //$dataUserLogin = User::where('user_id', '=', Session::get('loginId')['user_id'])->first();
        $dataRoleUser = Role_user::where('user_id',"=", Session::get('loginId')['user_id'])->first();

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

        $dataUserLogin = Session::get('loginId');
        //$dataUserLogin = User::where('user_id', '=', Session::get('loginId')['user_id'])->first();
        $dataRoleUser = Role_user::where('user_id',"=", Session::get('loginId')['user_id'])->first();


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


        $dataUserLogin = User::where('user_id', '=', Session::get('loginId')['user_id'])->first();
        $dataRoleUser = Role_user::where('user_id',"=", Session::get('loginId')['user_id'])->first();



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

    public function reportByTeamPie(Request $request)
    {


        $dataUserLogin = User::where('user_id', '=', Session::get('loginId')['user_id'])->first();
        $dataRoleUser = Role_user::where('user_id',"=", Session::get('loginId')['user_id'])->first();


        if($request->ajax())
    	{
            $currentYear = Carbon::now()->year;
            $bookings = Booking::leftJoin('teams', 'bookings.team_id', '=', 'teams.id')
            ->select(
                DB::raw('COUNT(team_id) as total_bookings'), 'teams.team_name'
            )
            ->whereYear('booking_start', $currentYear)
            ->groupBy('teams.team_name')
            ->get();
                        //dd($bookings);
            return response()->json($bookings);
        }


       return view('report.booking.team', compact(
        'dataUserLogin',
        'dataRoleUser'
       ));
    }

    public function reportBySubTeam(Request $request)
    {


        $dataUserLogin = User::where('user_id', '=', Session::get('loginId')['user_id'])->first();
        $dataRoleUser = Role_user::where('user_id',"=", Session::get('loginId')['user_id'])->first();



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

    public function reportBySubTeamPie(Request $request)
    {


        $dataUserLogin = User::where('user_id', '=', Session::get('loginId')['user_id'])->first();
        $dataRoleUser = Role_user::where('user_id',"=", Session::get('loginId')['user_id'])->first();


        if($request->ajax())
    	{
            $currentYear = Carbon::now()->year;
            $bookings = Booking::leftJoin('subteams', 'bookings.subteam_id', '=', 'subteams.id')
            ->select(
                DB::raw('COUNT(subteam_id) as total_bookings'), 'subteams.subteam_name'
            )
            ->whereYear('booking_start', $currentYear)
            ->groupBy('subteams.subteam_name')
            ->get();
                        //dd($bookings);
            return response()->json($bookings);
        }


       return view('report.booking.team', compact(
        'dataUserLogin',
        'dataRoleUser'
       ));
    }

    public function reportGroupProjectByTeam(Request $request)
    {


        $dataUserLogin = User::where('user_id', '=', Session::get('loginId')['user_id'])->first();
        $dataRoleUser = Role_user::where('user_id',"=", Session::get('loginId')['user_id'])->first();

        //ทีมไหน โปรเจคไหนบ้าง

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
