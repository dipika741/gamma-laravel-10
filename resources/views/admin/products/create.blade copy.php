@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Product</h2>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Category --}}
        <div class="form-group">
            <label for="category_id">Category</label>
            <select name="category_id" class="form-control" required>
                <option value="">-- Select Category --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Subcategory --}}
        <div class="form-group">
            <label for="subcategory_id">Subcategory</label>
            <select name="subcategory_id" class="form-control">
                <option value="">-- Select Subcategory --</option>
                @foreach($subcategories as $subcat)
                    <option value="{{ $subcat->id }}">{{ $subcat->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Sub-subcategory --}}
        <div class="form-group">
            <label for="sub_sub_category_id">Sub-Subcategory</label>
            <select name="sub_sub_category_id" class="form-control">
                <option value="">-- Select Sub-Subcategory --</option>
                @foreach($subsubcategories as $subsubcat)
                    <option value="{{ $subsubcat->id }}">{{ $subsubcat->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Name & Slug --}}
        <div class="form-group">
            <label>Product Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="form-group">
            <label>Slug (URL)</label>
            <input type="text" name="slug" class="form-control" placeholder="auto-generate if left empty">
        </div>

        {{-- Description --}}
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="4" class="form-control"></textarea>
        </div>

        {{-- Pricing --}}
        <div class="row">
            <div class="col-md-4">
                <label>Original Price</label>
                <input type="number" step="0.01" name="original_price" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label>Discount %</label>
                <input type="number" name="discount_percentage" class="form-control" min="0" max="100" value="0">
            </div>
            <div class="col-md-4">
                <label>Rating (0-5)</label>
                <input type="number" step="0.1" name="rating" class="form-control" min="0" max="5">
            </div>
        </div>

        {{-- Images --}}
        <div class="form-group mt-3">
            <label>Upload Images (first one becomes thumbnail)</label>
            <input type="file" name="images[]" class="form-control" multiple>
        </div>

        {{-- SEO --}}
        <h4>SEO Data</h4>
        <div class="form-group">
            <label>Meta Title</label>
            <input type="text" name="meta_title" class="form-control">
        </div>
        <div class="form-group">
            <label>Meta Description</label>
            <textarea name="meta_description" rows="2" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label>Meta Keywords</label>
            <input type="text" name="meta_keywords" class="form-control">
        </div>

        <button type="submit" class="btn btn-success mt-3">Save Product</button>
    </form>
</div>
@endsection
