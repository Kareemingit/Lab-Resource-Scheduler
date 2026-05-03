<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use Illuminate\Http\Request;
use App\Models\Reservation;
use App\Models\Researcher;
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
        $equipment = Equipment::where('eq_id', $equipment_id)->first();
        $mainCost = $equipment->price * $duration;
        $sitePercentage = $mainCost + ($mainCost * 0.10);
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
            'grant_id'     => 'required'
        ]);
        $startDateTime = Carbon::parse($validatedData['res_date'] . ' ' . $validatedData['start_time']);
        $duration = (int) $validatedData['duration']; 
        $endDateTime = (clone $startDateTime)->addHours($duration);

        if (!$this->checkAvailability($validatedData['equipment_id'], $startDateTime, $endDateTime)) {
            //return redirect()->back()->with('error', 'The equipment is not available for the selected period.');
            dd('The equipment is not available for the selected period.');
        }

        if (!$this->checkUserHasPermission($validatedData['user_id'], $validatedData['equipment_id'])) {
            dd('You are not certified to use this equipment.');
        }

        $ammount = $this->calculateCost($validatedData['equipment_id'], $duration);

        if($this->isGrantBudgetExceeded($validatedData['grant_id'], $ammount)){
            dd('The grant budget is exceeded. Cannot create reservation.');
        }

        try {
            $this->moneyTransfer($validatedData['grant_id'], $validatedData['user_id'], $ammount);
        } catch (\Exception $e) {
            dd('Error processing payment: ' . $e->getMessage());
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

        return redirect()->back()->with('success', 'Reservation created successfully.');
    }
}
