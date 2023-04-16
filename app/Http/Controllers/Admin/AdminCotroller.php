<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LanguageUserSpeak;
use App\Models\Skills;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AdminCotroller extends Controller
{
    public function dashboard()
    {
        return view('candidate.index.index');
    }

    public function profile()
    {
        $skills = Skills::where('user_id', Auth::user()->id)->orderBy('skills')->get();
        $language = LanguageUserSpeak::where('user_id', Auth::user()->id)->orderBy('name')->get();
        return view('authenticate.profile', compact('skills', 'language'));
    }
    public function AllCandidates()
    {
        $user = User::where('role', 'Candidate')->get();
        return view('admin.users.index', compact('user'));
    }
    public function AllEmployers()
    {
        $user = User::where('role', 'Employer')->get();
        return view('admin.users.index', compact('user'));
    }
    public function ActivateEmployerAccount($id)
    {
        $user = User::where('id', $id)->first();
        if ($user->account_status == 1) {
            return redirect()->back()->with('success', 'Account approved successfully!');
        } else {
            User::where('id', $id)->update(['account_status' => 1]);
            $email_data = ['name' => $user->first_name . ' ' . $user->last_name, 'email' => $user->email];
            Mail::send(
                'emails.gotVerified',
                $email_data,
                function ($message) use ($email_data) {
                    $message->to($email_data['email'])->subject("Dear " . ' ' . $email_data['name'] . ' ' . "Your Profile at Cybinix Job Portal Got Approved!");
                }
            );
            return redirect()->back()->with('success', 'Account approved successfully!');
        }
    }
    public function ActivateEmployerAccountEmail($id)
    {
        $user = User::where('id', $id)->first();
        if ($user->account_status == 1) {
            return view('admin.users.verified', compact('id'));
        } else {
            User::where('id', $id)->update(['account_status' => 1]);
            $user = User::where('id', $id)->first();
            $email_data = ['name' => $user->first_name . ' ' . $user->last_name, 'email' => $user->email];
            Mail::send(
                'emails.gotVerified',
                $email_data,
                function ($message) use ($email_data) {
                    $message->to($email_data['email'])->subject("Dear " . ' ' . $email_data['name'] . ' ' . "Your Profile at Cybinix Job Portal Got Approved!");
                }
            );
            return view('admin.users.verified', compact('id'));
        }
    }

    public function BlockEmployerAccount($id)
    {
        User::where('id', $id)->update(['account_status' => 0]);
        return redirect()->back()->with('success', 'Account rejected successfully!');
    }
}
