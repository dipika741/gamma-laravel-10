<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SeoData;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductControllercopy extends Controller
{
    public function index()
    {
        $products = Product::with('category')->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    // public function create()
    // {
    //     $categories = Category::whereNull('parent_id')->get();
    //     return view('admin.products.create', compact('categories'));
    // }

    public function create()
    {
        $categories = Category::all(); // You can optimize to load hierarchy if needed
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:categories,id',
            'sub_sub_category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'original_price' => 'required|numeric|min:0',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'rating' => 'nullable|numeric|min:0|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        // Determine final category id (sub-sub category if exists, else sub-category, else main category)
        $finalCategoryId = $request->sub_sub_category_id ?? $request->sub_category_id ?? $request->category_id;

        $discountPercentage = $request->discount_percentage ?? 0;
        $discountedPrice = $request->original_price * (1 - $discountPercentage / 100);

        $product = Product::create([
            'category_id' => $finalCategoryId,
            'name' => "'".$request->name."'",
            'description' => $request->description,
            'original_price' => $request->original_price,
            'discount_percentage' => $discountPercentage,
            'discounted_price' => $discountedPrice,
            'rating' => $request->rating ?? 0,
        ]);

        // Save images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        // Save SEO data
        SeoData::create([
            'product_id' => $product->id,
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $categories = Category::whereNull('parent_id')->get();
        $product->load('images', 'seo');
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:categories,id',
            'sub_sub_category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'original_price' => 'required|numeric|min:0',
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'rating' => 'nullable|numeric|min:0|max:5',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'meta_keywords' => 'nullable|string',
        ]);

        $finalCategoryId = $request->sub_sub_category_id ?? $request->sub_category_id ?? $request->category_id;

        $discountPercentage = $request->discount_percentage ?? 0;
        $discountedPrice = $request->original_price * (1 - $discountPercentage / 100);

        $product->update([
            'category_id' => $finalCategoryId,
            'name' => $request->name,
            'description' => $request->description,
            'original_price' => $request->original_price,
            'discount_percentage' => $discountPercentage,
            'discounted_price' => $discountedPrice,
            'rating' => $request->rating ?? 0,
        ]);

        // Save new images if any
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('products', 'public');
                ProductImage::create([
                    'product_id' => $product->id,
                    'image_path' => $path,
                ]);
            }
        }

        // Update or create SEO data
        $seo = $product->seo;
        if ($seo) {
            $seo->update([
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords,
            ]);
        } else {
            SeoData::create([
                'product_id' => $product->id,
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords,
            ]);
        }

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        // Delete images from storage
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->image_path);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully.');
    }
}