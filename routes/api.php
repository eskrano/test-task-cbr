<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group(['prefix' => 'currency'], function () {
    Route::get('/all')
        ->uses([\App\Http\Controllers\API\CurrencyController::class, 'all'])
        ->name('api.currency.all');

    Route::get('/all_flatten')
        ->uses([\App\Http\Controllers\API\CurrencyController::class, 'allFlatten'])
        ->name('api.currency.all_flatten');

    Route::get('/{currency}')
        ->uses([\App\Http\Controllers\API\CurrencyController::class, 'show'])
        ->name('api.currency.history')
        ->where('currency', '[0-9]+');

    Route::get('/{currency}/history')
        ->uses([\App\Http\Controllers\API\CurrencyController::class, 'history'])
        ->name('api.currency.history')
        ->where('currency', '[0-9]+');
});
