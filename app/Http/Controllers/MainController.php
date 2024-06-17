<?php

namespace App\Http\Controllers;
use Session;
use App\Models\User;
use App\Models\Main;
use App\Models\Role_user;
use App\Models\Booking;
use App\Models\Project;
use App\Models\Subteam;
use App\Models\Log;
use Carbon\Carbon;
use Phattarachai\LineNotify\Line;
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

        $dataUserLogin = Session::get('loginId');
        //dd($dataUserLogin);
       // $dataUserLogin = User::where('id', '=', Session::get('loginId'))->first();

        $projects = Project::where('active',1)->get();
        dd($projects);

        $dataRoleUser = Role_user::where('user_id', Session::get('loginId')['user_id'])->first();

        $dataEmps = Role_user::where('role_type','Staff')->get();
        //$dataEmps = Role_user::with('user_ref:id,code,name_th as name_emp,active')->where('role_type','Staff')->get();
       // dd($dataEmps);
        //$dataSales = Role_user::with('user_ref:id,code,name_th as name_sale')->where('role_type','Sale')->get();
        $dataSales = Role_user::where('role_type','Sale')->get();
        //$countBooking = Booking::where('teampro_id', Session::get('loginId'))->where('booking_status', 0)->count();
        //dd($CountBooking);
        $subTeams = Subteam::get();

        //ดึงข้อมูลเฉพาะที่ยังเปลี่ยนสถานะยกเลิกได้
        //$ItemStatusHowCancel =  Booking::whereNotIn('booking_status', ["3","4","5"])->get();
        $ItemStatusHowCancel =  Booking::get();

        if ($dataRoleUser->role_type== "SuperAdmin" || $dataRoleUser->role_type=="User"){

            $countAllBooking = Booking::count();
            $countSucessBooking = Booking::where('booking_status',3)->count();
            $countCancelBooking = Booking::where('booking_status',4)->count();
            $countExitBooking = Booking::where('booking_status',5)->count();

            $countUser = Role_user::count();
            $countUserAdmin = Role_user::whereIn('role_type',['Admin','SuperAdmin'])->count();
            $countUserStaff= Role_user::where('role_type',"=",'Staff')->count();
            $countUserSale= Role_user::where('role_type',"=",'Sale')->count();
            $countUserOther= Role_user::where('role_type',"=",'User')->count();

             return view('index',compact('dataUserLogin',
             'dataRoleUser',
             'countAllBooking',
             'countSucessBooking',
             'countCancelBooking',
             'countExitBooking',
             'countUser',
             'countUserAdmin',
             'countUserStaff',
             'countUserSale',
             'countUserOther'));

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


    public function checkAlertBookingConfirm(){

        $bookings = Booking::where('booking_status', 0)->get();
        //dd($bookings);
        $currentDate = date('Y-m-d');
        $currentTime = date('H:i:s');
        $startTime = '16:00:00';
        $endTime = '17:30:00';

       // dd($startTime1);


        if($bookings->count() > 0){

            foreach ($bookings as $booking) {

                $bookingId = $booking->id;
                $booking_start = date('Y-m-d', strtotime($booking->booking_start));

                //check จองล่วงหน้า 1 วัน
                //$oneDayBeforeBookingDate = date('Y-m-d', strtotime($booking->booking_start . ' -1 day'));
                $limitTime = date('H:i:s', strtotime($booking->created_at.' +1 Hour'));

                if ($currentTime > $limitTime){

                    DB::table('bookings')
                    ->where('id', '=', $bookingId)
                    ->update([
                        'bookings.booking_status' => '5',
                        'bookings.because_cancel_remark' => 'ถูกยกเลิกอัตโนมัติ',
                        'bookings.because_cancel_other' => 'เจ้าหน้าที่โครงการไม่กดรับจอง',
                    ]);

                    Log::addLog('System', 'Update Status', 'ยกเลิกอัตโนมัติ เจ้าหน้าที่โครงการไม่กดรับจอง');

                    $token_line1 = config('line-notify.access_token_project');
                    $line = new Line($token_line1);
                    $line->send(
                        '🚨 *การจอง ถูกยกเลิกอัตโนมัติ '."* \n".
                        '----------------------------'." \n".
                        'หมายเลขการจอง : *'.$bookingId."* \n".
                        'เหตุผล : เจ้าหน้าที่โครงการ ❌ไม่กดรับจอง ภายในเวลาที่กำหนด 😥'
                    );
                    $token_line2 = config('line-notify.access_token_sale');
                    $line = new Line($token_line2);
                    $line->send(
                        '🚨 *การจอง ถูกยกเลิกอัตโนมัติ '."* \n".
                        '----------------------------'." \n".
                        'หมายเลขการจอง : *'.$bookingId."* \n".
                        'เหตุผล : เจ้าหน้าที่โครงการ ❌ไม่กดรับจอง ภายในเวลาที่กำหนด 😥'
                    );
                    return response()->json("OK! Sent Alert ".$bookings->count(), 200);

                }else{

                    return response()->json("Notfound! Sent Alert ", 404);
                }

            }



        }else{

            return response()->json("Error not found", 404);

        }








    }

    //แจ้งเตือนยกเลิก กรณี Saleไม่กด confirm
    public function checkAlertBookingConfirmSale(){

        $currentDate = Carbon::now();
        $currentTime = date('H:i:s');
        $nextDay = $currentDate->addDay(); // วันที่ปัจจุบัน +1 วัน

       //dd($currentDate);
        $bookings = Booking::where('booking_status', 1)
            ->where('booking_start', '<=', $nextDay)
            ->get();

        //dd($bookings);
        if ($bookings->count() > 0) {
            //dd("ok");
            foreach ($bookings as $booking) {
                $bookingId = $booking->id;

                DB::table('bookings')
                ->where('id', '=', $bookingId)
                ->update([
                    'bookings.booking_status' => '5',
                    'bookings.because_cancel_remark' => 'ถูกยกเลิกอัตโนมัติ',
                    'bookings.because_cancel_other' => 'Saleไม่กดคอนเฟิร์มนัด',
                ]);

                 Log::addLog('System', 'Update Status', 'ยกเลิกอัตโนมัติ Sale ไม่กดคอนเฟิร์มนัด');

                 $token_line1 = config('line-notify.access_token_project');
                 $line = new Line($token_line1);
                 $line->send(
                     '🚨 *การจอง ถูกยกเลิกอัตโนมัติ '."* \n".
                     '----------------------------'." \n".
                     'หมายเลขการจอง : *'.$bookingId."* \n".
                    'เหตุผล : Sale ❌ไม่กดคอนเฟิร์มนัด  ภายในเวลาที่กำหนด 😥'
                 );
                 $token_line2 = config('line-notify.access_token_sale');
                 $line = new Line($token_line2);
                 $line->send(
                     '🚨 *การจอง ถูกยกเลิกอัตโนมัติ '."* \n".
                     '----------------------------'." \n".
                     'หมายเลขการจอง : *'.$bookingId."* \n".
                    'เหตุผล : Sale ❌ไม่กดคอนเฟิร์มนัด  ภายในเวลาที่กำหนด 😥'
                 );

             }

             return response()->json("OK! Sent Alert ".$bookings->count(), 200);
        }else{

            return response()->json("Notfound! Sent Alert ", 404);

        }



    }

    //แจ้งเตือน Sale ให้กด confirm
    public function alertBeforeBookingConfirmSale(){

        $currentDate = Carbon::now();
        $currentTime = date('H:i:s');
        $nextDay = $currentDate->addDay();

       //dd($currentDate);
        $bookings = Booking::with('booking_user_ref:id,code,name_th')->with('booking_emp_ref:id,code,name_th,phone')
        ->where('booking_status', 1)
        ->where('booking_start', '<=', $nextDay)
        ->get();

        //dd($bookings);
        if ($bookings->count() > 0) {
            //dd("ok");
            foreach ($bookings as $booking) {
                $bookingId = $booking->id;

                 $token_line1 = config('line-notify.access_token_sale');
                 $line = new Line($token_line1);
                 $line->send(
                     '⚠️ *เตือน...* ❗️❗️'." \n".
                     'หมายเลขการจอง : *'.$bookingId."* \n".
                     'ชื่อ Sale : *'.$booking->booking_user_ref[0]->name_th."* \n".
                     '----------------------------'." \n".
                     '❌ ยังไม่ได้กดคอนเฟริ์มนัด'." \n".
                     '✨ กดคอนเฟริ์มนัด => '.route('main')
                 );
             }
             Log::addLog('System', 'Alert', 'แจ้งเตือน Sale ให้กดคอนเฟริ์มนัด');
             return response()->json("OK! Sent Alert ".$bookings->count(), 200);
        }else{

            return response()->json("Notfound! Sent Alert ", 404);

        }



    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {


        $dataUserLogin = User::where('user_id', Session::get('loginId')['user_id'])->first();

        $projects = Project::where('active',1)->get();
        $subTeams = Subteam::get();

        $dataRoleUser = Role_user::where('user_id', Session::get('loginId')['user_id'])->first();
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

            $bookings = $bookings->where('teampro_id',Session::get('loginId')['user_id'])->get();
              //dd($bookings);

           $countAllBooking = Booking::where('teampro_id', Session::get('loginId')['user_id'])->count();
           $countSucessBooking = Booking::where('teampro_id', Session::get('loginId')['user_id'])->where('booking_status',3)->count();
           $countCancelBooking = Booking::where('teampro_id', Session::get('loginId')['user_id'])->where('booking_status',4)->count();
           $countExitBooking = Booking::where('teampro_id', Session::get('loginId')['user_id'])->where('booking_status',5)->count();

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

            $bookings = $bookings->where('user_id',Session::get('loginId')['user_id'])->get();
              //dd($bookings);

           $countAllBooking = Booking::where('user_id', Session::get('loginId')['user_id'])->count();
           $countSucessBooking = Booking::where('user_id', Session::get('loginId')['user_id'])->where('booking_status',3)->count();
           $countCancelBooking = Booking::where('user_id', Session::get('loginId')['user_id'])->where('booking_status',4)->count();
           $countExitBooking = Booking::where('user_id', Session::get('loginId')['user_id'])->where('booking_status',5)->count();
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
