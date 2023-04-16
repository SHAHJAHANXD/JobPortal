<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\JobSkill;
use App\Models\Language as ModelsLanguage;
use App\Models\LanguageUserSpeak;
use App\Models\Skills;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use JetBrains\PhpStorm\Language;

class EmployerController extends Controller
{
    public function dashboard()
    {
        return view('employer.index.index');
    }
    public function profielApproved()
    {
        return view('authenticate.profileApproved');
    }
    public function profile()
    {
        $jobSkills = JobSkill::orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $language = ModelsLanguage::orderBy('name')->get();
        $skills = Skills::where('user_id', Auth::user()->id)->orderBy('skills')->get();
        $language = LanguageUserSpeak::where('user_id', Auth::user()->id)->orderBy('name')->get();
        return view('authenticate.profile', compact('skills', 'language'));
    }
    public function postNewJob()
    {
        return view('candidate.job.postJob');
    }
    public function completeprofile()
    {
        if (Auth::user()->profile == 1) {
            return redirect()->route('employer.dashboard')->with('error', 'Profile already updated. Thank you!');
        } else {
            $jobSkills = JobSkill::orderBy('name')->get();
            $cities = City::orderBy('name')->get();
            $all_cities = City::orderBy('name')->get();
            $language = ModelsLanguage::orderBy('name')->get();
            return view('authenticate.completeProfile', compact('jobSkills', 'cities', 'language', 'all_cities'));
        }
    }
    public function postcompleteprofile(Request $request)
    {
        // $table->string('c_name')->nullable();
        // $table->string('c_email')->nullable();
        // $table->string('c_position')->nullable();
        // $table->string('c_phone')->nullable();
        // $table->string('c_about_us')->nullable();
        // $table->string('c_image')->nullable();
        // $table->string('c_website')->nullable();
        // $table->string('c_revenue')->nullable();
        // $table->string('c_location')->nullable();
        $user = User::where('id', Auth::user()->id)->first();
        $user->about_me = $request->about_me;
        $user->designation = $request->designation;
        $user->experience = $request->experience;
        $user->availability = $request->availability;
        $user->age = $request->age;
        $user->profile = 1;
        $user->location = $request->location;

        $user->c_name = $request->c_name;
        $user->c_email = $request->c_email;
        $user->c_position = $request->c_position;
        $user->c_phone = $request->c_phone;
        $user->c_about_us = $request->c_about_us;
        // $user->c_image = $request->c_image;
        $user->c_website = $request->c_website;
        $user->c_revenue = $request->c_revenue;
        $user->c_location = $request->c_location;
        $user->save();
        return redirect()->route('candidate.dashboard')->with('success', 'Profile updated successfully!');
    }
}
