<?php

namespace App\Http\Controllers;
use Session;
use App\Models\User;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    //นัดเยี่ยมโครงการ
    public function bookingProject(){

        $dataUserLogin = array();

        if (Session::has('loginId')) {
           $dataUserLogin = User::where('id',"=", Session::get('loginId'))->first();
        }

        return view("booking.index",compact('dataUserLogin'));
    }
}
