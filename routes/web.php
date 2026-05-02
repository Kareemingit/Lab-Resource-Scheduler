<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
//user module
Route::get('/', function () {return view('login');})->name('login.view');
Route::get('/register', function () {return view('register');})->name('register.view');
Route::post('/register' , [UserController::class, 'CreateUser'])->name('user.create');