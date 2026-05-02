<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\FinancialDepartment;
use App\Models\Researcher;
use Illuminate\Http\Request;

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
    public function LoginUser(Request $request){
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);
        $user = User::where('username', $request->username)->first();
        if (!$user || $user->password !== $request->password) {
            dd('Invalid username or password');
        }
        dd('Login successful for user: ' . $user->username);
    }
}
