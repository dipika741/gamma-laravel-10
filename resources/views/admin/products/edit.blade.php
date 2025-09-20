@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Edit Product</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        {{-- Category --}}
        <div class="mb-3">
            <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
            <select name="category_id" id="category_id" class="form-control" required>
                <option value="">-- Select Category --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ $product->category_id == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Subcategory --}}
        <div class="mb-3">
            <label for="subcategory_id" class="form-label">Subcategory</label>
            <select name="subcategory_id" id="subcategory_id" class="form-control">
                <option value="">-- Select Category First --</option>
                @if($subcategories)
                    @foreach($subcategories as $sub)
                        <option value="{{ $sub->id }}" {{ $product->subcategory_id == $sub->id ? 'selected' : '' }}>
                            {{ $sub->name }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>

        {{-- Sub-Subcategory --}}
        <div class="mb-3">
            <label for="sub_sub_category_id" class="form-label">Sub-Subcategory</label>
            <select name="sub_sub_category_id" id="sub_sub_category_id" class="form-control">
                <option value="">-- Select Subcategory First --</option>
                @if($subsubcategories)
                    @foreach($subsubcategories as $ssub)
                        <option value="{{ $ssub->id }}" {{ $product->sub_sub_category_id == $ssub->id ? 'selected' : '' }}>
                            {{ $ssub->name }}
                        </option>
                    @endforeach
                @endif
            </select>
        </div>

        {{-- Name --}}
        <div class="mb-3">
            <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control"
                   value="{{ old('name', $product->name) }}" required>
        </div>

        {{-- Slug --}}
        <div class="mb-3">
            <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
            <input type="text" name="slug" id="slug" class="form-control"
                   value="{{ old('slug', $product->slug) }}" readonly>
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description', $product->description) }}</textarea>
        </div>

        {{-- Price --}}
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="original_price" class="form-label">Original Price <span class="text-danger">*</span></label>
                <input type="number" name="original_price" id="original_price" class="form-control"
                       step="0.01" required value="{{ old('original_price', $product->original_price) }}">
            </div>

            <div class="col-md-4 mb-3">
                <label for="discount_percentage" class="form-label">Discount (%)</label>
                <input type="number" name="discount_percentage" id="discount_percentage"
                       class="form-control" min="0" max="100"
                       value="{{ old('discount_percentage', $product->discount_percentage) }}">
            </div>

            <div class="col-md-4 mb-3">
                <label for="discounted_price" class="form-label">Discounted Price</label>
                <input type="text" id="discounted_price" name="discounted_price"
                       class="form-control bg-light"
                       value="{{ old('discounted_price', $product->discounted_price) }}" readonly>
            </div>
        </div>

        {{-- Rating --}}
        <div class="mb-3">
            <label for="rating" class="form-label">Rating (0–5)</label>
            <input type="number" name="rating" id="rating" class="form-control"
                   step="0.1" min="0" max="5"
                   value="{{ old('rating', $product->rating) }}">
        </div>

        {{-- Existing Images --}}
        <div class="mb-3">
            <label class="form-label">Existing Images</label>
            <div class="d-flex flex-wrap gap-3">
                @foreach($product->images as $image)
                    <div class="position-relative" style="width:120px;">
                        <img src="{{ asset('storage/'.$image->image_path) }}" class="img-thumbnail {{ $image->is_thumbnail ? 'border border-3 border-success' : '' }}" style="height:100px; object-fit:cover;">

                        {{-- Delete Button --}}
                        <button type="button" class="btn btn-sm btn-danger p-1 position-absolute top-0 start-0 delete-image-btn" data-id="{{ $image->id }}" title="Delete Image">
                            <i class="fas fa-trash"></i>
                        </button>

                        {{-- Set Thumbnail Button --}}
                        <button type="button" class="btn btn-sm btn-success p-1 position-absolute top-0 end-0 set-thumbnail-btn" data-id="{{ $image->id }}" title="Set as Thumbnail">
                            <i class="fas fa-star"></i>
                        </button>

                        @if($image->is_thumbnail)
                            <span class="badge bg-primary thumbnail-badge position-absolute bottom-0 start-50 translate-middle-x">Thumbnail</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Upload New Images --}}
        <div class="mb-3">
            <label for="images" class="form-label">Upload New Images</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple>
        </div>

        {{-- SEO Section --}}
        <div class="card border-primary mb-3">
            <div class="card-header bg-primary text-white">
                SEO Information
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="meta_title" class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" id="meta_title" class="form-control"
                           value="{{ old('meta_title', $product->seoData->meta_title ?? '') }}">
                </div>

                <div class="mb-3">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <textarea name="meta_description" id="meta_description" class="form-control">{{ old('meta_description', $product->seoData->meta_description ?? '') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="meta_keywords" class="form-label">Meta Keywords</label>
                    <input type="text" name="meta_keywords" id="meta_keywords" class="form-control"
                           value="{{ old('meta_keywords', $product->seoData->meta_keywords ?? '') }}">
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn btn-success">Update Product</button>
        <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {
    // Auto slug
    $('#name').on('input', function () {
        let slug = $(this).val().toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/(^-|-$)+/g, '');
        $('#slug').val(slug);
    });

    // Auto calculate discount
    function calculateDiscountedPrice() {
        let original = parseFloat($('#original_price').val()) || 0;
        let discount = parseFloat($('#discount_percentage').val()) || 0;
        let discounted = original - (original * (discount / 100));
        $('#discounted_price').val(discounted.toFixed(2));
    }
    $('#original_price, #discount_percentage').on('input', calculateDiscountedPrice);

    // Dependent dropdowns
    $('#category_id').on('change', function () {
        let categoryId = $(this).val();
        let $subcategory = $('#subcategory_id');
        let $subsub = $('#sub_sub_category_id');

        $subcategory.html('<option value="">-- Loading... --</option>');
        $subsub.html('<option value="">-- Select Subcategory First --</option>');

        if (categoryId) {
            $.get(`/admin/categories/${categoryId}/subcategories`, function (data) {
                $subcategory.html('<option value="">-- Select Subcategory --</option>');
                $.each(data, function (i, sub) {
                    $subcategory.append(`<option value="${sub.id}">${sub.name}</option>`);
                });
            });
        }
    });

    $('#subcategory_id').on('change', function () {
        let subcategoryId = $(this).val();
        let $subsub = $('#sub_sub_category_id');
        $subsub.html('<option value="">-- Loading... --</option>');

        if (subcategoryId) {
            $.get(`/admin/subcategories/${subcategoryId}/subsubcategories`, function (data) {
                $subsub.html('<option value="">-- Select Sub-Subcategory --</option>');
                $.each(data, function (i, ssub) {
                    $subsub.append(`<option value="${ssub.id}">${ssub.name}</option>`);
                });
            });
        }
    });

    // ✅ Set Thumbnail AJAX
    $(document).on('click', '.set-thumbnail-btn', function (e) {
        e.preventDefault();
        let imageId = $(this).data('id');
        let $wrapper = $(this).closest('.position-relative');

        $.ajax({
            url: `/admin/product-images/${imageId}/set-thumbnail`,
            type: "POST",
            data: { _token: "{{ csrf_token() }}" },
            success: function (res) {
                
                if (res.success) {
                    $('.position-relative img').removeClass('border border-3 border-success');
                    $('.thumbnail-badge').remove();
                    $wrapper.find('img').addClass('border border-3 border-success');
                    $wrapper.append('<span class="badge bg-primary thumbnail-badge position-absolute bottom-0 start-50 translate-middle-x">Thumbnail</span>');
                }
            }
        });
    });

    // ✅ Delete Image AJAX
    $(document).on('click', '.delete-image-btn', function (e) {
        e.preventDefault();
        if (!confirm("Are you sure you want to delete this image?")) return;

        let imageId = $(this).data('id');
        let $wrapper = $(this).closest('.position-relative');

        $.ajax({
            url: `/admin/product-images/${imageId}`,
            type: "POST",
            data: { _method: "DELETE", _token: "{{ csrf_token() }}" },
            success: function (res) {
                if (res.success) {
                    $wrapper.fadeOut(300, function () { $(this).remove(); });
                }
            }
        });
    });
});
</script>
@endpush
