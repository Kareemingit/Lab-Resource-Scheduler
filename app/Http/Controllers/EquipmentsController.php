<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\Grant;
use App\Models\Researcher;
use App\Models\Report;
use Illuminate\Support\Facades\DB;
use App\Models\Certification;
class EquipmentsController extends Controller
{
    public function index($id){
        $equipments = Equipment::all();
        $researcher = Researcher::findOrFail($id);
        // dd($researcher);
        $project = $researcher->project_id;

        $grants = Grant::all();
        $grant = $grants->find($project);
        return view('researcher.equipments', compact('equipments' , 'researcher', 'grants'));
    }
    
    public function index_lab_manager($id){
        $equipments = Equipment::all();
        return view('lab_manager.equipment', ['equipments' => $equipments, 'lab_manager_id' => $id]);
    }

    // Add Equipment
    public function store(Request $request, $id)
{
    $validated = $request->validate([
        'name'              => 'required|string|max:255',
        'category'          => 'required|string',
        'price'             => 'nullable|numeric|min:0',
        'needs_supervision' => 'nullable|boolean',
        'sec_eq_id'         => 'nullable|string|max:255',
        'required_role'     => 'nullable|string|max:255',
        'certification_name'=> 'nullable|string|max:255',
        'status'            => 'required|in:available,offline,maintenance'
    ]);

    $equipment = Equipment::create([
        'name'              => $validated['name'],
        'category'          => $validated['category'],
        'price'             => $validated['price'] ?? 0,
        'is_special'        => $request->has('needs_supervision'),
        'sec_eq_id'         => $validated['sec_eq_id'] ?? null,
        'required_role'     => $validated['required_role'] ?? null,
        'status'            => $validated['status'],
        'max_hours'         => 0,
        'used_hours'        => 0,
        'maintenance_times' => 0,
    ]);

    if (!empty($validated['certification_name'])) {
        Certification::create([
            'name'  => $validated['certification_name'],
            'eq_id' => $equipment->eq_id,
        ]);
    }

    return redirect()->route('lab_manager.equipments', ['id' => $id])
        ->with('success', 'Equipment added successfully.');
}

    // Update Equipment
    public function update(Request $request, $id){
        $equipment = Equipment::findOrFail($id);

        $validated = $request->validate([
            'status' => 'required|in:available,in-use,maintenance,locked-out,offline',
            'price' => 'nullable|numeric|min:0',
            'max_hours' => 'nullable|numeric|min:0'
        ]);

        $equipment->update([
            'status' => $validated['status'],
            'price' => $validated['price'] ?? $equipment->price,
            'max_hours' => $validated['max_hours'] ?? $equipment->max_hours
        ]);

        return redirect()->back()->with('success', 'Equipment updated successfully!');
    }

    // Delete Equipment
    public function destroy($id){
        $equipment = Equipment::findOrFail($id);
        $equipment->delete();
        
        return redirect()->back()->with('success', 'Equipment removed successfully!');
    }

    // Get lab manager ID for view context
    private function getLabManagerId()
    {
        return auth()->id();
    }

    // Report Accident/Incident
    public function reportAccident(Request $request, $eq_id){
        $equipment = Equipment::findOrFail($eq_id);

        $validated = $request->validate([
            'researcher_id' => 'required|string|max:255',
            'description' => 'required|string|min:10'
        ]);

        // Store incident report
        Report::create([
            'eq_id' => $eq_id,
            'researcher_id' => $validated['researcher_id'],
            'description' => $validated['description'],
            'date' => now()->toDateString(),
            'lab_man_id' => auth()->id() // Get current authenticated lab manager
        ]);

        return redirect()->back()->with('success', 'Report submitted successfully!');
    }
}