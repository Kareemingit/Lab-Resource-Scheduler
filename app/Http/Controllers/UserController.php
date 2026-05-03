<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FinancialDepartment;
use App\Models\Project;
use App\Models\Researcher;
use App\Models\Certification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
//user module
class UserController extends Controller
{
    public function CreateUser(Request $request){
        $request->validate([
            'username' => 'required|unique:user_infos,username',
            'name' => 'required',
            'password' => 'required|min:12'
        ]);
        $user = User::create([
            'username' => $request->username,
            'name' => $request->name,
            'password' => $request->password,
            'role' => $request->role
        ]);
        $userid = $user->id;
        if($request->role == 'researcher'){
            Researcher::create([
                'user_id' => $userid
            ]);
            return redirect()->route('login.view');
        } else if($request->role == 'financial_department'){
            FinancialDepartment::create([
                'user_id' => $userid,
                'budget' => 0
            ]);
            return redirect()->route('login.view');
        } else if ($request->role == 'admin'){
            // No additional table for admin role
        } else if ($request->role == 'lab_manager'){
            // No additional table for lab manager role
        } else if ($request->role == 'supervisor'){
            // No additional table for supervisor role
        } else if ($request->role == 'pi'){
            // No additional table for pi role
        }
    }

    public function ResearcherShowHome($id){
        $researcher = Researcher::findOrFail($id);
        $project = Project::where('project_id', $researcher->project_id)->first();
        return view('researcher.home', ['researcher' => $researcher, 'project' => $project ?? null]);
    }

    public function ResearcherShowProfile($id){
        $user = User::where('user_id', $id)->first();
        $researcher = Researcher::findOrFail($id);
        $AllCertifications = Certification::all();
        $researcherCertifications = DB::table('certification_researcher')
            ->join('certifications', 'certification_researcher.cert_id', '=', 'certifications.cert_id')
            ->where('certification_researcher.researcher_id', $id)
            ->select('certifications.name')
            ->get();
        return view('researcher.profile', [
            'researcher' => $researcher , 
            'user' => $user, 
            'certifications' => $AllCertifications,
            'researcherCertifications' => $researcherCertifications
            ]);
    }

    public function LoginUser(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        $user = User::where('username', $request->username)->first();
        if (!$user || $user->password !== $request->password) {
            dd('Invalid username or password');
        }
        
        if($user->role == 'researcher'){
            $researcher = Researcher::findOrFail($user->user_id);
            $project = Project::where('project_id', $researcher->project_id)->first();
            return redirect()->route('researcher.home', ['id' => $researcher->user_id , 'project' => $project ?? null]);
        } else if($user->role == 'financial_department'){
            return view('financial_department.home' , ['user' => $user]);
        } else if ($user->role == 'admin'){
            //return redirect()->route('admin.home');
        } else if ($user->role == 'lab_manager'){
            //return redirect()->route('lab_manager.home');
        } else if ($user->role == 'supervisor'){
            //return redirect()->route('supervisor.home');
        } else if ($user->role == 'pi'){
            //return redirect()->route('pi.home');
        }
    }
}