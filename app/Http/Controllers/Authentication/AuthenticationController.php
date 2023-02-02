<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

use function GuzzleHttp\Promise\all;

class AuthenticationController extends Controller
{
    public function index()
    {
        return view('landingpage.index');
    }
    public function login()
    {
        return view('authenticate.login');
    }
    public function signup()
    {
        return view('authenticate.signup');
    }
    public function post_signup(Request $request)
    {
        $request->validate(
            [
                'first_name' => 'required|string|max:254',
                'last_name' => 'required|string|max:254',
                'email' => 'required|string|max:254|unique:users',
                'role' => 'required',
                'password' => 'required|string|min:8',
            ],
            [
                'role.required' => 'Role is required...',

                'password.required' => 'Password is required...',
                'password.string' => 'Password must be a type of string...',
                'password.min' => 'Password must be equal to 8 characters...',

                'first_name.required' => 'First Name is required...',
                'first_name.string' => 'First Name must be a type of string...',
                'first_name.max' => 'First Name must be less then 254 characters...',

                'last_name.required' => 'Last Name is required...',
                'last_name.string' => 'Last Name must be a type of string...',
                'last_name.max' => 'Last Name must be less then 254 characters...',

                'email.required' => 'Email is required...',
                'email.string' => 'Email must be a type of string...',
                'email.max' => 'Email must be less then 254 characters...',

            ]
        );
        $user = new User();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = Hash::make($request->password);
        $user->save();
        if ($user == true) {
            return redirect()->route('login')->with('success', 'Account Created Successfully');
        }
    }
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::guard('web')->attempt($credentials)) {
            if (Auth::user()->role == 'Candidate') {
                return redirect()->route('candidate.dashboard')->with('success', 'Welcome Back' . ' ' . Auth::user()->first_name . ' ' . Auth::user()->last_name);
            } else {
                Auth::logout();
                return redirect()->route('login')->with('error', 'User role is Invalid!');
            }
        }
        return redirect()->back()->with('error', 'Email or Password is Invalid!');
    }
    public function Logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('login')->with('error', 'Session Expired!');
    }
}
