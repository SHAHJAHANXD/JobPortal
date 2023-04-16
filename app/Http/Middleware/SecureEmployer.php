<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecureEmployer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */

    public function handle(Request $request, Closure $next)
    {
        $user = User::where('id', Auth::user()->id)->first();
        if (Auth::check() && (Auth::user()->role == 'Employer')) {
            if (
                $user->about_me == null
                || $user->availability == null
                || $user->experience == null
                || $user->age == null
                || $user->location == null
                || $user->designation == null
                || $user->c_name == null
                || $user->c_email == null
                || $user->c_about_us == null
                || $user->c_website == null
                || $user->c_revenue == null
                || $user->c_location == null
            ) {
                return redirect()->route('employer.completeprofile')->with('error', 'Complete your Profile First');
            }
            if (Auth::user()->account_status == 0) {
                return redirect()->route('employer.profielApproved')->with('error', 'Your profile is not aprroved yet. Thank you!');
            } else {
                return $next($request);
            }
        } else {
            return redirect()->back()->with('error', 'User role is Invalid!');
        }
        // if (Auth::check() && (Auth::user()->role == 'Employer')) {
        //     return $next($request);
        // } else {
        //     return redirect()->back()->with('error', 'User role is Invalid!');
        // }
    }
}
