<?php

namespace App\Http\Controllers;
use Session;
use App\Models\User;
use App\Models\Main;
use App\Models\Role_user;
use App\Models\Booking;
use App\Models\Project;
use App\Models\Subteam;
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


        $dataUserLogin = User::where('id', '=', Session::get('loginId'))->first();

        $projects = Project::where('active',1)->get();

        $dataRoleUser = Role_user::where('user_id', Session::get('loginId'))->first();

        $dataEmps = Role_user::with('user_ref:id,code,name_th as name_emp')->where('role_type','Staff')->get();
       // dd($dataEmps);
        $dataSales = Role_user::with('user_ref:id,code,name_th as name_sale')->where('role_type','Sale')->get();
        //$countBooking = Booking::where('teampro_id', Session::get('loginId'))->where('booking_status', 0)->count();
        //dd($CountBooking);
        $subTeams = Subteam::get();

        //ดึงข้อมูลเฉพาะที่ยังเปลี่ยนสถานะยกเลิกได้
        $ItemStatusHowCancel =  Booking::whereNotIn('booking_status', ["3","4","5"])->get();

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
             'dataSales',
            'ItemStatusHowCancel'));
        }elseif ($dataRoleUser->role_type=="Staff") {


            $bookings = Booking::with('booking_user_ref:id,code,name_th')
            ->with('booking_emp_ref:id,code,name_th,phone')
            ->with('booking_project_ref:id,name')
           ->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
           ->leftJoin('teams','teams.id', '=', 'bookings.team_id')
           ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
           ->select('bookings.*', 'bookingdetails.*','bookings.id as bkid','teams.id', 'teams.team_name', 'subteams.subteam_name')
           ->where('teampro_id',Session::get('loginId'))->get();


           $countAllBooking = Booking::where('teampro_id', Session::get('loginId'))->count();
           $countSucessBooking = Booking::where('teampro_id', Session::get('loginId'))->where('booking_status',3)->count();
           $countCancelBooking = Booking::where('teampro_id', Session::get('loginId'))->where('booking_status',4)->count();
           $countExitBooking = Booking::where('teampro_id', Session::get('loginId'))->where('booking_status',5)->count();

            return view('staff',compact('dataUserLogin',
            'dataRoleUser',
            'bookings',
            'projects',
            'subTeams',
            'countAllBooking',
            'countSucessBooking',
            'countCancelBooking',
            'countExitBooking',
            'dataEmps',
            'dataSales',
            'ItemStatusHowCancel'));

        }else{

            $bookings = Booking::with('booking_user_ref:id,code,name_th')
            ->with('booking_emp_ref:id,code,name_th,phone')
            ->with('booking_project_ref:id,name')
           ->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
           ->leftJoin('teams','teams.id', '=', 'bookings.team_id')
           ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
           ->select('bookings.*', 'bookingdetails.*','bookings.id as bkid','teams.id', 'teams.team_name', 'subteams.subteam_name')
           ->where('user_id',Session::get('loginId'))->get();

           $countAllBooking = Booking::where('user_id', Session::get('loginId'))->count();
           $countSucessBooking = Booking::where('user_id', Session::get('loginId'))->where('booking_status',3)->count();
           $countCancelBooking = Booking::where('user_id', Session::get('loginId'))->where('booking_status',4)->count();
           $countExitBooking = Booking::where('user_id', Session::get('loginId'))->where('booking_status',5)->count();
            //dd($countAllBooking);
            return view('sale',compact('dataUserLogin',
            'dataRoleUser',
            'bookings',
            'projects',
            'subTeams',
            'countAllBooking',
            'countSucessBooking',
            'countCancelBooking',
            'countExitBooking',
            'dataEmps',
            'dataSales'));
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {


        $dataUserLogin = User::where('id', Session::get('loginId'))->first();

        $projects = Project::where('active',1)->get();
        $subTeams = Subteam::get();

        $dataRoleUser = Role_user::where('user_id', Session::get('loginId'))->first();
        $dataEmps = Role_user::with('user_ref:id,code,name_th as name_emp')->where('role_type','Staff')->get();
        $dataSales = Role_user::with('user_ref:id,code,name_th as name_sale')->where('role_type','Sale')->get();
        $ItemStatusHowCancel =  Booking::whereNotIn('booking_status', ["3","4","5"])->get();

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

           // dd($request->start_date);
            $bookings = Booking::query()
            ->with('booking_user_ref:id,code,name_th')
            ->with('booking_emp_ref:id,code,name_th')
            ->with('booking_project_ref:id,name')
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
                $bookings->where('booking_start', 'like', '%' . $request->start_date . '%');
                //$bookings->where('booking_start', $request->start_date);
            }
            if ($request->end_date) {
                //$bookings->where('booking_stop', $request->end_date);
                $bookings->orwhere('booking_start', 'like', '%' . $request->end_date . '%');
            }
            if ($request->status) {
                $bookings->where('booking_status', $request->status);
            }
            if ($request->customer_name) {
                $bookings->where('customer_name', 'like', '%' . $request->customer_name . '%');
            }
            if ($request->sale_id) {
                $bookings->where('user_id', $request->sale_id);
            }
            if ($request->emp_id) {
                $bookings->where('teampro_id', $request->emp_id);
            }


            $bookings = $bookings->get();
              //dd($bookings);


            $projects = Project::where('active',1)->get();

            $countAllBooking = Booking::count();
            $countSucessBooking = Booking::where('booking_status',3)->count();
            $countCancelBooking = Booking::where('booking_status',4)->count();
            $countExitBooking = Booking::where('booking_status',5)->count();

             return view('search.admin',compact('dataUserLogin',
             'dataRoleUser',
             'bookings',
             'projects',
             'countAllBooking',
             'countSucessBooking',
             'countCancelBooking',
             'countExitBooking',
             'dataEmps',
             'dataSales',
            'ItemStatusHowCancel'));

        }elseif ($dataRoleUser->role_type=="Staff") {

            $bookings = Booking::query()
            ->with('booking_user_ref:id,code,name_th')
            ->with('booking_emp_ref:id,code,name_th')
            ->with('booking_project_ref:id,name')
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
                $bookings->where('booking_start', 'like', '%' . $request->start_date . '%');
                //$bookings->where('booking_start', $request->start_date);
            }
            if ($request->end_date) {
                //$bookings->where('booking_stop', $request->end_date);
                $bookings->orwhere('booking_start', 'like', '%' . $request->end_date . '%');
            }
            if ($request->status) {
                $bookings->where('booking_status', $request->status);
            }
            if ($request->customer_name) {
                $bookings->where('customer_name', 'like', '%' . $request->customer_name . '%');
            }
            if ($request->sale_id) {
                $bookings->where('user_id', $request->sale_id);
            }
            if ($request->emp_id) {
                $bookings->where('teampro_id', $request->emp_id);
            }
            if ($request->subteam_id) {
                $bookings->where('subteam_id', $request->subteam_id);
            }

            $bookings = $bookings->where('teampro_id',Session::get('loginId'))->get();
              //dd($bookings);

           $countAllBooking = Booking::where('teampro_id', Session::get('loginId'))->count();
           $countSucessBooking = Booking::where('teampro_id', Session::get('loginId'))->where('booking_status',3)->count();
           $countCancelBooking = Booking::where('teampro_id', Session::get('loginId'))->where('booking_status',4)->count();
           $countExitBooking = Booking::where('teampro_id', Session::get('loginId'))->where('booking_status',5)->count();

            return view('search.staff',compact('dataUserLogin',
            'dataRoleUser',
            'bookings',
            'projects',
            'subTeams',
            'countAllBooking',
            'countSucessBooking',
            'countCancelBooking',
            'countExitBooking',
            'dataEmps',
            'dataSales',
            'ItemStatusHowCancel'));

        }else{

            $bookings = Booking::query()
            ->with('booking_user_ref:id,code,name_th')
            ->with('booking_emp_ref:id,code,name_th')
            ->with('booking_project_ref:id,name')
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
                $bookings->where('booking_start', 'like', '%' . $request->start_date . '%');
                //$bookings->where('booking_start', $request->start_date);
            }
            if ($request->end_date) {
                //$bookings->where('booking_stop', $request->end_date);
                $bookings->orwhere('booking_start', 'like', '%' . $request->end_date . '%');
            }
            if ($request->status) {
                $bookings->where('booking_status', $request->status);
            }
            if ($request->customer_name) {
                $bookings->where('customer_name', 'like', '%' . $request->customer_name . '%');
            }
            if ($request->sale_id) {
                $bookings->where('user_id', $request->sale_id);
            }
            if ($request->emp_id) {
                $bookings->where('teampro_id', $request->emp_id);
            }
            if ($request->subteam_id) {
                $bookings->where('subteam_id', $request->subteam_id);
            }

            $bookings = $bookings->where('user_id',Session::get('loginId'))->get();
              //dd($bookings);

           $countAllBooking = Booking::where('user_id', Session::get('loginId'))->count();
           $countSucessBooking = Booking::where('user_id', Session::get('loginId'))->where('booking_status',3)->count();
           $countCancelBooking = Booking::where('user_id', Session::get('loginId'))->where('booking_status',4)->count();
           $countExitBooking = Booking::where('user_id', Session::get('loginId'))->where('booking_status',5)->count();
            //dd($countAllBooking);
            return view('search.sale',compact('dataUserLogin',
            'dataRoleUser',
            'bookings',
            'projects',
            'subTeams',
            'countAllBooking',
            'countSucessBooking',
            'countCancelBooking',
            'countExitBooking',
            'dataEmps',
            'dataSales'));
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
