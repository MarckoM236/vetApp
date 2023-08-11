<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('home');
});

Auth::routes();

//logged in users
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
});

//users logged in with administrator role
Route::middleware(['auth', 'admin'])->group(function () {
    //users
    Route::get('/user/create',[UserController::class,'create'])->name('user.create');
});


