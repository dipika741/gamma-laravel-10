<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\SeoData;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController1 extends Controller
{
    /**
     * Display a listing of the products.
     */
    public function index()
    {
        // $products = Product::with(['category', 'subcategory', 'subsubcategory', 'thumbnail'])
        //     ->latest()
        //     ->paginate(10);

        //        return view('admin.products.index', compact('products'));

    $products = Product::with([
        'category',
        'subcategory',
        'subsubcategory',
        'thumbnail'
    ])->orderBy('created_at', 'desc')->paginate(10);

    return view('admin.products.index', compact('products'));



    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        return view('admin.products.create');

        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('admin.products.create', compact('categories','subcategories'));
   
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'sub_category_id' => 'nullable|exists:categories,id',
            'sub_sub_category_id' => 'nullable|exists:categories,id',
            'name' => 'required|string|max:255|unique:products,name',
            'description' => 'nullable|string',
            'original_price' => 'required|numeric|min:0',
            'discount_percentage' => 'nullable|numeric|min:0|max:100',
            'rating' => 'nullable|numeric|min:0|max:5',
            'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'meta_keywords' => 'nullable|string|max:255',
        ]);
    
        DB::transaction(function () use ($request) {
            $discountedPrice = $request->original_price * (1 - ($request->discount_percentage ?? 0) / 100);
    
            // ✅ Create product
            $product = Product::create([
                'category_id' => $request->category_id,
                'sub_category_id' => $request->sub_category_id,
                'sub_sub_category_id' => $request->sub_sub_category_id,
                'name' => $request->name,
                'description' => $request->description,
                'original_price' => $request->original_price,
                'discount_percentage' => $request->discount_percentage ?? 0,
                'discounted_price' => $discountedPrice,
                'rating' => $request->rating ?? 0,
            ]);
    
            // ✅ Handle SEO
            $product->seoData()->create([
                'meta_title' => $request->meta_title,
                'meta_description' => $request->meta_description,
                'meta_keywords' => $request->meta_keywords,
            ]);
    
            // ✅ Handle images (save under "products" folder, relative path)
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
                    $path = $image->store('products', 'public'); // stored as "products/filename.jpg"
    
                    $product->images()->create([
                        'image_path' => $path, // saved in DB as "products/filename.jpg"
                        'is_thumbnail' => $index === 0, // first image is thumbnail
                    ]);
                }
            }
        });
    
        return redirect()->route('admin.products.index')
            ->with('success', 'Product created successfully.');
    }
    

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        $product->load(['seoData', 'images']);
        return view('admin.products.edit', compact('product'));
    }

    /**
     * Update the specified product in storage.
     */

     public function update(Request $request, $id)
     {
         $product = Product::findOrFail($id);
     
         // ✅ validation
         $request->validate([
             'category_id' => 'required|exists:categories,id',
             'subcategory_id' => 'nullable|exists:subcategories,id',
             'sub_sub_category_id' => 'nullable|exists:subsub_categories,id',
             'name' => 'required|string|max:255',
             'title' => 'nullable|string|max:255',
             'description' => 'nullable|string',
             'original_price' => 'required|numeric',
             'discount_percentage' => 'nullable|numeric|min:0|max:100',
             'discounted_price' => 'required|numeric',
             'rating' => 'nullable|numeric|min:0|max:5',
             'slug' => 'required|string|max:255|unique:products,slug,' . $product->id,
             'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
     
             // ✅ SEO
             'meta_title' => 'nullable|string|max:255',
             'meta_description' => 'nullable|string|max:500',
             'meta_keywords' => 'nullable|string|max:255',
         ]);
     
         // ✅ update product
         $product->update([
             'category_id' => $request->category_id,
             'subcategory_id' => $request->subcategory_id,
             'sub_sub_category_id' => $request->sub_sub_category_id,
             'name' => $request->name,
             'title' => $request->title,
             'description' => $request->description,
             'original_price' => $request->original_price,
             'discount_percentage' => $request->discount_percentage ?? 0,
             'discounted_price' => $request->discounted_price,
             'rating' => $request->rating ?? 0,
             'slug' => $request->slug,
         ]);
     
         // ✅ update or create SEO data
         $product->seoData()->updateOrCreate(
             ['product_id' => $product->id],
             [
                 'meta_title' => $request->meta_title,
                 'meta_description' => $request->meta_description,
                 'meta_keywords' => $request->meta_keywords,
             ]
         );
     
         // ✅ handle new images (append, don’t overwrite)
         if ($request->hasFile('images')) {
             foreach ($request->file('images') as $image) {
                 $path = $image->store('products', 'public');
     
                 $product->images()->create([
                     'image_path' => $path,
                     'is_thumbnail' => $product->images()->where('is_thumbnail', true)->count() === 0,
                 ]);
             }
         }
     
         return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
     }
     


    // public function update(Request $request, Product $product)
    // {
    //     $request->validate([
    //         'category_id' => 'required|exists:categories,id',
    //         'sub_category_id' => 'nullable|exists:categories,id',
    //         'sub_sub_category_id' => 'nullable|exists:categories,id',
    //         'name' => 'required|string|max:255|unique:products,name,' . $product->id,
    //         'description' => 'nullable|string',
    //         'original_price' => 'required|numeric|min:0',
    //         'discount_percentage' => 'nullable|numeric|min:0|max:100',
    //         'rating' => 'nullable|numeric|min:0|max:5',
    //         'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    //         'meta_title' => 'nullable|string|max:255',
    //         'meta_description' => 'nullable|string|max:500',
    //         'meta_keywords' => 'nullable|string|max:255',
    //     ]);
    
    //     DB::transaction(function () use ($request, $product) {
    //         $discountedPrice = $request->original_price * (1 - ($request->discount_percentage ?? 0) / 100);
    
    //         // ✅ Update product
    //         $product->update([
    //             'category_id' => $request->category_id,
    //             'sub_category_id' => $request->sub_category_id,
    //             'sub_sub_category_id' => $request->sub_sub_category_id,
    //             'name' => $request->name,
    //             'description' => $request->description,
    //             'original_price' => $request->original_price,
    //             'discount_percentage' => $request->discount_percentage ?? 0,
    //             'discounted_price' => $discountedPrice,
    //             'rating' => $request->rating ?? 0,
    //         ]);
    
    //         // ✅ Update SEO (create if missing)
    //         $product->seoData()->updateOrCreate(
    //             ['product_id' => $product->id],
    //             [
    //                 'meta_title' => $request->meta_title,
    //                 'meta_description' => $request->meta_description,
    //                 'meta_keywords' => $request->meta_keywords,
    //             ]
    //         );
    
    //         // ✅ Replace images if new ones are uploaded
    //         if ($request->hasFile('images')) {
    //             // delete old images (DB + storage handled in ProductImage model)
    //             foreach ($product->images as $image) {
    //                 $image->delete();
    //             }
    
    //             // upload new images
    //             foreach ($request->file('images') as $index => $image) {
    //                 $path = $image->store('products', 'public');
    
    //                 $product->images()->create([
    //                     'image_path' => $path,
    //                     'is_thumbnail' => $index === 0, // first image is thumbnail
    //                 ]);
    //             }
    //         }
    //     });
    
    //     return redirect()->route('admin.products.index')
    //         ->with('success', 'Product updated successfully.');
    // }
    
    
    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        try {
            // Delete SEO data
            if ($product->seo) {
                $product->seo->delete();
            }
    
            // Delete product images from storage & DB
            foreach ($product->images as $image) {
                if (\Storage::exists('public/' . $image->image_path)) {
                    \Storage::delete('public/' . $image->image_path);
                }
                $image->delete();
            }
    
            // Finally delete the product
            $product->delete();
    
            return redirect()->route('admin.products.index')
                ->with('success', 'Product deleted successfully along with related images & SEO data.');
    
        } catch (\Exception $e) {
            return redirect()->route('admin.products.index')
                ->with('error', 'Failed to delete product: ' . $e->getMessage());
        }
    }
    public function deleteImage($productId, $imageId)
{
    $image = ProductImage::where('product_id', $productId)->where('id', $imageId)->firstOrFail();

    if (\Storage::exists('public/' . $image->image_path)) {
        \Storage::delete('public/' . $image->image_path);
    }

    $image->delete();

    return back()->with('success', 'Image deleted successfully.');
}
public function setThumbnail($productId, $imageId)
{
    ProductImage::where('product_id', $productId)->update(['is_thumbnail' => false]);
    ProductImage::where('product_id', $productId)->where('id', $imageId)->update(['is_thumbnail' => true]);

    return back()->with('success', 'Thumbnail updated.');
}

    
}
