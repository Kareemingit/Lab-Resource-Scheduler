<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\EquipmentsController;
//user module
Route::get('/', function () {return view('login');})->name('login.view');
Route::get('/register', function () {return view('register');})->name('register.view');
Route::post('/register' , [UserController::class, 'CreateUser'])->name('user.create');
Route::post('/login', [UserController::class, 'LoginUser'])->name('user.login');

//researcher
Route::get('/researcher/profile', function () {return view('researcher.profile');})->name('researcher.profile');
Route::get('/researcher/home/{id}', [UserController::class, 'ResearcherShowHome'])->name('researcher.home');

//components module
Route::get('/reservations/create', [ReservationController::class, 'create'])->name('reservations.create');
Route::get('/researcher/equipments/{id}', [EquipmentsController::class, 'index'])->name('researcher.equipments');