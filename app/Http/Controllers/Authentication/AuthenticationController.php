<?php

namespace App\Http\Controllers\Authentication;

use App\Http\Controllers\Controller;
use App\Mail\ForgetPasswordMail;
use App\Mail\MailToAdmin;
use App\Mail\UserVerifyEmail;
use App\Models\AddressSetting;
use App\Models\JobSkill;
use App\Models\PostJob;
use App\Models\User;
use App\Notifications\CustomNotification;
use App\Notifications\JobApplyNotification;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Notification as FacadesNotification;
use Illuminate\Support\Facades\Session;

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
        try {
            return view('frontend.index');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function aboutUs()
    {
        try {
            $jobSkills = JobSkill::orderBy('id', 'desc')->with('JobPostedSkills')->get();
            return view('frontend.aboutUs', compact('jobSkills'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function contactUs()
    {
        try {
            $address = AddressSetting::where('id', 1)->first();
            return view('frontend.contactUs', compact('address'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }



    public function jobs(Request $request)
    {
        
        try {
            if ($request->page == null) {
                $loadmore = "?page=2";
            } else {
                $loadmore = "?page=" . $request->page + 1;
            }
            $jobs = PostJob::where('status', 1)->with('Users')->with('Skills')->inRandomOrder()->orderBy('id', 'desc')->paginate(15);
            return view('frontend.jobs', compact('jobs', 'loadmore'));
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function changePostPassword(Request $request)
    {
        try {
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
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function changePassword()
    {
        try {
            return view('authenticate.changePassword');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function login()
    {
        try {
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
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function signup()
    {
        try {
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
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function post_signup(Request $request)
    {
        try {
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
            $user = ['email' => $request->email, 'code' => $code];
            Mail::to($user['email'])->queue(new UserVerifyEmail($user));
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
                    $user = ['email' => env('ADMIN_EMAIL'), 'name' => $request->first_name . ' ' . $request->last_name, 'id' => $user->id];
                    Mail::to($user['email'])->queue(new MailToAdmin($user));
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
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function authenticate(Request $request)
    {
        try {
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
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function Logout()
    {
        try {
            Auth::logout();
            Session::flush();
            return redirect()->route('login')->with('error', 'Session Expired!');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function forget_password()
    {
        try {
            return view('authenticate.forgetPassword');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function verify_forget_password()
    {
        try {
            return view('authenticate.VerifyForgetPassword');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function post_verify_forget_password(Request $request)
    {
        try {
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
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function post_forget_password(Request $request)
    {
        try {
            $email = $request->email;
            $count = User::where('email', $email)->count();
            if ($count == 0) {
                return redirect()->back()->with('error', 'Email Address Not Found. Thank You!');
            } else {
                $code = mt_rand(1, 999999);
                $user = User::where('email', $email)->first();
                $user->password_code = $code;
                $user->save();
                $user = ['email' => $request->email, 'code' => $code];
                Mail::to($user['email'])->queue(new ForgetPasswordMail($user));
                return redirect()->route('verify_forget_password')->with('success', 'Resend Code Sent Successfully!');
            }
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
