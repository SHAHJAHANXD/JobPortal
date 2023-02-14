<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Skills;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CandidateDashboardController extends Controller
{
    public function dashboard()
    {
        return view('candidate.index.index');
    }
    public function profile()
    {
        $skills = Skills::where('user_id' , Auth::user()->id)->get();
        return view('authenticate.profile', compact('skills'));
    }
    public function completeprofile()
    {
        if (Auth::user()->profile == 1) {
            return redirect()->route('candidate.dashboard')->with('error', 'Profile already updated. Thank you!');
        } else {
            return view('authenticate.completeProfile');
        }
    }
    public function postcompleteprofile(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        $skills = $request->skills;
        foreach ($skills as $key => $value) {
            $skill = new Skills();
            $skill->user_id = $user->id;
            $skill->skills = $value;
            $skill->save();
        }

        $user->about_me = $request->about_me;
        $user->designation = $request->designation;
        $user->experience = $request->experience;
        $user->availability = $request->availability;
        $user->age = $request->age;
        $user->profile = 1;
        $user->location = $request->location;
        $user->language = $request->language;
        $user->save();
        return redirect()->route('candidate.dashboard')->with('success', 'Profile updated successfully!');
    }
}
