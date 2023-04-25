<?php

namespace App\Http\Controllers;

use App\Models\AddressSetting;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AddressController extends Controller
{
    public function get()
    {
        $AddressSetting = AddressSetting::get();
        return view('admin.address.index', compact('AddressSetting'));
    }
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            AddressSetting::create($request->all());
            DB::commit();
            return redirect()->back()->with('success', 'Record added successfully!');
        } catch (Exception $e) {
            DB::rollback();
            DB::commit();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit($id)
    {
        $AddressSetting = AddressSetting::where('id', $id)->first();
        return view('admin.address.edit', compact('AddressSetting','id'));
    }
    public function postEdit(Request $request)
    {
        $id = $request->id;
        $AddressSetting = AddressSetting::where('id', $id)->first();
        try {
            DB::beginTransaction();
            if ($AddressSetting) {
                $AddressSetting->update($request->all());
            }
            DB::commit();
            return redirect()->route('address.get')->with('success', 'Record updated successfully!');
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
            AddressSetting::where('id', $id)->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Record deleted successfully!');
        } catch (Exception $e) {
            DB::rollback();
            DB::commit();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
