<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BookingController extends Controller
{
    //นัดเยี่ยมโครงการ
    public function bookingProject(){
        return view("booking.index");
    }
}
