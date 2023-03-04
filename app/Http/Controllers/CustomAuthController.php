<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;
use Phattarachai\LineNotify\Line;
use App\Models\User;

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

        ],[
            'code.required' => 'ป้อนรหัสพนักงาน',
            'code.unique' => 'รหัสนี้มีผู้ใช้แล้ว',
            'fullname.required' => 'ป้อนชื่อ-นามสกุล',
            'password.required' => 'ป้อนชื่อรหัสผ่าน',
            'password.min' => 'รหัสผ่านต้องไม่ต่ำกว่า 8 ตัวอักษร',
        ]);

        $user = new User();
        $user->code = $request->code;
        $user->fullname = $request->fullname;
        $user->password = Hash::make($request->password);
        $user->role = 'user'; //user = ผู้ใช้งานทั่วไป //admin = ผู้ดูแลระบบ //staff ผู้ใช้งานลองจาก admin
        $user->team_id = '0'; //0 = Df ไม่มี team
        $user->active = 'disable'; // enable = ใช้งาน // disable = ปิดใช้งาน
        $res = $user->save();

        if ($res) {
            Alert::success('ลงทะเบียนสำเร็จ', 'คุณได้ลงทะเบียนเรียบร้อย
            รอ Admin เปิดใช้งานระบบ 5 นาที');


            $line = new Line('UOmTNB7jin55QZUvG67BiDjEYNx3I7cWmHtCTBLCXts');//token กลุ่ม Admin vBisProject
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

        $user = User::where('code',"=", $request->code)->first();

        if ($user) {
            if($user->active != 'disable'){
                if(Hash::check($request->password, $user->password)){
                    $request->session()->put('loginId',$user->id);
                    Alert::success('เข้าสู่ระบบสำเร็จ');
                    return redirect('/');
                }else{
                    Alert::warning('รหัสผ่านไม่ถูกต้อง', 'กรุณากรอกข้อมูลใหม่อีกครั้ง');
                    return back();
                }
            }else{
                Alert::error('ผู้ใช้ถูกปิด & ยังไม่เปิดใช้งาน', 'กรุณาติดต่อ Admin!!');
                return back();
            }
        }else{
            Alert::warning('ไม่พบผู้ใช้งาน', 'กรุณากรอกข้อมูลใหม่อีกครั้ง');
            //return back()->with('ล้มเหลว','ไม่พบผู้ใช้งาน');
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



