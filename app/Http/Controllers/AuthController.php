<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        return view('index');
    }
    public function login()
    {
        return view('login');
    }
    public function regView()
    {
        return view('reg');
    }
    public function checkUser()
    {
        return view('check-state-uni');
    }

    public function checkUserForm(Request $request)
    {
        $users = Session::get('users', []);

        $newUser = [
            'gender' => $request->gender,
            'university' => $request->university,
            'field_of_study' => $request->field_of_study,
            'year_of_study' => $request->year_of_study,
            'district_of_residence' => $request->district_of_residence,
        ];

        // Store updated array back in the session
        $users[] = $newUser;
        Session::put('users', $users);

        return response()->json([
            'success' => 'User Info stored successfully!',
            'redirect' => 'base-quiz/1'
        ]);
    }

    public function regAction(Request $request)
    {
        User::create([
            'username' => $request->user,
            'password' => Hash::make($request->pass)
        ]);
        $user = User::where('username', $request->user)->first();
        UserRole::create([
            'user_id' => $user->id,
            'role_name' => 'user'
        ]);
        return redirect()->route('login.view');
    }

    public function loginAction(Request $request)
    {
        $user = User::where('username', $request->user)->first();
        if (isset($user)) {
            if ($request->user == $user->username) {
                if (Hash::check($request->pass, $user->password)) {
                    $request->session()->put('user_id', $user->id);
                    return redirect()->route('dashboard.view')->with('msg', 'Successfully Logged in!');
                } else {
                    return redirect()->route('login.view')->with('error', 'Wrong Password');
                }
            }
        } else {
            return redirect()->route('login.view')->with('error', 'User not found');
        }
    }

    public function dashboardView()
    {
        return view('dashboard');
    }
    public function adminDashboardView()
    {
        return view('admin-dashboard');
    }

    public function logout()
    {
        session()->forget('user');
        return redirect()->route('login.view');
    }
}
