<?php

namespace App\Http\Controllers;

use App\Models\JobSkill;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JobSkillController extends Controller
{
    public function get()
    {
        $JobSkill = JobSkill::get();
        return view('admin.JobSkill.index', compact('JobSkill'));
    }
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $count = JobSkill::where('name', $request->name)->count();
            if($count == 1)
            {
                return redirect()->back()->with('error', 'JobSkill is already exsits!');
            }
            JobSkill::create($request->all());
            DB::commit();
            return redirect()->back()->with('success', 'JobSkill created successfully!');
        } catch (Exception $e) {
            DB::rollback();
            DB::commit();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $JobSkill = JobSkill::where('id', $id)->first();
        return view('admin.JobSkill.edit', compact('JobSkill'));
    }
    public function postEdit(Request $request)
    {
        $id = $request->id;
        $JobSkill = JobSkill::where('id', $id)->first();
        try {
            DB::beginTransaction();
            if ($JobSkill) {
                $JobSkill->update($request->all());
            }
            DB::commit();
            return redirect()->route('JobSkill.get')->with('success', 'JobSkill updated successfully!');
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
            JobSkill::where('id', $id)->delete();
            DB::commit();
            return redirect()->back()->with('success', 'JobSkill deleted successfully!');
        } catch (Exception $e) {
            DB::rollback();
            DB::commit();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
