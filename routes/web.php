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

Route::get('/user/test',[UserController::class,'testteam']);
Route::get('/calendar',[MainController::class,'calendar'])->name('calendar')->middleware('isLogin');


/*
|--------------------------------------------------------------------------
| User Routes
|--------------------------------------------------------------------------
*/
Route::get('/user',[UserController::class,'index'])->name('user')->middleware('isLogin');
Route::post('/user',[UserController::class,'insert'])->name('user.insert')->middleware('isLogin');
Route::delete('/user/{id}',[UserController::class,'destroy'])->name('user.destroy')->middleware('isLogin');
Route::get('/user/edit/{id}',[UserController::class,'edit'])->name('user.edit')->middleware('isLogin');
Route::post('/user/update/{id}',[UserController::class,'update'])->name('user.update')->middleware('isLogin');


/*
|--------------------------------------------------------------------------
| bookings Routes
|--------------------------------------------------------------------------
*/

Route::get('/booking',[BookingController::class,'bookingProject'])->name('bookingProject')->middleware('isLogin');
//ajax getteams
Route::get('/subteams', [BookingController::class,'getByTeam'])->name('subteams.get');
Route::post('/booking/create',[BookingController::class,'createBookingProject'])->name('createBookingProject.create')->middleware('isLogin');
Route::get('/booking/list',[BookingController::class,'listBooking'])->name('listBooking')->middleware('isLogin');
Route::delete('/booking/{id}',[BookingController::class,'destroyBooking'])->name('booking.del')->middleware('isLogin');
