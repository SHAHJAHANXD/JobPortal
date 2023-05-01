<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\GotVerifiedMail;
use App\Mail\UserVerifyMail;
use App\Models\Category;
use App\Models\City;
use App\Models\HomePageSetting;
use App\Models\JobSkill;
use App\Models\JobType;
use App\Models\LanguageUserSpeak;
use App\Models\PostJob;
use App\Models\Skills;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class AdminCotroller extends Controller
{
    public function dashboard()
    {
        try {
            $employer = User::where('role','Employer')->count();
            $candidate = User::where('role','Candidate')->count();
            $jobs = PostJob::where('status' , 1)->count();
            return view('admin.index.index', compact('employer','candidate','jobs'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function jobListing()
    {
        $all_jobs = PostJob::with('Users')->get();
        return view('admin.Jobs.listing', compact('all_jobs'));
    }
    public function profile()
    {
        try {
            $userData = User::where('id', Auth::user()->id)->first();
            return view('authenticate.profile', compact('userData'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function AllCandidates()
    {
        try {
            $user = User::where('role', 'Candidate')->get();
            return view('admin.users.index', compact('user'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function AllEmployers()
    {
        try {
            $user = User::where('role', 'Employer')->get();
            return view('admin.users.index', compact('user'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function ActivateEmployerAccount($id)
    {
        try {
            $user = User::where('id', $id)->first();
            if ($user->account_status == 1) {
                return redirect()->back()->with('success', 'Account approved successfully!');
            } else {
                User::where('id', $id)->update(['account_status' => 1]);
                $user = ['name' => $user->first_name . ' ' . $user->last_name, 'email' => $user->email];
                Mail::to($user['email'])->queue(new UserVerifyMail($user));
                return redirect()->back()->with('success', 'Account approved successfully!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function ActivateEmployerAccountEmail($id)
    {
        try {
            $user = User::where('id', $id)->first();
            if ($user->account_status == 1) {
                return view('admin.users.verified', compact('id'));
            } else {
                User::where('id', $id)->update(['account_status' => 1]);
                $user_info = User::where('id', $id)->first();
                $user = ['name' => $user_info->first_name . ' ' . $user_info->last_name, 'email' => $user_info->email];
                Mail::to($user['email'])->queue(new GotVerifiedMail($user));
                return view('admin.users.verified', compact('id'));
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function BlockEmployerAccount($id)
    {
        try {
            User::where('id', $id)->update(['account_status' => 0]);
            return redirect()->back()->with('success', 'Account rejected successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function autocomplete(Request $request)
    {
        try {
            $data = [];

            if ($request->filled('q')) {
                $data = JobSkill::select("name", "id")
                    ->where('name', 'LIKE', '%' . $request->get('q') . '%')
                    ->get();
            }
            return response()->json($data);
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function envEdit()
    {
        return view('admin.env.edit');
    }
    public function envPostEdit(Request $request)
    {
        $env_val['APP_URL'] = $request->APP_URL;

        $env_val['ADMIN_EMAIL'] = $request->ADMIN_EMAIL;
        $env_val['MAIL_MAILER'] = $request->MAIL_MAILER;
        $env_val['MAIL_HOST'] = $request->MAIL_HOST;
        $env_val['MAIL_PORT'] = $request->MAIL_PORT;
        $env_val['MAIL_USERNAME'] = $request->MAIL_USERNAME;
        $env_val['MAIL_PASSWORD'] = $request->MAIL_PASSWORD;
        $env_val['MAIL_ENCRYPTION'] = $request->MAIL_ENCRYPTION;
        $env_val['MAIL_FROM_ADDRESS'] = $request->MAIL_FROM_ADDRESS;

        $env_val['GOOGLE_CLIENT_SECRET'] = $request->GOOGLE_CLIENT_SECRET;
        $env_val['GOOGLE_CLIENT_ID'] = $request->GOOGLE_CLIENT_ID;
        $env_val['GOOGLE_CLIENT_CALL_BACK_URL'] = $request->GOOGLE_CLIENT_CALL_BACK_URL;

        $update = $this->setEnvValue($env_val);
        if ($update == true) {
            return redirect()->back()->with('success', __('Successfully updated!'));
        }
        return redirect()->back()->with('error', __('Something went wrong!'));
    }
    public function setEnvValue($values)
    {
        $envFile = app()->environmentFilePath();
        $str = file_get_contents($envFile);
        if (count($values) > 0) {
            foreach ($values as $envKey => $envValue) {
                $str .= "\n";
                $keyPosition = strpos($str, "{$envKey}=");
                $endOfLinePosition = strpos($str, "\n", $keyPosition);
                $oldLine = substr($str, $keyPosition, $endOfLinePosition - $keyPosition);

                if (!$keyPosition || !$endOfLinePosition || !$oldLine) {
                    $str .= "{$envKey}={$envValue}\n";
                } else {
                    $str = str_replace($oldLine, "{$envKey}={$envValue}", $str);
                }
            }
        }
        $str = substr($str, 0, -1);
        if (!file_put_contents($envFile, $str)) return false;
        return true;
    }
    public function edit()
    {
        $HomePageSetting = HomePageSetting::where('id', 1)->first();
        return view('admin.HomePageSetting.edit', compact('HomePageSetting'));
    }
    public function postEdit(Request $request)
    {
        $HomePageSetting = HomePageSetting::where('id', 1)->first();
        try {
            DB::beginTransaction();
            if ($HomePageSetting) {
                $HomePageSetting->update($request->all());
            }
            DB::commit();
            return redirect()->back()->with('success', 'Record updated successfully!');
        } catch (Exception $e) {
            DB::rollback();
            DB::commit();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function testEmail()
    {
        $email_data = ['email' => env('ADMIN_EMAIL')];
        Mail::send(
            'emails.testEmail',
            $email_data,
            function ($message) use ($email_data) {
                $message->to($email_data['email'])->subject('Cybinix Job Portal | Test Email');
            }
        );
        return redirect()->back()->with('success', 'Email set successfully!');
    }
    public function updateProfile(Request $request)
    {
        $user = User::where('id', Auth::user()->id)->first();
        $user->update($request->all());
        return redirect()->route('admin.profile')->with('success', 'Profile updated successfully!');
    }
    public function editJob($id)
    {
        $category = Category::get();
        $type = JobType::get();
        $location = City::get();
        $Skills = JobSkill::get();
        $job = PostJob::where('id', $id)->first();
        return view('admin.Jobs.edit', compact('job', 'id', 'category', 'type', 'location', 'Skills'));
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
            return redirect()->route('jobListing.get')->with('success', 'Job Updated Successfully!');
        }
    }
    public function ActivateJob($id)
    {
        PostJob::where('id', $id)->update(['status' => 1]);
        return redirect()->back()->with('success', 'Job Published Successfully!');
    }
    public function BlockJob($id)
    {
        PostJob::where('id', $id)->update(['status' => 0]);
        return redirect()->back()->with('success', 'Job Drafted Successfully!');
    }
    public function deleteJob($id)
    {
        PostJob::where('id', $id)->delete();
        return redirect()->back()->with('success', 'Job deleted successfully!');
    }
    public function UpdateAccountStatus($id)
    {
        $user = User::where('id', $id)->first();
        if ($user->status == '0') {
            $status = '1';
        } else {
            $status = '0';
        }
        $user = $user->update(['status' => $status]);
        return redirect()->back()->with('success', 'Account Status Updated Successfully!');
    }
}
