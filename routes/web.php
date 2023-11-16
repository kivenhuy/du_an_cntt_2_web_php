<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get("/login", [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post("/login", [LoginController::class, 'login'])->name('user.login');
Route::post("/user_registration", [LoginController::class, 'login'])->name('user.registration');



Route::group(['middleware' => ['auth']], function () {
    Route::get("/logout", [LoginController::class, 'logout'])->name('user.logout');
    Route::get('/', function () {return view('user_layout.index');})->name('homepage');
});


