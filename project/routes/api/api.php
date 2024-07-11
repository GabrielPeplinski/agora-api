<?php

use App\Http\Api\Controllers\Client\Solicitation\AddSolicitationImageController;
use App\Http\Api\Controllers\Shared\SolicitationController;
use App\Http\Shared\Controllers\Selects\SolicitationCategoriesSelectController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Unauthenticated Routes
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

Route::get('solicitations', [SolicitationController::class, 'index']);
Route::get('solicitations/{solicitation}', [SolicitationController::class, 'show']);

Route::post('my-solicitations/{mySolicitation}/add-image', AddSolicitationImageController::class);

Route::prefix('selects')->group(function () {
    Route::get('solicitation-categories', SolicitationCategoriesSelectController::class);
});
