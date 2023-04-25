<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use App\Models\appliedjob;
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
        $applied_jobs = appliedjob::where('candidate_id' , Auth::user()->id)->count();
        return view('candidate.index.index', compact('applied_jobs'));
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
        $user->wa_no = $request->wa_no;
        $user->profile = 1;
        $user->location = $request->location;
        $user->save();
        return redirect()->route('candidate.dashboard')->with('success', 'Profile updated successfully!');
    }
    public function updateProfile(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        $user->update($request->all());
        return redirect()->route('candidate.profile')->with('success', 'Profile updated successfully!');
    }
    public function allJobs()
    {
        $skills = JobSkill::orderBy('name')->get();
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
    public function jobDetails($id)
    {
        $PostJob = PostJob::where('status', 1)->where('id', $id)->with('Skills')->first();
        return view('candidate.job.jobDetails', compact('PostJob'));
    }
    public function jobDetailsToApply($id)
    {
        $PostJob = PostJob::where('status', 1)->where('id', $id)->with('Skills')->first();
        return view('candidate.job.jobDetailsToApply', compact('PostJob'));
    }
    public function jobToApply(Request $request)
    {
        $request->validate(
            [
                'cv' => 'required|file|mimes:ppt,pptx,doc,docx,pdf,xls,xlsx|max:5120',
                'cover_letter' => 'required|max:255',
            ]
        );
        $auth_id = Auth::user()->id;
        $data = $request->all();
        $jobSkills = PostJob::where('id', $request->job_id)->first();
        $count = appliedjob::where('employer_id', $request->employer_id)->where('job_id', $request->job_id)->where('candidate_id', $auth_id)->count();
        if ($count > 0) {
            return redirect()->route('candidate.listallJobsBySkills', $jobSkills->skills)->with('error', 'You have already applied the job. Thank You!');
        }
        if ($request->hasfile('cv')) {
            $imageName = $request->cv->getClientOriginalName();
            $data['cv'] = $imageName;
            $request->cv->move(public_path('cv'), $imageName);
        }
        $data['candidate_id'] = $auth_id;
        $job = appliedjob::create($data);


        if ($job == true) {
            return redirect()->route('candidate.listallJobsBySkills', $jobSkills->skills)->with('success', 'You have successfully applied for the job. The employer will contact you soon. Thank You!');
        }
    }
    public function appliedJobs()
    {
        $auth_id = Auth::user()->id;
        $all_jobs = appliedjob::where('candidate_id', $auth_id)->with('PostJobs')->with('user')->orderBy('id', 'desc')->get();
        return view('candidate.job.AppliedListJobs', compact('all_jobs'));
    }
}
