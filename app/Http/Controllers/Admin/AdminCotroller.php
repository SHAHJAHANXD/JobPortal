<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminCotroller extends Controller
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
