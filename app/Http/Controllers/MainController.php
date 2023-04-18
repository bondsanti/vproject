<?php

namespace App\Http\Controllers;
use Session;
use App\Models\User;
use App\Models\Main;
use App\Models\Role_user;
use App\Models\Booking;
use App\Models\Project;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class MainController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dataUserLogin = array();

        $dataUserLogin = DB::connection('mysql_user')->table('users')
        ->where('id', '=', Session::get('loginId'))
        ->first();

        $dataRoleUser = Role_user::where('user_id',"=", Session::get('loginId'))->first();
        $dataEmps = Role_user::with('user_ref:id as id_user,code,name_th as name_emp')->where('role_type','Staff')->get();
       dd($dataEmps);
        $dataSales = Role_user::with('user_ref:id,code,name_th as name_sale')->where('role_type','Sale')->get();
        //$countBooking = Booking::where('teampro_id', Session::get('loginId'))->where('booking_status', 0)->count();
        //dd($CountBooking);

        if ($dataRoleUser->role_type== "SuperAdmin"){

            $countAllBooking = Booking::count();
            $countSucessBooking = Booking::where('booking_status',3)->count();
            $countCancelBooking = Booking::where('booking_status',4)->count();
            $countExitBooking = Booking::where('booking_status',5)->count();

             return view('index',compact('dataUserLogin',
             'dataRoleUser',
             'countAllBooking',
             'countSucessBooking',
             'countCancelBooking',
             'countExitBooking'));

        }elseif ($dataRoleUser->role_type=="Admin") {
            $bookings = Booking::with('booking_user_ref:id,code,name_th')->with('booking_emp_ref:id,code,name_th,phone')->with('booking_project_ref:id,name')
            ->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
            ->leftJoin('teams','teams.id', '=', 'bookings.team_id')
            ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
            ->select('bookings.*', 'bookingdetails.*','bookings.id as bkid','teams.id', 'teams.team_name', 'subteams.subteam_name')->orderBy('bookings.id')->get();

            $projects = Project::where('active',1)->get();

            $countAllBooking = Booking::count();
            $countSucessBooking = Booking::where('booking_status',3)->count();
            $countCancelBooking = Booking::where('booking_status',4)->count();
            $countExitBooking = Booking::where('booking_status',5)->count();

             return view('admin',compact('dataUserLogin',
             'dataRoleUser',
             'bookings',
             'projects',
             'countAllBooking',
             'countSucessBooking',
             'countCancelBooking',
             'countExitBooking',
             'dataEmps',
             'dataSales'));
        }elseif ($dataRoleUser->role_type=="Staff") {

            $bookings = Booking::with('booking_user_ref:id,code,name_th')->with('booking_emp_ref:id,code,name_th,phone')->with('booking_project_ref:id,name')
           ->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
           ->leftJoin('users as sales', 'sales.id', '=', 'bookings.user_id')
           ->leftJoin('users as employees', 'employees.id', '=', 'bookings.teampro_id')
           ->leftJoin('teams','teams.id', '=', 'bookings.team_id')
           ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
           ->select('bookings.*', 'bookingdetails.*','bookings.id as bkid', 'sales.fullname as sale_name',
           'employees.fullname as emp_name','teams.id', 'teams.team_name', 'subteams.subteam_name')
           ->where('teampro_id',Session::get('loginId'))->get();

           $countAllBooking = Booking::where('teampro_id', Session::get('loginId'))->count();
           $countSucessBooking = Booking::where('teampro_id', Session::get('loginId'))->where('booking_status',3)->count();
           $countCancelBooking = Booking::where('teampro_id', Session::get('loginId'))->where('booking_status',4)->count();
           $countExitBooking = Booking::where('teampro_id', Session::get('loginId'))->where('booking_status',5)->count();

            return view('staff',compact('dataUserLogin',
            'dataRoleUser',
            'bookings',
            'countAllBooking',
            'countSucessBooking',
            'countCancelBooking',
            'countExitBooking'));

        }else{

            $bookings = Booking::with('booking_user_ref:id,code,name_th')->with('booking_emp_ref:id,code,name_th,phone')->with('booking_project_ref:id,name')
           ->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
           ->leftJoin('users as sales', 'sales.id', '=', 'bookings.user_id')
           ->leftJoin('users as employees', 'employees.id', '=', 'bookings.teampro_id')
           ->leftJoin('teams','teams.id', '=', 'bookings.team_id')
           ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
           ->select('bookings.*', 'bookingdetails.*','bookings.id as bkid', 'sales.fullname as sale_name',
           'employees.fullname as emp_name','teams.id', 'teams.team_name', 'subteams.subteam_name')
           ->where('user_id',Session::get('loginId'))->get();

           $countAllBooking = Booking::where('user_id', Session::get('loginId'))->count();
           $countSucessBooking = Booking::where('user_id', Session::get('loginId'))->where('booking_status',3)->count();
           $countCancelBooking = Booking::where('user_id', Session::get('loginId'))->where('booking_status',4)->count();
           $countExitBooking = Booking::where('user_id', Session::get('loginId'))->where('booking_status',5)->count();
            //dd($countAllBooking);
            return view('sale',compact('dataUserLogin',
            'dataRoleUser',
            'bookings',
            'countAllBooking',
            'countSucessBooking',
            'countCancelBooking',
            'countExitBooking'));
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $dataUserLogin = array();

        $dataUserLogin = DB::connection('mysql_user')->table('users')
        ->where('id', '=', Session::get('loginId'))
        ->first();

        $dataRoleUser = Role_user::where('user_id',"=", Session::get('loginId'))->first();

        if ($dataRoleUser->role_type== "SuperAdmin"){

            $countAllBooking = Booking::count();
            $countSucessBooking = Booking::where('booking_status',3)->count();
            $countCancelBooking = Booking::where('booking_status',4)->count();
            $countExitBooking = Booking::where('booking_status',5)->count();

             return view('index',compact('dataUserLogin',
             'dataRoleUser',
             'countAllBooking',
             'countSucessBooking',
             'countCancelBooking',
             'countExitBooking'));

        }elseif ($dataRoleUser->role_type=="Admin") {


            $bookings = Booking::query()
            ->with('booking_user_ref:id,code,name_th')
            ->with('booking_emp_ref:id,code,name_th')
            ->with('booking_project_ref:id,name as project_name')
            ->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
            ->leftJoin('teams','teams.id', '=', 'bookings.team_id')
            ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
            ->select('bookings.*', 'bookingdetails.*','bookings.id as bkid',
            'teams.id', 'teams.team_name', 'subteams.subteam_name')
            ->orderBy('bookings.id');

            if ($request->project_id) {

                $bookings->where('project_id', $request->project_id);
            }
            if ($request->booking_title) {
                $bookings->where('booking_title', $request->booking_title);
            }
            if ($request->start_date) {
                $bookings->where('booking_start', $request->start_date);
            }
            if ($request->end_date) {
                $bookings->where('booking_end', $request->end_date);
            }
            if ($request->status) {
                $bookings->where('booking_status', $request->status);
            }
            if ($request->customer_name) {
                $bookings->where('customer_name', 'like', '%' . $request->customer_name . '%');
            }
            // if ($request->sale_name) {
            //     $bookings->whereHas('booking_user_ref', function ($query) use ($request) {
            //         $query->where('name_th', 'like', '%' . $request->sale_name . '%');
            //     });

            // }
            // if ($request->emp_name) {
            //     $bookings->whereHas('booking_emp_ref', function ($query) use ($request) {
            //         $query->where('name_th', 'like', '%' . $request->emp_name . '%');
            //     });

            // }

            $bookings = $bookings->get();
              dd($bookings);


            $projects = Project::where('active',1)->get();

            $countAllBooking = Booking::count();
            $countSucessBooking = Booking::where('booking_status',3)->count();
            $countCancelBooking = Booking::where('booking_status',4)->count();
            $countExitBooking = Booking::where('booking_status',5)->count();

            //  return view('search',compact('dataUserLogin',
            //  'dataRoleUser',
            //  'bookings',
            //  'projects',
            //  'countAllBooking',
            //  'countSucessBooking',
            //  'countCancelBooking',
            //  'countExitBooking'));
        }elseif ($dataRoleUser->role_type=="Staff") {

            $bookings = Booking::with('booking_user_ref:id,code,name_th')->with('booking_emp_ref:id,code,name_th,phone')->with('booking_project_ref:id,name')
           ->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
           ->leftJoin('users as sales', 'sales.id', '=', 'bookings.user_id')
           ->leftJoin('users as employees', 'employees.id', '=', 'bookings.teampro_id')
           ->leftJoin('teams','teams.id', '=', 'bookings.team_id')
           ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
           ->select('bookings.*', 'bookingdetails.*','bookings.id as bkid', 'sales.fullname as sale_name',
           'employees.fullname as emp_name','teams.id', 'teams.team_name', 'subteams.subteam_name')
           ->where('teampro_id',Session::get('loginId'))->get();

           $countAllBooking = Booking::where('teampro_id', Session::get('loginId'))->count();
           $countSucessBooking = Booking::where('teampro_id', Session::get('loginId'))->where('booking_status',3)->count();
           $countCancelBooking = Booking::where('teampro_id', Session::get('loginId'))->where('booking_status',4)->count();
           $countExitBooking = Booking::where('teampro_id', Session::get('loginId'))->where('booking_status',5)->count();

            return view('staff',compact('dataUserLogin',
            'dataRoleUser',
            'bookings',
            'countAllBooking',
            'countSucessBooking',
            'countCancelBooking',
            'countExitBooking'));

        }else{

            $bookings = Booking::with('booking_user_ref:id,code,name_th')->with('booking_emp_ref:id,code,name_th,phone')->with('booking_project_ref:id,name')
           ->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
           ->leftJoin('users as sales', 'sales.id', '=', 'bookings.user_id')
           ->leftJoin('users as employees', 'employees.id', '=', 'bookings.teampro_id')
           ->leftJoin('teams','teams.id', '=', 'bookings.team_id')
           ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
           ->select('bookings.*', 'bookingdetails.*','bookings.id as bkid', 'sales.fullname as sale_name',
           'employees.fullname as emp_name','teams.id', 'teams.team_name', 'subteams.subteam_name')
           ->where('user_id',Session::get('loginId'))->get();

           $countAllBooking = Booking::where('user_id', Session::get('loginId'))->count();
           $countSucessBooking = Booking::where('user_id', Session::get('loginId'))->where('booking_status',3)->count();
           $countCancelBooking = Booking::where('user_id', Session::get('loginId'))->where('booking_status',4)->count();
           $countExitBooking = Booking::where('user_id', Session::get('loginId'))->where('booking_status',5)->count();
            //dd($countAllBooking);
            return view('sale',compact('dataUserLogin',
            'dataRoleUser',
            'bookings',
            'countAllBooking',
            'countSucessBooking',
            'countCancelBooking',
            'countExitBooking'));
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Main  $main
     * @return \Illuminate\Http\Response
     */
    public function show(Main $main)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Main  $main
     * @return \Illuminate\Http\Response
     */
    public function edit(Main $main)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Main  $main
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Main $main)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Main  $main
     * @return \Illuminate\Http\Response
     */
    public function destroy(Main $main)
    {
        //
    }
}
