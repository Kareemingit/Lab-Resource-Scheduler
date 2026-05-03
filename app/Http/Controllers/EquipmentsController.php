<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\Grant;
use App\Models\Researcher;

class EquipmentsController extends Controller
{
    public function index($id){
        $equipments = Equipment::all();
        $researcher = Researcher::findOrFail($id);
        $project = $researcher->project_id;
        $grants = Grant::where('project_id', $project)->get();
        return view('researcher.equipments', compact('equipments' , 'researcher', 'grants'));
    }
}