<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
//user module
Route::get('/', function () {return view('login');})->name('login.view');
Route::get('/register', function () {return view('register');})->name('register.view');
Route::post('/register' , [UserController::class, 'CreateUser'])->name('user.create');
Route::post('/login', [UserController::class, 'LoginUser'])->name('user.login');

//researcher
Route::get('/researcher/profile', function () {return view('researcher.profile');})->name('researcher.profile');
Route::get('/researcher/home/{id}', [UserController::class, 'ResearcherShowHome'])->name('researcher.home');