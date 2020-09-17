<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/banned',function (){
    return view('ban');
});
Auth::routes();

Route::middleware('status')->get('/home', [Controllers\HomeController::class, 'index'])->name('home');
Route::middleware('status')->resource('doctor',Controllers\DoctorController::class);

Route::get('login/github', [Controllers\Auth\LoginController::class,'redirectToProvider'])->name('login.github');
Route::get('login/github/callback', [Controllers\Auth\LoginController::class,'handleProviderCallback']);
Route::group(['middleware'=>'DoctorProfile'],function(){
    Route::group(['middleware'=>'docValidity'],function (){
        Route::resource('doctor.appointment',Controllers\DocAppointmentController::class);
    });
    Route::get('doctor/{id}/invalid',[Controllers\DoctorController::class,'invalid'])->name('doctor.invalid');
});


