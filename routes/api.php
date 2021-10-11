<?php

use App\Http\Controllers\VehicleController;
use App\Http\Controllers\AuthController;
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

Route::group([
    'prefix' => 'auth'

], function () {
    
    Route::get('index', [VehicleController::class,'index']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('register', [AuthController::class, 'register']);
    Route::post('store', [VehicleController::class,'store']);
    Route::put('update/{vehicle}', [VehicleController::class,'update']);
    Route::match(['delete', 'put'], 'restart/{newmonth}', [VehicleController::class,'restart']);
    Route::post('show/{search}', [VehicleController::class,'show']);
});
