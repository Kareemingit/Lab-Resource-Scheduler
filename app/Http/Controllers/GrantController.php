<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grant;
use App\Models\FinancialDepartment;
use App\Models\Project;
use Illuminate\Support\Facades\DB;

class GrantController extends Controller
{
    public function store(Request $request){
        // Use a transaction to ensure data integrity
        DB::beginTransaction();

        try {
            $fd = FinancialDepartment::where('user_id', $request->user_id)->firstOrFail();
            $p = Project::where('project_id', $request->project_id)->firstOrFail();

            $amount = ($fd->budget) * (($request->percentage) / 100);

            $fd->budget -= $amount;
            $p->balance += $amount;
            $fd->save();
            $p->save();

            Grant::create([
                'end_date' => $request->end_date,
                'fund' => $amount,
                'project_id' => $request->project_id,
                'financial_id' => $request->user_id
            ]);

            DB::commit();
            return redirect()->route('financial_department.projects', ['id' => $request->user_id])
                            ->with('success', 'Grant created and budget allocated successfully.');

        } catch (\Exception $e) {
            DB::rollBack();
            // This will show you exactly what went wrong if it fails again
            return redirect()->back()->with('error', 'Error: ' . $e->getMessage());
        }
    }
}
