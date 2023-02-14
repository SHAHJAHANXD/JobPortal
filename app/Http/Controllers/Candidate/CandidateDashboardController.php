<?php

namespace App\Http\Controllers\Candidate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CandidateDashboardController extends Controller
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
