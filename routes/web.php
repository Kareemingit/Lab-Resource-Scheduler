<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\EquipmentsController;
use App\Http\Controllers\GrantController;

//user module
Route::get('/', function () {return view('login');})->name('login.view');
Route::get('/register', function () {return view('register');})->name('register.view');
Route::post('/register' , [UserController::class, 'CreateUser'])->name('user.create');
Route::post('/login', [UserController::class, 'LoginUser'])->name('user.login');
Route::post('/logout' , [UserController::class , 'LogoutUser'])->name('user.logout');
//researcher
Route::post('/researcher/add-certification', [UserController::class, 'AddCertification'])->name('researcher.add_certification');
Route::middleware(['user_access'])->group(function () {
    //researcher
    Route::get('/researcher/profile/{id}', [UserController::class, 'ResearcherShowProfile'])->name('researcher.profile');
    Route::get('/researcher/home/{id}', [UserController::class, 'ResearcherShowHome'])->name('researcher.home');
    Route::get('/researcher/equipments/{id}', [EquipmentsController::class, 'index'])->name('researcher.equipments');
    Route::post('/researcher/reservation/{id}/{eq_id}/confirm', [ReservationController::class, 'confirmReceipt'])->name('confirm.receipt.submit');
    Route::get('/researcher/reservation/{id}', [ReservationController::class, 'show'])->name('researcher.reservation');
    //lab_manager
    Route::get('/lab_manager/equipments/{id}', [EquipmentsController::class, 'index_lab_manager'])->name('lab_manager.equipments');
    Route::get('/lab_manager/profile/{id}', [UserController::class, 'LabManagerShowProfile'])->name('lab_manager.profile');
    Route::put('/lab_manager/profile/{id}', [UserController::class, 'UpdateLabManagerProfile'])->name('lab_manager.update_profile');
    Route::put('/lab_manager/profile/{id}/password', [UserController::class, 'UpdateLabManagerPassword'])->name('lab_manager.update_password');
    Route::post('/lab_manager/equipment/{id}/store', [EquipmentsController::class, 'store'])->name('equipment.store');
    Route::put('/lab_manager/equipment/{id}/update', [EquipmentsController::class, 'update'])->name('equipment.update');
    Route::delete('/lab_manager/equipment/{id}/delete', [EquipmentsController::class, 'destroy'])->name('equipment.destroy');

    //financial_department
    Route::get('/financial_department/{id}', [UserController::class, 'FinancialDepartmentShowProjects'])->name('financial_department.projects');
    Route::put('/financial_department/{id}/update-budget', [UserController::class, 'UpdateBudget'])->name('financial_department.update_budget');
    Route::get('/researcher/reservation/{id}/{eq_id}',[ReservationController::class, 'start_session'])->name('confirm.receipt');
});

Route::post('/lab_manager/equipment/{eq_id}/report-accident', [EquipmentsController::class, 'reportAccident'])->name('equipment.report');

//resource control module
//reservation
Route::post('/reservations/store', [ReservationController::class, 'store'])->name('reservations.store');
//grant
Route::post('/grant/store' , [GrantController::class , 'store'])->name('grant.store');



/*
Objectives: 
1. Start Reservation
we press Submit reservation: 
    3. Create Reservation
*/