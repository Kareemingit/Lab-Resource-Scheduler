<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Reservation;
use Illuminate\Support\Carbon;

class ReservationController extends Controller
{
    private function checkAvailability($equipment_id, $start_time, $end_time){
        $reservations = Reservation::where('eq_id', $equipment_id)
            ->where(function($query) use ($start_time, $end_time) {
                $query->whereBetween('start_date', [$start_time, $end_time])
                      ->orWhereBetween('end_date', [$start_time, $end_time])
                      ->orWhere(function($query) use ($start_time, $end_time) {
                          $query->where('start_date', '<=', $start_time)
                                ->where('end_date', '>=', $end_time);
                      });
            })->get();
        return $reservations->isEmpty();
    }


    private function checkUserHasPermission($researcher_id , $eq_id){
            
    }
    public function store(Request $request){
        $validatedData = $request->validate([
            'equipment_id' => 'required|exists:equipments,eq_id',
            'user_id'      => 'required|exists:researchers,user_id', // Matching your hidden input name
            'res_date'     => 'required|date',
            'start_time'   => 'required',
            'duration'     => 'required|numeric|min:1',
            'grant_id'     => 'required'
        ]);


        $startDateTime = Carbon::parse($validatedData['res_date'] . ' ' . $validatedData['start_time']);
        
        $duration = (int) $validatedData['duration']; 
        $endDateTime = (clone $startDateTime)->addHours($duration);

        
        if (!$this->checkAvailability($validatedData['equipment_id'], $startDateTime, $endDateTime)) {
            //return redirect()->back()->with('error', 'The equipment is not available for the selected period.');
            dd('The equipment is not available for the selected period.');
        }

        Reservation::create([
            'eq_id'         => $validatedData['equipment_id'],
            'researcher_id' => $validatedData['user_id'],
            'start_date'    => $startDateTime,
            'end_date'      => $endDateTime,
            'grant_id'      => $validatedData['grant_id'],
            'res_hours'    => $duration,
            'status'        => 'pending',
        ]);

        //return redirect()->back()->with('success', 'Reservation created successfully.');
        dd('Reservation created successfully.');
    }
}
