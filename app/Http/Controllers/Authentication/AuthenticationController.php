<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

use function GuzzleHttp\Promise\all;

class AuthenticationController extends Controller
{

    public function migrate()
    {
        Artisan::call('migrate:refresh');
        dd('Success');
    }
    public function dbSeed()
    {
        Artisan::call('db:seed');
        dd('Success');
    }
    public function index()
    {
        return redirect()->route('login');
    }
    public function changePostPassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);
        if (!Hash::check($request->old_password, Auth::user()->password)) {
            return back()->with("error", "Old Password Doesn't match!");
        }
        User::whereId(Auth::user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);
        if (Auth::user()->role == 'Candidate') {
            return redirect()->route('candidate.dashboard')->with('success', "Password changed successfully!");
        }
        if (Auth::user()->role == 'Admin') {
            return redirect()->route('admin.dashboard')->with('success', "Password changed successfully!");
        }
        if (Auth::user()->role == 'Employer') {
            return redirect()->route('employer.dashboard')->with('success', "Password changed successfully!");
        }
    }
    public function changePassword()
    {
        return view('authenticate.changePassword');
    }
    public function login()
    {
        $auth_check = Auth::check();
        if ($auth_check == true) {

            if (Auth::user()->role == 'Candidate') {
                return redirect()->route('candidate.dashboard')->with('success', 'Welcome Back' . ' ' . Auth::user()->first_name . ' ' . Auth::user()->last_name);
            }
            if (Auth::user()->role == 'Admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Welcome Back' . ' ' . Auth::user()->first_name . ' ' . Auth::user()->last_name);
            }
            if (Auth::user()->role == 'Employer') {
                return redirect()->route('employer.dashboard')->with('success', 'Welcome Back' . ' ' . Auth::user()->first_name . ' ' . Auth::user()->last_name);
            }
        } else {
            return view('authenticate.login');
        }
    }
    public function signup()
    {
        $auth_check = Auth::check();
        if ($auth_check == true) {
            if (Auth::user()->role == 'Candidate') {
                return redirect()->route('candidate.dashboard')->with('success', 'Welcome Back' . ' ' . Auth::user()->first_name . ' ' . Auth::user()->last_name);
            }
            if (Auth::user()->role == 'Admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Welcome Back' . ' ' . Auth::user()->first_name . ' ' . Auth::user()->last_name);
            }
            if (Auth::user()->role == 'Employer') {
                return redirect()->route('employer.dashboard')->with('success', 'Welcome Back' . ' ' . Auth::user()->first_name . ' ' . Auth::user()->last_name);
            }
        } else {
            return view('authenticate.signup');
        }
    }
    public function post_signup(Request $request)
    {
        $data = $request->validate(
            [
                'first_name' => 'required|string|max:254',
                'last_name' => 'required|string|max:254',
                'email' => 'required|string|max:254|unique:users',
                'role' => 'required',
                'password' => 'required|string|min:8',
            ],
            [
                'role.required' => 'Role is required...',

                'password.required' => 'Password is required...',
                'password.string' => 'Password must be a type of string...',
                'password.min' => 'Password must be equal to 8 characters...',

                'first_name.required' => 'First Name is required...',
                'first_name.string' => 'First Name must be a type of string...',
                'first_name.max' => 'First Name must be less then 254 characters...',

                'last_name.required' => 'Last Name is required...',
                'last_name.string' => 'Last Name must be a type of string...',
                'last_name.max' => 'Last Name must be less then 254 characters...',

                'email.required' => 'Email is required...',
                'email.string' => 'Email must be a type of string...',
                'email.max' => 'Email must be less then 254 characters...',

            ]
        );
        $code = str_pad(mt_rand(1, 999999), 6, '0', STR_PAD_LEFT);
        Mail::send('emails.verify', ['code' => $code], function ($message) use ($request) {
            $message->to($request->email);
            $message->subject('Verify Email');
        });
        if (true == true) {
            $user = new User();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->password = Hash::make($request->password);
            $user->code = $code;
            if ($request->role == "Employer") {
                $user->account_status = 0;
            }
            $user->save();

            if ($request->role == "Employer") {
                $email_data = ['name' => $request->first_name . ' ' . $request->last_name, 'id' => $user->id];
                Mail::send(
                    'emails.toAdmin',
                    $email_data,
                    function ($message) use ($email_data) {
                        $message->to(env('ADMIN_EMAIL'))->subject($email_data['name'] . ' ' . "Just Joined as a Employer at Cybinix Job Portal.");
                    }
                );
            }
            $credentials = $request->only('email', 'password');
            if ($user == true) {
                if ($request->role == 'Candidate') {
                    Auth::guard('web')->attempt($credentials);
                    return redirect()->route('candidate.dashboard')->with('success', 'Account Created Successfully');
                }
                if ($request->role == 'Employer') {
                    Auth::guard('web')->attempt($credentials);
                    return redirect()->route('employer.dashboard')->with('success', 'Account Created Successfully');
                }
            }
        } else {
            return redirect()->back()->with('error', 'Mail server error. Thank you!');
        }
    }
    public function authenticate(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
        $credentials = $request->only('email', 'password');
        if (Auth::guard('web')->attempt($credentials)) {
            if (Auth::user()->status == 0) {
                Auth::logout();
                return redirect()->route('login')->with('error', 'Your account is Blocked. Thank You!');
            } else {
                if (Auth::user()->role == 'Candidate') {
                    return redirect()->route('candidate.dashboard')->with('success', 'Welcome Back' . ' ' . Auth::user()->first_name . ' ' . Auth::user()->last_name);
                } elseif (Auth::user()->role == 'Admin') {
                    return redirect()->route('admin.dashboard')->with('success', 'Welcome Back' . ' ' . Auth::user()->first_name . ' ' . Auth::user()->last_name);
                } elseif (Auth::user()->role == 'Employer') {
                    return redirect()->route('employer.dashboard')->with('success', 'Welcome Back' . ' ' . Auth::user()->first_name . ' ' . Auth::user()->last_name);
                } else {
                    Auth::logout();
                    return redirect()->route('login')->with('error', 'User role is Invalid!');
                }
            }
        }
        return redirect()->back()->with('error', 'Email or Password is Invalid!');
    }
    public function Logout()
    {
        Auth::logout();
        Session::flush();
        return redirect()->route('login')->with('error', 'Session Expired!');
    }
    public function forget_password()
    {
        return view('authenticate.forgetPassword');
    }
    public function verify_forget_password()
    {
        return view('authenticate.VerifyForgetPassword');
    }
    public function post_verify_forget_password(Request $request)
    {
        $email = $request->email;
        $count = User::where('email', $email)->count();
        if ($count == 0) {
            return redirect()->back()->with('error', 'Email Address Not Found. Thank You!');
        } else {
            $user = User::where('email', $email)->first();
            $request->validate([
                'email' => 'required',
                'password' => 'required',
            ]);
            if ($user->password_code == $request->code) {
                $user->password = Hash::make($request->password);
                $user->password_code == null;
                $user->save();
                $credentials = $request->only('email', 'password');
                if (Auth::guard('web')->attempt($credentials)) {
                    if (Auth::user()->role == 'Candidate') {
                        return redirect()->route('candidate.dashboard')->with('success', 'Welcome Back' . ' ' . Auth::user()->first_name . ' ' . Auth::user()->last_name);
                    } elseif (Auth::user()->role == 'Admin') {
                        return redirect()->route('admin.dashboard')->with('success', 'Welcome Back' . ' ' . Auth::user()->first_name . ' ' . Auth::user()->last_name);
                    } elseif (Auth::user()->role == 'Employer') {
                        return redirect()->route('employer.dashboard')->with('success', 'Welcome Back' . ' ' . Auth::user()->first_name . ' ' . Auth::user()->last_name);
                    } else {
                        Auth::logout();
                        return redirect()->route('login')->with('error', 'User role is Invalid!');
                    }
                }
            } else {
                return redirect()->back()->with('error', 'Reset Code Is Invalid. Thank You!');
            }
        }
    }
    public function post_forget_password(Request $request)
    {
        $email = $request->email;
        $count = User::where('email', $email)->count();
        if ($count == 0) {
            return redirect()->back()->with('error', 'Email Address Not Found. Thank You!');
        } else {
            $code = mt_rand(1, 999999);
            $user = User::where('email', $email)->first();
            $user->password_code = $code;
            $user->save();
            Mail::send('emails.forget', ['code' => $code], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject('Verify Email');
            });
            return redirect()->route('verify_forget_password')->with('success', 'Resend Code Sent Successfully!');
        }
    }
}
