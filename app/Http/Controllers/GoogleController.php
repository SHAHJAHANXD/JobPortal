<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Exception;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();
            $finduser = User::where('email', $user->email)->first();
            if ($finduser) {
                Auth::login($finduser);
                if (Auth::user()->role == 'Candidate') {
                    return redirect()->route('candidate.dashboard')->with('success', 'Welcome Back' . ' ' . Auth::user()->first_name . ' ' . Auth::user()->last_name);
                } elseif (Auth::user()->role == 'Admin') {
                    return redirect()->route('admin.dashboard')->with('success', 'Welcome Back' . ' ' . Auth::user()->first_name . ' ' . Auth::user()->last_name);
                } elseif (Auth::user()->role == 'Employer') {
                    return redirect()->route('employer.dashboard')->with('success', 'Welcome Back' . ' ' . Auth::user()->first_name . ' ' . Auth::user()->last_name);
                } else {
                    Auth::logout();
                    return redirect()->route('login')->with('error', 'User role is Invalid!');
                }
            } else {
                return redirect()->route('login')->with('error', 'User account is not valid. Thank you!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
