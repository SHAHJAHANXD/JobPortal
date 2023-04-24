<?php

namespace App\Http\Controllers\VerifyUser;

use App\Http\Controllers\Controller;
use App\Mail\UserVerifyEmail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class VerifyUserController extends Controller
{

    public function verify()
    {
        return view('authenticate.verify');
    }
    public function postverify(Request $request)
    {
        $request->validate([
            'code' => 'required|max:6',
        ]);
        $role = Auth::guard('web')->user()->role;
        $id = Auth::guard('web')->user()->id;
        $user = Auth::guard('web')->user()->code == $request->code;
        if ($user == true) {
            $user = User::where('id', $id)->first();
            $user->email_status = '1';
            $user->code = NULL;
            $user->save();
            if ($role == 'Candidate') {
                return redirect()->route('candidate.dashboard')->with('success', 'Email Verified Successfully!');
            }
            if ($role == 'Employer') {
                return redirect()->route('employer.dashboard')->with('success', 'Email Verified Successfully!');
            }
        } else {
            return redirect()->back()->with('error', 'Code is Invalid!');
        }
    }
    public function resend_code(Request $request)
    {
        $code = mt_rand(1, 999999);
        $email = Auth::guard('web')->user()->email;
        $users = User::where('email', $email)->first();
        $users->code = $code;
        $users->save();
        $user = ['email' => $request->email, 'code' => $code];
        Mail::to($user['email'])->queue(new UserVerifyEmail($user));
        return redirect()->back()->with('success', 'Resend Code Sent Successfully!');
    }
}
