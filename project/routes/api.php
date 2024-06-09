<?php

use App\Http\Api\Controllers\Auth\LoginController;
use App\Http\Api\Controllers\Auth\LogoutController;
use App\Http\Api\Controllers\Auth\MeController;
use App\Http\Api\Controllers\Auth\RegisterController;
use App\Http\Api\Controllers\Auth\UpdatePersonalDataController;
use App\Http\Api\Controllers\Client\AddressController;
use App\Http\Api\Controllers\Client\Solicitation\AddSolicitationImageController;
use App\Http\Api\Controllers\Client\Solicitation\LikeSolicitationController;
use App\Http\Api\Controllers\Client\Solicitation\MySolicitationsController;
use App\Http\Api\Controllers\Shared\SolicitationController;
use App\Http\Shared\Controllers\Selects\SolicitationCategoriesSelectController;
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

Route::post('my-solicitations/{mySolicitation}/add-image', AddSolicitationImageController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('client')->group(function () {

        Route::get('address', [AddressController::class, 'index']);
        Route::put('address', [AddressController::class, 'createOrUpdate']);


        Route::apiResource('my-solicitations', MySolicitationsController::class);

        Route::post('solicitations/like', LikeSolicitationController::class);
    });
});

/*
 * No authentication routes
 */
Route::prefix('selects')->group(function () {
    Route::get('solicitation-categories', SolicitationCategoriesSelectController::class);
});

Route::get('solicitations', [SolicitationController::class, 'index']);
Route::get('solicitations/{solicitation}', [SolicitationController::class, 'show']);
