<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Phattarachai\LineNotify\Line;
use App\Models\User;
use App\Models\Role_user;
use App\Models\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CustomAuthController extends Controller
{

    public function login()
    {
        return view('auth.login');
        //return redirect('https://vbis.vbeyond.co.th/main');
        //return redirect('http://127.0.0.1:8000/main');
    }

    public function regis()
    {
        return view('auth.register');
    }

    public function insertRegis(Request $request)
    {

        $request->validate([
            'code' => ['required', 'unique:users'],
            'fullname' => 'required',
            'password' => ['required', 'min:8'],
            'tel' => ['required', 'min:10'],

        ], [
            'code.required' => 'ป้อนรหัสพนักงาน',
            'code.unique' => 'รหัสนี้มีผู้ใช้แล้ว',
            'fullname.required' => 'ป้อนชื่อ-นามสกุล',
            'password.required' => 'ป้อนชื่อรหัสผ่าน',
            'password.min' => 'รหัสผ่านต้องไม่ต่ำกว่า 8 ตัวอักษร',
            'tel.required' => 'ป้อนเบอร์โทร',
            'tel.min' => 'เบอร์โทรไม่ถูกต้อง',
        ]);

        $user = new User();
        $user->code = $request->code;
        $user->fullname = $request->fullname;
        $user->password = Hash::make($request->password);
        $user->role = 'user'; //user = ผู้ใช้งานทั่วไป //admin = ผู้ดูแลระบบ //staff ผู้ใช้งานลองจาก admin
        $user->team_id = '0'; //0 = Df ไม่มี team
        $user->active = 'disable'; // enable = ใช้งาน // disable = ปิดใช้งาน
        $user->tel = $request->tel;
        $res = $user->save();

        if ($res) {
            Alert::success('ลงทะเบียนสำเร็จ', 'คุณได้ลงทะเบียนเรียบร้อย
            รอ Admin เปิดใช้งานระบบ 5 นาที');
            $token_line = config('line-notify.access_token_project');
            $line = new Line($token_line);
            $line->send('มีผู้สมัครใช้งานระบบ vBisProject');
            return redirect('/login');
        } else {
            Alert::error('Error Title', 'Error Message');
            return back();
        }
    }


    public function loginUser(Request $request)
    {

        $request->validate([
            'code' => 'required',
            'password' => 'required'
        ], [
            'code.required' => 'ป้อนรหัสพนักงาน',
            'password.required' => 'ป้อนรหัสผ่าน'
        ]);

        $code = $request->code;
        $password = $request->password;

        try {

            $url = env('API_URL') . '/getAuth/' . $code;
            $token = env('API_TOKEN_AUTH');

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->get($url);


            $url_log = env('API_URL') . '/logs/login/' . $code . ',vproject';
            //insert loglogin
            $response_log = Http::withHeaders([
                'Authorization' => 'Bearer ' . $token
            ])->get($url_log);

            if ($response_log->successful()) {
            }

            if ($response->successful()) {
                $userData = $response->json()['data'];
                // dd($userData);
                if (Hash::check($password, $userData['password'])) {
                    $request->session()->put('loginId', $userData);

                    Log::addLog($userData['user_id'], 'Login', 'By LoginPage');
                    Alert::success('เข้าสู่ระบบสำเร็จ');
                    return redirect('/');
                } else {
                    Alert::warning('รหัสผ่านไม่ถูกต้อง', 'กรุณากรอกข้อมูลใหม่อีกครั้ง');
                    return back();
                }
            } else {

                Alert::warning('ไม่พบผู้ใช้งาน', 'กรุณากรอกข้อมูลใหม่อีกครั้ง');
                return back();
            }
        } catch (\Exception $e) {

            Alert::error('Error', 'เกิดข้อผิดพลาดในการเชื่อมต่อกับ API ภายนอก' . $e->getMessage());
            return back();
        }
    }

    public function logoutUser(Request $request)
    {

        if ($request->session()->has('loginId')) {

            // dd($request->session()->get('loginId')['user_id']);

            Log::addLog($request->session()->get('loginId')['user_id'], 'Logout', '');
            $request->session()->pull('loginId');

            Alert::success('ออกจากระบบเรียบร้อย');
            return redirect('login');
        }
    }

    public function AllowLoginConnect(Request $request, $code, $token)
    {

        try {

            $url = env('API_URL') . '/token/check/out/' . $token;
            $tokenapi = env('API_TOKEN_AUTH');
            //dd($url);
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $tokenapi
            ])->get($url);

            $url_log = env('API_URL') . '/logs/login/' . $code . ',vproject';
            //insert loglogin
            $response_log = Http::withHeaders([
                'Authorization' => 'Bearer ' . $tokenapi
            ])->get($url_log);
            if ($response_log->successful()) {
            }

            if ($response->successful()) {
                $userData = $response->json()['data'];
                Log::addLog($userData['user_id'], 'Login', 'AllowLoginConnect By VBNext');
                $request->session()->put('loginId', $userData);
                Alert::success('เข้าสู่ระบบสำเร็จ');
                return redirect('/');
            } else {

                Alert::warning('ไม่พบผู้ใช้งาน', 'กรุณากรอกข้อมูลใหม่อีกครั้ง');
                return back();
            }
        } catch (\Exception $e) {

            Alert::error('Error', 'เกิดข้อผิดพลาดในการเชื่อมต่อกับ API ภายนอก');
            return back();
        }
    }
}
