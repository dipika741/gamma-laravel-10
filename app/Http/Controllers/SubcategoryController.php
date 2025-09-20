<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function index()
    {
        $subcategories = Subcategory::with('category')->latest()->get();
        return view('admin.subcategories.index', compact('subcategories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.subcategories.create', compact('categories'));
    }

    public function store(Request $request)
    { 
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255'
        ]);

        $exists = Subcategory::where('name', $request->name)
        ->where('category_id', $request->category_id)
        ->exists();

        if ($exists) {
            return back()->withErrors(['name' => 'This SubCategory already exists under selected category.'])->withInput();
        }

        Subcategory::create($request->only('category_id', 'name'));

        return redirect()->route('admin.subcategories.index')
                         ->with('success', 'Subcategory created successfully.');
    }

    public function edit(Subcategory $subcategory)
    {
        $categories = Category::all();
        return view('admin.subcategories.edit', compact('subcategory', 'categories'));
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255'
        ]);
        $exists = Subcategory::where('name', $request->name)
        ->where('category_id', $request->category_id)
        ->exists();

        if ($exists) {
            return back()->withErrors(['name' => 'This SubCategory already exists under selected category.'])->withInput();
        }
        
        $subcategory->update($request->only('category_id', 'name'));

        return redirect()->route('admin.subcategories.index')
                         ->with('success', 'Subcategory updated successfully.');
    }

    public function destroy(Subcategory $subcategory)
    {
        $subcategory->delete();
        return redirect()->route('admin.subcategories.index')
                         ->with('success', 'Subcategory deleted successfully.');
    }
}
