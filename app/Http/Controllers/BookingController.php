<?php

namespace App\Http\Controllers;

use Session;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Role_user;
use App\Models\Holiday;
use App\Models\Project;
use App\Models\Booking;
use App\Models\Bookingdetail;
use App\Models\Team;
use App\Models\Subteam;
use App\Models\Log;
use GuzzleHttp\Client;
use RealRashid\SweetAlert\Facades\Alert;
use Phattarachai\LineNotify\Line;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class BookingController extends Controller
{

    private function addApiDataToSale($dataSales)
    {

        $client = new Client();
        $url = env('API_URL');
        $token = env('API_TOKEN_AUTH');


        $userIds = $dataSales->pluck('user_id')->toArray();
        $userIdsString = implode(',', $userIds);

        try {
            // ส่ง request ไปยัง System B เพื่อดึงข้อมูลผู้ใช้
            $response = $client->request('GET', $url . '/get-users/' . $userIdsString, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token
                ]
            ]);
            if ($response->getStatusCode() == 200) {

                $apiResponse = json_decode($response->getBody()->getContents(), true);

                if (isset($apiResponse['data']['data'])) {
                    // ดึงข้อมูล user จาก $apiResponse['data']['data']
                    $userData = $apiResponse['data']['data'];

                    foreach ($dataSales as $sale) {

                        $userApiData = collect($userData)->firstWhere('id', $sale->user_id);

                        if ($userApiData) {
                            $sale->apiData = [
                                'id' => $userApiData['id'],
                                'name_th' => $userApiData['name_th'],

                            ];
                        } else {

                            $sale->apiData = null;
                        }
                    }
                } else {

                    foreach ($dataSales as $sale) {
                        $sale->apiData = null;
                    }
                }
            } else {

                foreach ($dataSales as $sale) {
                    $sale->apiData = null;
                }
            }
        } catch (\Exception $e) {

            foreach ($dataSales as $sale) {
                $sale->apiData = null;
            }
        }
    }

    private function addApiDataToEmp($dataEmps)
    {

        $client = new Client();
        $url = env('API_URL');
        $token = env('API_TOKEN_AUTH');


        $userIds = $dataEmps->pluck('user_id')->toArray();
        $userIdsString = implode(',', $userIds);

        try {

            $response = $client->request('GET', $url . '/get-users/' . $userIdsString, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token
                ]
            ]);
            if ($response->getStatusCode() == 200) {

                $apiResponse = json_decode($response->getBody()->getContents(), true);

                if (isset($apiResponse['data']['data'])) {
                    // ดึงข้อมูล user จาก $apiResponse['data']['data']
                    $userData = $apiResponse['data']['data'];

                    foreach ($dataEmps as $dataEmp) {

                        $userApiData = collect($userData)->firstWhere('id', $dataEmp->user_id);

                        if ($userApiData) {
                            $dataEmp->apiData = [
                                'id' => $userApiData['id'],
                                'name_th' => $userApiData['name_th'],
                                'active' => $userApiData['active'],

                            ];
                        } else {

                            $userSelect->apiData = null;
                        }
                    }
                } else {

                    foreach ($dataEmps as $dataEmp) {
                        $dataEmp->apiData = null;
                    }
                }
            } else {

                foreach ($dataEmps as $dataEmp) {
                    $dataEmp->apiData = null;
                }
            }
        } catch (\Exception $e) {

            foreach ($dataEmps as $dataEmp) {
                $dataEmp->apiData = null;
            }
        }
    }

    private function addApiDataToUser($bookings)
    {
        $client = new Client();
        $url = env('API_URL');
        $token = env('API_TOKEN_AUTH');

        // Extract user_ids and teampro_ids from bookings
        $userIds = $bookings->pluck('user_id')->toArray();
        $userIdsString = implode(',', $userIds);

        $tProIds = $bookings->pluck('teampro_id')->toArray();
        $tProIdsString = implode(',', $tProIds);

        try {
            // First API call to get user data
            $userResponse = $client->request('GET', $url . '/get-users/' . $userIdsString, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token
                ]
            ]);

            if ($userResponse->getStatusCode() == 200) {
                $userApiResponse = json_decode($userResponse->getBody()->getContents(), true);

                if (isset($userApiResponse['data']['data'])) {
                    $userData = $userApiResponse['data']['data'];
                } else {
                    $userData = [];
                }
            } else {
                $userData = [];
            }

            // Second API call to get teampro data
            $teamProResponse = $client->request('GET', $url . '/get-users/' . $tProIdsString, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token
                ]
            ]);

            if ($teamProResponse->getStatusCode() == 200) {
                $teamProApiResponse = json_decode($teamProResponse->getBody()->getContents(), true);

                if (isset($teamProApiResponse['data']['data'])) {
                    $teamProData = $teamProApiResponse['data']['data'];
                } else {
                    $teamProData = [];
                }
            } else {
                $teamProData = [];
            }

            // Attach apiData to bookings
            foreach ($bookings as $booking) {
                $userApiData = collect($userData)->firstWhere('id', $booking->user_id);
                $teamProApiData = collect($teamProData)->firstWhere('id', $booking->teampro_id);

                $booking->apiDataSale = $userApiData ? [
                    'id' => $userApiData['id'],
                    'name_th' => $userApiData['name_th'],
                    'active' => $userApiData['active'],
                ] : null;

                $booking->apiDataPro = $teamProApiData ? [
                    'id' => $teamProApiData['id'],
                    'name_th' => $teamProApiData['name_th'],
                    'active' => $teamProApiData['active'],
                    'phone' => $teamProApiData['phone'],
                ] : null;
            }
        } catch (\Exception $e) {
            // Handle exception by setting apiData to null for all bookings
            foreach ($bookings as $booking) {
                if (is_object($booking)) {
                    $booking->apiDataSale = null;
                    $booking->apiDataPro = null;
                }
            }
        }
    }

    private function addApiDataToEmps($dataEmps)
    {
        if (!$dataEmps) {
            return; // or handle the null case as needed
        }

        $client = new Client();
        $url = env('API_URL');
        $token = env('API_TOKEN_AUTH');

        $userIds = is_array($dataEmps) ? collect($dataEmps)->pluck('user_id')->toArray() : [$dataEmps->user_id];
        $userIdsString = implode(',', $userIds);

        try {
            $response = $client->request('GET', $url . '/get-users/' . $userIdsString, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token
                ]
            ]);

            if ($response->getStatusCode() == 200) {
                $apiResponse = json_decode($response->getBody()->getContents(), true);

                if (isset($apiResponse['data']['data'])) {
                    $userData = $apiResponse['data']['data'];

                    $dataEmpsCollection = is_array($dataEmps) ? $dataEmps : [$dataEmps];
                    foreach ($dataEmpsCollection as $dataEmp) {
                        $userApiData = collect($userData)->firstWhere('id', $dataEmp->user_id);

                        if ($userApiData) {
                            $dataEmp->apiData = [
                                'id' => $userApiData['id'],
                                'name_th' => $userApiData['name_th'],
                                'active' => $userApiData['active'],
                            ];
                        } else {
                            $dataEmp->apiData = null;
                        }
                    }
                } else {
                    $this->clearApiData($dataEmps);
                }
            } else {
                $this->clearApiData($dataEmps);
            }
        } catch (\Exception $e) {
            $this->clearApiData($dataEmps);
        }
    }

    private function addApiDataToSales($dataSales)
    {
        if (!$dataSales) {
            return; // or handle the null case as needed
        }

        $client = new Client();
        $url = env('API_URL');
        $token = env('API_TOKEN_AUTH');

        $userIds = is_array($dataSales) ? collect($dataSales)->pluck('user_id')->toArray() : [$dataSales->user_id];
        $userIdsString = implode(',', $userIds);

        try {
            $response = $client->request('GET', $url . '/get-users/' . $userIdsString, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token
                ]
            ]);

            if ($response->getStatusCode() == 200) {
                $apiResponse = json_decode($response->getBody()->getContents(), true);

                if (isset($apiResponse['data']['data'])) {
                    $userData = $apiResponse['data']['data'];

                    $dataSalesCollection = is_array($dataSales) ? $dataSales : [$dataSales];
                    foreach ($dataSalesCollection as $sale) {
                        $userApiData = collect($userData)->firstWhere('id', $sale->user_id);

                        if ($userApiData) {
                            $sale->apiData = [
                                'id' => $userApiData['id'],
                                'name_th' => $userApiData['name_th'],
                            ];
                        } else {
                            $sale->apiData = null;
                        }
                    }
                } else {
                    $this->clearApiData($dataSales);
                }
            } else {
                $this->clearApiData($dataSales);
            }
        } catch (\Exception $e) {
            $this->clearApiData($dataSales);
        }
    }

    private function clearApiData($data)
    {
        if (is_array($data) || $data instanceof \Illuminate\Support\Collection) {
            foreach ($data as $item) {
                $item->apiData = null;
            }
        } else {
            $data->apiData = null;
        }
    }

    private function addApiDataToUsers($booking)
    {
        $client = new Client();
        $url = env('API_URL');
        $token = env('API_TOKEN_AUTH');

        // Extract user_ids and teampro_ids from bookings
        $userIds = $booking->pluck('user_id')->toArray();
        $userIdsString = implode(',', $userIds);

        $tProIds = $booking->pluck('teampro_id')->toArray();
        $tProIdsString = implode(',', $tProIds);

        try {
            // First API call to get user data
            $userResponse = $client->request('GET', $url . '/get-users/' . $userIdsString, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token
                ]
            ]);

            if ($userResponse->getStatusCode() == 200) {
                $userApiResponse = json_decode($userResponse->getBody()->getContents(), true);

                if (isset($userApiResponse['data']['data'])) {
                    $userData = $userApiResponse['data']['data'];
                } else {
                    $userData = [];
                }
            } else {
                $userData = [];
            }

            // Second API call to get teampro data
            $teamProResponse = $client->request('GET', $url . '/get-users/' . $tProIdsString, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $token
                ]
            ]);

            if ($teamProResponse->getStatusCode() == 200) {
                $teamProApiResponse = json_decode($teamProResponse->getBody()->getContents(), true);

                if (isset($teamProApiResponse['data']['data'])) {
                    $teamProData = $teamProApiResponse['data']['data'];
                } else {
                    $teamProData = [];
                }
            } else {
                $teamProData = [];
            }

            // Attach apiData to bookings
            foreach ($booking as $book) {
                $userApiData = collect($userData)->firstWhere('id', $book->user_id);
                $teamProApiData = collect($teamProData)->firstWhere('id', $book->teampro_id);

                $book->apiDataSale = $userApiData ? [
                    'id' => $userApiData['id'],
                    'name_th' => $userApiData['name_th'],
                    'active' => $userApiData['active'],
                ] : null;

                $book->apiDataPro = $teamProApiData ? [
                    'id' => $teamProApiData['id'],
                    'name_th' => $teamProApiData['name_th'],
                    'active' => $teamProApiData['active'],
                    'phone' => $teamProApiData['phone'],
                ] : null;
            }
        } catch (\Exception $e) {

            foreach ($booking as $book) {
                if (is_object($book)) {
                    $book->apiDataSale = null;
                    $book->apiDataPro = null;
                }
            }
        }
    }

    //นัดเยี่ยมโครงการ
    public function bookingProject(Request $request)
    {

        $currentTime = date('H:i:s');
        $startTime = '08:30:00';
        $endTime = '18:00:00';

        $events = [];

        // $dataUserLogin = User::where('user_id', Session::get('loginId')['user_id'])->first();
        $dataUserLogin = Session::get('loginId');
        $dataRoleUser = Role_user::where('user_id', Session::get('loginId')['user_id'])->first();
        //dd($dataUserLogin['apiData']['data']['name_th']);
        // $dataSales = Role_user::with('user_ref:id,code,name_th as name_sale')->where('role_type','Sale')->get();

        $dataSales = Role_user::where('role_type', 'Sale')->get();

        // API
        $this->addApiDataToSale($dataSales);

        //โครงการ
        $projects = Project::where('active', 1)->get();

        //ทีมสายงาน
        $teams = Team::get();

        //dd($dataSales);


        if ($request->ajax()) {

            // $bookings = Booking::leftJoin('projects','projects.id','=','bookings.project_id')
            // ->leftJoin('bookingdetails','bookingdetails.booking_id','=','bookings.id')->get();

            $bookings = Booking::with('booking_project_ref:id,name')
                // ->with('booking_emp_ref:id,code,name_th,phone') //จน. โครงการ
                // ->with('booking_user_ref:id,code,name_th') //ชื่อ Sale
                ->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
                ->leftJoin('teams', 'teams.id', '=', 'bookings.team_id')
                ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
                ->select('bookings.*', 'bookingdetails.*', 'bookings.id as bkid', 'teams.id', 'teams.team_name', 'subteams.subteam_name')
                ->where('user_id', Session::get('loginId')['user_id'])
                ->orderBy('bkid', 'desc')
                ->get();
                $this->addApiDataToUser($bookings);
            //dd($bookings);

            foreach ($bookings as $booking) {

                $start_time = Carbon::parse($booking->booking_start)->toIso8601String();
                $end_time = Carbon::parse($booking->booking_end)->toIso8601String();

                if ($booking->booking_status == 0) {
                    $backgroundColor = "#a6a6a6";
                    $borderColor = "#a6a6a6";
                    $textStatus = "รอรับงาน";
                } elseif ($booking->booking_status == 1) {
                    $backgroundColor = "#f39c12";
                    $borderColor = "#f39c12";
                    $textStatus = "รับงานแล้ว";
                } elseif ($booking->booking_status == 2) {
                    $backgroundColor = "#00c0ef";
                    $borderColor = "#00c0ef";
                    $textStatus = "จองสำเร็จ";
                } elseif ($booking->booking_status == 3) {
                    $backgroundColor = "#00a65a";
                    $borderColor = "#00a65a";
                    $textStatus = "เยี่ยมชมเรียบร้อย";
                } elseif ($booking->booking_status == 4) {
                    $backgroundColor = "#dd4b39";
                    $borderColor = "#dd4b39";
                    $textStatus = "ยกเลิก";
                } else {
                    $backgroundColor = "#b342f5";
                    $borderColor = "#b342f5";
                    $textStatus = "ยกเลิกอัตโนมัติ";
                }

                $event = [
                    'id' => $booking->id,
                    'title' => $booking->booking_title,
                    'project' => $booking->booking_project_ref[0]->name,
                    'status' => $textStatus,
                    'booking_status' => $booking->booking_status,
                    'customer' => $booking->customer_name . " " . $booking->customer_tel,
                    'sale' => $booking->booking_user_ref[0]->name_th,
                    'employee' => $booking->booking_emp_ref[0]->name_th . " " . $booking->booking_emp_ref[0]->phone,
                    'team_name' => $booking->team_name . "/" . $booking->subteam_name,
                    'tel' => $booking->user_tel,
                    'room_no' => $booking->room_no,
                    'room_price' => number_format($booking->room_price),
                    'cus_req' => $booking->customer_req,
                    'start' => $start_time,
                    'end' => $end_time,
                    'allDay' => false,
                    'backgroundColor' => $backgroundColor,
                    'borderColor' => $borderColor,
                ];

                array_push($events, $event);
            }

            return response()->json($events);
        } // call ajax

        //check time booking for sale
        if ($dataRoleUser->role_type == "Sale") {

            // if ($currentTime >= $startTime && $currentTime <= $endTime) {
                return view("booking.index", compact('dataUserLogin', 'dataRoleUser', 'projects', 'teams', 'dataSales'));
                //return view("booking.close",compact('dataUserLogin','dataRoleUser'));
            // } else {
            //     return view("booking.close", compact('dataUserLogin', 'dataRoleUser'));
            // }
        } else {
            return view("booking.index", compact('dataUserLogin', 'dataRoleUser', 'projects', 'teams', 'dataSales'));
        }
    }

    public function editBooking(Request $request, $id)
    {

        // $dataUserLogin = User::where('user_id', Session::get('loginId')['user_id'])->first();
        $dataUserLogin = Session::get('loginId');
        $dataRoleUser = Role_user::where('user_id', Session::get('loginId')['user_id'])->first();
        // $dataSales = Role_user::with('user_ref:id,code,name_th as name_sale')->where('role_type', 'Sale')->get();
        $dataSales = Role_user::where('role_type', 'Sale')->get();
        $this->addApiDataToSale($dataSales);
        //โครงการ
        $projects = Project::where('active', 1)->get();

        //ทีมสายงาน
        $teams = Team::get();

        // $bookings = Booking::with('booking_user_ref:id,code,name_th')
        //     ->with('booking_emp_ref:id,code,name_th,phone')
        //     ->with('booking_project_ref:id,name')
        //     ->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
        //     ->leftJoin('teams', 'teams.id', '=', 'bookings.team_id')
        //     ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
        //     ->select('bookings.*', 'bookingdetails.*', 'bookings.id as bkid', 'teams.id', 'teams.team_name', 'subteams.subteam_name')
        //     ->where('bookings.id', "=", $id)->first();
            $bookings = Booking::with('booking_project_ref:id,name')
            ->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
            ->leftJoin('teams', 'teams.id', '=', 'bookings.team_id')
            ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
            ->select('bookings.*', 'bookingdetails.*', 'bookings.id as bkid', 'teams.id', 'teams.team_name', 'subteams.subteam_name')
            ->where('bookings.id', "=", $id)->get();
            $this->addApiDataToUser($bookings);
        //dd($bookings[0]->apiDataSale['name_th']);

        return view("booking.edit", compact('dataUserLogin', 'dataRoleUser', 'bookings', 'projects', 'teams', 'dataSales'));
    }
    //รายการจอง เฉพาะ Superadmin
    public function listBooking(Request $request)
    {

        $dataUserLogin = Session::get('loginId');
        // $dataUserLogin = User::where('user_id', '=', Session::get('loginId')['user_id'])->first();
        $dataRoleUser = Role_user::where('user_id', Session::get('loginId')['user_id'])->first();

        $projects = Project::where('active', 1)->get();

        $teams = Team::get();
        $subTeams = Subteam::get();

        //$dataEmps = Role_user::with('user_ref:id,code,name_th as name_emp')->where('role_type', 'Staff')->get();
        $dataEmps = Role_user::where('role_type', 'Staff')->get();
        $this->addApiDataToEmp($dataEmps);
        // dd($dataEmps);
        //$dataSales = Role_user::with('user_ref:id,code,name_th as name_sale')->where('role_type', 'Sale')->get();
        $dataSales = Role_user::where('role_type', 'Sale')->get();
        $this->addApiDataToSale($dataSales);
        //$countBooking = Booking::where('teampro_id', Session::get('loginId'))->where('booking_status', 0)->count();
        //dd($CountBooking);

        //ดึงข้อมูลเฉพาะที่ยังเปลี่ยนสถานะยกเลิกได้
        //$ItemStatusHowCancel =  Booking::whereNotIn('booking_status', ["3","4","5"])->get();
        $ItemStatusHowCancel =  Booking::get();

        // $bookings = Booking::with('booking_user_ref:id,code,name_th')
        //     ->with('booking_emp_ref:id,code,name_th,phone')
        //     ->with('booking_project_ref:id,name')
        //     ->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
        //     ->leftJoin('teams', 'teams.id', '=', 'bookings.team_id')
        //     ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
        //     ->select('bookings.*', 'bookingdetails.*', 'bookings.id as bkid', 'teams.id', 'teams.team_name', 'subteams.subteam_name')
        //     ->orderBy('bkid', 'desc')->get();

        $bookings = Booking::with('booking_project_ref:id,name')
            ->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
            ->leftJoin('teams', 'teams.id', '=', 'bookings.team_id')
            ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
            ->select('bookings.*', 'bookingdetails.*', 'bookings.id as bkid', 'teams.id', 'teams.team_name', 'subteams.subteam_name')
            ->orderBy('bkid', 'desc')->get();

        $this->addApiDataToUser($bookings);

       //dd($bookings);

        return view("booking.list", compact(
            'dataUserLogin',
            'dataRoleUser',
            'bookings',
            'projects',
            'teams',
            'subTeams',
            'dataEmps',
            'dataSales',
            'ItemStatusHowCancel'
        ));
    }


    public function getByTeam(Request $request)
    {
        $subteams = Subteam::where('team_id', $request->team_id)->get();
        return response()->json($subteams);
    }

    //สร้างนัดเยี่ยมโครงการ
    public function createBookingProject(Request $request)
    {

        $request->validate([
            'date' => 'required',
            'time' => 'required',
            'project_id' => 'required',
            'customer_name' => 'required',
            'customer_tel' => 'required',
            'room_price' => 'required',
            'room_no' => 'required',
            'team_id' => 'required',
            'subteam_id' => 'required',
            'user_tel' => 'required',
        ], [
            'date.required' => 'กรอกวันที่',
            'time.required' => 'กรอกเวลา',
            'project_id.required' => 'เลือกโครงการ',
            'customer_name.required' => 'กรอกชื่อลูกค้า',
            'customer_tel.required' => 'กรอกเบอร์ลูกค้า',
            'room_price.required' => 'กรอกราคาห้อง',
            'room_no.required' => 'เลขห้อง',
            'team_id.required' => 'เลือกผู้ดูแลสายงาน',
            'subteam_id.required' => 'เลือกชื่อสายงาน',
            'user_tel.required' => 'กรอกเบอร์ติดต่อสายงาน',
        ]);

        //slot time 3 hr.
        $end_time = date('H:i', strtotime($request->time . ' +3 hours'));
        $booking_date = $request->date;
        $booking_start = $request->date . " " . $request->time;
        $booking_end = $request->date . " " . $end_time;


        // $employees_not_on_holiday = Role_user::with('user_ref:id,code,name_th,active')
        //     ->whereNotIn('role_users.user_id', function ($query) use ($booking_date) {
        //         $query->select('holiday_users.user_id')
        //             ->from('holiday_users')
        //             ->where('holiday_users.start_date', '<=', $booking_date)
        //             ->where('holiday_users.end_date', '>=', $booking_date)
        //             ->whereIn('holiday_users.status', [0, 1]);
        //     })
        //     ->whereIn('role_type', ['Staff'])
        //     ->select('role_users.*')
        //     ->orderBy('role_users.id')
        //     ->get();
        $employees_not_on_holiday = Role_user::whereNotIn('role_users.user_id', function ($query) use ($booking_date) {
            $query->select('holiday_users.user_id')
                ->from('holiday_users')
                ->where('holiday_users.start_date', '<=', $booking_date)
                ->where('holiday_users.end_date', '>=', $booking_date)
                ->whereIn('holiday_users.status', [0, 1]);
        })
        ->whereIn('role_type', ['Staff'])
        ->select('role_users.*')
        ->orderBy('role_users.id')
        ->get();


        $booking_count = [];

        foreach ($employees_not_on_holiday as $employee) {
            // if (optional($employee->user_ref->first())->active == "1") {
            //dd($employee);
                $teampro_id = $employee->user_id;
                $booking_count = Booking::where(function ($query) use ($booking_start, $booking_end, $teampro_id) {
                    $query->where(function ($subquery) use ($booking_start, $booking_end) {
                        $subquery->where('booking_start', '<', $booking_end)
                            ->where('booking_end', '>', $booking_start);
                    })->orWhere(function ($subquery) use ($booking_start, $booking_end) {
                        $subquery->whereBetween('booking_start', [$booking_start, $booking_end])
                            ->orWhereBetween('booking_end', [$booking_start, $booking_end]);
                    });
                })->where('teampro_id', $teampro_id)->count();


                if ($booking_count == 0 && !in_array($employee->user_id, session()->get('booked_employee_ids', []))) {
                    //เรียกค่าของ session ของ booked_employee_ids หากไม่มีข้อมูล จะ return ค่าว่างไว้ก่อน
                    session()->push('booked_employee_ids', $employee->user_id);
                    break; // หลังจาก insert แล้ว ให้ break การวน loop เพื่อให้เลือกพนักงานคนต่อไป

                }

                if ($employee->user_id == $employees_not_on_holiday->last()->user_id) {
                    // ถ้าถึงคนสุดท้ายแล้ว ให้ reset ค่า array ที่เก็บไว้ใน session
                    session()->forget('booked_employee_ids');
                    session()->save();
                    reset($employees_not_on_holiday); // ให้วน loop จากตัวแรกอีกครั้ง
                    break; // หลังจาก reset ให้ break การวน loop เพื่อให้เลือกพนักงานคนต่อไป
                }
            // }
        }



        if ($booking_count == 0) {

            $booking = new Booking();
            $booking->booking_title = $request->booking_title; //หัวข้อการจอง
            $booking->booking_start = $booking_start;
            $booking->booking_end = $booking_end;
            $booking->booking_status = "0"; //สถานะ เยี่ยมโครงการ
            $booking->project_id = $request->project_id;
            $booking->booking_status_df = "0"; //สถานะ DF
            $booking->teampro_id = $employee->user_id; //เจ้าหน้าที่โครง
            $booking->team_id = $request->team_id;
            $booking->subteam_id = $request->subteam_id;
            $booking->user_id = $request->user_id; //ชื่อผู้จอง|ผู้ทำรายการจอง
            $booking->user_tel = $request->user_tel;
            $booking->remark = $request->remark;
            $res1 = $booking->save();


            $id_booking = Booking::with('booking_project_ref:id,name')
                ->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
                ->leftJoin('teams', 'teams.id', '=', 'bookings.team_id')
                ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
                ->select('bookings.*', 'bookingdetails.*', 'teams.id', 'teams.team_name', 'subteams.subteam_name', 'bookings.id as bkID')->latest()->first();
            // $id_booking = Booking::with('booking_user_ref:id,code,name_th')
            //     ->with('booking_emp_ref:id,code,name_th,phone')
            //     ->with('booking_project_ref:id,name')
            //     ->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
            //     ->leftJoin('teams', 'teams.id', '=', 'bookings.team_id')
            //     ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
            //     ->select('bookings.*', 'bookingdetails.*', 'teams.id', 'teams.team_name', 'subteams.subteam_name', 'bookings.id as bkID')->latest()->first();

            $projects = Project::where('id', $request->project_id)->first();


            //insert detail customer
            $bookingdetail = new Bookingdetail();
            $bookingdetail->booking_id = $id_booking->bkID; //ref booking_id
            $bookingdetail->customer_name = $request->customer_name;
            $bookingdetail->customer_tel = $request->customer_tel;

            if ($request->checkbox_room != null) {
                $bookingdetail->customer_req = implode(',', $request->checkbox_room);
                $customer_req = implode(',', $request->checkbox_room);
            } else {
                $bookingdetail->customer_req = "";
                $customer_req = "-";
            }

            if ($request->checkbox_bank != null) {
                $bookingdetail->customer_req_bank = implode(',', $request->checkbox_bank);
            } else {
                $bookingdetail->customer_req_bank = "";
            }

            if ($request->checkbox_doc != null) {
                $bookingdetail->customer_doc_personal = implode(',', $request->checkbox_doc);
            } else {
                $bookingdetail->customer_doc_personal = "";
            }

            $bookingdetail->customer_req_bank_other = $request->customer_req_bank_other;
            $bookingdetail->num_home = $request->num_home;
            $bookingdetail->num_idcard = $request->num_idcard;
            $bookingdetail->num_app_statement = $request->num_app_statement;
            $bookingdetail->num_statement = $request->num_statement;
            $bookingdetail->room_no = $request->room_no;
            $bookingdetail->room_price = ($request->room_price) ? str_replace(',', '', $request->room_price) : NULL;

            $res2 = $bookingdetail->save();

            $Strdate_start = date('d/m/Y', strtotime($request->date . ' +543 year'));

            // $getSaleName = Role_user::with('user_ref:id,code,name_th as name_sale')->where('user_id', $request->user_id)->first();
            $dataSales = Role_user::where('role_type', 'Sale')->where('user_id', $request->user_id)->first();

            $this->addApiDataToSales($dataSales);

            $dataEmps = Role_user::where('role_type', 'Staff')->where('user_id', $employee->user_id)->first();
            $this->addApiDataToEmps($dataEmps);

           // dd($dataEmps->apiData['name_th']);


            if ($res1 || $res2) {

                Alert::success('จองสำเร็จ!', '');
                $token_line1 = config('line-notify.access_token_project');
                $line = new Line($token_line1);
                $line->send(
                    '📌 *มีนัด ' . $request->booking_title . "* \n" .
                        '----------------------------' . " \n" .
                        'หมายเลขการจอง : *' . $id_booking->bkID . "* \n" .
                        'โครงการ : *' . $projects->name . "* \n" .
                        'วัน/เวลา : `' . $Strdate_start . ' ' . $request->time . '-' . $end_time . "` \n" .
                        // 'ลูกค้าชื่อ : *'.$request->customer_name."* \n".
                        // 'เบอร์ติดต่อ : *'.$request->customer_tel."* \n".
                        'ข้อมูลเข้าชม : *' . $customer_req . ' ' . $request->room_price . ' ห้อง' . $request->room_no . "* \n" .
                        '----------------------------' . " \n" .
                        'ชื่อ Sale : *' .$dataSales->apiData['name_th']. "* \n" .
                        'ทีม/สายงาน : *' . $id_booking->team_name . "* - $id_booking->subteam_name \n" .
                        'เบอร์สายงาน : *' . $request->user_tel . "* \n" .
                        'จน. โครงการ : *' . $dataEmps->apiData['name_th'] . "* \n\n" .
                        '⚠️ กรุณากดรับจองภายใน 1 ชม. ' . " \n" . 'หากไม่รับจองภายในเวลาที่กำหนด' . " \n" . 'ระบบจะยกเลิกการจองอัตโนมัติ❗️'
                        // ." \n ✅กดรับจอง => ".'https://bit.ly/3AUARP0');
                        . " \n ✅กดรับจอง => " . route('main')
                );





                $token_line2 = config('line-notify.access_token_sale');
                $line = new Line($token_line2);
                $line->send(
                    '📌 *คุณได้จองนัด ' . $request->booking_title . "* \n" .
                        '----------------------------' . " \n" .
                        'หมายเลขการจอง : *' . $id_booking->bkID . "* \n" .
                        'โครงการ : *' . $projects->name . "* \n" .
                        'วัน/เวลา : `' . $Strdate_start . ' ' . $request->time . '-' . $end_time . "` \n" .
                        // 'ลูกค้าชื่อ : *'.$request->customer_name."* \n".
                        'ข้อมูลเข้าชม : *' . $customer_req . ' ' . $request->room_price . ' ห้อง' . $request->room_no . "* \n" .
                        '---------------------------' . " \n" .
                        'ชื่อ Sale : *' . $dataSales->apiData['name_th']. "* \n" .
                        'ทีม/สายงาน : *' . $id_booking->team_name . "* - $id_booking->subteam_name \n" .
                        'เบอร์สายงาน : *' . $request->user_tel . "* \n" .
                        'จน. โครงการ : *' . $dataEmps->apiData['name_th'] . "* \n\n" .
                        '⏰ โปรดรอ *เจ้าหน้าที่โครงการ' . "* \n" . ' กดรับงานภายใน 1 ชม.'
                );

                Log::addLog(Session::get('loginId')['user_id'], 'Create', $request->booking_title . ", " . $id_booking->bkID);

                Alert::success('Success', 'จองสำเร็จ!');
                return redirect()->back();
            } else {

                Alert::error('Error', 'เกิดข้อผิดพลาด กรุณาตรวจสอบข้อมูล');
                return redirect()->back();
            }
        } else {
            Alert::error('ไม่สามารถจองได้', 'เนื่องจาก ช่วงเวลาที่คุณเลือก เจ้าหน้าที่โครงการรับคิวเต็มแล้ว', 2000);
            return redirect()->back();
        }
    }

    //ลบข้อมูลการจอง
    public function destroyBooking(Request $request, $id)
    {

        $booking = Booking::find($id);

        $bookingdetail = Bookingdetail::where('booking_id', $id);

        if (!$booking || !$bookingdetail) {
            return response()->json([
                'message' => 'เกิดข้อผิดพลาด'
            ], 404);
        } else {

            Log::addLog(Session::get('loginId')['user_id'], 'Delete', $booking->booking_title . ", " . $id);

            $booking->delete();
            $bookingdetail->delete();

            $token_line1 = config('line-notify.access_token_project');
            $line = new Line($token_line1);
            $line->send(
                'หมายเลขการจอง : *' . $id . "* \n" .
                    'ถูกลบเรียบร้อยแล้ว❗️' . " \n"
            );


            $token_line2 = config('line-notify.access_token_sale');
            $line = new Line($token_line2);
            $line->send(
                'หมายเลขการจอง : *' . $id . "* \n" .
                    'ถูกลบเรียบร้อยแล้ว❗️' . " \n"
            );

            return response()->json([
                'message' => 'ลบข้อมูลสำเร็จ!'
            ], 201);
        }
    }

    //update status ต่าง ๆ
    public function updateStatus(Request $request)
    {
        $bookings = Booking::where('bookings.id', $request->booking_id)->first();

        // $booking = Booking::with('booking_user_ref:id,code,name_th')
        //     ->with('booking_emp_ref:id,code,name_th,phone')
        //     ->with('booking_project_ref:id,name')->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
        //     ->select('bookings.*', 'bookingdetails.*', 'bookings.id as bkid')->where('bookings.id', $request->booking_id)->first();
            $booking = Booking::with('booking_project_ref:id,name')->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
            ->select('bookings.*', 'bookingdetails.*', 'bookings.id as bkid')->where('bookings.id', $request->booking_id)->get();
            $this->addApiDataToUsers($booking);

        $projects = Project::where('id', $booking[0]->project_id)->first();
        //$projects = DB::connection('mysql_project')->table('projects')->where('id', $booking->project_id)->first();
        //dd($request);

        if (!$booking[0]) {
            Alert::error('Error', 'Not found ID');
            return redirect()->back();
        } else {


            $bookings->booking_status = $request->booking_status;
            $bookings->because_cancel_remark = $request->because_cancel_remark;
            $bookings->because_cancel_other = $request->because_cancel_other;
            $bookings->save();



            if ($request->because_cancel_remark == "อื่นๆ") {
                $becaseText = "อื่นๆ เพราะ=>" . $request->because_cancel_other;
            } else {
                $becaseText = $request->because_cancel_remark;
            }

            if ($request->booking_status == 0) {
                $textStatus = "รอรับงาน";
            } elseif ($request->booking_status == 1) {
                $textStatus = "รับงานแล้ว";

                //$oneDayBeforeBookingDate = date('Y-m-d', strtotime($booking->booking_start . ' -1 day'));
                // $oneDayBeforeBookingDateTHg = date('d/m/Y', strtotime($oneDayBeforeBookingDate.' +543 year'));

                $oneDayBeforeBookingDate = Carbon::parse($booking[0]->booking_start)->subDay();
                $oneDayBeforeBookingDateTH = $oneDayBeforeBookingDate->addYears(543)->format('d/m/Y');

                //dd($oneDayBeforeBookingDateTH);


                $Strdate_start = date('d/m/Y', strtotime($booking[0]->booking_start . ' +543 year'));
                $Strtime_start = date('H:i', strtotime($booking[0]->booking_start));
                $Strtime_end = date('H:i', strtotime($booking[0]->booking_end));

                $token_line1 = config('line-notify.access_token_project');
                $line = new Line($token_line1);
                $line->send(
                    '🔔 *นัด ' . $booking[0]->booking_title . "* \n" .
                        '----------------------------' . " \n" .
                        'หมายเลขการจอง : *' . $booking[0]->bkid . "* \n" .
                        'โครงการ : *' . $projects->name . "* \n" .
                        'วัน/เวลา : `' . $Strdate_start . ' ' . $Strtime_start . '-' . $Strtime_end . "` \n" .
                        '----------------------------' . " \n" .
                        'ชื่อ Sale : *' . $booking[0]->apiDataSale['name_th'] . "* \n" .
                        'จน. โครงการ : *' . $booking[0]->apiDataPro['name_th'] . "* \n" .
                        'สถานะจอง :✅ *' . $textStatus . "* \n" .
                        '⏰ โปรดรอ Sale คอนเฟริ์มการนัดหมาย หาก Sale ไม่ *คอนเฟิร์ม*' . " \n" . 'ระบบจะยกเลิกการจองอัตโนมัติ❗️'
                );

                $token_line2 = config('line-notify.access_token_sale');
                $line = new Line($token_line2);
                $line->send(
                    '🔔 *นัด ' . $booking[0]->booking_title . "* \n" .
                        '----------------------------' . " \n" .
                        'หมายเลขการจอง : *' . $booking[0]->bkid . "* \n" .
                        'โครงการ : *' . $projects->name . "* \n" .
                        'วัน/เวลา : `' . $Strdate_start . ' ' . $Strtime_start . '-' . $Strtime_end . "` \n" .
                        '----------------------------' . " \n" .
                        'จน. โครงการ : *' . $booking[0]->apiDataSale['name_th']. "* \n" .
                        'ชื่อ Sale : *' . $booking[0]->apiDataPro['name_th']. "* \n" .
                        'สถานะจอง :✅ *' . $textStatus . "* \n" .
                        '⚠️ ผู้รับผิดชอบ กรุณากดคอนเฟริ์มนัด ในวันที่ `' . $oneDayBeforeBookingDateTH . '` ภายในเวลา 16.00-17.30 น.' . " \n" .
                        '🚫 หากไม่ *คอนเฟิร์ม* ระบบจะยกเลิกการจองอัตโนมัติ'
                        // ." \n กดคอนเฟริ์ม => ".'https://bit.ly/3AUARP0');
                        . " \n กดคอนเฟริ์ม => " . route('main')
                );

                Log::addLog(Session::get('loginId')['user_id'], 'Update Status', $booking[0]->booking_title . ", " . $booking[0]->bkid . ", " . $textStatus);

                Alert::success('Success', 'อัปเดตสถานะการจองสำเร็จแล้ว!');
                return redirect()->back();
            } elseif ($request->booking_status == 2) {
                $textStatus = "จองสำเร็จ";

                $Strdate_start = date('d/m/Y', strtotime($booking[0]->booking_start . ' +543 year'));
                $Strtime_start = date('H:i', strtotime($booking[0]->booking_start));
                $Strtime_end = date('H:i', strtotime($booking[0]->booking_end));

                $token_line1 = config('line-notify.access_token_project');
                $line = new Line($token_line1);
                $line->send(
                    '🔔 *นัด ' . $booking[0]->booking_title . "* \n" .
                        '----------------------------' . " \n" .
                        'หมายเลขการจอง : *' . $booking[0]->bkid . "* \n" .
                        'โครงการ : *' . $projects->name . "* \n" .
                        'วัน/เวลา : `' . $Strdate_start . ' ' . $Strtime_start . '-' . $Strtime_end . "` \n" .
                        '----------------------------' . " \n" .
                        'ชื่อ Sale : *' . $booking[0]->apiDataSale['name_th']. "* \n" .
                        'จน. โครงการ : *' . $booking[0]->apiDataPro['name_th'] . "* \n" .
                        'สถานะจอง :✅ *' . $textStatus . "* \n"
                );

                $token_line2 = config('line-notify.access_token_sale');
                $line = new Line($token_line2);
                $line->send(
                    '🔔 *นัด ' . $booking[0]->booking_title . "* \n" .
                        '----------------------------' . " \n" .
                        'หมายเลขการจอง : *' . $booking[0]->bkid . "* \n" .
                        'โครงการ : *' . $projects->name . "* \n" .
                        'วัน/เวลา : `' . $Strdate_start . ' ' . $Strtime_start . '-' . $Strtime_end . "` \n" .
                        '----------------------------' . " \n" .
                        'ชื่อ Sale : *' . $booking[0]->apiDataSale['name_th'] . "* \n" .
                        'จน. โครงการ : *' . $booking[0]->apiDataPro['name_th'] . "* \n" .
                        'สถานะจอง :✅ *' . $textStatus . "* \n"
                );

                Log::addLog(Session::get('loginId')['user_id'], 'Update Status', $booking[0]->booking_title . ", " . $booking[0]->bkid . ", " . $textStatus);

                Alert::success('Success', 'อัปเดตสถานะการจองสำเร็จแล้ว!');
                return redirect()->back();
            } elseif ($request->booking_status == 3) {
                $textStatus = "เยี่ยมชมเรียบร้อย";
                $Strdate_start = date('d/m/Y', strtotime($booking[0]->booking_start . ' +543 year'));
                $Strtime_start = date('H:i', strtotime($booking[0]->booking_start));
                $Strtime_end = date('H:i', strtotime($booking[0]->booking_end));

                $token_line1 = config('line-notify.access_token_project');
                $line = new Line($token_line1);
                $line->send(
                    '✨ *นัด ' . $booking[0]->booking_title . "* \n" .
                        '----------------------------' . " \n" .
                        'หมายเลขการจอง : *' . $booking[0]->bkid . "* \n" .
                        'โครงการ : *' . $projects->name . "* \n" .
                        'วัน/เวลา : `' . $Strdate_start . ' ' . $Strtime_start . '-' . $Strtime_end . "` \n" .
                        '----------------------------' . " \n" .
                        'ชื่อ Sale : *' . $booking[0]->apiDataSale['name_th'] . "* \n" .
                        'จน. โครงการ : *' . $booking[0]->apiDataPro['name_th'] . "* \n" .
                        'สถานะ :✅ *' . $textStatus . "* \n"
                );

                $token_line2 = config('line-notify.access_token_sale');
                $line = new Line($token_line2);
                $line->send(
                    '✨ *นัด ' . $booking[0]->booking_title . "* \n" .
                        '----------------------------' . " \n" .
                        'หมายเลขการจอง : *' . $booking[0]->bkid . "* \n" .
                        'โครงการ : *' . $projects->name . "* \n" .
                        'วัน/เวลา : `' . $Strdate_start . ' ' . $Strtime_start . '-' . $Strtime_end . "` \n" .
                        '----------------------------' . " \n" .
                        'ชื่อ Sale : *' . $booking[0]->apiDataSale['name_th']  . "* \n" .
                        'จน. โครงการ : *' . $booking[0]->apiDataPro['name_th'] . "* \n" .
                        'สถานะ :✅ *' . $textStatus . "* \n"
                );
                Log::addLog(Session::get('loginId')['user_id'], 'Update Status', $booking[0]->booking_title . ", " . $booking[0]->bkid . ", " . $textStatus);
                Alert::success('Success', 'อัปเดตสถานะการจองสำเร็จแล้ว!');
                return redirect()->back();
            } elseif ($request->booking_status == 4) {

                $textStatus = "ยกเลิก";
                $Strdate_start = date('d/m/Y', strtotime($booking[0]->booking_start . ' +543 year'));
                $Strtime_start = date('H:i', strtotime($booking[0]->booking_start));
                $Strtime_end = date('H:i', strtotime($booking[0]->booking_end));

                $token_line1 = config('line-notify.access_token_project');
                $line = new Line($token_line1);
                $line->send(
                    '🔔 *นัด ' . $booking[0]->booking_title . "* \n" .
                        '----------------------------' . " \n" .
                        'หมายเลขการจอง : *' . $booking[0]->bkid . "* \n" .
                        'โครงการ : *' . $projects->name . "* \n" .
                        'วัน/เวลา : `' . $Strdate_start . ' ' . $Strtime_start . '-' . $Strtime_end . "` \n" .
                        '----------------------------' . " \n" .
                        'ชื่อ Sale : *' . $booking[0]->apiDataSale['name_th']  . "* \n" .
                        'จน. โครงการ : *' . $booking[0]->apiDataPro['name_th'] . "* \n" .
                        'สถานะจอง :❌ *' . $textStatus . "* \n" .
                        'เหตุผล : ' . $becaseText
                );

                $token_line2 = config('line-notify.access_token_sale');
                $line = new Line($token_line2);
                $line->send(
                    '🔔 *นัด ' . $booking[0]->booking_title . "* \n" .
                        '----------------------------' . " \n" .
                        'หมายเลขการจอง : *' . $booking[0]->bkid . "* \n" .
                        'โครงการ : *' . $projects->name . "* \n" .
                        'วัน/เวลา : `' . $Strdate_start . ' ' . $Strtime_start . '-' . $Strtime_end . "` \n" .
                        '----------------------------' . " \n" .
                        'ชื่อ Sale : *' . $booking[0]->apiDataSale['name_th']  . "* \n" .
                        'จน. โครงการ : *' . $booking[0]->apiDataPro['name_th'] . "* \n" .
                        'สถานะจอง :❌ *' . $textStatus . "* \n" .
                        'เหตุผล : ' . $becaseText
                );
                Log::addLog(Session::get('loginId')['user_id'], 'Update Status', $booking[0]->booking_title . ", " . $booking[0]->bkid . ", " . $textStatus . ", " . $becaseText);
                Alert::success('Success', 'อัปเดตสถานะการจองสำเร็จแล้ว!');
                return redirect()->back();
            } else {
                $textStatus = "ยกเลิกอัตโนมัติ";
                $Strdate_start = date('d/m/Y', strtotime($booking[0]->booking_start . ' +543 year'));
                $Strtime_start = date('H:i', strtotime($booking[0]->booking_start));
                $Strtime_end = date('H:i', strtotime($booking[0]->booking_end));

                $token_line1 = config('line-notify.access_token_project');
                $line = new Line($token_line1);
                $line->send(
                    '🔔 *นัด ' . $booking[0]->booking_title . "* \n" .
                        '----------------------------' . " \n" .
                        'หมายเลขการจอง : *' . $booking[0]->bkid . "* \n" .
                        'โครงการ : *' . $projects->name . "* \n" .
                        'วัน/เวลา : `' . $Strdate_start . ' ' . $Strtime_start . '-' . $Strtime_end . "` \n" .
                        '----------------------------' . " \n" .
                        'ชื่อ Sale : *' . $booking[0]->apiDataSale['name_th']  . "* \n" .
                        'จน. โครงการ : *' . $booking[0]->apiDataPro['name_th'] . "* \n" .
                        'สถานะจอง :❌ *' . $textStatus . "* \n"
                );

                $token_line2 = config('line-notify.access_token_sale');
                $line = new Line($token_line2);
                $line->send(
                    '🔔 *นัด ' . $booking[0]->booking_title . "* \n" .
                        '----------------------------' . " \n" .
                        'หมายเลขการจอง : *' . $booking[0]->bkid . "* \n" .
                        'โครงการ : *' . $projects->name . "* \n" .
                        'วัน/เวลา : `' . $Strdate_start . ' ' . $Strtime_start . '-' . $Strtime_end . "` \n" .
                        '----------------------------' . " \n" .
                        'จน. โครงการ : *' . $booking[0]->apiDataPro['name_th'] . "* \n" .
                        'สถานะจอง :❌ *' . $textStatus . "* \n"
                );

                Log::addLog('System', 'Update Status', $booking[0]->booking_title . ", " . $booking[0]->bkid . ", " . $textStatus);
                // Alert::success('Success', 'อัปเดตสถานะการจองสำเร็จแล้ว!');
                // return redirect()->back();
            }
        }
    }

    //update พนักงานหน้าโครงการ
    public function updateUser(Request $request)
    {
        $booking = Booking::where('bookings.id', $request->booking_id)->first();
        $booking->teampro_id = $request->teampro_id;
        $booking->save();

        // $bookings = Booking::with('booking_user_ref:id,code,name_th')
        //     ->with('booking_emp_ref:id,code,name_th,phone')
        //     ->with('booking_project_ref:id,name')
        //     ->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
        //     ->leftJoin('teams', 'teams.id', '=', 'bookings.team_id')
        //     ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
        //     ->select('bookings.*', 'bookingdetails.*', 'teams.id', 'teams.team_name', 'subteams.subteam_name')
        //     ->where('bookings.id', "=", $request->booking_id)->first();
            $bookings = Booking::with('booking_project_ref:id,name')
            ->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
            ->leftJoin('teams', 'teams.id', '=', 'bookings.team_id')
            ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
            ->select('bookings.*', 'bookingdetails.*', 'teams.id', 'teams.team_name', 'subteams.subteam_name')
            ->where('bookings.id', "=", $request->booking_id)->get();

            $this->addApiDataToUser($bookings);

        $projects = Project::where('id', $bookings->project_id)->first();
        //$projects = DB::connection('mysql_project')->table('projects')->where('id', $bookings->project_id)->first();



        //dd($request);

        if (!$booking) {
            Alert::error('Error', 'Not found ID');
            return redirect()->back();
        } else {

            $Strdate_start = date('d/m/Y', strtotime($bookings->booking_start . ' +543 year'));
            $Strtime_start = date('H:i', strtotime($bookings->booking_start));
            $Strtime_end = date('H:i', strtotime($bookings->booking_end));

            $token_line1 = config('line-notify.access_token_project');
            $line = new Line($token_line1);
            $line->send(
                '*อัพเดท❗️ เจ้าหน้าที่โครงการใหม่' . "* \n" .
                    '📌 *หัวข้อ: นัด' . $bookings->booking_title . "* \n" .
                    '----------------------------' . " \n" .
                    'หมายเลขการจอง : *' . $request->booking_id . "* \n" .
                    'โครงการ : *' . $projects->name . "* \n" .
                    'วัน/เวลา : `' . $Strdate_start . ' ' . $Strtime_start . '-' . $Strtime_end . "` \n" .
                    // 'ลูกค้าชื่อ : *'.$bookings->customer_name."* \n".
                    // 'เบอร์ติดต่อ : *'.$bookings->customer_tel."* \n".
                    'ข้อมูลเข้าชม : *' . $bookings->customer_req . ' ' . $bookings->room_price . ' ห้อง' . $bookings->room_no . "* \n" .
                    '----------------------------' . " \n" .
                    'ชื่อ Sale : *' . $bookings->apiDataSale['name_th'] . "* \n" .
                    'ทีม/สายงาน : *' . $bookings->team_name . "* - $bookings->subteam_name \n" .
                    'เบอร์สายงาน : *' . $bookings->user_tel . "* \n" .
                    'จน. โครงการ : * [' . $bookings->apiDataPro['name_th'] . "] * \n\n" .
                    '⚠️ กรุณากดรับจองภายใน 1 ชม. ' . " \n" . 'หากไม่รับจองภายในเวลาที่กำหนด' . " \n" . 'ระบบจะยกเลิกการจองอัตโนมัติ❗️'
                    . " \n ✅กดรับจอง => " . route('main')
            );


            $token_line2 = config('line-notify.access_token_sale');
            $line = new Line($token_line2);
            $line->send(
                ' *อัพเดท❗️เจ้าหน้าที่โครงการใหม่' . "* \n" .
                    '📌 *หัวข้อ: นัด' . $bookings->booking_title . "* \n" .
                    '----------------------------' . " \n" .
                    'หมายเลขการจอง : *' . $request->booking_id . "* \n" .
                    'โครงการ : *' . $projects->name . "* \n" .
                    'วัน/เวลา : `' . $Strdate_start . ' ' . $Strtime_start . '-' . $Strtime_end . "` \n" .
                    // 'ลูกค้าชื่อ : *'.$bookings->customer_name."* \n".
                    // 'เบอร์ติดต่อ : *'.$bookings->customer_tel."* \n".
                    'ข้อมูลเข้าชม : *' . $bookings->customer_req . ' ' . $bookings->room_price . ' ห้อง' . $bookings->room_no . "* \n" .
                    '----------------------------' . " \n" .
                    'ชื่อ Sale : *' . $bookings->apiDataSale['name_th'] . "* \n" .
                    'ทีม/สายงาน : *' . $bookings->team_name . "* - $bookings->subteam_name \n" .
                    'เบอร์สายงาน : *' . $bookings->user_tel . "* \n" .
                    'จน. โครงการ : * [' . $bookings->apiDataPro['name_th'] . "] * \n\n" .
                    '⏰ โปรดรอ *เจ้าหน้าที่โครงการ' . "* \n" . ' กดรับงานภายใน 1 ชม.'
            );

            Log::addLog(Session::get('loginId')['user_id'], 'Update Employee Project', $bookings->booking_title . ", " . $request->booking_id . ", " . $bookings->booking_emp_ref[0]->name_th);

            Alert::success('Success', 'อัปเดตข้อมูลสำเร็จแล้ว!');
            return redirect()->back();
        }
    }

    //update ข้อมูลการนัดเยี่ยมโครงการ
    public function updateBookingProject(Request $request)
    {

        //dd($request);

        //$dataUserLogin = User::where('user_id', Session::get('loginId')['user_id'])->first();
        $dataUserLogin = Session::get('loginId');
        // $dataUserLogin = DB::connection('mysql_user')->table('users')
        // ->where('id', '=', Session::get('loginId'))
        // ->first();
        $dataRoleUser = Role_user::where('user_id', "=", Session::get('loginId')['user_id'])->first();

        $booking = Booking::where('bookings.id', "=", $request->booking_id)->first();

        // $bookings = Booking::with('booking_user_ref:id,code,name_th')
        //     ->with('booking_emp_ref:id,code,name_th,phone')
        //     ->with('booking_project_ref:id,name')
        //     ->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
        //     ->leftJoin('teams', 'teams.id', '=', 'bookings.team_id')
        //     ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
        //     ->select('bookings.*', 'bookingdetails.*', 'teams.id', 'teams.team_name', 'subteams.subteam_name')
        //     ->where('bookings.id', "=", $request->booking_id)->first();
            $bookings = Booking::with('booking_project_ref:id,name')
            ->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
            ->leftJoin('teams', 'teams.id', '=', 'bookings.team_id')
            ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
            ->select('bookings.*', 'bookingdetails.*', 'teams.id', 'teams.team_name', 'subteams.subteam_name')
            ->where('bookings.id', "=", $request->booking_id)->get();
            $this->addApiDataToUsers($bookings);


        //dd($booking);

        $end_time = date('H:i', strtotime($request->time . ' +3 hours'));
        $booking_start = $request->date . " " . $request->time;
        $booking_end = $request->date . " " . $end_time;


        $booking->booking_start = $booking_start;
        $booking->booking_end = $booking_end;
        $booking->booking_status = "0"; //สถานะ เยี่ยมโครงการ
        $booking->project_id = $request->project_id;
        $booking->booking_status_df = "0"; //สถานะ DF

        $booking->team_id = $request->team_id;
        $booking->subteam_id = $request->subteam_id;
        $booking->user_id = $request->user_id; //ชื่อผู้จอง|ผู้ทำรายการจอง
        $booking->user_tel = $request->user_tel;
        $booking->remark = $request->remark;

        $res1 = $booking->save();

        //dd($booking->project_id);
        //$id_booking = Booking::latest()->first();
        $projects = Project::where('id', $request->project_id)->first();
        //$projects = DB::connection('mysql_project')->table('projects')->where('id', $request->project_id)->first();




        //insert detail customer
        $bookingdetail = Bookingdetail::where('booking_id', '=', $request->booking_id)->first();
        //$bookingdetail->booking_id = $request->booking_id; //ref booking_id
        $bookingdetail->customer_name = $request->customer_name;
        $bookingdetail->customer_tel = $request->customer_tel;

        if ($request->checkbox_room != null) {
            $bookingdetail->customer_req = implode(',', $request->checkbox_room);
            $customer_req = implode(',', $request->checkbox_room);
        } else {
            $bookingdetail->customer_req = "";
            $customer_req = "-";
        }

        if ($request->checkbox_bank != null) {
            $bookingdetail->customer_req_bank = implode(',', $request->checkbox_bank);
        } else {
            $bookingdetail->customer_req_bank = "";
        }

        if ($request->checkbox_doc != null) {
            $bookingdetail->customer_doc_personal = implode(',', $request->checkbox_doc);
        } else {
            $bookingdetail->customer_doc_personal = "";
        }
        $bookingdetail->customer_req_bank_other = $request->customer_req_bank_other;
        $bookingdetail->num_home = $request->num_home;
        $bookingdetail->num_idcard = $request->num_idcard;
        $bookingdetail->num_app_statement = $request->num_app_statement;
        $bookingdetail->num_statement = $request->num_statement;
        $bookingdetail->room_no = $request->room_no;
        $bookingdetail->room_price = ($request->room_price) ? str_replace(',', '', $request->room_price) : NULL;

        $res2 = $bookingdetail->save();

        $Strdate_start = date('d/m/Y', strtotime($request->date . ' +543 year'));
       // $getSaleName = Role_user::with('user_ref:id,code,name_th as name_sale')->where('user_id', $request->user_id)->first();
       $dataSales = Role_user::where('role_type', 'Sale')->where('user_id', $request->user_id)->first();
       $this->addApiDataToSales($dataSales);
       //dd($request->user_id);
       $dataEmps = Role_user::where('role_type', 'Staff')->where('user_id', $booking->teampro_id)->first();
       $this->addApiDataToEmps($dataEmps);

       $team_name =$bookings[0]->team_name;
       $subteam_name =$bookings[0]->subteam_name;

        if ($res1 || $res2) {

            // Alert::success('จองสำเร็จ!', '');
            $token_line1 = config('line-notify.access_token_project');
            $line = new Line($token_line1);
            $line->send(
                '❗️ *ขออภัย อัพเดทข้อมูลการจองใหม่' . "* \n" .
                    '📌 *นัด ' . $request->booking_title . "* \n" .
                    '----------------------------' . " \n" .
                    'หมายเลขการจอง : *' . $request->booking_id . "* \n" .
                    'โครงการ : *' . $projects->name . "* \n" .
                    'วัน/เวลา : `' . $Strdate_start . ' ' . $request->time . '-' . $end_time . "` \n" .
                    'ลูกค้าชื่อ : *' . $request->customer_name . "* \n" .
                    'เบอร์ติดต่อ : *' . $request->customer_tel . "* \n" .
                    'ข้อมูลเข้าชม : *' . $customer_req . "* $request->room_price \n" .
                    '----------------------------' . " \n" .
                    'ชื่อ Sale : *' . $dataSales->apiData['name_th'] . "* \n" .
                    'ทีม/สายงาน : *' . $team_name . "* -  $subteam_name \n" .
                    'เบอร์สายงาน : *' . $request->user_tel . "* \n" .
                    'เจ้าหน้าที่โครงการ : *' . $dataEmps->apiData['name_th'] . "* \n\n" .
                    '⚠️ กรุณากดรับจองภายใน 1 ชม. ' . " \n" . 'หากไม่รับจองภายในเวลาที่กำหนด' . " \n" . 'ระบบจะยกเลิกการจองอัตโนมัติ❗️'
                    . " \n กดรับจอง => " . route('main')
            );

            $token_line2 = config('line-notify.access_token_sale');
            $line = new Line($token_line2);
            $line->send(
                '❗️ *คุณได้อัพเดทข้อมูลการจองใหม่' . "* \n" .
                    '📌 *นัด ' . $request->booking_title . "* \n" .
                    '------------------------------' . " \n" .
                    'หมายเลขการจอง : *' . $request->booking_id . "* \n" .
                    'โครงการ : *' . $projects->name . "* \n" .
                    'วัน/เวลา : `' . $Strdate_start . ' ' . $request->time . '-' . $end_time . "` \n" .
                    'ลูกค้าชื่อ : *' . $request->customer_name . "* \n" .
                    'ข้อมูลเข้าชม : *' . $customer_req . "* $request->room_price \n" .
                    '-----------------------------' . " \n" .
                    'ชื่อ Sale : *' . $dataSales->apiData['name_th'] . "* \n" .
                    'ทีม/สายงาน : *' . $team_name . "* -  $subteam_name \n" .
                    'เบอร์สายงาน : *' . $request->user_tel . "* \n" .
                    'เจ้าหน้าที่โครงการ : *' . $dataEmps->apiData['name_th'] . "* \n\n" .
                    '⏰ โปรดรอ *เจ้าหน้าที่โครงการ' . "* \n" . ' กดรับงานภายใน 1 ชม.'
            );

            Log::addLog(Session::get('loginId')['user_id'], 'Update Booking', $request->booking_title . ", " . $request->booking_id);
            // return response()->json([
            //     'message' => 'เพิ่มข้อมูลสำเร็จ'
            // ], 201);

            // return back();
            if (in_array($dataRoleUser->role_type, ["Sale", "Staff"])) {
                Alert::success('Success', 'แก้ไขสำเร็จ!');
                return redirect('/');
            } else {
                Alert::success('Success', 'แก้ไขสำเร็จ!');
                return redirect('/booking/list');
            }
        } else {

            Alert::error('Error', 'เกิดข้อผิดพลาด กรุณาตรวจสอบข้อมูล');
            // return response()->json([
            //     'message' => 'เกิดข้อผิดพลาด'
            // ], 404);
            return redirect()->back();
        }

        // if ($res1 && $res2) {
        //     Alert::success('แก้ไขข้อมูลการจองสำเร็จ!', '');
        //     $token_line = config('line-notify.access_token_project');
        //     $line = new Line($token_line);
        //     $line->send('*ขออภัย อัพเดทข้อมูลการจองใหม่!* '." \n".
        //     'หมายเลขการจอง : *'.$request->booking_id."* \n".
        //     'นัด *'.$request->booking_title."* \n".
        //     'โครงการ : *'.$projects->name."* \n".
        //     'วัน/เวลา : `'.$Strdate_start.' '.$request->time.'-'.$end_time."` \n".
        //     'ลูกค้าชื่อ : *'.$request->customer_name."* \n".
        //     '-------------------'." \n".
        //     'เจ้าหน้าที่โครงการ : *'.$bookings->booking_emp_ref[0]->name_th."* \n".
        //     'กรุณากดรับจองภายใน 1 ชม. '." \n".'หากไม่รับจองภายในเวลาที่กำหนด ระบบจะยกเลิกการจองอัตโนมัติ!');

        //     $token_line2 = config('line-notify.access_token_sale');
        //     $line = new Line($token_line2);
        //     $line->send('*ขออภัย อัพเดทข้อมูลการจองใหม่!* '." \n".
        //     'หมายเลขการจอง : *'.$request->booking_id."* \n".
        //     'นัด *'.$request->booking_title."* \n".
        //     'โครงการ : *'.$projects->name."* \n".
        //     'วัน/เวลา : `'.$Strdate_start.' '.$request->time.'-'.$end_time."` \n".
        //     'ลูกค้าชื่อ : *'.$request->customer_name."* \n".
        //     '-------------------'." \n".
        //     'เจ้าหน้าที่โครงการ : *'.$bookings->booking_emp_ref[0]->name_th."* \n".
        //     'โปรดรอเจ้าหน้าที่โครงการ กดรับงานภายใน 1 ชั่วโมง');

        //     if (in_array($dataRoleUser->role_type, ["Sale", "Staff"])){
        //         Alert::success('แก้ไขสำเร็จ');
        //         return redirect('/');
        //     }else{
        //         Alert::success('แก้ไขสำเร็จ');
        //         return redirect('/booking/list');
        //     }

        // }else{
        //     Alert::error('Error', '');
        //     return back();
        // }

        //dd($request);


    }


    public function printBooking(Request $request, $id)
    {
        // $bookings = Booking::with('booking_user_ref:id,code,name_th')
        //     ->with('booking_emp_ref:id,code,name_th,phone')
        //     ->with('booking_project_ref:id,name')
        //     ->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
        //     ->leftJoin('teams', 'teams.id', '=', 'bookings.team_id')
        //     ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
        //     ->select('bookings.*', 'bookingdetails.*', 'bookings.id as bkid', 'teams.id', 'teams.team_name', 'subteams.subteam_name')
        //     ->where('bookings.id', "=", $id)->first();

            $bookings = Booking::with('booking_project_ref:id,name')
            ->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
            ->leftJoin('teams', 'teams.id', '=', 'bookings.team_id')
            ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
            ->select('bookings.*', 'bookingdetails.*', 'bookings.id as bkid', 'teams.id', 'teams.team_name', 'subteams.subteam_name')
            ->where('bookings.id', "=", $id)->get();
            // dd($bookings);
            $this->addApiDataToUser($bookings);
            //dd($bookings);

        Log::addLog(Session::get('loginId')['user_id'], 'Print Booking', $bookings[0]->booking_title . ", " . $bookings[0]->booking_id);

        return view("booking.print", compact('bookings'));
    }

    public function showJob($id)
    {

        $bookings = Booking::where('id', '=', $id)->first();
        //dd($bookings);
        return response()->json($bookings, 200);
    }



    public function updateScore(Request $request)
    {

        $bookings = Booking::where('bookings.id', $request->booking_id)->first();
        //dd($request->rating);
        if ($bookings) {
            $bookings->job_score = $request->rating;
            $bookings->save();

            Log::addLog(Session::get('loginId')['user_id'], 'Update Score', $bookings->booking_title . ", " . $request->booking_id);

            Alert::success('Success', 'ให้คะแนนความพึ่งพอใจเรียบร้อย');
            return redirect()->back();
        } else {

            Alert::success('Error', 'เกิดข้อผิดพลาด');
            return redirect()->back();
        }
    }

    public function updateshowJob(Request $request)
    {

        //dd($request);
        $bookings = Booking::where('id', '=', $request->id)->first();

        // $booking = Booking::with('booking_user_ref:id,code,name_th')
        //     ->with('booking_emp_ref:id,code,name_th,phone')
        //     ->with('booking_project_ref:id,name')->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
        //     ->select('bookings.*', 'bookingdetails.*', 'bookings.id as bkid')->where('bookings.id', $request->id)->first();
            $booking = Booking::with('booking_project_ref:id,name')->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
            ->select('bookings.*', 'bookingdetails.*', 'bookings.id as bkid')->where('bookings.id', $request->id)->get();
           $this->addApiDataToUser($booking);

        $projects = Project::where('id', $booking[0]->project_id)->first();


        //dd($user);
        if (!$bookings) {
            return response()->json([
                'errors' => [
                    'message' => 'ไม่สามารถอัพเดทข้อมูลได้ ID ไม่ถูกต้อง..'
                ]
            ], 400);
        }
        // Get image file
        // ตรวจสอบว่ามีการอัพโหลดไฟล์รูปภาพหรือไม่
        if ($request->hasFile('job_img')) {
            // รับไฟล์รูปภาพ
            $image = $request->file('job_img');
            $image_1 = $request->file('job_img_1');
            $image_2 = $request->file('job_img_2');
            $image_3 = $request->file('job_img_3');

            // กำหนดชื่อไฟล์รูปภาพใหม่
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $imageName_1 = time() . '1' . '.' . $image_1->getClientOriginalExtension();
            $imageName_2 = time() . '2' . '.' . $image_2->getClientOriginalExtension();
            $imageName_3 = time() . '3' . '.' . $image_3->getClientOriginalExtension();

            // บันทึกไฟล์รูปภาพในโฟลเดอร์ public/images
            $image->move(public_path('images/jobs'), $imageName);
            $image_1->move(public_path('images/jobs'), $imageName_1);
            $image_2->move(public_path('images/jobs'), $imageName_2);
            $image_3->move(public_path('images/jobs'), $imageName_3);

            // อ่านขนาดของรูปภาพ
            // list($width, $height) = getimagesize(public_path('images/jobs/' . $imageName));
            // list($width, $height) = getimagesize(public_path('images/jobs/' . $imageName_1));
            // list($width, $height) = getimagesize(public_path('images/jobs/' . $imageName_2));
            // list($width, $height) = getimagesize(public_path('images/jobs/' . $imageName_3));

            // กำหนดขนาดใหม่ของรูปภาพเมื่อย่อขนาดให้เหลือ 350x450
            // $newWidth = 450;
            // $newHeight = 450;

            // สร้างรูปภาพใหม่โดยใช้ฟังก์ชัน imagecreatefromjpeg() หรือ imagecreatefrompng() ขึ้นอยู่กับประเภทของไฟล์รูปภาพ
            // $thumbnail = imagecreatetruecolor($newWidth, $newHeight);
            // $thumbnail_1 = imagecreatetruecolor($newWidth, $newHeight);
            // $thumbnail_2 = imagecreatetruecolor($newWidth, $newHeight);
            // $thumbnail_3 = imagecreatetruecolor($newWidth, $newHeight);

            // $source = imagecreatefromjpeg(public_path('images/jobs/' . $imageName));
            // $source_1 = imagecreatefromjpeg(public_path('images/jobs/' . $imageName_1));
            // $source_2 = imagecreatefromjpeg(public_path('images/jobs/' . $imageName_2));
            // $source_3 = imagecreatefromjpeg(public_path('images/jobs/' . $imageName_3));

            // ย่อขนาดรูปภาพ
            // imagecopyresized($thumbnail, $source, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            // imagecopyresized($thumbnail_1, $source_1, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            // imagecopyresized($thumbnail_2, $source_2, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
            // imagecopyresized($thumbnail_3, $source_3, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

            // บันทึกรูปภาพที่ย่อขนาดแล้วในโฟลเดอร์ public/images
            $thumbnailPath = 'images/jobs/' . $imageName;
            //($thumbnail, $thumbnailPath);

            $thumbnailPath_1 = 'images/jobs/' . $imageName_1;
            //imagejpeg($thumbnail_1, $thumbnailPath_1);

            $thumbnailPath_2 = 'images/jobs/' . $imageName_2;
            //imagejpeg($thumbnail_2, $thumbnailPath_2);

            $thumbnailPath_3 = 'images/jobs/' . $imageName_3;
            //imagejpeg($thumbnail_3, $thumbnailPath_3);

            // ลบไฟล์รูปภาพเดิม
            //unlink(public_path('images/jobs/' . $imageName));


            $bookings->booking_status = $request->booking_status;
            $bookings->job_detailsubmission = $request->job_detailsubmission;
            $bookings->job_img = $thumbnailPath;
            $bookings->job_img_1 = $thumbnailPath_1;
            $bookings->job_img_2 = $thumbnailPath_2;
            $bookings->job_img_3 = $thumbnailPath_3;
            $bookings->save();


            $textStatus = "เยี่ยมชมเรียบร้อย";


            $token_line1 = config('line-notify.access_token_project');
            $line = new Line($token_line1);
            $line->send(
                '✨ *นัด ' . $booking[0]->booking_title . "* \n" .
                    '----------------------------' . " \n" .
                    'หมายเลขการจอง : *' . $booking[0]->bkid . "* \n" .
                    'โครงการ : *' . $projects->name . "* \n" .
                    'ชื่อ Sale : *' . $booking[0]->apiDataSale['name_th'] . "* \n" .
                    'จน. โครงการ : *' . $booking[0]->apiDataPro['name_th']. "* \n" .
                    '----------------------------' . " \n" .
                    'สถานะ :✅ *' . $textStatus . "* \n"
            );

            $token_line2 = config('line-notify.access_token_sale');
            $line = new Line($token_line2);
            $line->send(
                '✨ *นัด ' . $booking[0]->booking_title . "* \n" .
                    '----------------------------' . " \n" .
                    'หมายเลขการจอง : *' . $booking[0]->bkid . "* \n" .
                    'โครงการ : *' . $projects->name . "* \n" .
                    'ชื่อ Sale : *' . $booking[0]->apiDataSale['name_th']. "* \n" .
                    'จน. โครงการ : *' . $booking[0]->apiDataPro['name_th']. "* \n" .
                    '----------------------------' . " \n" .
                    'สถานะ :✅ *' . $textStatus . "* \n"
            );


            Log::addLog(Session::get('loginId')['user_id'], 'Update Job Succress', $bookings->booking_title . ", " . $request->id);
            Alert::success('Success', 'ส่งงานสำเร็จ!');
            return redirect()->back();
        }




        // Alert::error('Error', 'ไม่พบรูปภาพที่จะอัพโหลด');
        // return redirect()->back();
    }

    public function updateeditJob(Request $request)
    {

        //dd($request);
        $bookings = Booking::where('id', '=', $request->id)->first();


        if (!$bookings) {
            return response()->json([
                'errors' => [
                    'message' => 'ไม่สามารถอัพเดทข้อมูลได้ ID ไม่ถูกต้อง..'
                ]
            ], 400);
        }


        // ตรวจสอบว่ามีการอัพโหลดไฟล์รูปภาพหรือไม่
        if ($request->hasFile('job_img')) {

            unlink(public_path($bookings->job_img)); // ลบภาพเก่า

            $image = $request->file('job_img');


            // กำหนดชื่อไฟล์รูปภาพใหม่
            $imageName = time() . '.' . $image->getClientOriginalExtension();


            // บันทึกไฟล์รูปภาพในโฟลเดอร์ public/images
            $image->move(public_path('images/jobs'), $imageName);


            // บันทึกรูปภาพที่ย่อขนาดแล้วในโฟลเดอร์ public/images
            $thumbnailPath = 'images/jobs/' . $imageName;
            //($thumbnail, $thumbnailPath);



            // ลบไฟล์รูปภาพเดิม
            //unlink(public_path('images/jobs/' . $imageName));


            $bookings->job_detailsubmission = $request->job_detailsubmission;
            $bookings->job_img = $thumbnailPath;
            $bookings->save();


            Log::addLog(Session::get('loginId')['user_id'], 'Update Job Success', $bookings->booking_title . ", " . $request->id);
            Alert::success('Success', 'ส่งงานสำเร็จ!');
            return redirect()->back();
        } elseif ($request->hasFile('job_img_1')) {
            unlink(public_path($bookings->job_img_1)); // ลบภาพเก่า

            $image = $request->file('job_img_1');


            // กำหนดชื่อไฟล์รูปภาพใหม่
            $imageName = time() . '.' . $image->getClientOriginalExtension();


            // บันทึกไฟล์รูปภาพในโฟลเดอร์ public/images
            $image->move(public_path('images/jobs'), $imageName);


            // บันทึกรูปภาพที่ย่อขนาดแล้วในโฟลเดอร์ public/images
            $thumbnailPath = 'images/jobs/' . $imageName;
            //($thumbnail, $thumbnailPath);



            // ลบไฟล์รูปภาพเดิม
            //unlink(public_path('images/jobs/' . $imageName));


            $bookings->job_detailsubmission = $request->job_detailsubmission;
            $bookings->job_img_1 = $thumbnailPath;
            $bookings->save();

            Log::addLog(Session::get('loginId')['user_id'], 'Update Job Success', $bookings->booking_title . ", " . $request->id);
            Alert::success('Success', 'ส่งงานสำเร็จ!');
            return redirect()->back();
        } elseif ($request->hasFile('job_img_2')) {
            unlink(public_path($bookings->job_img_2)); // ลบภาพเก่า

            $image = $request->file('job_img_2');


            // กำหนดชื่อไฟล์รูปภาพใหม่
            $imageName = time() . '.' . $image->getClientOriginalExtension();


            // บันทึกไฟล์รูปภาพในโฟลเดอร์ public/images
            $image->move(public_path('images/jobs'), $imageName);


            // บันทึกรูปภาพที่ย่อขนาดแล้วในโฟลเดอร์ public/images
            $thumbnailPath = 'images/jobs/' . $imageName;
            //($thumbnail, $thumbnailPath);



            // ลบไฟล์รูปภาพเดิม
            //unlink(public_path('images/jobs/' . $imageName));


            $bookings->job_detailsubmission = $request->job_detailsubmission;
            $bookings->job_img_2 = $thumbnailPath;
            $bookings->save();

            Log::addLog(Session::get('loginId')['user_id'], 'Update Job Success', $bookings->booking_title . ", " . $request->id);
            Alert::success('Success', 'ส่งงานสำเร็จ!');
            return redirect()->back();
        } elseif ($request->hasFile('job_img_3')) {
            unlink(public_path($bookings->job_img_3)); // ลบภาพเก่า

            $image = $request->file('job_img_3');


            // กำหนดชื่อไฟล์รูปภาพใหม่
            $imageName = time() . '.' . $image->getClientOriginalExtension();


            // บันทึกไฟล์รูปภาพในโฟลเดอร์ public/images
            $image->move(public_path('images/jobs'), $imageName);


            // บันทึกรูปภาพที่ย่อขนาดแล้วในโฟลเดอร์ public/images
            $thumbnailPath = 'images/jobs/' . $imageName;
            //($thumbnail, $thumbnailPath);



            // ลบไฟล์รูปภาพเดิม
            //unlink(public_path('images/jobs/' . $imageName));


            $bookings->job_detailsubmission = $request->job_detailsubmission;
            $bookings->job_img_3 = $thumbnailPath;
            $bookings->save();

            Log::addLog(Session::get('loginId')['user_id'], 'Update Job Success', $bookings->booking_title . ", " . $request->id);
            Alert::success('Success', 'ส่งงานสำเร็จ!');
            return redirect()->back();
        } else {


            $bookings->job_detailsubmission = $request->job_detailsubmission;
            $bookings->save();

            Log::addLog(Session::get('loginId')['user_id'], 'EditJ ob Success', $bookings->booking_title . ", " . $request->id);
            Alert::success('Success', 'แก้ไขสำเร็จ!');
            return redirect()->back();
        }







        // Alert::error('Error', 'ไม่พบรูปภาพที่จะอัพโหลด');
        // return redirect()->back();
    }


    public function search(Request $request)
    {

        $dataUserLogin = Session::get('loginId');
        //$dataUserLogin = User::where('user_id', '=', Session::get('loginId')['user_id'])->first();
        $dataRoleUser = Role_user::where('user_id', Session::get('loginId')['user_id'])->first();

        $projects = Project::where('active', 1)->get();

        $teams = Team::get();
        $subTeams = Subteam::get();

        //$dataEmps = Role_user::with('user_ref:id,code,name_th as name_emp')->where('role_type', 'Staff')->get();
        // dd($dataEmps);
        //$dataSales = Role_user::with('user_ref:id,code,name_th as name_sale')->where('role_type', 'Sale')->get();
        $dataEmps = Role_user::where('role_type', 'Staff')->get();
        $this->addApiDataToEmp($dataEmps);

        $dataSales = Role_user::where('role_type', 'Sale')->get();
        $this->addApiDataToSale($dataSales);

        //ดึงข้อมูลเฉพาะที่ยังเปลี่ยนสถานะยกเลิกได้
        $ItemStatusHowCancel =  Booking::whereNotIn('booking_status', ["3", "4", "5"])->get();

        if ($dataRoleUser->role_type == "SuperAdmin") {


            // $bookings = Booking::query()
            //     ->with('booking_user_ref:id,code,name_th')
            //     ->with('booking_emp_ref:id,code,name_th')
            //     ->with('booking_project_ref:id,name')
            //     ->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
            //     ->leftJoin('teams', 'teams.id', '=', 'bookings.team_id')
            //     ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
            //     ->select(
            //         'bookings.*',
            //         'bookingdetails.*',
            //         'bookings.id as bkid',
            //         'teams.id',
            //         'teams.team_name',
            //         'subteams.subteam_name'
            //     )
            //     ->orderBy('bookings.id','desc');
            $bookings = Booking::query()
            // ->with('booking_user_ref:id,code,name_th')
            // ->with('booking_emp_ref:id,code,name_th')
            ->with('booking_project_ref:id,name')
            ->leftJoin('bookingdetails', 'bookingdetails.booking_id', '=', 'bookings.id')
            ->leftJoin('teams', 'teams.id', '=', 'bookings.team_id')
            ->leftJoin('subteams', 'subteams.id', '=', 'bookings.subteam_id')
            ->select(
                'bookings.*',
                'bookingdetails.*',
                'bookings.id as bkid',
                'teams.id',
                'teams.team_name',
                'subteams.subteam_name'
            )
            ->orderBy('bkid', 'desc');

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

            $bookings = $bookings->get();
            //dd($bookings);
            $this->addApiDataToUser($bookings);

            return view("booking.search", compact(
                'dataUserLogin',
                'dataRoleUser',
                'bookings',
                'projects',
                'teams',
                'subTeams',
                'dataEmps',
                'dataSales',
                'ItemStatusHowCancel'
            ));
        }
    }
}
