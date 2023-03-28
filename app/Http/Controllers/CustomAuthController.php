<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Phattarachai\LineNotify\Line;
use App\Models\User;
use App\Models\Role_user;
use Illuminate\Support\Facades\DB;

class CustomAuthController extends Controller
{

   public function login(){
        return view('auth.login');
   }

   public function regis(){
        return view('auth.register');
   }

   public function insertRegis(Request $request){

        $request->validate([
            'code' => ['required','unique:users'],
            'fullname'=> 'required',
            'password'=> ['required', 'min:8'],
            'tel'=> ['required', 'min:10'],

        ],[
            'code.required' => 'ป้อนรหัสพนักงาน',
            'code.unique' => 'รหัสนี้มีผู้ใช้แล้ว',
            'fullname.required' => 'ป้อนชื่อ-นามสกุล',
            'password.required' => 'ป้อนชื่อรหัสผ่าน',
            'password.min' => 'รหัสผ่านต้องไม่ต่ำกว่า 8 ตัวอักษร',
            'tel.required'=> 'ป้อนเบอร์โทร',
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
        }else{
            Alert::error('Error Title', 'Error Message');
            return back();
        }






   }

   public function loginUser(Request $request){

        $request->validate([
            'code'=>'required',
            'password'=>'required'
        ],[
            'code.required'=>'ป้อนรหัสพนักงาน',
            'password.required'=>'ป้อนรหัสผ่าน'
        ]);


        $user_hr = DB::connection('mysql_user')->table('users')
        ->where('code', '=', $request->code)
        ->orWhere('old_code', '=', $request->code)->first();

        //dd($user_hr);
        if($user_hr->active_vproject!=0){
            if($user_hr->active !=0 or $user_hr->resign_date==null){

                $role_user = Role_user::where('user_id',"=",$user_hr->id)->first();

                if(!$role_user){
                    Alert::warning('คุณไม่มีสิทธิ์เข้าระบบ', 'กรุณาติดต่อ Admin!!');
                    return back();

                }else{

                    if(Hash::check($request->password, $user_hr->password)){

                        $request->session()->put('loginId',$user_hr->id);

                        DB::table('vbeyond_report.log_login')->insert([
                            'username' => $user_hr->code,
                            'dates' => date('Y-m-d'),
                            'timeStm' => date('Y-m-d H:i:s'),
                            'page' => 'vProject'
                        ]);

                        Alert::success('เข้าสู่ระบบสำเร็จ');
                        return redirect('/');


                        }else{

                            Alert::warning('รหัสผ่านไม่ถูกต้อง', 'กรุณากรอกข้อมูลใหม่อีกครั้ง');
                            return back();

                        }


                        Alert::warning('รหัสผ่านไม่ถูกต้อง', 'กรุณากรอกข้อมูลใหม่อีกครั้ง');
                        return back();
                }

            }else{
                Alert::error('ไม่พบผู้ใช้งาน', 'กรุณากรอกข้อมูลใหม่อีกครั้ง');
                return back();
            }
        }else{
            Alert::error('ไม่พบผู้ใช้งาน', 'กรุณากรอกข้อมูลใหม่อีกครั้ง');
            return back();
        }

   }

   public function logoutUser(Request $request){

    if($request->session()->has('loginId')){
        Alert::success('ออกจากระบบเรียบร้อย');
        $request->session()->pull('loginId');
        return redirect('login');
    }

}

}



