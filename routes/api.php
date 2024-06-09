<?php


use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\MessageController;
use App\Http\Controllers\Api\RoomTypeContoller;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\ServicesController;
use App\Http\Controllers\Api\ReservationController;
use App\Http\Controllers\Api\V1\ReservationEventController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});




Route::group(['prefix'=>'v1'],function(){

    Route::post('/auth/register', [AuthController::class, 'register']);
    Route::post('/auth/login', [AuthController::class, 'login']);
    Route::post('/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('/reservation/events/{reservation}', [ReservationEventController::class, 'reservationEvents']);
    
    });
Route::post('/contacts',[ContactController::class,'store']);
Route::post('/messages',[MessageController::class,'store']);
Route::post('/reservation',[ReservationController::class,'store'])->middleware('auth:sanctum');
Route::get('/services', [ServicesController::class, 'index']);
Route::get('/services/{service}', [ServicesController::class, 'show']);


Route::get('/roomType',[RoomTypeContoller::class,'index']);
