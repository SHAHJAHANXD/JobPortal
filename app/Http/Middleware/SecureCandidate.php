<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SecureCandidate
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
        if (Auth::check() && (Auth::user()->role == 'Candidate')) {
            if ($user->about_me == null || $user->availability == null || $user->experience == null || $user->age == null || $user->location == null || $user->designation == null || $user->wa_no == null) {
                return redirect()->route('candidate.completeprofile')->with('error', 'Complete your Profile First');
            } else {
                return $next($request);
            }
        } else {
            return redirect()->back()->with('error', 'User role is Invalid!');
        }
    }
}
