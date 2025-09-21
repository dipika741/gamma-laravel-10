<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\SubSubCategory;
use App\Models\Product;

class ProductController extends Controller
{
    // Category page
    public function category($category)
    {
        $category = Category::where('slug', $category)
            ->with('subcategories')
            ->firstOrFail();

            $products = Product::where('category_id', $category->id)->paginate(12);
            
            return view('products.category', compact('category', 'products'));
    }

    // Subcategory page
    public function subcategory($category, $subcategory)
    {
        $subcategory = Subcategory::where('slug', $subcategory)
            ->whereHas('category', fn($q) => $q->where('slug', $category))
            ->with('subSubCategories')
            ->firstOrFail();

        $products = Product::where('subcategory_id', $subcategory->id)->paginate(12);

        return view('products.subcategory', compact('subcategory', 'products'));
    }

    // Sub-subcategory page
    public function subsubcategory($category, $subcategory, $subsubcategory)
    {
        $subsubcategory = SubSubCategory::where('slug', $subsubcategory)
            ->whereHas('subcategory', fn($q) => $q->where('slug', $subcategory))
            ->firstOrFail();

        $products = Product::where('sub_sub_category_id', $subsubcategory->id)->paginate(12);

        return view('products.subsubcategory', compact('subsubcategory', 'products'));
    }

    // Product detail page
    public function show($category, $subcategory = null, $subsubcategory = null, $product)
    {
        $product = Product::where('slug', $product)
            ->with(['category','subcategory','subSubCategory'])
            ->firstOrFail();

        return view('products.show', compact('product'));
    }
}
