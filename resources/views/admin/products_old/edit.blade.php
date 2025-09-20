@extends('admin.layout')

@section('title', 'Edit Product')

@section('content')
<h2>Edit Product</h2>

<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data" id="productForm">
    @csrf
    @method('PUT')

    <div class="row">
        <!-- Category -->
        <div class="col-md-6 mb-3">
            <label for="category_id" class="form-label">Main Category</label>
            <select name="category_id" id="category_id" class="form-select" required>
                <option value="">Select Main Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label for="sub_category_id" class="form-label">Sub Category</label>
            <select name="sub_category_id" id="sub_category_id" class="form-select">
                <option value="">Select Sub Category</option>
            </select>
        </div>

        <div class="col-md-6 mb-3">
            <label for="sub_sub_category_id" class="form-label">Sub-Sub Category</label>
            <select name="sub_sub_category_id" id="sub_sub_category_id" class="form-select">
                <option value="">Select Sub-Sub Category</option>
            </select>
        </div>

        <!-- Product Name -->
        <div class="col-md-6 mb-3">
            <label for="name" class="form-label">Product Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $product->name) }}" required>
        </div>

        <!-- Description -->
        <div class="col-12 mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required>{{ old('description', $product->description) }}</textarea>
        </div>

        <!-- Price and Discount -->
        <div class="col-md-4 mb-3">
            <label for="original_price" class="form-label">Original Price ($)</label>
            <input type="number" class="form-control" id="original_price" name="original_price" value="{{ old('original_price', $product->original_price) }}" step="0.01" min="0" required>
        </div>

        <div class="col-md-4 mb-3">
            <label for="discount_percentage" class="form-label">Discount (%)</label>
            <input type="number" class="form-control" id="discount_percentage" name="discount_percentage" value="{{ old('discount_percentage', $product->discount_percentage) }}" min="0" max="100">
        </div>

        <div class="col-md-4 mb-3">
            <label for="discounted_price" class="form-label">Discounted Price ($)</label>
            <input type="number" class="form-control" id="discounted_price" name="discounted_price" value="{{ old('discounted_price', $product->discounted_price) }}" step="0.01" min="0" readonly>
        </div>

        <div class="col-md-6 mb-3">
            <label for="rating" class="form-label">Rating (0-5)</label>
            <input type="number" class="form-control" id="rating" name="rating" value="{{ old('rating', $product->rating) }}" step="0.1" min="0" max="5">
        </div>

        <!-- New Images Upload -->
        <div class="col-12 mb-3">
            <label for="images" class="form-label">Add New Images</label>
            <input type="file" class="form-control" id="images" name="images[]" multiple accept="image/*">
            <div class="form-text">You can select multiple images.</div>
            
            <div id="imagePreview" class="row mt-3"></div>
        </div>

        <!-- Existing Images -->
        <div class="col-12 mb-3">
            <label class="form-label">Existing Images</label>
            <div class="row">
                @foreach($product->images as $image)
                    <div class="col-md-3 text-center mb-2" id="image-{{ $image->id }}">
                        <img src="{{ asset('storage/' . $image->image_path) }}" class="img-fluid rounded mb-1" style="max-height: 150px;">
                        
                        @if($image->is_thumbnail)
                            <span class="badge bg-success d-block mb-1">Thumbnail</span>
                        @endif

                        <button type="button" class="btn btn-sm btn-danger delete-image" data-id="{{ $image->id }}">Delete</button>

                        @if(!$image->is_thumbnail)
                            <button type="button" class="btn btn-sm btn-primary set-thumbnail" data-id="{{ $image->id }}">Set as Thumbnail</button>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- SEO Settings -->
        <div class="col-12 mb-3">
            <div class="card">
                <div class="card-header"><h5>SEO Settings</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="meta_title" class="form-label">Meta Title</label>
                        <input type="text" class="form-control" id="meta_title" name="meta_title" value="{{ old('meta_title', $product->seoData->meta_title ?? '') }}" maxlength="255">
                    </div>
                    <div class="mb-3">
                        <label for="meta_description" class="form-label">Meta Description</label>
                        <textarea class="form-control" id="meta_description" name="meta_description" rows="3" maxlength="500">{{ old('meta_description', $product->seoData->meta_description ?? '') }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="meta_keywords" class="form-label">Meta Keywords</label>
                        <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" value="{{ old('meta_keywords', $product->seoData->meta_keywords ?? '') }}" placeholder="keyword1, keyword2">
                    </div>
                </div>
            </div>
        </div>

        <!-- Submit -->
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Update Product</button>
            <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </div>
</form>

@push('scripts')
<script>
$(document).ready(function() {
    // Calculate discounted price
    $('#original_price, #discount_percentage').on('input', function() {
        let original = parseFloat($('#original_price').val()) || 0;
        let discount = parseFloat($('#discount_percentage').val()) || 0;
        $('#discounted_price').val((original * (1 - discount/100)).toFixed(2));
    });

    // Preview new images
    $('#images').on('change', function() {
        $('#imagePreview').empty();
        let files = $(this)[0].files;
        for (let i=0; i<files.length; i++) {
            let reader = new FileReader();
            reader.onload = function(e) {
                $('#imagePreview').append(
                    `<div class="col-md-3 mb-2">
                        <div class="card">
                            <img src="${e.target.result}" class="card-img-top" style="height: 150px; object-fit: cover;">
                        </div>
                    </div>`
                );
            }
            reader.readAsDataURL(files[i]);
        }
    });

    // Delete image
    $('.delete-image').click(function() {
        let imageId = $(this).data('id');
        if(confirm('Are you sure you want to delete this image?')) {
            $.ajax({
                url: `/admin/product-images/${imageId}`,
                type: 'DELETE',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                success: function(res) {
                    if(res.success) $('#image-' + imageId).remove();
                }
            });
        }
    });

    // Set as thumbnail
    $('.set-thumbnail').click(function() {
        let imageId = $(this).data('id');
        $.post(`/admin/product-images/${imageId}/set-thumbnail`, {_token: '{{ csrf_token() }}'}, function(res){
            if(res.success) location.reload();
        });
    });

    // Load subcategories (AJAX)
    function loadChildren(parentId, targetSelect, selectedId = null) {
        $(targetSelect).html('<option value="">Select</option>');
        if(!parentId) return;
        $.get(`/admin/categories/children/${parentId}`, function(data){
            data.forEach(function(child){
                let selected = (child.id == selectedId) ? 'selected' : '';
                $(targetSelect).append(`<option value="${child.id}" ${selected}>${child.name}</option>`);
            });
        });
    }

    $('#category_id').change(function(){
        loadChildren($(this).val(), '#sub_category_id');
        $('#sub_sub_category_id').html('<option value="">Select</option>');
    });

    $('#sub_category_id').change(function(){
        loadChildren($(this).val(), '#sub_sub_category_id');
    });

    // On page load, load subcategories if already selected
    loadChildren($('#category_id').val(), '#sub_category_id', '{{ $product->sub_category_id }}');
    loadChildren($('#sub_category_id').val(), '#sub_sub_category_id', '{{ $product->sub_sub_category_id }}');
});
</script>
@endpush
@endsection
