<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CustomAuthController extends Controller
{

   public function login(){
        return view('auth.login');
   }

   public function regis(){
        return view('auth.register');
   }

}
