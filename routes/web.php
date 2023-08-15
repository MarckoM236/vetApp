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
    Route::post('/user/create',[UserController::class,'store'])->name('user.store');
    Route::get('/user/index',[UserController::class,'index'])->name('user.index');
    Route::get('/user/{id}/delete',[UserController::class,'destroy'])->name('user.delete');
    Route::get('/user/{id}/edit',[UserController::class,'edit'])->name('user.edit');
    Route::put('/user/{id}/update',[UserController::class,'update'])->name('user.update');
    Route::put('/user/{id}/status',[UserController::class,'updateStatus'])->name('user.status');
});


