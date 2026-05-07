<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FinancialDepartment;
use App\Models\Project;
use App\Models\Researcher;
use App\Models\Certification;
use App\Models\Grant;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
            'password' => Hash::make($request->password),
            'role' => $request->role
        ]);
        $userid = $user->user_id;
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

    public function AddCertification(Request $request){
        $validatedData = $request->validate([
            'certification' => 'required|exists:certifications,cert_id',
            'user_id' => 'required|exists:user_infos,user_id'
        ]);
        $researcher_id = $validatedData['user_id'];
        $cert_id = $validatedData['certification'];
        DB::table('certification_researcher')->insert([
            'researcher_id' => $researcher_id,
            'cert_id' => $cert_id,
            'expiry_date' => Carbon::now()->addYears(1)
        ]);
        $user = User::where('user_id', $researcher_id)->first();
        $researcher = Researcher::findOrFail($researcher_id);
        $AllCertifications = Certification::all();
        $researcherCertifications = DB::table('certification_researcher')
            ->join('certifications', 'certification_researcher.cert_id', '=', 'certifications.cert_id')
            ->where('certification_researcher.researcher_id', $researcher_id)
            ->select('certifications.name')
            ->get();
        return redirect()->route('researcher.profile', 
        [
            'id' => $researcher_id,
            'researcher' => $researcher , 
            'user' => $user, 
            'certifications' => $AllCertifications,
            'researcherCertifications' => $researcherCertifications
        ])->with('success', 'Certification added successfully.');
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

    public function FinancialDepartmentShowProjects($id){
        $financialDepartment = FinancialDepartment::where('user_id', $id)->first();
        $projects = Project::all();
        $grants = Grant::all();
        return view('financial_department.projects', [
            'user' => $financialDepartment , 
            'projects' => $projects , 
            'grants' => $grants
        ]);
    }

    public function UpdateBudget(Request $request, $id){
        $financialDepartment = FinancialDepartment::where('user_id', $id)->first();
        if ($financialDepartment) {
            $financialDepartment->budget += $request->amount;
            $financialDepartment->save();
            $projects = Project::all();
            $grants = Grant::where('financial_id', $id)->get();
            return redirect()->route('financial_department.projects', [
                'id' => $id,
                'user' => $financialDepartment, 
                'projects' => $projects , 
                'grants' => $grants
            ])->with('success', 'Budget updated successfully.');
        } else {
            return redirect()->route('financial_department.projects', ['id' => $id])->with('error', 'Financial department or grant not found.');
        }
    }

    public function LoginUser(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        $user = User::where('username', $request->username)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            dd('Invalid username or password');
        }

        session([
            'user_id' => $user->user_id,
            'role'    => $user->role
        ]);

        if($user->role == 'researcher'){
            $researcher = Researcher::findOrFail($user->user_id);
            $project = Project::where('project_id', $researcher->project_id)->first();
            return redirect()->route('researcher.home', ['id' => $researcher->user_id , 'project' => $project ?? null]);
        } else if($user->role == 'financial_department'){
            $projects = Project::all();
            $grants = Grant::where('financial_id', $user->user_id)->get();
            $financialDepartment = FinancialDepartment::where('user_id', $user->user_id)->first();
            return redirect()->route('financial_department.projects' , [
                'id' => $user->user_id,
                'user' => $financialDepartment, 
                'projects' => $projects , 
                'grants' => $grants
            ]);
        } else if ($user->role == 'admin'){
            return redirect()->route('admin.analytics' , ['id' => $user->user_id , 'user' => $user]);
        } else if ($user->role == 'lab_manager'){
            return redirect()->route('lab_manager.equipments', ['id' => $user->user_id]);
        } else if ($user->role == 'supervisor'){
            //return redirect()->route('supervisor.home');
        } else if ($user->role == 'pi'){
            //return redirect()->route('pi.home');
        }
    }

    public function LogoutUser(Request $request){
        session()->forget(['user_id', 'role']);
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login.view')->with('success', 'You have been logged out.');
    }
    // Lab Manager Profile Methods
    public function LabManagerShowProfile($id){
        $user = User::findOrFail($id);
        return view('lab_manager.profile', ['user' => $user]);
    }

    public function UpdateLabManagerProfile(Request $request, $id){
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:user_infos,username,' . $id . ',user_id'
        ]);

        $user->update([
            'name' => $validated['name'],
            'username' => $validated['username']
        ]);

        return redirect()->route('lab_manager.profile', ['id' => $id])
            ->with('success', 'Profile updated successfully.');
    }

    public function UpdateLabManagerPassword(Request $request, $id){
        $user = User::findOrFail($id);
        
        $validated = $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:12|confirmed'
        ]);

        if (!Hash::check($validated['current_password'], $user->password)) {
            return redirect()->back()->with('error', 'Current password is incorrect.');
        }

        $user->update([
            'password' => Hash::make($validated['new_password'])
        ]);

        return redirect()->route('lab_manager.profile', ['id' => $id])
            ->with('success', 'Password updated successfully.');
    }
    //admin
    public function AdminShowAnalytics($id){
        $user = User::findOrFail($id);
        return view('admin.analytics' , ['user' => $user]);
    }

    public function AdminShowUsers(Request $request ,$id){
        $user = User::findOrFail($id);
        $query = User::query();

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'LIKE', "%{$search}%")
                ->orWhere('username', 'LIKE', "%{$search}%")
                ->orWhere('role', 'LIKE', "%{$search}%");
        }

        $users = $query->get();
        $researchers = User::where('role', 'researcher')->get();

        return view('admin.users', [
            'user' => $user,
            'users' => $users,
            'researchers' => $researchers,
            'id' => $id
        ]);
    }

    public function AdminShowProfile($id){
        $user = User::where('user_id', $id)->first();
        return view('admin.profile' , ['user' => $user]);
    }
}