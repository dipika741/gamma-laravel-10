{{-- resources/views/admin/products/create.blade.php --}}
@extends('admin.layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Add Product</h2>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- Category --}}
        <div class="mb-3">
            <label class="form-label">Category</label>
            <select name="category_id" class="form-select" required>
                <option value="">-- Select Category --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Product Info --}}
        <div class="mb-3">
            <label class="form-label">Product Name</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Description</label>
            <textarea name="description" rows="4" class="form-control"></textarea>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Original Price</label>
                <input type="number" name="original_price" step="0.01" class="form-control" required>
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Discount %</label>
                <input type="number" name="discount_percentage" class="form-control" value="0">
            </div>
            <div class="col-md-4 mb-3">
                <label class="form-label">Discounted Price</label>
                <input type="number" name="discounted_price" step="0.01" class="form-control" required>
            </div>
        </div>

        {{-- SEO --}}
        <h5 class="mt-4">SEO Data</h5>
        <div class="mb-3">
            <label class="form-label">Meta Title</label>
            <input type="text" name="meta_title" class="form-control">
        </div>
        <div class="mb-3">
            <label class="form-label">Meta Description</label>
            <textarea name="meta_description" class="form-control" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label class="form-label">Meta Keywords</label>
            <input type="text" name="meta_keywords" class="form-control">
        </div>

        {{-- Images --}}
        <h5 class="mt-4">Product Images</h5>
        <div class="mb-3">
            <input type="file" name="images[]" class="form-control" multiple>
            <small class="text-muted">You can upload multiple images. First one will be set as thumbnail.</small>
        </div>

        <button type="submit" class="btn btn-success">Save Product</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
