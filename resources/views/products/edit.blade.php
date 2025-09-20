@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Product</h2>

    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Category --}}
        <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" class="form-control" required>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Subcategory --}}
        <div class="form-group">
            <label for="subcategory_id">Subcategory</label>
            <select name="subcategory_id" class="form-control">
                <option value="">-- None --</option>
                @foreach($subcategories as $subcat)
                    <option value="{{ $subcat->id }}" {{ $product->subcategory_id == $subcat->id ? 'selected' : '' }}>
                        {{ $subcat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Sub-subcategory --}}
        <div class="form-group">
            <label for="sub_sub_category_id">Sub-Subcategory</label>
            <select name="sub_sub_category_id" class="form-control">
                <option value="">-- None --</option>
                @foreach($subsubcategories as $subsubcat)
                    <option value="{{ $subsubcat->id }}" {{ $product->sub_sub_category_id == $subsubcat->id ? 'selected' : '' }}>
                        {{ $subsubcat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Name & Slug --}}
        <div class="form-group">
            <label>Product Name</label>
            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
        </div>

        <div class="form-group">
            <label>Slug (URL)</label>
            <input type="text" name="slug" class="form-control" value="{{ $product->slug }}">
        </div>

        {{-- Description --}}
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="4" class="form-control">{{ $product->description }}</textarea>
        </div>

        {{-- Pricing --}}
        <div class="row">
            <div class="col-md-4">
                <label>Original Price</label>
                <input type="number" step="0.01" name="original_price" class="form-control" value="{{ $product->original_price }}">
            </div>
            <div class="col-md-4">
                <label>Discount %</label>
                <input type="number" name="discount_percentage" class="form-control" min="0" max="100" value="{{ $product->discount_percentage }}">
            </div>
            <div class="col-md-4">
                <label>Rating (0-5)</label>
                <input type="number" step="0.1" name="rating" class="form-control" min="0" max="5" value="{{ $product->rating }}">
            </div>
        </div>

        {{-- Current Images --}}
        <h4 class="mt-4">Product Images</h4>
        <div class="row">
            @foreach($product->images as $image)
                <div class="col-md-3 text-center">
                    <img src="{{ Storage::url($image->image_path) }}" class="img-fluid mb-2" style="height: 150px; object-fit: cover;">
                    
                    {{-- Set Thumbnail --}}
                    @if(!$image->is_thumbnail)
                        <form action="{{ route('products.setThumbnail', [$product->id, $image->id]) }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-sm btn-primary">Set as Thumbnail</button>
                        </form>
                    @else
                        <span class="badge badge-success d-block">Thumbnail</span>
                    @endif

                    {{-- Delete Image --}}
                    <form action="{{ route('products.deleteImage', [$product->id, $image->id]) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger mt-1">Delete</button>
                    </form>
                </div>
            @endforeach
        </div>

        {{-- Upload New Images --}}
        <div class="form-group mt-3">
            <label>Upload More Images</label>
            <input type="file" name="images[]" class="form-control" multiple>
        </div>

        {{-- SEO --}}
        <h4>SEO Data</h4>
        <div class="form-group">
            <label>Meta Title</label>
            <input type="text" name="meta_title" class="form-control" value="{{ $product->seoData->meta_title ?? '' }}">
        </div>
        <div class="form-group">
            <label>Meta Description</label>
            <textarea name="meta_description" rows="2" class="form-control">{{ $product->seoData->meta_description ?? '' }}</textarea>
        </div>
        <div class="form-group">
            <label>Meta Keywords</label>
            <input type="text" name="meta_keywords" class="form-control" value="{{ $product->seoData->meta_keywords ?? '' }}">
        </div>

        <button type="submit" class="btn btn-success mt-3">Update Product</button>
    </form>
</div>
@endsection
