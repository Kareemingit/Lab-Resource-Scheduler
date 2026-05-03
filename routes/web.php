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
Route::post('/researcher/add-certification', [UserController::class, 'AddCertification'])->name('researcher.add_certification');
Route::get('/researcher/profile/{id}', [UserController::class, 'ResearcherShowProfile'])->name('researcher.profile');
Route::get('/researcher/home/{id}', [UserController::class, 'ResearcherShowHome'])->name('researcher.home');
Route::get('/researcher/equipments/{id}', [EquipmentsController::class, 'index'])->name('researcher.equipments');
//financial_department
Route::get('/financial_department/{id}', [UserController::class, 'FinancialDepartmentShowProjects'])->name('financial_department.projects');
Route::put('/financial_department/{id}/update-budget', [UserController::class, 'UpdateBudget'])->name('financial_department.update_budget');
//reservation module
Route::post('/reservations/store', [ReservationController::class, 'store'])->name('reservations.store');