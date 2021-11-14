<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;





Route::get('/', function () {
    return view('layouts.master');
});
// Route::get('/login', function () {
//     return view('welcome');
// });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


// Studen
Route::POST('/student/updated', [App\Http\Controllers\StudentController::class, 'updated']);
Route::resource('student', StudentController::class);


// User
Route::POST('/user/updated', [App\Http\Controllers\UserController::class, 'updated']);
Route::resource('user', UserController::class);
