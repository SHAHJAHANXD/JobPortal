<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\GotVerifiedMail;
use App\Mail\UserVerifyMail;
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
}
