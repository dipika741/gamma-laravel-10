<?php
namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\SubSubCategory;
use App\Models\Product;
use Illuminate\Http\Request;
use Str;

class FrontendProductController extends Controller
{
    public function listing($categorySlug, $subcategorySlug = null, $subSubCategorySlug = null)
    {
        $category = Category::where('slug', $categorySlug)->firstOrFail();
        $subcategory = null;
        $subSubCategory = null;
        $productsQuery = Product::query()->where('category_id', $category->id);

        if ($subcategorySlug) {
            $subcategory = Subcategory::where('slug', $subcategorySlug)
                ->where('category_id', $category->id)
                ->firstOrFail();
            $productsQuery->where('subcategory_id', $subcategory->id);
        }

        if ($subSubCategorySlug) {
            $subSubCategory = SubSubCategory::where('slug', $subSubCategorySlug)
                ->where('subcategory_id', $subcategory->id)
                ->firstOrFail();
            $productsQuery->where('sub_sub_category_id', $subSubCategory->id);
        }

        $products = $productsQuery->paginate(12);

        return view('products.listing', compact('category', 'subcategory', 'subSubCategory', 'products'));
    }

    public function showallslug($categorySlug, $slug1 = null, $slug2 = null, $productSlug = null)
    {
        // If $productSlug is null → it means product slug is in $slug1
        if (!$productSlug) {
            $productSlug = $slug2 ?? $slug1;
        }
    
        $category = Category::where('slug', $categorySlug)->firstOrFail();
    
        $product = Product::where('slug', $productSlug)
            ->where('category_id', $category->id)
            ->firstOrFail();
    
        return view('products.show', compact('category', 'product'));
    }

    public function showcategoryslugonly($categorySlug, $productSlug)
    {       
        // find category
        $category = Category::where('slug', $categorySlug)->firstOrFail();
        //dd(vars: $category->id);
        \DB::enableQueryLog();

    $product = Product::with(['seoData', 'images', 'thumbnail'])
        ->where('slug', $productSlug)
        ->where('category_id', $category->id)
        ->firstOrFail();

        
        //dd(\DB::getQueryLog());
        // dd($product->images);
        // Build canonical URL
        $meta = [
            'title' => $product->seoData->meta_title ?? $product->name,
            'description' => $product->seoData->meta_description ?? Str::limit($product->description, 160),
            'keywords' => $product->seoData->meta_keywords ?? '',
            'canonical' => route('product.showcategoryslugonly', [
                'categorySlug' => $product->category->slug,
                'productSlug' => $product->slug,
            ]),
            'type' => 'product',
            'image' => $product->main_image_url,
        ];
//dd(vars: $meta);

    return view('products.show', compact('product','meta'));
    }
    

    
}
