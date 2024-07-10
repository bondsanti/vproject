<?php

use App\Http\Controllers\Api\ApiReportController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/report/booking.current-year',[ApiReportController::class,'ReportBookingAllCurrentYear']);

// api createRoleBy VBNext
Route::post('/create-role/{user_id}',[UserController::class,'createUserRoleByAPI'])->middleware(['checkTokenApi']);
// Route::get('/users-list/{user_id}',[UserController::class,'userListAPI'])->middleware(['checkTokenApi']);
Route::get('/users-list/{user_id}',[UserController::class,'userListAPI']);
