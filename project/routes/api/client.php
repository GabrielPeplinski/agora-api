<?php

use App\Http\Api\Controllers\Client\AddressController;
use App\Http\Api\Controllers\Client\Solicitation\AddSolicitationImageController;
use App\Http\Api\Controllers\Client\Solicitation\LikeSolicitationController;
use App\Http\Api\Controllers\Client\Solicitation\MySolicitationsController;
use App\Http\Api\Controllers\Client\Solicitation\UpdateSolicitationStatusController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Authenticated Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('address', [AddressController::class, 'index']);
Route::put('address', [AddressController::class, 'createOrUpdate']);

Route::post('my-solicitations/{mySolicitation}/add-image', AddSolicitationImageController::class);
Route::put('my-solicitations/{mySolicitation}/status', UpdateSolicitationStatusController::class);
Route::apiResource('my-solicitations', MySolicitationsController::class);

Route::post('solicitations/like', LikeSolicitationController::class);
