<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
//user module
Route::get('/', function () {return view('login');})->name('login.view');
Route::get('/register', function () {return view('register');})->name('register.view');
Route::post('/register' , [UserController::class, 'CreateUser'])->name('user.create');
Route::post('/login', [UserController::class, 'LoginUser'])->name('user.login');

//researcher
Route::get('/researcher/home', function () {return view('researcher.home');})->name('researcher.home');
Route::get('/researcher/equipments', function () {return view('researcher.equipments');})->name('researcher.equipment');
Route::get('/researcher/reservations', function () {return view('researcher.reservations');})->name('researcher.reservation');
Route::get('/researcher/profile', function () {return view('researcher.profile');})->name('researcher.profile');