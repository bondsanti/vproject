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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/login',[CustomAuthController::class,'login']);
Route::get('/regis',[CustomAuthController::class,'regis']);


Route::get('/main',[MainController::class,'index'])->name('main');
Route::get('/calendar',[MainController::class,'calendar'])->name('calendar');
Route::get('/booking_project',[BookingController::class,'bookingProject'])->name('bookingProject');
Route::get('/user',[UserController::class,'index'])->name('user');
