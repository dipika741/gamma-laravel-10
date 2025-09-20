@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Create Product</h2>

    @if ($errors->any())
    <?php echo '<pre>'; print_r($errors->all()); ?>
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

    {{-- Category --}}
<div class="mb-3">
    <label for="category_id" class="form-label">Category <span class="text-danger">*</span></label>
    <select name="category_id" id="category_id" class="form-control" required>
        <option value="">-- Select Category --</option>
        @foreach($categories as $cat)
            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
        @endforeach
    </select>
</div>

{{-- Subcategory --}}
<div class="mb-3">
    <label for="subcategory_id" class="form-label">Subcategory</label>
    <select name="subcategory_id" id="subcategory_id" class="form-control">
        <option value="">-- Select Category First --</option>
    </select>
</div>

{{-- Sub-Subcategory --}}
<div class="mb-3">
    <label for="sub_sub_category_id" class="form-label">Sub-Subcategory</label>
    <select name="sub_sub_category_id" id="sub_sub_category_id" class="form-control">
        <option value="">-- Select Subcategory First --</option>
    </select>
</div>


        {{-- Name --}}
        <div class="mb-3">
            <label for="name" class="form-label">Product Name <span class="text-danger">*</span></label>
            <input type="text" name="name" id="name" class="form-control" required value="{{ old('name') }}">
        </div>

        {{-- Slug --}}
        <div class="mb-3">
            <label for="slug" class="form-label">Slug <span class="text-danger">*</span></label>
            <input type="text" name="slug" id="slug" class="form-control" value="{{ old('slug') }}" readonly>
        </div>

        {{-- Description --}}
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control">{{ old('description') }}</textarea>
        </div>

        {{-- Price --}}
        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="original_price" class="form-label">Original Price <span class="text-danger">*</span></label>
                <input type="number" name="original_price" id="original_price" class="form-control" step="0.01" required value="{{ old('original_price') }}">
            </div>

            <div class="col-md-4 mb-3">
                <label for="discount_percentage" class="form-label">Discount (%)</label>
                <input type="number" name="discount_percentage" id="discount_percentage" class="form-control" min="0" max="100" value="{{ old('discount_percentage', 0) }}">
            </div>

            <div class="col-md-4 mb-3">
                <label for="discounted_price" class="form-label">Discounted Price</label>
                <input type="text" id="discounted_price" name="discounted_price" class="form-control bg-light" value="{{ old('discounted_price') }}" readonly>
            </div>
        </div>

        {{-- Rating --}}
        <div class="mb-3">
            <label for="rating" class="form-label">Rating (0–5)</label>
            <input type="number" name="rating" id="rating" class="form-control" step="0.1" min="0" max="5" value="{{ old('rating', 0) }}">
        </div>

        {{-- Images --}}
        <div class="mb-3">
            <label for="images" class="form-label">Product Images</label>
            <input type="file" name="images[]" id="images" class="form-control" multiple>
            <small class="text-muted">First image will be set as thumbnail automatically.</small>
        </div>

        {{-- SEO Section --}}
        <div class="card border-primary mb-3">
            <div class="card-header bg-primary text-white">
                SEO Information
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="meta_title" class="form-label">Meta Title</label>
                    <input type="text" name="meta_title" id="meta_title" class="form-control" value="{{ old('meta_title') }}">
                </div>

                <div class="mb-3">
                    <label for="meta_description" class="form-label">Meta Description</label>
                    <textarea name="meta_description" id="meta_description" class="form-control">{{ old('meta_description') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="meta_keywords" class="form-label">Meta Keywords</label>
                    <input type="text" name="meta_keywords" id="meta_keywords" class="form-control" value="{{ old('meta_keywords') }}">
                </div>
            </div>
        </div>

        {{-- Submit --}}
        <button type="submit" class="btn btn-success">Save Product</button>
        <a href="{{ route('products.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function () {

    // 🔹 Auto-generate slug from name
    $('#name').on('input', function () {
        let slug = $(this).val().toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')   // replace non-alphanumeric with dashes
            .replace(/(^-|-$)+/g, '');    // remove leading/trailing dashes
        $('#slug').val(slug);
    });

    // 🔹 Auto-calculate discounted price
    function calculateDiscountedPrice() {
        let original = parseFloat($('#original_price').val()) || 0;
        let discount = parseFloat($('#discount_percentage').val()) || 0;
        let discounted = original - (original * (discount / 100));
        $('#discounted_price').val(discounted.toFixed(2));
    }

    $('#original_price, #discount_percentage').on('input', calculateDiscountedPrice);

    // 🔹 Dependent Dropdowns with AJAX (Category → Subcategory)
    $('#category_id').on('change', function () {
        let categoryId = $(this).val();
        let $subcategory = $('#subcategory_id');
        let $subsub = $('#sub_sub_category_id');

        $subcategory.html('<option value="">-- Loading... --</option>');
        $subsub.html('<option value="">-- Select Subcategory First --</option>');

        if (categoryId) {
            $.get(`/categories/${categoryId}/subcategories`, function (data) {
                $subcategory.html('<option value="">-- Select Subcategory --</option>');
                $.each(data, function (index, sub) {
                    $subcategory.append(`<option value="${sub.id}">${sub.name}</option>`);
                });
            });
        } else {
            $subcategory.html('<option value="">-- Select Category First --</option>');
        }
    });

    // 🔹 Dependent Dropdowns with AJAX (Subcategory → Sub-Subcategory)
    $('#subcategory_id').on('change', function () {
        let subcategoryId = $(this).val();
        let $subsub = $('#sub_sub_category_id');

        $subsub.html('<option value="">-- Loading... --</option>');

        if (subcategoryId) {
            $.get(`/subcategories/${subcategoryId}/subsubcategories`, function (data) {
                $subsub.html('<option value="">-- Select Sub-Subcategory --</option>');
                $.each(data, function (index, subsub) {
                    $subsub.append(`<option value="${subsub.id}">${subsub.name}</option>`);
                });
            });
        } else {
            $subsub.html('<option value="">-- Select Subcategory First --</option>');
        }
    });

});
</script>
@endpush


