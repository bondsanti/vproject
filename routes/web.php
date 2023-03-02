<?php
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/login',[CustomAuthController::class,'login'])->middleware('alreadyLogin');
Route::get('/regis',[CustomAuthController::class,'regis'])->middleware('alreadyLogin');
Route::post('/registration',[CustomAuthController::class,'insertRegis'])->name('insertRegis');
Route::post('/login/auth',[CustomAuthController::class,'loginUser'])->name('loginUser');
Route::get('/logout/auth',[CustomAuthController::class,'logoutUser'])->name('logoutUser')->middleware('isLogin');


Route::get('/',[MainController::class,'index'])->name('main')->middleware('isLogin');
Route::get('/calendar',[MainController::class,'calendar'])->name('calendar')->middleware('isLogin');
Route::get('/booking_project',[BookingController::class,'bookingProject'])->name('bookingProject')->middleware('isLogin');
Route::get('/user',[UserController::class,'index'])->name('user')->middleware('isLogin');
