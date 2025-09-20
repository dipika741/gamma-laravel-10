<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\SubsubCategory;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SubsubCategoryController extends Controller
{
    public function index()
    {
        $subsubcategories = SubsubCategory::with(['category','subcategory'])->get();
        return view('admin.subsubcategories.index', compact('subsubcategories'));
    }

    public function create()
    {
        $categories = Category::all();
        $subcategories = SubCategory::all();
        return view('admin.subsubcategories.create', compact('categories','subcategories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'name' => 'required',
        ]);

        // Duplicate check
        $exists = SubsubCategory::where('name', $request->name)
            ->where('subcategory_id', $request->subcategory_id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['name' => 'This SubsubCategory already exists under selected Subcategory.'])->withInput();
        }

        SubsubCategory::create([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.subsubcategories.index')->with('success','Created Successfully');
    }

    public function edit(SubsubCategory $subsubcategory)
    {
        $categories = Category::all();
        $subcategories = SubCategory::all();
        return view('admin.subsubcategories.edit', compact('subsubcategory','categories','subcategories'));
    }

    public function update(Request $request, SubsubCategory $subsubcategory)
    {
        $request->validate([
            'category_id' => 'required',
            'subcategory_id' => 'required',
            'name' => 'required',
        ]);

        // Duplicate check excluding current
        $exists = SubsubCategory::where('name', $request->name)
            ->where('subcategory_id', $request->subcategory_id)
            ->where('id', '!=', $subsubcategory->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['name' => 'This SubsubCategory already exists under selected Subcategory.'])->withInput();
        }

        $subsubcategory->update([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
        ]);

        return redirect()->route('admin.subsubcategories.index')->with('success','Updated Successfully');
    }

    public function destroy(SubsubCategory $subsubcategory)
    {
        $subsubcategory->delete();
        return redirect()->route('admin.subsubcategories.index')->with('success','Deleted Successfully');
    }

    public function getData()
    {
        $data = SubsubCategory::with(['category', 'subcategory'])->get();
    
        return datatables()->of($data)
            ->addColumn('category_name', fn($row) => $row->category->name ?? '-')
            ->addColumn('subcategory_name', fn($row) => $row->subcategory->name ?? '-')
            ->addColumn('actions', function ($row) {
                $editUrl = route('admin.subsubcategories.edit', $row->id);
                $deleteUrl = route('admin.subsubcategories.destroy', $row->id);
                return '
                    <a href="'.$editUrl.'" class="btn btn-sm btn-warning">Edit</a>
                    <form action="'.$deleteUrl.'" method="POST" style="display:inline;">
                        '.csrf_field().method_field("DELETE").'
                        <button type="submit" class="btn btn-sm btn-danger"
                            onclick="return confirm(\'Are you sure?\')">Delete</button>
                    </form>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
    

//     public function getData()
// {
//     $subsubcategories = SubsubCategory::with(['subcategory.category'])->select('subsub_categories.*');

//     return datatables()->of($subsubcategories)
//         ->addColumn('category', fn($row) => $row->subcategory->category->name ?? '-')
//         ->addColumn('subcategory', fn($row) => $row->subcategory->name ?? '-')
//         ->addColumn('actions', function ($row) {
//             $editUrl = route('admin.subsubcategories.edit', $row->id);
//             $deleteUrl = route('admin.subsubcategories.destroy', $row->id);
//             return '
//                 <a href="'.$editUrl.'" class="btn btn-sm btn-warning">Edit</a>
//                 <form action="'.$deleteUrl.'" method="POST" style="display:inline-block;">
//                     '.csrf_field().method_field('DELETE').'
//                     <button type="submit" class="btn btn-sm btn-danger">Delete</button>
//                 </form>
//             ';
//         })
//         ->rawColumns(['actions'])
//         ->make(true);
// }

}
