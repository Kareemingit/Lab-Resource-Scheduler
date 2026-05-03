<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;
use App\Models\Researcher;

class EquipmentsController extends Controller
{
    public function index($id){
        $equipments = Equipment::all();
        $researcher = Researcher::findOrFail($id);
        return view('researcher.equipments', compact('equipments' , 'researcher'));
    }
}