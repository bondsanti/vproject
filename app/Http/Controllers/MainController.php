<?php

namespace App\Http\Controllers;
use Session;
use App\Models\User;
use App\Models\Main;
use App\Models\Role_user;
use App\Models\Booking;
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
        //$countBooking = Booking::where('teampro_id', Session::get('loginId'))->where('booking_status', 0)->count();
        //dd($CountBooking);

        if ($dataRoleUser->role_type== "SuperAdmin"){
            return view('index',compact('dataUserLogin','dataRoleUser'));
        }elseif ($dataRoleUser->role_type=="Admin") {
            return view('admin',compact('dataUserLogin','dataRoleUser'));
        }elseif ($dataRoleUser->role_type=="Staff") {

            $bookings = Booking::with('booking_user_ref:id,code,name_th')->with('booking_emp_ref:id,code,name_th,phone')
            ->leftJoin('projects', 'projects.id', '=', 'bookings.project_id')
           ->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
           ->leftJoin('users as sales', 'sales.id', '=', 'bookings.user_id')
           ->leftJoin('users as employees', 'employees.id', '=', 'bookings.teampro_id')
           ->leftJoin('teams','teams.id', '=', 'bookings.team_id')
           ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
           ->select('bookings.*', 'projects.*', 'bookingdetails.*','bookings.id as bkid', 'sales.fullname as sale_name',
           'employees.fullname as emp_name','teams.id', 'teams.team_name', 'subteams.subteam_name')
           ->where('teampro_id',Session::get('loginId'))->get();

            return view('staff',compact('dataUserLogin','dataRoleUser','bookings'));
        }else{

            $bookings = Booking::with('booking_user_ref:id,code,name_th')->with('booking_emp_ref:id,code,name_th,phone')
            ->leftJoin('projects', 'projects.id', '=', 'bookings.project_id')
           ->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
           ->leftJoin('users as sales', 'sales.id', '=', 'bookings.user_id')
           ->leftJoin('users as employees', 'employees.id', '=', 'bookings.teampro_id')
           ->leftJoin('teams','teams.id', '=', 'bookings.team_id')
           ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
           ->select('bookings.*', 'projects.*', 'bookingdetails.*','bookings.id as bkid', 'sales.fullname as sale_name',
           'employees.fullname as emp_name','teams.id', 'teams.team_name', 'subteams.subteam_name')
           ->where('user_id',Session::get('loginId'))->get();

            return view('sale',compact('dataUserLogin','dataRoleUser','bookings'));
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
