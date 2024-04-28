<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BusControllerr;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\OrderController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

//ROUTE UNTUK AUTENTIKASI
Route::post('/v1/auth/login', [AuthController::class, 'login']);
Route::get('/v1/auth/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

//ROUTES UNTUK BUS
Route::controller(BusControllerr::class)->middleware('auth:sanctum')->group(function(){
    Route::get('/v1/buses', 'index');
    Route::post('/v1/bus', 'store');
    Route::put('/v1/bus/{id}', 'update');
    Route::delete('/v1/bus/{id}', 'destroy');
});

//ROUTE UNTUK DRIVER
Route::controller(DriverController::class)->middleware('auth:sanctum')->group(function(){
    Route::get('/v1/drivers', 'index');
    Route::post('/v1/driver', 'store');
    Route::put('/v1/driver/{id}', 'update');
    Route::delete('/v1/driver/{id}', 'destroy');
});


//ROUTE UNTUK ORDER
Route::controller(OrderController::class)->middleware('auth:sanctum')->group(function(){
    Route::get('/v1/orders', 'index');
    Route::post('/v1/order', 'store');
    Route::delete('/v1/order/{id}', 'destroy');
});

//MIDDLEWARE ITU UNTUK PROTECTING ROUTES
//CLIENT -> MIDDLEWARE -> ROUTE -> CONTROLLER -> MODEL -> DB