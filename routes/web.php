<?php
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\SubTeamController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\HolidayController;

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
Route::get('/calendar',[CalendarController::class,'index'])->name('calendar')->middleware('isLogin');


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
| Team Routes
|--------------------------------------------------------------------------
*/
Route::get('/team',[TeamController::class,'index'])->name('team')->middleware('isLogin');
Route::post('/team',[TeamController::class,'insert'])->name('team.insert')->middleware('isLogin');
Route::delete('/team/{id}',[TeamController::class,'destroy'])->name('team.destroy')->middleware('isLogin');
Route::get('/team/edit/{id}',[TeamController::class,'edit'])->name('team.edit')->middleware('isLogin');
Route::post('/team/update/{id}',[TeamController::class,'update'])->name('team.update')->middleware('isLogin');
/*
|--------------------------------------------------------------------------
| subTeam Routes
|--------------------------------------------------------------------------
*/
Route::get('/subteam',[SubTeamController::class,'index'])->name('subteam')->middleware('isLogin');
Route::post('/subteam',[SubTeamController::class,'insert'])->name('subteam.insert')->middleware('isLogin');
Route::delete('/subteam/{id}',[SubTeamController::class,'destroy'])->name('subteam.destroy')->middleware('isLogin');
Route::get('/subteam/edit/{id}',[SubTeamController::class,'edit'])->name('subteam.edit')->middleware('isLogin');
Route::post('/subteam/update/{id}',[SubTeamController::class,'update'])->name('subteam.update')->middleware('isLogin');

/*
|--------------------------------------------------------------------------
| bookings Routes
|--------------------------------------------------------------------------
*/

Route::get('/booking',[BookingController::class,'bookingProject'])->name('bookingProject')->middleware('isLogin');

//ajax get teams
Route::get('/subteams', [BookingController::class,'getByTeam'])->name('subteams.get');

Route::post('/booking/create',[BookingController::class,'createBookingProject'])->name('createBookingProject.create')->middleware('isLogin');
Route::get('/booking/list',[BookingController::class,'listBooking'])->name('listBooking')->middleware('isLogin');
Route::delete('/booking/list/{id}',[BookingController::class,'destroyBooking'])->name('booking.del')->middleware('isLogin');
Route::put('/booking/list/update-status',[BookingController::class,'updateStatus'])->name('booking.update.status')->middleware('isLogin');
Route::post('/booking/list/update',[BookingController::class,'updateBookingProject'])->name('updateBookingProject')->middleware('isLogin');
Route::get('/booking/edit/{id}',[BookingController::class,'editBooking'])->name('booking.edit')->middleware('isLogin');
Route::get('/booking/print/{id}',[BookingController::class,'printBooking'])->middleware('isLogin');

Route::get('/user/test',[BookingController::class,'testUser']);

/*
|--------------------------------------------------------------------------
| holiday Routes
|--------------------------------------------------------------------------
*/
Route::get('/holiday',[HolidayController::class,'index'])->name('holiday')->middleware('isLogin');
Route::post('/holiday',[HolidayController::class,'insert'])->name('holiday.insert')->middleware('isLogin');
Route::get('/holiday/{id}',[HolidayController::class,'showStatus'])->name('showStatus')->middleware('isLogin');
Route::post('/holiday/update_status/{id}',[HolidayController::class,'updateStatus'])->name('holiday.update.status')->middleware('isLogin');
Route::post('/holiday/update/{id}',[HolidayController::class,'updateData'])->name('holiday.update')->middleware('isLogin');
Route::delete('/holiday/{id}',[HolidayController::class,'destroy'])->name('holiday.destroy')->middleware('isLogin');
