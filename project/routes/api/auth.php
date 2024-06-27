<?php

use App\Http\Api\Controllers\Auth\LoginController;
use App\Http\Api\Controllers\Auth\LogoutController;
use App\Http\Api\Controllers\Auth\MeController;
use App\Http\Api\Controllers\Auth\RegisterController;
use App\Http\Api\Controllers\Auth\UpdatePersonalDataController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Auth Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('register', RegisterController::class);
Route::post('login', LoginController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('me', MeController::class);
    Route::delete('logout', LogoutController::class);

    Route::put('personal-data', UpdatePersonalDataController::class);
});
