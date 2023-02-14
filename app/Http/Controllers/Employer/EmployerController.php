<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use App\Models\Skills;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EmployerController extends Controller
{
    public function charge()
    {

    }
    public function dashboard()
    {
        return view('candidate.index.index');
    }
    public function profile()
    {
        $skills = Skills::where('user_id' , Auth::user()->id)->get();
        return view('authenticate.profile', compact('skills'));
    }
}
