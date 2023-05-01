<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function get()
    {
        $category = Category::get();
        return view('admin.category.index', compact('category'));
    }
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $count = Category::where('name', $request->name)->count();
            if($count == 1)
            {
                return redirect()->back()->with('error', 'Category is already exsits!');
            }
            Category::create($request->all());
            DB::commit();
            return redirect()->back()->with('success', 'Category created successfully!');
        } catch (Exception $e) {
            DB::rollback();
            DB::commit();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function edit(Category $category, $id)
    {
        $category = Category::where('id', $id)->first();
        return view('admin.category.edit', compact('category'));
    }
    public function postEdit(Request $request)
    {
        $id = $request->id;
        $category = Category::where('id', $id)->first();
        try {
            DB::beginTransaction();
            if ($category) {
                $category->update($request->all());
            }
            DB::commit();
            return redirect()->route('category.get')->with('success', 'Category updated successfully!');
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
            Category::where('id', $id)->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Category deleted successfully!');
        } catch (Exception $e) {
            DB::rollback();
            DB::commit();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
