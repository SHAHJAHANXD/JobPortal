<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactUsController extends Controller
{
    public function get()
    {
        $ContactUs = ContactUs::get();
        return view('admin.ContactUs.index', compact('ContactUs'));
    }
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            ContactUs::create($request->all());
            DB::commit();
            return redirect()->back()->with('success', 'Request submitted successfully. Our team member will contact you soon. Thank you!');
        } catch (Exception $e) {
            DB::rollback();
            DB::commit();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
    public function destroy($id)
    {

        try {
            DB::beginTransaction();
            ContactUs::where('id', $id)->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Record deleted successfully!');
        } catch (Exception $e) {
            DB::rollback();
            DB::commit();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
