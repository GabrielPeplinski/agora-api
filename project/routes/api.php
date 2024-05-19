<?php

use App\Http\Api\Controllers\Auth\LoginController;
use App\Http\Api\Controllers\Auth\LogoutController;
use App\Http\Api\Controllers\Auth\MeController;
use App\Http\Api\Controllers\Auth\RegisterController;
use App\Http\Api\Controllers\Auth\UpdatePersonalDataController;
use App\Http\Api\Controllers\Client\AddressController;
use App\Http\Api\Controllers\Client\Selects\SolicitationCategoriesSelectController;
use App\Http\Api\Controllers\Client\Solicitation\LikeSolicitationController;
use App\Http\Api\Controllers\Client\Solicitation\MySolicitationsController;
use App\Http\Api\Controllers\Client\Solicitation\SolicitationController;
use Illuminate\Support\Facades\Route;

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

Route::get('health-check', function () {
    return response()->json('working...');
});

Route::prefix('auth')->group(function () {
    Route::post('register', RegisterController::class);
    Route::post('login', LoginController::class);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('me', MeController::class);
        Route::delete('logout', LogoutController::class);

        Route::put('personal-data', UpdatePersonalDataController::class);
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('client')->group(function () {

        /*
         * Select routes
         */
        Route::prefix('selects')->group(function () {
            Route::get('solicitation-categories', SolicitationCategoriesSelectController::class);
        });

        Route::get('address', [AddressController::class, 'index']);
        Route::put('address', [AddressController::class, 'createOrUpdate']);

        Route::get('my-solicitations', MySolicitationsController::class);
        Route::post('solicitations/like', LikeSolicitationController::class);
        Route::apiResource('solicitations', SolicitationController::class)
            ->except(['index']);
    });
});
