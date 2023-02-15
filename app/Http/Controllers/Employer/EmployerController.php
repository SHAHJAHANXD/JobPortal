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
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://{site}.chargebee.com/api/v2/hosted_pages/checkout_existing_for_items');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded',
        ]);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, '{site_api_key}:');
        curl_setopt($ch, CURLOPT_POSTFIELDS, 'subscription[id]=__test__KyVnGWS4EgP3HA&subscription_items[item_price_id][0]=basic-USD&subscription_items[quantity][0]=4&subscription_items[unit_price][0]=1000');
        $response = curl_exec($ch);
        curl_close($ch);
        dd(json_decode($response));
        $response = ['status' => true, 'data' => $response,  'message' => 'TRUE'];
        return response($response, 200);
    }
    public function dashboard()
    {
        return view('candidate.index.index');
    }
    public function profile()
    {
        $skills = Skills::where('user_id', Auth::user()->id)->get();
        return view('authenticate.profile', compact('skills'));
    }
}
