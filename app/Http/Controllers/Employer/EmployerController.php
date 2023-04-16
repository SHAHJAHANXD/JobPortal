<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\JobSkill;
use App\Models\JobType;
use App\Models\Language as ModelsLanguage;
use App\Models\LanguageUserSpeak;
use App\Models\PostJob;
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
        $category = Category::get();
        $type = JobType::get();
        $location = City::get();
        $Skills = JobSkill::get();
        return view('employer.job.postJob', compact('category', 'type', 'location','Skills'));
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
        $user->c_website = $request->c_website;
        $user->c_revenue = $request->c_revenue;
        $user->c_location = $request->c_location;
        $user->save();
        return redirect()->route('candidate.dashboard')->with('success', 'Profile updated successfully!');
    }
    public function postJob(Request $request)
    {
        $data = $request->all();
        $data['user_id'] = Auth::user()->id;
        $job = PostJob::create($data);
        if ($job == true) {
            return redirect()->route('employer.listAllJobs')->with('success', 'Job Created Successfully!');
        }
    }
    public function listAllJobs()
    {
        $all_jobs = PostJob::where('user_id', Auth::user()->id)->get();
        return view('employer.job.listJob', compact('all_jobs'));
    }
    public function ActivateJob($id)
    {
        PostJob::where('id', $id)->update(['status' => 1]);
        return redirect()->back()->with('success', 'Job Published Successfully!');
    }
    public function BlockJob($id)
    {
        PostJob::where('id', $id)->update(['status' => 0]);
        return redirect()->back()->with('success', 'Job Blocked Successfully!');
    }
}
