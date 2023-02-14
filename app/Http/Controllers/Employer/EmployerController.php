<?php

namespace App\Http\Controllers\Employer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    public function dashboard()
    {
        return view('candidate.index.index');
    }
    public function profile()
    {
        return view('authenticate.profile');
    }
}
