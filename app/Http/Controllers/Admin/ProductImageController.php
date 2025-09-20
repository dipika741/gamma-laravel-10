<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    /**
     * Store uploaded images for a product
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'images.*'   => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $product = Product::findOrFail($request->product_id);

        foreach ($request->file('images') as $index => $image) {
            $path = $image->store('products', 'public');

            $product->images()->create([
                'image_path'   => $path,
                'is_thumbnail' => $product->images()->count() === 0 && $index === 0, // set first image as thumbnail
            ]);
        }

        return back()->with('success', 'Images uploaded successfully.');
    }

    /**
     * Delete a product image
     */
    public function destroy($id)
    {
        $image = ProductImage::findOrFail($id);
        $product = $image->product;

        // Delete file
        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        // Delete db record
        $image->delete();

        // If it was thumbnail, assign another one
        if ($image->is_thumbnail && $product->images()->exists()) {
            $newThumb = $product->images()->first();
            $newThumb->update(['is_thumbnail' => true]);
        }

        return back()->with('success', 'Image deleted successfully.');
    }

    /**
     * Set a product image as thumbnail
     */
    public function setThumbnail($id)
    {
        $image = ProductImage::findOrFail($id);
        $product = $image->product;

        // Reset all images
        $product->images()->update(['is_thumbnail' => false]);

        // Mark this one as thumbnail
        $image->update(['is_thumbnail' => true]);
        return response()->json(['success' => true, 'message' => 'Thumbnail updated successfully']);

       // return back()->with('success', 'Thumbnail updated successfully.');
    }

    public function deleteImage($id)
    {
        $image = ProductImage::findOrFail($id);
        $product = $image->product;

        if (Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        if ($image->is_thumbnail) {
            $newThumb = $product->images()->first();
            if ($newThumb) {
                $newThumb->update(['is_thumbnail' => true]);
            }
        }
        return response()->json(['success' => true, 'message' => 'Image deleted successfully']);

        //return back()->with('success','Image deleted successfully.');
    }
}
