<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifyUser
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
        // if (Auth::check() && (Auth::user()->email_status == '0')) {
        //     return redirect()->route('teacher.verify.email')->with('error', 'Verify Your Email!');
        // }
        if (Auth::check() && (Auth::user()->role == 'Candidate')) {
            return $next($request);
        } else {
            return redirect()->back();
        }
    }
}
