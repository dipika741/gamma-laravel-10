<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::latest()->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255']);
        
        $exists = Category::where('name', $request->name)
            ->exists();

        if ($exists) {
            return back()->withErrors(['name' => 'This Category already exists.'])->withInput();
        }
        
        Category::create($request->only('name'));

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category created successfully.');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate(['name' => 'required|string|max:255']);
        
        $exists = Category::where('name', $request->name)
            ->exists();

        if ($exists) {
            return back()->withErrors(['name' => 'This Category already exists.'])->withInput();
        }
        
        $category->update($request->only('name'));

        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')
                         ->with('success', 'Category deleted successfully.');
    }
}
