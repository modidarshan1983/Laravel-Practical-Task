<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HealthcareController;
use App\Http\Controllers\AppointmentController;

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
 Route::group(['middleware' => 'api'], function($routes){
        Route::post('/register',[UserController::class, 'register']);
        Route::post('/login',[UserController::class, 'login']);
        Route::get('/healthcare',[HealthcareController::class, 'index']);
        Route::post('/appointments/booke',[AppointmentController::class, 'book']);
        Route::get('/users/appointments', [AppointmentController::class, 'index']);
        Route::put('/appointments/{appointment}/cancel', [AppointmentController::class, 'cancel']);
        Route::put('/appointments/{appointment}/complete', [AppointmentController::class, 'complete']);
        Route::post('/profile',[UserController::class, 'profile']);
        Route::post('/refresh',[UserController::class, 'refresh']);
        Route::post('/logout',[UserController::class, 'logout']);
 });

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::controller(AuthController::class)->group(function(){
//         Route::post('register','register');
//         Route::post('login','login');
// });
