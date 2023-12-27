<?php

use App\Http\Controllers\Api\RequestForProductController;
use App\Http\Controllers\Api\RequestSendController;
use App\Http\Controllers\Api\SuggestProductController;
use Illuminate\Http\Request;
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



Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'v2'], function () {
    Route::controller(RequestSendController::class)->group(function () {
        Route::post('/send_request/store', 'store')->name('send_request.store');
        Route::get('/send_request/get_detail/{id}', 'show')->name('send_request.get_detail');
        Route::post('/send_request/get_all', 'index')->name('send_request.get_all');
    });

    Route::controller(SuggestProductController::class)->group(function () {
        Route::get('/suggest_for_supermarket', 'suggest_for_supermarket')->name('suggest_for_supermarket');
    });
});

