<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use App\Models\SubSubCategory;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Show index page.
     */
    public function index()
    {
        // fetch only id + name to keep payload small — adjust ordering if you want
        $categories   = Category::select('id','name')->orderBy('name')->get();
        $subcategories = Subcategory::select('id','name','category_id')->orderBy('name')->get();
    
        // pass to view so the filters (dropdowns) have data
        return view('admin.products.index', compact('categories','subcategories'));
    }
    
    /**
     * Data for DataTables.
     */
    public function indexData(Request $request)
    {
        $products = Product::with(['category', 'subcategory', 'subsubcategory'])->select('products.*');
    
        // Filter by category_id
        if ($request->category_id) {
            $products->where('category_id', $request->category_id);
        }
    
        // Filter by subcategory_id
        if ($request->subcategory_id) {
            $products->where('subcategory_id', $request->subcategory_id);
        }
    
        // Filter by subsubcategory_id
        if ($request->subsubcategory_id) {
            $products->where('sub_sub_category_id', $request->subsubcategory_id);
        }
    
        return DataTables::of($products)
            ->addColumn('category', fn($row) => $row->category?->name ?? '-')
            ->addColumn('subcategory', fn($row) => $row->subcategory?->name ?? '-')
            ->addColumn('subsubcategory', fn($row) => $row->subsubcategory?->name ?? '-')
            ->addColumn('discounted_price', function ($row) {
                return $row->original_price - ($row->original_price * $row->discount_percentage / 100);
            })
            ->addColumn('actions', function ($row) {
                $editUrl = route('admin.products.edit', $row->id);
                $deleteUrl = route('admin.products.destroy', $row->id);
                return '
                    <a href="'.$editUrl.'" class="btn btn-sm btn-primary">Edit</a>
                    <form action="'.$deleteUrl.'" method="POST" style="display:inline-block;" onsubmit="return confirm(\'Are you sure?\')">
                        '.csrf_field().method_field('DELETE').'
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                ';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }
    
    

    
    /**
     * Show create form.
     */
    public function create()
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $subsubcategories = SubSubCategory::all();

        return view('admin.products.create', compact('categories','subcategories','subsubcategories'));
    }

    /**
     * Store product.
     */
    // public function store(Request $request)
    // {
    //     $request->validate([
    //         'category_id'          => 'required|exists:categories,id',
    //         'sub_category_id'      => 'nullable|exists:subcategories,id',
    //         'sub_sub_category_id'  => 'nullable|exists:sub_sub_categories,id',
    //         'name'                 => 'required|string|max:255|unique:products,name',
    //         'slug'                 => 'required|string|max:255|unique:products,slug',
    //         'description'          => 'nullable|string',
    //         'original_price'       => 'required|numeric|min:0',
    //         'discount_percentage'  => 'nullable|numeric|min:0|max:100',
    //         'rating'               => 'nullable|numeric|min:0|max:5',
    //         'images.*'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    //     ]);

    //     DB::transaction(function () use ($request) {
    //         $discountedPrice = $request->original_price * (1 - ($request->discount_percentage ?? 0) / 100);

    //         $product = Product::create([
    //             'category_id'         => $request->category_id,
    //             'sub_category_id'     => $request->sub_category_id,
    //             'sub_sub_category_id' => $request->sub_sub_category_id,
    //             'name'                => $request->name,
    //             'slug'                => Str::slug($request->slug),
    //             'description'         => $request->description,
    //             'original_price'      => $request->original_price,
    //             'discount_percentage' => $request->discount_percentage ?? 0,
    //             'discounted_price'    => $discountedPrice,
    //             'rating'              => $request->rating ?? 0,
    //         ]);

    //         // SEO
    //         $product->seoData()->create([
    //             'meta_title'       => $request->meta_title,
    //             'meta_description' => $request->meta_description,
    //             'meta_keywords'    => $request->meta_keywords,
    //         ]);

    //         // Images
    //         if ($request->hasFile('images')) {
    //             foreach ($request->file('images') as $index => $image) {
    //                 $path = $image->store('products', 'public');
    //                 $product->images()->create([
    //                     'image_path'   => $path,
    //                     'is_thumbnail' => $index === 0,
    //                 ]);
    //             }
    //         }
    //     });

    //     return redirect()->route('admin.products.index')->with('success', 'Product created successfully.');
    // }

    /**
     * Show edit form.
     */
    public function edit(Product $product)
    {
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $subsubcategories = SubSubCategory::all();

        return view('admin.products.edit', compact('product','categories','subcategories','subsubcategories'));
    }

    public function store(Request $request)
{
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
        'slug' => 'required|string|max:255|unique:products,slug',
        'images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        'meta_title' => 'nullable|string|max:255',
        'meta_description' => 'nullable|string|max:500',
        'meta_keywords' => 'nullable|string|max:255',
    ]);

    // ✅ check product existence (by slug)
    if (Product::where('slug', $request->slug)->exists()) {
        return back()->withErrors(['slug' => 'This slug already exists. Please choose another.'])->withInput();
    }

    // ✅ create product
    $product = Product::create($request->only([
        'category_id',
        'subcategory_id',
        'sub_sub_category_id',
        'name',
        'title',
        'description',
        'original_price',
        'discount_percentage',
        'discounted_price',
        'rating',
        'slug'
    ]));

    // ✅ create SEO data
    $product->seoData()->create([
        'meta_title' => $request->meta_title,
        'meta_description' => $request->meta_description,
        'meta_keywords' => $request->meta_keywords,
    ]);

    // ✅ handle images
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('products', 'public');

            $product->images()->create([
                'image_path' => $path,
                'is_thumbnail' => $index === 0, // first image = thumbnail
            ]);
        }
    }

    return redirect()->route('admin.products.index')->with('success', 'Product created successfully!');
}

public function update(Request $request, $id)
{
    $product = Product::with('seoData')->findOrFail($id);

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
        'meta_title' => 'nullable|string|max:255',
        'meta_description' => 'nullable|string|max:500',
        'meta_keywords' => 'nullable|string|max:255',
    ]);

    // ✅ check product existence (slug must be unique except self)
    if (Product::where('slug', $request->slug)->where('id', '!=', $product->id)->exists()) {
        return back()->withErrors(['slug' => 'This slug already exists. Please choose another.'])->withInput();
    }

    // ✅ update product
    $product->update($request->only([
        'category_id',
        'subcategory_id',
        'sub_sub_category_id',
        'name',
        'title',
        'description',
        'original_price',
        'discount_percentage',
        'discounted_price',
        'rating',
        'slug'
    ]));

    // ✅ update or create SEO
    if ($product->seoData) {
        $product->seoData->update([
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
        ]);
    } else {
        $product->seoData()->create([
            'meta_title' => $request->meta_title,
            'meta_description' => $request->meta_description,
            'meta_keywords' => $request->meta_keywords,
        ]);
    }

    // ✅ handle new images
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('products', 'public');

            $product->images()->create([
                'image_path' => $path,
                'is_thumbnail' => false,
            ]);
        }
    }

    return redirect()->route('admin.products.index')->with('success', 'Product updated successfully!');
}


    /**
     * Update product.
     */
    // public function update(Request $request, Product $product)
    // {
    //     $request->validate([
    //         'name'           => 'required|unique:products,name,'.$product->id,
    //         'slug'           => 'required|unique:products,slug,'.$product->id,
    //         'category_id'    => 'required|exists:categories,id',
    //         'original_price' => 'required|numeric',
    //     ]);

    //     $discountedPrice = $request->original_price * (1 - ($request->discount_percentage ?? 0) / 100);

    //     $product->update([
    //         'category_id'         => $request->category_id,
    //         'sub_category_id'     => $request->sub_category_id,
    //         'sub_sub_category_id' => $request->sub_sub_category_id,
    //         'name'                => $request->name,
    //         'slug'                => Str::slug($request->slug),
    //         'description'         => $request->description,
    //         'original_price'      => $request->original_price,
    //         'discount_percentage' => $request->discount_percentage ?? 0,
    //         'discounted_price'    => $discountedPrice,
    //         'rating'              => $request->rating ?? 0,
    //     ]);

    //     if ($request->hasFile('images')) {
    //         foreach ($request->file('images') as $image) {
    //             $path = $image->store('products', 'public');
    //             $product->images()->create([
    //                 'image_path'   => $path,
    //                 'is_thumbnail' => false,
    //             ]);
    //         }
    //     }

    //     return redirect()->route('admin.products.edit', $product->id)->with('success','Product updated successfully.');
    // }

    /**
     * Delete product.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('success','Product deleted successfully.');
    }

    /**
     * Export products to CSV.
     */
    public function exportCsv()
    {
        $products = Product::with('category')->get();
        $filename = "products.csv";
        $handle = fopen($filename, 'w+');
        fputcsv($handle, ['ID','Name','Slug','Category','Price']);

        foreach($products as $product) {
            fputcsv($handle, [
                $product->id,
                $product->name,
                $product->slug,
                $product->category->name ?? '',
                $product->discounted_price
            ]);
        }

        fclose($handle);
        return response()->download($filename)->deleteFileAfterSend(true);
    }

    /**
     * Delete product image.
     */
    // public function deleteImage($id)
    // {
    //     $image = ProductImage::findOrFail($id);
    //     $product = $image->product;

    //     if (Storage::disk('public')->exists($image->image_path)) {
    //         Storage::disk('public')->delete($image->image_path);
    //     }

    //     $image->delete();

    //     if ($image->is_thumbnail) {
    //         $newThumb = $product->images()->first();
    //         if ($newThumb) {
    //             $newThumb->update(['is_thumbnail' => true]);
    //         }
    //     }

    //     return back()->with('success','Image deleted successfully.');
    // }

    /**
     * Set product image as thumbnail.
     */
    // public function setThumbnail($id)
    // {
    //     $image = ProductImage::findOrFail($id);
    //     $product = $image->product;

    //     $product->images()->update(['is_thumbnail' => false]);
    //     $image->update(['is_thumbnail' => true]);

    //     return back()->with('success','Thumbnail updated successfully.');
    // }

    /**
     * Dependent dropdowns.
     */
    public function getSubcategories($categoryId)
    {
        return response()->json(Subcategory::where('category_id', $categoryId)->get());
    }

    public function getSubSubcategories($subcategoryId)
    {
        return response()->json(SubSubCategory::where('subcategory_id', $subcategoryId)->get());
    }
}
