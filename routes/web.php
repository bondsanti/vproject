<?php
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\SubTeamController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\ReportController;
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

Route::get('/testapi',[UserController::class,'testAPI']);

Route::get('McfaSei97t71S0w62eKWQCVWXRqVe2naBUS8rUNxajavLw1F5aR7Y1buECBP5AdtiMCZajbvy1kvitbA36FD3NECkW/{code}&{token}',[CustomAuthController::class,'AllowLoginConnect']);

Route::get('/login',[CustomAuthController::class,'login'])->middleware('alreadyLogin');
Route::get('/regis',[CustomAuthController::class,'regis'])->middleware('alreadyLogin');
Route::post('/registration',[CustomAuthController::class,'insertRegis'])->name('insertRegis');
Route::post('/login/auth',[CustomAuthController::class,'loginUser'])->name('loginUser');
Route::get('/logout/auth',[CustomAuthController::class,'logoutUser'])->name('logoutUser')->middleware('isLogin');


/*
|--------------------------------------------------------------------------
| Main Routes
|--------------------------------------------------------------------------
*/

Route::get('/',[MainController::class,'index'])->name('main')->middleware('isLogin');
Route::post('/search',[MainController::class,'search'])->name('main.search')->middleware('isLogin');


/*
|--------------------------------------------------------------------------
| Calendar Routes
|--------------------------------------------------------------------------
*/

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

Route::get('/user/test',[UserController::class,'testteam']);

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
Route::put('/booking/list/update-user',[BookingController::class,'updateUser'])->name('booking.update.user')->middleware('isLogin');
Route::post('/booking/list/update-score',[BookingController::class,'updateScore'])->name('booking.update.score')->middleware('isLogin');
Route::post('/booking/list/update',[BookingController::class,'updateBookingProject'])->name('updateBookingProject')->middleware('isLogin');
Route::get('/booking/edit/{id}',[BookingController::class,'editBooking'])->name('booking.edit')->middleware('isLogin');
Route::get('/booking/print/{id}',[BookingController::class,'printBooking'])->middleware('isLogin');
Route::get('/booking/showJob/{id}',[BookingController::class,'showJob'])->middleware('isLogin');
Route::post('/booking/update-job',[BookingController::class,'updateshowJob'])->name('booking.update.job')->middleware('isLogin');
Route::post('/booking/edit-job',[BookingController::class,'updateeditJob'])->name('booking.edit.job')->middleware('isLogin');
Route::post('/booking/list/search',[BookingController::class,'search'])->name('booking.search')->middleware('isLogin');

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


/*
|--------------------------------------------------------------------------
| Report
|--------------------------------------------------------------------------
*/

Route::get('/report/booking/project',[ReportController::class,'reportByProject'])->name('report.book.project')->middleware('isLogin');
Route::get('/report/booking/group/project',[ReportController::class,'reportGroupByProject'])->middleware('isLogin');
Route::get('/report/booking/group/project/pie',[ReportController::class,'reportGroupByProjectPie'])->middleware('isLogin');

Route::get('/report/booking/team',[ReportController::class,'reportByTeam'])->name('report.book.team')->middleware('isLogin');
Route::get('/report/booking/team/pie',[ReportController::class,'reportByTeamPie'])->middleware('isLogin');
Route::get('/report/booking/subteam',[ReportController::class,'reportBySubTeam'])->middleware('isLogin');
Route::get('/report/booking/subteam/pie',[ReportController::class,'reportBySubTeam'])->middleware('isLogin');
Route::get('/report/booking/group/project/team',[ReportController::class,'reportGroupProjectByTeam'])->middleware('isLogin');


//ChackBooking to alert auto
Route::get('/alert/booking',[MainController::class,'checkAlertBookingConfirm'])->name('alert.booking');
Route::get('/alert/booking/sale',[MainController::class,'checkAlertBookingConfirmSale'])->name('alert.booking.sale');
Route::get('/alert/booking/before/sale',[MainController::class,'alertBeforeBookingConfirmSale'])->name('alert.booking.bf.sale');
