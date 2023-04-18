<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\City;
use App\Models\JobSkill;
use App\Models\JobType;
use App\Models\Language;
use App\Models\LanguageUserSpeak;
use App\Models\PostJob;
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
    public function changePassword()
    {
        return view('authenticate.changePassword');
    }

    public function profile()
    {
        $userData = User::where('id', Auth::user()->id)->first();
        $activatedSkills = Skills::where('user_id', Auth::user()->id)->first();
        $jobSkills = JobSkill::with('skills')->orderBy('name')->get();
        $cities = City::orderBy('name')->get();
        $language = Language::orderBy('name')->get();
        $skills = Skills::where('user_id', Auth::user()->id)->orderBy('name')->get();
        $languageUser = LanguageUserSpeak::where('user_id', Auth::user()->id)->orderBy('name')->get();
        return view('authenticate.profile', compact('skills', 'languageUser', 'jobSkills', 'cities', 'language', 'activatedSkills', 'userData'));
    }
    public function completeprofile()
    {
        if (Auth::user()->profile == 1) {
            return redirect()->route('candidate.dashboard')->with('error', 'Profile already updated. Thank you!');
        } else {
            $jobSkills = JobSkill::orderBy('name')->get();
            $cities = City::orderBy('name')->get();
            $language = Language::orderBy('name')->get();
            return view('authenticate.completeProfile', compact('jobSkills', 'cities', 'language'));
        }
    }
    public function postcompleteprofile(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        $skills = $request->skills;
        $language = $request->language;
        foreach ($skills as $key => $value) {
            $skill = new Skills();
            $skill->user_id = $user->id;
            $skill->name = $value;
            $skill->save();
        }
        foreach ($language as $key => $value) {
            $skill = new LanguageUserSpeak();
            $skill->user_id = $user->id;
            $skill->name = $value;
            $skill->save();
        }
        $user->about_me = $request->about_me;
        $user->designation = $request->designation;
        $user->experience = $request->experience;
        $user->availability = $request->availability;
        $user->age = $request->age;
        $user->profile = 1;
        $user->location = $request->location;
        $user->save();
        return redirect()->route('candidate.dashboard')->with('success', 'Profile updated successfully!');
    }
    public function updateProfile(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        if ($request->first_name == true) {
            $user->first_name = $request->first_name;
        }
        if ($request->last_name == true) {
            $user->last_name = $request->last_name;
        }
        if ($request->about_me == true) {
            $user->about_me = $request->about_me;
        }
        if ($request->designation == true) {
            $user->designation = $request->designation;
        }
        if ($request->experience == true) {
            $user->experience = $request->experience;
        }
        if ($request->availability == true) {
            $user->availability = $request->availability;
        }
        if ($request->age == true) {
            $user->age = $request->age;
        }
        if ($request->location == true) {
            $user->location = $request->location;
        }
        $user->save();
        return redirect()->route('candidate.profile')->with('success', 'Profile updated successfully!');
    }
    public function allJobs()
    {
        $skills = JobSkill::get();
        return view('candidate.job.allJobs', compact('skills'));
    }
    public function listallJobs(Request $request)
    {
        if ($request->page == null) {
            $loadmore = "?page=2";
        } else {
            $loadmore = "?page=" . $request->page + 1;
        }
        $PostJob = PostJob::where('status', 1)->with('Users')->with('Skills')->inRandomOrder()->orderBy('id', 'desc')->paginate(16);
        $category = Category::orderBy('name')->get();
        $job_type = JobType::get();
        $location = City::orderBy('name')->get();
        $skill = JobSkill::get();
        return view('candidate.job.listallJobs', compact('PostJob', 'request', 'loadmore', 'category', 'job_type', 'location', 'skill'));
    }
    public function listallJobsBySkills(Request $request, $skills)
    {
        $appliedSkill = $skills;
        if ($request->page == null) {
            $loadmore = "?page=2";
        } else {
            $loadmore = "?page=" . $request->page + 1;
        }
        $search = $request['search'] ?? '';
        $PostJob = PostJob::where('status', 1)->where('skills', $appliedSkill)->with('Users')->with('Skills')->inRandomOrder()->orderBy('id', 'desc')->paginate(16);
        $category = Category::orderBy('name')->get();
        $job_type = JobType::get();
        $location = City::orderBy('name')->get();
        $skill = JobSkill::get();
        return view('candidate.job.listallJobs', compact('PostJob', 'request', 'loadmore', 'category', 'job_type', 'location', 'skill', 'appliedSkill'));
    }
    public function jobSearch(Request $request)
    {
        if ($request->page == null) {
            $loadmore = "?page=2";
        } else {
            $loadmore = "?page=" . $request->page + 1;
        }
        $search = $request['search'] ?? '';
        $PostJob = PostJob::where('status', 1)->where('title', 'LIKE', "%{$search}%")->with('Users')->with('Skills')->inRandomOrder()->orderBy('id', 'desc')->paginate(16);
        $category = Category::orderBy('name')->get();
        $job_type = JobType::get();
        $location = City::orderBy('name')->get();
        $skill = JobSkill::get();
        return view('candidate.job.listallJobs', compact('PostJob', 'request', 'loadmore', 'category', 'job_type', 'location', 'skill'));
    }
    public function jobSearchFilter(Request $request)
    {
        if ($request->page == null) {
            $loadmore = "?page=2";
        } else {
            $loadmore = "?page=" . $request->page + 1;
        }
        $appliedSkill = $request->skills;
        $PostJob = PostJob::where('status', 1)->where('experience', 'LIKE', "%{$request->experience}%")->where('skills', 'LIKE', "%{$request->skills}%")->where('job_type', 'LIKE', "%{$request->job_type}%")->where('location', 'LIKE', "%{$request->location}%")->where('gender', 'LIKE', "%{$request->gender}%")->with('Users')->with('Skills')->orderBy('id', 'desc')->paginate(16);
        $category = Category::orderBy('name')->get();
        $job_type = JobType::get();
        $location = City::orderBy('name')->get();
        $skill = JobSkill::get();
        return view('candidate.job.listallJobs', compact('PostJob', 'request', 'loadmore', 'category', 'job_type', 'location', 'skill', 'appliedSkill'));
    }
}
