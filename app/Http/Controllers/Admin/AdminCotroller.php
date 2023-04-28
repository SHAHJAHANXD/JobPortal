<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\GotVerifiedMail;
use App\Mail\UserVerifyMail;
use App\Models\HomePageSetting;
use App\Models\JobSkill;
use App\Models\LanguageUserSpeak;
use App\Models\Skills;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class AdminCotroller extends Controller
{
    public function dashboard()
    {
        try {
            return view('admin.index.index');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function profile()
    {
        try {
            $skills = Skills::where('user_id', Auth::user()->id)->orderBy('skills')->get();
            $language = LanguageUserSpeak::where('user_id', Auth::user()->id)->orderBy('name')->get();
            return view('authenticate.profile', compact('skills', 'language'));
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
        $env_val['APP_DEBUG'] = $request->APP_DEBUG;
        $env_val['ADMIN_EMAIL'] = $request->ADMIN_EMAIL;

        $env_val['MAIL_MAILER'] = $request->MAIL_MAILER;
        $env_val['MAIL_HOST'] = $request->MAIL_HOST;
        $env_val['MAIL_PORT'] = $request->MAIL_PORT;
        $env_val['MAIL_USERNAME'] = $request->MAIL_USERNAME;
        $env_val['MAIL_PASSWORD'] = $request->MAIL_PASSWORD;
        $env_val['MAIL_ENCRYPTION'] = $request->MAIL_ENCRYPTION;
        $env_val['MAIL_FROM_ADDRESS'] = $request->MAIL_FROM_ADDRESS;
        $env_val['MAIL_FROM_NAME'] = $request->MAIL_FROM_NAME;

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
}
