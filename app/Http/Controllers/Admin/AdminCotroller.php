<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Skills;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminCotroller extends Controller
{
    public function dashboard()
    {
        return view('candidate.index.index');
    }
    public function profile()
    {
        $skills = Skills::where('user_id', Auth::user()->id)->get();
        return view('authenticate.profile', compact('skills'));
    }
    public function AllCandidates()
    {
        $user = User::where('role', 'Candidate')->get();
        return view('admin.users.index', compact('user'));
    }
}
