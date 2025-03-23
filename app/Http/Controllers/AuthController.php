<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class AuthController extends Controller
{
    public function index(){
        return view('index');
    }
    public function login(){
        return view('login');
    }
    public function regView(){
        return view('reg');
    }
    public function checkUser(){
        return view('check-state-uni');
    }

    public function checkUserForm(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'gender' => 'required',
            'university' => 'required',
            'field_of_study' => 'required',
            'year_of_study' => 'required',
            'district_of_residence' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // You can process the data here (e.g., save to the database)
        return response()->json(['success' => 'Form submitted successfully!']);
    }

    public function regAction(Request $request){
        User::create([
           'username'=>$request->user,
            'password'=>Hash::make($request->pass)
        ]);
        $user=User::where('username',$request->user)->first();
        UserRole::create([
            'user_id'=>$user->id,
            'role_name'=>'user'
        ]);
        return redirect()->route('login.view');
    }

    public function loginAction(Request $request){
        $user=User::where('username',$request->user)->first();
        if (isset($user)){
            if($request->user==$user->username){
                if(Hash::check($request->pass,$user->password)){
                    $request->session()->put('user_id',$user->id);
                    return redirect()->route('dashboard.view')->with('msg','Successfully Logged in!');
                }
                else{
                    return redirect()->route('login.view')->with('error','Wrong Password');
                }
            }
        }
        else{
            return redirect()->route('login.view')->with('error','User not found');
        }
    }

    public function dashboardView(){
        return view('dashboard');
    }
    public function adminDashboardView(){
        return view('admin-dashboard');
    }

    public function logout(){
        session()->forget('user');
        return redirect()->route('login.view');
    }
}
