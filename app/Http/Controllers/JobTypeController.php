<?php

namespace App\Http\Controllers;

use App\Models\JobType;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobTypeController extends Controller
{
    public function get()
    {
        $JobType = JobType::get();
        return view('admin.JobType.index', compact('JobType'));
    }
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            JobType::create($request->all());
            DB::commit();
            return redirect()->back()->with('success', 'JobType created successfully!');
        } catch (Exception $e) {
            DB::rollback();
            DB::commit();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $JobType = JobType::where('id', $id)->first();
        return view('admin.JobType.edit', compact('JobType'));
    }
    public function postEdit(Request $request)
    {
        $id = $request->id;
        $JobType = JobType::where('id', $id)->first();
        try {
            DB::beginTransaction();
            if ($JobType) {
                $JobType->update($request->all());
            }
            DB::commit();
            return redirect()->route('JobType.get')->with('success', 'JobType updated successfully!');
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
            JobType::where('id', $id)->delete();
            DB::commit();
            return redirect()->route('JobType.get')->with('success', 'JobType deleted successfully!');
        } catch (Exception $e) {
            DB::rollback();
            DB::commit();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
