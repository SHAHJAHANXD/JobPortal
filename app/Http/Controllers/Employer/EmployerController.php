<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\appliedjob;
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
use Illuminate\Support\Str;

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
        $userData = User::where('id', Auth::user()->id)->first();
        return view('authenticate.profile', compact('userData'));
    }
    public function postNewJob()
    {
        $category = Category::get();
        $type = JobType::get();
        $location = City::get();
        $Skills = JobSkill::get();
        return view('employer.job.postJob', compact('category', 'type', 'location', 'Skills'));
    }
    public function updateProfile(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        $user->update($request->all());
        return redirect()->route('employer.profile')->with('success', 'Profile updated successfully!');
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
        $request->validate(
            [
                'c_image' => 'required|file|mimes:gif,png,jpg,jpeg|max:5120',
            ]
        );
        $user = User::where('id', Auth::user()->id)->first();
        $data = $request->all();
        if ($request->hasfile('c_image')) {
            $imageName = $request->c_image->getClientOriginalName();
            $data['c_image'] = $imageName;
            $request->c_image->move(public_path('c_image'), $imageName);
        }
        $user->update($data);
        if (Auth::user()->role == 'Candidate') {
            return redirect()->route('candidate.dashboard')->with('success', "Profile updated successfully!");
        }
        if (Auth::user()->role == 'Admin') {
            return redirect()->route('admin.dashboard')->with('success', "Profile updated successfully!");
        }
        if (Auth::user()->role == 'Employer') {
            return redirect()->route('employer.dashboard')->with('success', "Profile updated successfully!");
        }
    }
    public function postJob(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|max:255',
                'skills' => 'required',
                'status' => 'required',
                'desc' => 'required',
                'gender' => 'required',
                'experience' => 'required',
                'category' => 'required',
                'job_type' => 'required',
                'recruitments' => 'required',
                'location' => 'required',
            ]
        );
        $data = $request->all();
        $data['slug'] =  Str::slug($request->title);
        $data['user_id'] = Auth::user()->id;
        $job = PostJob::create($data);
        if ($job == true) {
            return redirect()->route('employer.listAllJobs')->with('success', 'Job Created Successfully!');
        }
    }
    public function postEditJob(Request $request)
    {
        $request->validate(
            [
                'title' => 'required|max:255',
                'skills' => 'required',
                'status' => 'required',
                'desc' => 'required',
                'gender' => 'required',
                'experience' => 'required',
                'category' => 'required',
                'job_type' => 'required',
                'recruitments' => 'required',
                'location' => 'required',
            ]
        );
        $job = PostJob::where('id', $request->id)->first();
        $data = $request->all();
        $data['slug'] =  Str::slug($request->title);
        $data['user_id'] = Auth::user()->id;
        $job = $job->update($data);
        if ($job == true) {
            return redirect()->route('employer.listAllJobs')->with('success', 'Job Updated Successfully!');
        }
    }

    public function listAllJobs()
    {
        $all_jobs = PostJob::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->get();
        return view('employer.job.listJob', compact('all_jobs'));
    }
    public function editJob($id)
    {
        $category = Category::get();
        $type = JobType::get();
        $location = City::get();
        $Skills = JobSkill::get();
        $job = PostJob::where('id', $id)->first();
        return view('employer.job.editJob', compact('job', 'id', 'category', 'type', 'location', 'Skills'));
    }
    public function deleteJob($id)
    {
        PostJob::where('id', $id)->delete();
        return redirect()->route('employer.listAllJobs')->with('success', 'Job deleted successfully!');
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
    public function appliedJobs()
    {
        $auth_id = Auth::user()->id;
        $all_jobs = appliedjob::where('employer_id', $auth_id)->with('PostJobs')->with('user')->orderBy('id', 'desc')->get();
        return view('employer.job.AppliedListJobs', compact('all_jobs'));
    }
}
