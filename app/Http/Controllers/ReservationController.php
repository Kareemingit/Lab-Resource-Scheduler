<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Researcher;
use Illuminate\Support\Facades\Schedule;
use App\Models\Grant;
use App\Models\Project;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

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

    private function checkUserHasPermission($researcher_id, $eq_id){
        $certification = DB::table('certifications')
            ->where('eq_id', $eq_id)
            ->first();
        if (!$certification) {
            return true;
        }
        
        return DB::table('certification_researcher')
            ->where('researcher_id', $researcher_id)
            ->where('cert_id', $certification->cert_id)
            ->where('expiry_date', '>', Carbon::now())
            ->exists();
    }

    private function calculateCost($equipment_id, $duration){
        $equipment = Equipment::findOrFail($equipment_id);
        $mainCost = $equipment->price * $duration;
        $sitePercentage = ($mainCost * 0.10);
        $fees = $sitePercentage + ($sitePercentage * 0.05);
        $totalCost = $mainCost + $sitePercentage + $fees;
        return $totalCost;
    }

    private function moneyTransfer($fromGrantId, $researcherId, $amount){
        DB::beginTransaction();
        try {
            $fromGrant = Grant::where('grant_id', $fromGrantId)->firstOrFail();
            $researcher = Researcher::where('user_id', $researcherId)->firstOrFail();
            
            if (!$researcher->project_id) {
                throw new \Exception('Researcher is not assigned to a project.');
            }

            $project = Project::where('project_id', $researcher->project_id)->firstOrFail();

            if ($fromGrant->fund < $amount) {
                throw new \Exception('Insufficient funds in the source grant.');
            }

            // Deduct funds
            $fromGrant->fund -= $amount;
            $project->balance -= $amount;
            
            // These will now work because of the $primaryKey update in the Models
            $fromGrant->save();
            $project->save();
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    private function isGrantBudgetExceeded($grant_id, $reservation_cost){
        $grant = Grant::where('grant_id', $grant_id)->first();
        $grantFund = $grant->fund;
        return $grantFund < $reservation_cost;
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'equipment_id' => 'required|exists:equipments,eq_id',
            'user_id'      => 'required|exists:researchers,user_id',
            'res_date'     => 'required|date',
            'start_time'   => 'required',
            'duration'     => 'required|numeric|min:1',
            'grant_id'     => 'required|exists:grants,grant_id'
        ]);

        $startDateTime = Carbon::parse($validatedData['res_date'] . ' ' . $validatedData['start_time']);
        $duration = (int) $validatedData['duration']; 
        $endDateTime = (clone $startDateTime)->addHours($duration);
        $equipment = Equipment::findOrFail($validatedData['equipment_id']);
        if (!$this->checkAvailability($validatedData['equipment_id'], $startDateTime, $endDateTime)) {
            //return redirect()->back()->with('error', 'The equipment is not available for the selected period.');
            return view('error' , ['message' => 'The equipment is not available for the selected period.']);
        }

        if (!$this->checkUserHasPermission($validatedData['user_id'], $validatedData['equipment_id'])) {
            //return redirect()->back()->with('error', 'You are not certified to use this equipment.');
            return view('error' , ['message' => 'You are not certified to use this equipment.']);
        }

        $primary_amount = $this->calculateCost($validatedData['equipment_id'], $duration);
        $equipment->increment('used_hours', $duration);

        if (!is_null($equipment->sec_eq_id)) {
            if (!$this->checkAvailability($equipment->sec_eq_id, $startDateTime, $endDateTime)) {
                //return redirect()->back()->with('error', 'The secondary equipment is not available for the selected period.');
                return view('error' , ['message' => 'The secondary equipment is not available for the selected period.']);
            }
            if (!$this->checkUserHasPermission($validatedData['user_id'], $equipment->sec_eq_id)) {
                //return redirect()->back()->with('error', 'You are not certified to use the secondary equipment.');
                return view('error' , ['message' => 'You are not certified to use the secondary equipment.']); 
            }
            $sec_amount = $this->calculateCost($equipment->sec_eq_id, $duration);
            $total_amount = $primary_amount + $sec_amount;

            if($this->isGrantBudgetExceeded($validatedData['grant_id'], $total_amount)){
                //return redirect()->back()->with('error', 'The grant budget is exceeded. Cannot create reservation for the secondary equipment.');
                return view('error' , ['message' => 'The grant budget is exceeded. Cannot create reservation for the secondary equipment.']); 
            }
            try {
                $this->moneyTransfer($validatedData['grant_id'], $validatedData['user_id'], $total_amount);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Error processing payment: ' . $e->getMessage());
            }
            $sec_equipment = Equipment::findOrFail($equipment->sec_eq_id);
            $sec_equipment->increment('used_hours', $duration);

            Reservation::create([
                'eq_id'         => $validatedData['equipment_id'],
                'researcher_id' => $validatedData['user_id'],
                'start_date'    => $startDateTime,
                'end_date'      => $endDateTime,
                'grant_id'      => $validatedData['grant_id'],
                'res_hours'     => $duration,
                'authorized'    => 0,
                'confirm_receipt' => 0,
            ]);

            Reservation::create([
                'eq_id'         => $equipment->sec_eq_id,
                'researcher_id' => $validatedData['user_id'],
                'start_date'    => $startDateTime,
                'end_date'      => $endDateTime,
                'grant_id'      => $validatedData['grant_id'],
                'res_hours'    => $duration,
                'authorized'        => 0,
                'confirm_receipt' => 0,
            ]);
        }
        else{
            if($this->isGrantBudgetExceeded($validatedData['grant_id'], $primary_amount)){
                //return redirect()->back()->with('error', 'The grant budget is exceeded. Cannot create reservation.');
                return view('error' , ['message' => 'The grant budget is exceeded. Cannot create reservation.']); 

            }
            try {
                $this->moneyTransfer($validatedData['grant_id'], $validatedData['user_id'], $primary_amount);
            } catch (\Exception $e) {
                return redirect()->back()->with('error', 'Error processing payment: ' . $e->getMessage());
            }
            Reservation::create([
                'eq_id'         => $validatedData['equipment_id'],
                'researcher_id' => $validatedData['user_id'],
                'start_date'    => $startDateTime,
                'end_date'      => $endDateTime,
                'grant_id'      => $validatedData['grant_id'],
                'res_hours'    => $duration,
                'authorized'        => 0,
                'confirm_receipt' => 0,
            ]);
        }

        return redirect()->back()->with('success', 'Reservation created successfully.');
    }
    public function show($id){
        $researcher = Researcher::findOrFail($id);
        $researcher_id = $researcher->user_id;
        $reservations = Reservation::where('researcher_id', $researcher_id)
            ->orderBy('start_date', 'desc')
            ->get();
        $equipments = Equipment::all();

        return view('researcher.reservation', [
            'researcher' => $researcher,
            'reservations' => $reservations,
            'equipments'  => $equipments
        ]);
    }
    public function start_session($id, $eq_id){
        $researcher = Researcher::findOrFail($id);
        $reservations = Reservation::where('researcher_id', $id)
            ->orderBy('start_date', 'desc')
            ->get();
        

        return view('researcher/confirm_receipt', [
            'id'=>$id,
            'eq_id'=>$eq_id,
            'reservations'=>$reservations,
            'researcher'=>$researcher
        ]);
    }

    public function confirmReceipt($id, $eq_id){
            $equipment = Equipment::findOrFail($eq_id);
            $reservation = Reservation::where('researcher_id', $id)
                ->where('eq_id', $eq_id)
                ->orderBy('start_date', 'desc')
                ->first();
            if (!$reservation) {
                return redirect()->back()->with('error', 'Reservation not found.');
            }
            if (!is_null($equipment->sec_eq_id)) {
                $sec_reservation = Reservation::where('researcher_id', $id)
                    ->where('eq_id', $equipment->sec_eq_id)
                    ->where('start_date', $reservation->start_date)
                    ->first();
                if (!$sec_reservation) {
                        return redirect()->back()->with('error', 'Secondary reservation not found.');
                    }
                
                Reservation::where('researcher_id', $reservation->researcher_id)
                    ->where('eq_id', $reservation->eq_id)
                    ->where('start_date', $reservation->start_date)
                    ->update(['confirm_receipt' => 1]);
                    
                Reservation::where('researcher_id', $reservation->researcher_id)
                        ->where('eq_id', $equipment->sec_eq_id)
                        ->where('start_date', $reservation->start_date)
                        ->update(['confirm_receipt' => 1]);
            }
            else{
                Reservation::where('researcher_id', $reservation->researcher_id)
                    ->where('eq_id', $reservation->eq_id)
                    ->where('start_date', $reservation->start_date)
                    ->update(['confirm_receipt' => 1]);
            }
            return redirect()->back()->with('success', 'Receipt confirmed successfully.');
        
    }
    public function authorize($id, $eq_id){
            $equipment = Equipment::findOrFail($eq_id);
            $reservation = Reservation::where('researcher_id', $id)
                ->where('eq_id', $eq_id)
                ->orderBy('start_date', 'desc')
                ->first();
            if (!$reservation) {
                return redirect()->back()->with('error', 'Reservation not found.');
            }
            if (!is_null($equipment->sec_eq_id)) {
                $sec_reservation = Reservation::where('researcher_id', $id)
                    ->where('eq_id', $equipment->sec_eq_id)
                    ->where('start_date', $reservation->start_date)
                    ->first();
                if (!$sec_reservation) {
                        return redirect()->back()->with('error', 'Secondary reservation not found.');
                    }
                
                Reservation::where('researcher_id', $reservation->researcher_id)
                    ->where('eq_id', $reservation->eq_id)
                    ->where('start_date', $reservation->start_date)
                    ->update(['authorized' => 1]);
                    
                Reservation::where('researcher_id', $reservation->researcher_id)
                        ->where('eq_id', $equipment->sec_eq_id)
                        ->where('start_date', $reservation->start_date)
                        ->update(['authorized' => 1]);
            }
            else{
                Reservation::where('researcher_id', $reservation->researcher_id)
                    ->where('eq_id', $reservation->eq_id)
                    ->where('start_date', $reservation->start_date)
                    ->update(['authorized' => 1]);
            }
            return redirect()->back()->with('success', 'Authorization confirmed successfully.');
        
    }
    public function assign($id, $eq_id){
            $equipment = Equipment::findOrFail($eq_id);
            $reservation = Reservation::where('researcher_id', $id)
                ->where('eq_id', $eq_id)
                ->orderBy('start_date', 'desc')
                ->first();
            if (!$reservation) {
                return redirect()->back()->with('error', 'Reservation not found.');
            }
            if (!is_null($equipment->sec_eq_id)) {
                $sec_reservation = Reservation::where('researcher_id', $id)
                    ->where('eq_id', $equipment->sec_eq_id)
                    ->where('start_date', $reservation->start_date)
                    ->first();
                if (!$sec_reservation) {
                        return redirect()->back()->with('error', 'Secondary reservation not found.');
                    }
                
                Reservation::where('researcher_id', $reservation->researcher_id)
                    ->where('eq_id', $reservation->eq_id)
                    ->where('start_date', $reservation->start_date)
                    ->update(['assigned' => 1]);
                    
                Reservation::where('researcher_id', $reservation->researcher_id)
                        ->where('eq_id', $equipment->sec_eq_id)
                        ->where('start_date', $reservation->start_date)
                        ->update(['assigned' => 1]);
            }
            else{
                Reservation::where('researcher_id', $reservation->researcher_id)
                    ->where('eq_id', $reservation->eq_id)
                    ->where('start_date', $reservation->start_date)
                    ->update(['assigned' => 1]);
            }
            return redirect()->back()->with('success', 'Assignment confirmed successfully.');
        
    }

}