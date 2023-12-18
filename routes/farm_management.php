<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\FarmManagement\DashboardController;
use App\Http\Controllers\FarmManagement\FarmerDetailsController;
use Illuminate\Support\Facades\Route;
Route::group(['middleware' => ['auth'],'prefix' => 'farm_management'], function () {

    Route::get("/dashboard", [DashboardController::class, 'index'])->name('farm_management.dashboard');

    Route::get("/farmer", [FarmerDetailsController::class, 'index'])->name('farmer.index');
    Route::get("/farmer/create", [FarmerDetailsController::class, 'create'])->name('farmer.create');
    Route::post("/add_farmer", [FarmerDetailsController::class, 'store'])->name('farmer.store');
    Route::get("/farmer/dtajax", [FarmerDetailsController::class, 'dtajax'])->name('farmer.dtajax');
});

