<?php

namespace App\Http\Controllers;

use App\Models\NewsLetter;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NewsletterController extends Controller
{
    public function get()
    {
        $NewsLetter = NewsLetter::get();
        return view('admin.NewsLetter.index', compact('NewsLetter'));
    }
    public function store(Request $request)
    {
        $count = NewsLetter::where('email', $request->email)->count();
        if ($count == 1) {
            return redirect()->back()->with('error', 'You have already subscribed to the newsletter. Thank you!');
        }
        try {
            DB::beginTransaction();
            NewsLetter::create($request->all());
            DB::commit();
            return redirect()->back()->with('success', 'Newsletter subscribed successfully!');
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
            NewsLetter::where('id', $id)->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Record deleted successfully!');
        } catch (Exception $e) {
            DB::rollback();
            DB::commit();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
