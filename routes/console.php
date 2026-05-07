<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Schedule;
use App\Http\Controllers\ReservationController;
use App\Models\Reservation;
use App\Models\Researcher;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
//schedule

Schedule::call(function(){
    $deletedCount = Reservation::where('confirm_receipt', 0)
        ->where('end_date', '<=', Carbon::now())
        ->delete();
})->daily();